<?php
class MaintRoleForm extends CFormModel {
	public $role_code;
	public $role;
	public $is_retail;
	public $is_allow_internal ;
	
	public function rules() {
		return array(
			array('role', 'required'),
			array('role_code', 'required', 'on'=>'add'),
			array('role_code', 'length', 'max'=>'2', 'on'=>'add'),
			array('role_code', 'safe', 'on'=>'update,delete'),
			array('is_retail, is_allow_internal', 'safe'),
		);
	}
	
	public function find($role_code) {
		$model = Role::model()->findByPk($role_code);
		$this->role_code = $model->role_code;
		$this->role = $model->role;
		$this->is_retail = $model->is_retail;
		$this->is_allow_internal = $model->is_allow_internal;
	}
	
	public function create() {
		if (!$this->validate()) {
			return false;
		}
		
		// Check duplicate role & role code
		// TODO
		
		$model = new Role();
		$model->role_code = $this->role_code;
		$model->role = $this->role;
		$model->is_retail = $this->is_retail;
		$model->is_allow_internal = $this->is_allow_internal;
		
		$result = $model->save();
		if ($result) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function update() {
		if (!$this->validate()) {
			return false;
		}
		
		// Check role code
		// TODO
		
		$model = Role::model()->findByPk($this->role_code);
		$model->role = $this->role;
		$model->is_retail = $this->is_retail;
		$model->is_allow_internal = $this->is_allow_internal;
		
		$saveAttributes = array('role', 'is_retail', 'is_allow_internal');
		
		if ($model->save(true, $saveAttributes)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function delete() {
		if (!empty($this->role_code)) {
			// Update user's role to blank
			$criteria = new CDbCriteria();
			$criteria->compare('role_code', $this->role_code);
			Authorize::model()->updateAll(array('role_code'=>''), $criteria);
			
			// Delete role matrix
			RoleColumnMatrix::model()->deleteAll($criteria);
			RolePageMatrix::model()->deleteAll($criteria);
			
			// Delete role
			$model = Role::model()->findByPk($this->role_code);
			return $model->delete();
		}
		else {
			return false;
		}
	}

}