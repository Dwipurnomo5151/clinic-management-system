<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
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
			array('allow',
				'actions'=>array('login'),
				'users'=>array('*'),
			),
			array('allow',
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Checks if the current user has the specified permission
	 * @param string $permission the permission to check
	 * @return boolean whether the user has the permission
	 */
	public function hasPermission($permission)
	{
		return Yii::app()->user->checkAccess($permission);
	}

	/**
	 * Checks if the current user has the specified role
	 * @param string $role the role to check
	 * @return boolean whether the user has the role
	 */
	public function hasRole($role)
	{
		return Yii::app()->user->checkAccess($role);
	}

	/**
	 * Gets the current user's role
	 * @return string the user's role
	 */
	public function getUserRole()
	{
		$auth = Yii::app()->authManager;
		$assignments = $auth->getAuthAssignments(Yii::app()->user->id);
		foreach ($assignments as $assignment) {
			$item = $auth->getAuthItem($assignment->itemname);
			if ($item->type == 2) { // 2 is the type for roles
				return $item->name;
			}
		}
		return null;
	}

	/**
	 * Gets the current user's role name for display
	 * @return string the user's role name
	 */
	public function getUserRoleName()
	{
		$role = $this->getUserRole();
		switch ($role) {
			case 'admin':
				return 'Administrator';
			case 'petugas_pendaftaran':
				return 'Petugas Pendaftaran';
			case 'dokter':
				return 'Dokter';
			case 'kasir':
				return 'Kasir';
			default:
				return 'Pengguna';
		}
	}
}