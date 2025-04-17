<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_role;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('username' => $this->username));
		
		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->_id = $user->id;
			$this->_role = $user->role;
			$this->setState('role', $user->role);
			$this->errorCode = self::ERROR_NONE;

			// Assign role if not already assigned
			$auth = Yii::app()->authManager;
			$assignment = $auth->getAuthAssignment($user->role, $user->id);
			if (!$assignment) {
				$auth->assign($user->role, $user->id);
			}
		}
		
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getRole()
	{
		return $this->_role;
	}
}