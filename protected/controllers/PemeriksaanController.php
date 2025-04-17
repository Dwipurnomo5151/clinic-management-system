<?php

class PemeriksaanController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'create', 'update', 'updateTransaksiStatus'),
                'expression' => 'Yii::app()->user->checkAccess("managePemeriksaan")',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Pemeriksaan('search');
        $model->unsetAttributes();
        if (isset($_GET['Pemeriksaan'])) {
            $model->attributes = $_GET['Pemeriksaan'];
        }

        // Set default filter for current doctor
        if (Yii::app()->user->checkAccess('dokter')) {
            $model->dokter_id = Yii::app()->user->id;
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        
        // Check if the current user is the doctor who created this examination
        if (Yii::app()->user->checkAccess('dokter') && $model->dokter_id != Yii::app()->user->id) {
            throw new CHttpException(403, 'Anda tidak memiliki akses untuk melihat pemeriksaan ini.');
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionCreate($pendaftaran_id)
    {
        $model = new Pemeriksaan;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->dokter_id = Yii::app()->user->id;
        $model->tanggal = new CDbExpression('NOW()');

        if (isset($_POST['Pemeriksaan'])) {
            $model->attributes = $_POST['Pemeriksaan'];
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    // Save tindakan
                    if (isset($_POST['tindakan_ids']) && is_array($_POST['tindakan_ids'])) {
                        foreach ($_POST['tindakan_ids'] as $tindakan_id) {
                            $tindakan = Tindakan::model()->findByPk($tindakan_id);
                            if ($tindakan) {
                                $transaksi = new Transaksi;
                                $transaksi->pendaftaran_id = $pendaftaran_id;
                                $transaksi->pemeriksaan_id = $model->id;
                                $transaksi->jenis = 'tindakan';
                                $transaksi->item_id = $tindakan_id;
                                $transaksi->jumlah = 1;
                                $transaksi->harga = $tindakan->biaya;
                                $transaksi->total = $tindakan->biaya;
                                $transaksi->status = 'pending';
                                if (!$transaksi->save()) {
                                    throw new Exception('Gagal menyimpan transaksi tindakan');
                                }
                            }
                        }
                    }

                    // Save obat
                    if (isset($_POST['obat_ids']) && is_array($_POST['obat_ids'])) {
                        foreach ($_POST['obat_ids'] as $key => $obat_id) {
                            if (!empty($obat_id) && isset($_POST['jumlah_obat'][$key])) {
                                $obat = Obat::model()->findByPk($obat_id);
                                if ($obat) {
                                    $transaksi = new Transaksi;
                                    $transaksi->pendaftaran_id = $pendaftaran_id;
                                    $transaksi->pemeriksaan_id = $model->id;
                                    $transaksi->jenis = 'obat';
                                    $transaksi->item_id = $obat_id;
                                    $transaksi->jumlah = $_POST['jumlah_obat'][$key];
                                    $transaksi->harga = $obat->harga_jual;
                                    $transaksi->total = $obat->harga_jual * $_POST['jumlah_obat'][$key];
                                    $transaksi->status = 'pending';
                                    if (!$transaksi->save()) {
                                        throw new Exception('Gagal menyimpan transaksi obat');
                                    }

                                    // Update stok obat
                                    $obat->stok -= $_POST['jumlah_obat'][$key];
                                    if (!$obat->save()) {
                                        throw new Exception('Gagal mengupdate stok obat');
                                    }
                                }
                            }
                        }
                    }

                    // Update status pendaftaran menjadi 'dalam-proses'
                    $pendaftaran = Pendaftaran::model()->findByPk($pendaftaran_id);
                    if ($pendaftaran) {
                        $pendaftaran->status = 'dalam-proses';
                        if (!$pendaftaran->save()) {
                            throw new Exception('Gagal mengupdate status pendaftaran');
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data pemeriksaan berhasil disimpan.');
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        // Check if the current user is the doctor who created this examination
        if (Yii::app()->user->checkAccess('dokter') && $model->dokter_id != Yii::app()->user->id) {
            throw new CHttpException(403, 'Anda tidak memiliki akses untuk mengubah pemeriksaan ini.');
        }

        if (isset($_POST['Pemeriksaan'])) {
            $model->attributes = $_POST['Pemeriksaan'];
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    // Delete existing transactions
                    Transaksi::model()->deleteAll('pemeriksaan_id = :pemeriksaan_id', array(':pemeriksaan_id' => $model->id));

                    // Save tindakan
                    if (isset($_POST['tindakan_ids']) && is_array($_POST['tindakan_ids'])) {
                        foreach ($_POST['tindakan_ids'] as $tindakan_id) {
                            $tindakan = Tindakan::model()->findByPk($tindakan_id);
                            if ($tindakan) {
                                $transaksi = new Transaksi;
                                $transaksi->pendaftaran_id = $model->pendaftaran_id;
                                $transaksi->pemeriksaan_id = $model->id;
                                $transaksi->jenis = 'tindakan';
                                $transaksi->item_id = $tindakan_id;
                                $transaksi->jumlah = 1;
                                $transaksi->harga = $tindakan->biaya;
                                $transaksi->total = $tindakan->biaya;
                                $transaksi->status = 'pending';
                                if (!$transaksi->save()) {
                                    throw new Exception('Gagal menyimpan transaksi tindakan');
                                }
                            }
                        }
                    }

                    // Save obat
                    if (isset($_POST['obat_ids']) && is_array($_POST['obat_ids'])) {
                        foreach ($_POST['obat_ids'] as $key => $obat_id) {
                            if (!empty($obat_id) && isset($_POST['jumlah_obat'][$key])) {
                                $obat = Obat::model()->findByPk($obat_id);
                                if ($obat) {
                                    $transaksi = new Transaksi;
                                    $transaksi->pendaftaran_id = $model->pendaftaran_id;
                                    $transaksi->pemeriksaan_id = $model->id;
                                    $transaksi->jenis = 'obat';
                                    $transaksi->item_id = $obat_id;
                                    $transaksi->jumlah = $_POST['jumlah_obat'][$key];
                                    $transaksi->harga = $obat->harga_jual;
                                    $transaksi->total = $obat->harga_jual * $_POST['jumlah_obat'][$key];
                                    $transaksi->status = 'pending';
                                    if (!$transaksi->save()) {
                                        throw new Exception('Gagal menyimpan transaksi obat');
                                    }

                                    // Update stok obat
                                    $obat->stok -= $_POST['jumlah_obat'][$key];
                                    if (!$obat->save()) {
                                        throw new Exception('Gagal mengupdate stok obat');
                                    }
                                }
                            }
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data pemeriksaan berhasil diperbarui.');
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateTransaksiStatus($id)
    {
        $transaksi = Transaksi::model()->findByPk($id);
        if (!$transaksi) {
            throw new CHttpException(404, 'Transaksi tidak ditemukan.');
        }

        // Pastikan user adalah dokter yang melakukan pemeriksaan
        $pemeriksaan = Pemeriksaan::model()->findByPk($transaksi->pemeriksaan_id);
        if (!$pemeriksaan || $pemeriksaan->dokter_id != Yii::app()->user->id) {
            throw new CHttpException(403, 'Anda tidak memiliki akses untuk mengubah status transaksi ini.');
        }

        if (isset($_POST['status'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $transaksi->status = $_POST['status'];
                if (!$transaksi->save()) {
                    throw new Exception('Gagal mengubah status transaksi.');
                }

                // Jika semua transaksi sudah selesai, update status pendaftaran
                if ($transaksi->status == 'selesai') {
                    $allCompleted = true;
                    $allTransaksi = Transaksi::model()->findAll('pemeriksaan_id = :pid', array(':pid' => $pemeriksaan->id));
                    foreach ($allTransaksi as $t) {
                        if ($t->status != 'selesai') {
                            $allCompleted = false;
                            break;
                        }
                    }
                    
                    if ($allCompleted) {
                        $pendaftaran = Pendaftaran::model()->findByPk($pemeriksaan->pendaftaran_id);
                        if ($pendaftaran) {
                            $pendaftaran->status = 'selesai';
                            if (!$pendaftaran->save()) {
                                throw new Exception('Gagal mengupdate status pendaftaran.');
                            }
                        }
                    }
                }

                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Status transaksi berhasil diubah.');
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $this->redirect(array('view', 'id' => $transaksi->pemeriksaan_id));
    }

    public function loadModel($id)
    {
        $model = Pemeriksaan::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
} 