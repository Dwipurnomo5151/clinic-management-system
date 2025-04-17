<?php

class WilayahController extends BaseMasterController
{
    public function init()
    {
        $this->modelClass = 'Wilayah';
        $this->modelName = 'wilayah';
        $this->modelLabel = 'Wilayah';
        parent::init();
    }

    public function filters()
    {
        return array(
            'accessControl',
            array('application.filters.YXssFilter'),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('getParentOptions'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('admin','create','update','delete','index','view'),
                'roles'=>array('manageMasterData'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'roles'=>array('viewMasterData'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionGetParentOptions()
    {
        try {
            $tipe = Yii::app()->request->getParam('tipe');
            Yii::log("Getting parent options for tipe: " . $tipe, CLogger::LEVEL_INFO, 'wilayah');
            
            $parentType = '';
            switch($tipe) {
                case 'kabupaten':
                    $parentType = 'provinsi';
                    break;
                case 'kecamatan':
                    $parentType = 'kabupaten';
                    break;
                default:
                    throw new Exception('Tipe wilayah tidak valid: ' . $tipe);
            }

            $parents = Wilayah::model()->findAll(array(
                'condition' => 'tipe=:tipe AND status=:status',
                'params' => array(
                    ':tipe' => $parentType,
                    ':status' => 'aktif'
                ),
                'order' => 'nama ASC'
            ));
            
            Yii::log("Found " . count($parents) . " parent options", CLogger::LEVEL_INFO, 'wilayah');
            
            $options = array();
            $options[] = CHtml::tag('option', array('value'=>''), '- Pilih Wilayah Induk -');
            foreach($parents as $parent) {
                $options[] = CHtml::tag('option', array('value'=>$parent->id), CHtml::encode($parent->nama));
            }
            
            echo implode("\n", $options);

        } catch (Exception $e) {
            Yii::log("Error in getParentOptions: " . $e->getMessage(), CLogger::LEVEL_ERROR, 'wilayah');
            header('HTTP/1.1 500 Internal Server Error');
            echo CJSON::encode(array('error' => $e->getMessage()));
        }
    }

    public function actionGetKabupaten($provinsi_id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(400, 'Invalid request');
        }

        $kabupaten = Wilayah::model()->findAll(array(
            'condition' => 'parent_id = :parent_id AND tipe = :tipe AND status = :status',
            'params' => array(
                ':parent_id' => $provinsi_id,
                ':tipe' => 'kabupaten',
                ':status' => 'aktif'
            ),
            'order' => 'nama ASC',
        ));

        $options = array();
        $options[] = CHtml::tag('option', array('value'=>''), '- Pilih Kabupaten -');
        foreach($kabupaten as $kab) {
            $options[] = CHtml::tag('option', array('value'=>$kab->id), CHtml::encode($kab->nama));
        }
        
        echo implode("\n", $options);
    }

    public function actionGetKecamatan($kabupaten_id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(400, 'Invalid request');
        }

        $kecamatan = Wilayah::model()->findAll(array(
            'condition' => 'parent_id = :parent_id AND tipe = :tipe AND status = :status',
            'params' => array(
                ':parent_id' => $kabupaten_id,
                ':tipe' => 'kecamatan',
                ':status' => 'aktif'
            ),
            'order' => 'nama ASC',
        ));

        $options = array();
        $options[] = CHtml::tag('option', array('value'=>''), '- Pilih Kecamatan -');
        foreach($kecamatan as $kec) {
            $options[] = CHtml::tag('option', array('value'=>$kec->id), CHtml::encode($kec->nama));
        }
        
        echo implode("\n", $options);
    }

    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            
            try {
                $model->delete();
                
                if(!isset($_GET['ajax']))
                    Yii::app()->user->setFlash('success', 'Data wilayah berhasil dihapus.');
            } catch (Exception $e) {
                if(!isset($_GET['ajax']))
                    Yii::app()->user->setFlash('error', 'Gagal menghapus data wilayah. Data ini sedang digunakan.');
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
} 