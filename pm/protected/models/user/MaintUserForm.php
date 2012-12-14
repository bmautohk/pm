<?php
class MaintUserForm extends CFormModel {
	public $username;
	public $password;
	public $role_code;
	public $supplier;
	
	public function rules() {
		return array(
			array('username, role_code, supplier', 'required'),
			array('password', 'required', 'on'=>'add'),
			array('password', 'safe', 'on'=>'update'),
		);
	}
	
	public function find($username) {
		$model = Authorize::model()->findByPk($username);
		$this->username = $model->username;
		$this->role_code = $model->role_code;
		
		if ($model->role_code == GlobalConstants::ROLE_SUPPLIER) {
			$userSupplier = UserSupplier::model()->findByAttributes(array('username'=>$model->username));
			$this->supplier = $userSupplier->supplier;
		}
	}
	
	public function create() {
		if (!$this->validate()) {
			return false;
		}
		
		$model = new Authorize();
		$model->username = $this->username;
		$model->password = new CDbExpression('password(\''.$this->password.'\')');
		$model->role_code = $this->role_code;
		
		$result = $model->save();
		if ($result) {
			if ($this->role_code == GlobalConstants::ROLE_SUPPLIER) {
				// Create mapping between login user and supplier
				$userSupplier = new UserSupplier();
				$userSupplier->username = $this->username;
				$userSupplier->supplier = $this->supplier;
				return $userSupplier->save();
			}
			return true;
		}
		else {
			return false;
		}
	}
	
	public function update() {
		if (!$this->validate()) {
			var_dump($this->getErrors());
			return false;
		}
		
		$model = Authorize::model()->findByPk($this->username);
		$model->role_code = $this->role_code;
		
		if (trim($this->password) != '') {
			$model->password = new CDbExpression('password(\''.$this->password.'\')');
			$saveAttributes = array('password', 'role_code');
		}
		else {
			$saveAttributes = array('role_code');
		}
		
		if ($model->save(true, $saveAttributes)) {
			if ($this->role_code == GlobalConstants::ROLE_SUPPLIER) {
				// Find mapping between login user and supplier
				$userSupplier = UserSupplier::model()->findByPk($this->username);
				
				if ($userSupplier != NULL) {
					// Update
					$userSupplier->supplier = $this->supplier;
					return $userSupplier->save(true, array('supplier'));
				}
				else {
					// Create new one
					$userSupplier = new UserSupplier();
					$userSupplier->username = $this->username;
					$userSupplier->supplier = $this->supplier;
					return $userSupplier->save();
				}
			}
			else {
				// Delete user supplier mapping if exist
				UserSupplier::model()->deleteByPk($this->username);
				return true;
			}
		}
		else {
			return false;
		}
	}
	
	public function delete() {
		// Delete user supplier mapping if exist
		UserSupplier::model()->deleteByPk($this->username);
		
		// Delete user
		$model = Authorize::model()->findByPk($this->username);
		return $model->delete();
	}
	
	public function getSupplierDropdown() {
		$criteria = new CDbCriteria();
		$criteria->select = 'supplier';
		$criteria->distinct = true;
		$criteria->order = 'supplier';
		$criteria->compare('supplier', '<> ');
		
		$products = ProductMaster::model()->findAll($criteria);
		$options = array();
		foreach ($products as $product) {
			$options[$product->supplier] = $product->supplier;
		}
		
		return $options;
	}
}