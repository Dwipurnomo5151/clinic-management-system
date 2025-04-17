<?php

class UserController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow authenticated users to perform certain actions
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->checkAccess("manageUsers")',
			),
			array('allow', // allow admin users to perform all actions
				'actions'=>array('create', 'update', 'delete'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->checkAccess("manageUsers")',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all users.
	 */
	public function actionIndex()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Displays a particular user.
	 * @param integer $id the ID of the user to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new user.
	 */
	public function actionCreate()
	{
		$model = new User;

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular user.
	 * @param integer $id the ID of the user to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular user.
	 * @param integer $id the ID of the user to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		// Allow both GET and POST requests for deletion
		if(Yii::app()->request->isPostRequest || Yii::app()->request->getRequestType() === 'GET')
		{
			try {
				$model->delete();
				Yii::app()->user->setFlash('success', 'User has been deleted successfully.');
				
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			} catch(Exception $e) {
				Yii::app()->user->setFlash('error', 'Failed to delete user: ' . $e->getMessage());
				$this->redirect(array('view', 'id'=>$id));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
} 