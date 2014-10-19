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
					'select'=>'username, role_code',  // add ONLY the columns you need
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
			$this->setState('role', $user->role_code);
			
			// Retrieve column permission
			$tempRoleColumnMatrix = RoleColumnMatrix::model()->findAllByAttributes(array('role_code'=>$user->role_code));
			
			$prevTableName = '';
			$roleMatrix = array();
			foreach ($tempRoleColumnMatrix as $item) {
				if ($item->table_name != $prevTableName) {
					$roleMatrix[$item->table_name] = array();
					$prevTableName = $item->table_name;
				}
				
				$roleMatrix[$item->table_name][] = $item->column_name;
			}
			
			$this->setState('role_matrix', $roleMatrix);
			
			// Retrieve corresponding supplier
			if ($user->role_code == GlobalConstants::ROLE_SUPPLIER) {
				$userSupplier = UserSupplier::model()->findByPk($this->username);
				$this->setState('supplier', $userSupplier->supplier);
			}
			
			// Retrieve page permission
			$tempRolePageMatrixes = RolePageMatrix::model()->findAllByAttributes(array('role_code'=>$user->role_code));
			$rolePageMatrixes = array();
			foreach ($tempRolePageMatrixes as $rolePageMatrix) {
				$rolePageMatrixes[$rolePageMatrix->page] = $rolePageMatrix->permission;
			}
			$this->setState('role_page_matrix', $rolePageMatrixes);
			
			// Update last login date
			$user->last_login = new CDbExpression('NOW()');
			$user->save(true, array('last_login'));
			
			return true;
		}
	}
}