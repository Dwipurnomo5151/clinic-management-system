<?php

class ObatController extends BaseMasterController
{
    public function init()
    {
        $this->modelClass = 'Obat';
        $this->modelName = 'obat';
        $this->modelLabel = 'Obat';
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

    public function actionUpdateStok($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Obat'])) {
            $model->attributes = $_POST['Obat'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Stok obat berhasil diperbarui.');
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateStok', array(
            'model' => $model,
        ));
    }
} 