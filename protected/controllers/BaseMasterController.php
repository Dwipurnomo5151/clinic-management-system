<?php

abstract class BaseMasterController extends Controller
{
    public $layout = '//layouts/main';
    public $modelClass;
    public $modelName;
    public $modelLabel;

    public function init()
    {
        parent::init();
        if ($this->modelClass === null) {
            throw new CException('The "modelClass" property must be set.');
        }
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create', 'update', 'delete'),
                'users' => array('@'),
                'expression' => 'Yii::app()->user->checkAccess("manageMasterData")',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new $this->modelClass('search');
        $model->unsetAttributes();
        if (isset($_GET[$this->modelClass])) {
            $model->attributes = $_GET[$this->modelClass];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new $this->modelClass;

        if (isset($_POST[$this->modelClass])) {
            $model->attributes = $_POST[$this->modelClass];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil ditambahkan.");
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST[$this->modelClass])) {
            $model->attributes = $_POST[$this->modelClass];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil diperbarui.");
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            $model->status = 'nonaktif';
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Data {$this->modelLabel} berhasil dinonaktifkan.");
            }

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function loadModel($id)
    {
        $model = $this->modelClass::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
} 