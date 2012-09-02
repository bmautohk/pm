<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = Authorize::model()->find(
				array(
					'select'=>'username',  // add ONLY the columns you need
					'condition'=>'username=:uname AND password = PASSWORD(:up)',
					'params'=>array(':uname'=>$this->username, ':up'=>$this->password)
				));
		
		if ($user == null) {
			// No user found or invliad password
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			return false;
		}
		else {
			$this->errorCode=self::ERROR_NONE;
			// Store the role in a session:
			$this->setState('role', 'USER');
			return true;
		}
	}
}