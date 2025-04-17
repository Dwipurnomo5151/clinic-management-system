<?php

class PatientController extends Controller
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
                'actions'=>array('index', 'view', 'create', 'update', 'delete'),
                'roles'=>array('admin', 'petugas_pendaftaran'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Patient('search');
        $model->unsetAttributes();
        if (isset($_GET['Patient'])) {
            $model->attributes = $_GET['Patient'];
        }

        $this->render('index', array(
            'model'=>$model,
        ));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model'=>$model,
        ));
    }

    public function actionCreate()
    {
        $model = new Patient;
        $transaction = Yii::app()->db->beginTransaction();

        try {
            if (isset($_POST['Patient'])) {
                $model->attributes = $_POST['Patient'];
                
                if ($model->save()) {
                    // Generate nomor pendaftaran
                    $no_pendaftaran = date('Ymd') . str_pad($model->id, 4, '0', STR_PAD_LEFT);
                    
                    // Buat pendaftaran kunjungan
                    $pendaftaran = new Pendaftaran;
                    $pendaftaran->no_pendaftaran = $no_pendaftaran;
                    $pendaftaran->pasien_id = $model->id;
                    $pendaftaran->tanggal = new CDbExpression('NOW()');
                    $pendaftaran->keluhan = $_POST['keluhan'];
                    $pendaftaran->status = 'menunggu';
                    $pendaftaran->created_by = Yii::app()->user->id;
                    
                    if ($pendaftaran->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Data pasien dan kunjungan berhasil disimpan.');
                        $this->redirect(array('view', 'id'=>$model->id));
                    } else {
                        throw new Exception('Gagal menyimpan data pendaftaran');
                    }
                } else {
                    throw new Exception('Gagal menyimpan data pasien');
                }
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $this->render('create', array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Patient'])) {
            $model->attributes = $_POST['Patient'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data pasien berhasil diperbarui.');
                $this->redirect(array('view', 'id'=>$model->id));
            }
        }

        $this->render('update', array(
            'model'=>$model,
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            $model->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function loadModel($id)
    {
        $model = Patient::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Data pasien tidak ditemukan.');
        }
        return $model;
    }
} 