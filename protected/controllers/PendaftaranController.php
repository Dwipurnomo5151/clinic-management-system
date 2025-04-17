<?php

class PendaftaranController extends Controller
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
        $model = new Pendaftaran('search');
        $model->unsetAttributes();
        if (isset($_GET['Pendaftaran'])) {
            $model->attributes = $_GET['Pendaftaran'];
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
        $model = new Pendaftaran;
        $model->created_by = Yii::app()->user->id;
        $model->tanggal = new CDbExpression('NOW()');
        $model->status = 'menunggu';

        if (isset($_POST['Pendaftaran'])) {
            $model->attributes = $_POST['Pendaftaran'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data pendaftaran berhasil disimpan.');
                $this->redirect(array('view', 'id'=>$model->id));
            }
        }

        $this->render('create', array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        if (isset($_POST['Pendaftaran'])) {
            $model->attributes = $_POST['Pendaftaran'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data pendaftaran berhasil diperbarui.');
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
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request.');
        }
    }

    public function loadModel($id)
    {
        $model = Pendaftaran::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Data pendaftaran tidak ditemukan.');
        }
        return $model;
    }
} 