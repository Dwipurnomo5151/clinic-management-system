<?php

class PegawaiController extends BaseMasterController
{
    public function init()
    {
        $this->modelClass = 'Pegawai';
        $this->modelName = 'pegawai';
        $this->modelLabel = 'Pegawai';
        parent::init();
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            
            if ($model->delete()) {
                Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil dihapus.");
            }

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionCreateUser($id)
    {
        $pegawai = $this->loadModel($id);
        
        if ($pegawai->user !== null) {
            Yii::app()->user->setFlash('error', 'Pegawai ini sudah memiliki akun pengguna.');
            $this->redirect(array('view', 'id' => $id));
        }

        $model = new User;
        $model->pegawai_id = $id;

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Akun pengguna berhasil dibuat.');
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('createUser', array(
            'model' => $model,
            'pegawai' => $pegawai,
        ));
    }
} 