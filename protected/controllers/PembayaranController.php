<?php

class PembayaranController extends Controller
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
                'roles'=>array('kasir'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Pendaftaran('searchForKasir');
        $model->unsetAttributes();
        if(isset($_GET['Pendaftaran']))
            $model->attributes=$_GET['Pendaftaran'];

        $this->render('index', array(
            'model'=>$model,
        ));
    }

    public function actionView($id)
    {
        $pendaftaran = Pendaftaran::model()->findByPk($id);
        if (!$pendaftaran) {
            throw new CHttpException(404, 'Pendaftaran tidak ditemukan.');
        }

        $this->render('view', array(
            'pendaftaran'=>$pendaftaran,
        ));
    }

    public function actionBayar($id)
    {
        $pendaftaran = Pendaftaran::model()->findByPk($id);
        if (!$pendaftaran) {
            throw new CHttpException(404, 'Pendaftaran tidak ditemukan.');
        }

        $model = new Pembayaran;
        $model->jumlah_bayar = $pendaftaran->getTotalTagihan();

        if (isset($_POST['Pembayaran'])) {
            $model->attributes = $_POST['Pembayaran'];
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    // Update status semua transaksi menjadi lunas
                    foreach ($pendaftaran->transaksis as $transaksi) {
                        $transaksi->status_pembayaran = 'lunas';
                        $transaksi->tanggal_bayar = date('Y-m-d H:i:s');
                        if (!$transaksi->save()) {
                            throw new Exception('Gagal mengupdate status pembayaran transaksi');
                        }
                    }

                    // Update status pendaftaran
                    $pendaftaran->status_pembayaran = 'lunas';
                    if (!$pendaftaran->save()) {
                        throw new Exception('Gagal mengupdate status pembayaran pendaftaran');
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Pembayaran berhasil disimpan.');
                    $this->redirect(array('view', 'id'=>$id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }

        $this->render('bayar', array(
            'pendaftaran'=>$pendaftaran,
            'model'=>$model,
        ));
    }

    public function actionRiwayat()
    {
        $model = new Pendaftaran('searchRiwayat');
        $model->unsetAttributes();
        if(isset($_GET['Pendaftaran']))
            $model->attributes=$_GET['Pendaftaran'];

        $this->render('riwayat', array(
            'model'=>$model,
        ));
    }
} 