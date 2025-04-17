<?php

class TindakanController extends BaseMasterController
{
    public function init()
    {
        $this->modelClass = 'Tindakan';
        $this->modelName = 'tindakan';
        $this->modelLabel = 'Tindakan';
        parent::init();
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'view'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('create', 'update', 'delete', 'permanentDelete'),
                'users'=>array('@'),
                'expression'=>'Yii::app()->user->checkAccess("manageMasterData")',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            
            // Cek apakah data sudah digunakan dalam transaksi
            if($this->isDataUsed($model)) {
                $model->status = 'nonaktif';
                if($model->save()) {
                    Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil dinonaktifkan.");
                }
            } else {
                // Jika belum pernah digunakan, bisa dihapus permanen
                $model->delete();
                Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil dihapus permanen.");
            }

            if(!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Memeriksa apakah data sudah digunakan dalam transaksi
     * @param Tindakan $model
     * @return boolean
     */
    protected function isDataUsed($model)
    {
        // TODO: Implementasikan logika untuk memeriksa apakah tindakan sudah digunakan
        // Contoh: return Pemeriksaan::model()->exists('tindakan_id=:id', array(':id'=>$model->id));
        return false;
    }

    public function actionPermanentDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            $model->delete();
            Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil dihapus permanen.");

            if(!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
} 