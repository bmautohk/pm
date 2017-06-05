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
			
			// Is retail?
			$role = Role::model()->findByPk($user->role_code);
			$this->setState('is_retail', $role->is_retail == Role::IS_REATIL_YES? true : false);
			
			// Allow to view internal product?
			$this->setState('is_allow_internal', $role->is_allow_internal == Role::IS_ALLOW_INTERNAL_YES? true : false);
			
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
			
			// Update country
			try {
				$ip = $this->getIP();
				//http://ip-api.com/json/208.80.152.201
				//$url='http://getcitydetails.geobytes.com/GetCityDetails?fqcn='.$ip;
				$url='http://ip-api.com/json/'.$ip;
				$ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch,CURLOPT_TIMEOUT,5);
                        $str = curl_exec($ch);
                        curl_close($ch);
						
				//$str= file_get_contents($url,false,$ctx);
				$tags = json_decode($str, true);
				//$user->country = $tags['geobytescountry'];
				$user->country = $tags['country'];
				$user->ip = $ip;
			} catch (Exception $e) {
				Yii::log($e->getMessage(), 'error', 'pm.components.UserIdentity');
				$user->country = '';
				$user->ip = '';
			}
			
			// Update last login date
			$user->last_login = new CDbExpression('NOW()');
			$user->save(true, array('last_login', 'country', 'ip'));
			
			return true;
		}
	}
	
	function getIP() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}
}