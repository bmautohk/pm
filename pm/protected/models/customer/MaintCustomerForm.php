<?php
class MaintCustomerForm extends CFormModel {

	public $id;
	public $cust_cd;
	public $name;
	public $tel;
	public $fax;
	public $address;
	public $contact_person;
	public $email;
	
	public function rules() {
		return array(
				array('name, email', 'required'),
				array('id', 'safe', 'on'=>'add'),
				array('tel, fax', 'length', 'max'=>'15'),
				array('name, contact_person, address, email', 'length', 'max'=>'255'),
				array('id', 'required', 'on'=>'update,delete'),
				array('cust_cd', 'safe'),
		);
	}
	
	public function find($id) {
		$model = Customer::model()->findByPk($id);
		$this->id = $model->id;
		$this->cust_cd = $model->cust_cd;
		$this->name = $model->name;
		$this->tel = $model->tel;
		$this->fax = $model->fax;
		$this->address = $model->address;
		$this->contact_person = $model->contact_person;
		$this->email = $model->email;
	}
	
	public function create() {
		if (!$this->validate()) {
			return false;
		}

		$model = new Customer();
		$model->name = $this->name;
		$model->tel = $this->tel;
		$model->fax = $this->fax;
		$model->address = $this->address;
		$model->contact_person = $this->contact_person;
		$model->email = $this->email;
		
		$model->cust_cd = 'temp';
		$model->create_by = Yii::app()->user->name;
		$model->create_date = new CDbExpression('NOW()');
		$model->last_update_by = Yii::app()->user->name;
		$model->last_update_date = new CDbExpression('NOW()');
		
		$result = $model->save();
		if ($result) {
			// Set cust_cd = id
			$model->cust_cd = $model->id;
			$result = $model->save();
			return true;
		}
		else {
			$this->addErrors($model->errors);
			return false;
		}
	}
	
	public function update() {
		if (!$this->validate()) {
			return false;
		}

		$model = Customer::model()->findByPk($this->id);
		$model->name = $this->name;
		$model->tel = $this->tel;
		$model->fax = $this->fax;
		$model->address = $this->address;
		$model->contact_person = $this->contact_person;
		$model->email = $this->email;
		
		$model->last_update_by = Yii::app()->user->name;
		$model->last_update_date = new CDbExpression('NOW()');
	
		$saveAttributes = array('name', 'tel', 'fax', 'address', 'contact_person', 'email');
	
		if ($model->save(true, $saveAttributes)) {
			return true;
		}
		else {
			$this->addErrors($model->errors);
			return false;
		}
	}
	
	public function delete() {
		$model = Customer::model()->findByPk($this->id);
		return $model->delete();
	}
	
}