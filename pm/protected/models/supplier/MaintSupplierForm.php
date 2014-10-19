<?php
class MaintSupplierForm extends CFormModel {

	public $id;
	public $name;
	public $supplier_cd;
	public $tel;
	public $email;
	public $address;
	public $contact_person;
	public $mobile;
	public $qq;
	public $other_contact;
	public $notice;
	public $bank;
	public $open_account;
	public $account_owner;
	public $account_no;
	public $term_of_payment;
	public $remark;
	
	public function rules() {
		return array(
				array('name, supplier_cd', 'required'),
				array('id', 'safe', 'on'=>'add'),
				array('tel', 'length', 'max'=>'15'),
				array('mobile, qq, other_contact, account_owner', 'length', 'max'=>'20'),
				array('account_no', 'length', 'max'=>'40'),
				array('name, supplier_cd, address, email, address, contact_person, notice, bank, open_account, term_of_payment, remark', 'length', 'max'=>'255'),
				array('id', 'required', 'on'=>'update,delete'),
		);
	}
	
	public function find($id) {
		$model = Supplier::model()->findByPk($id);
		$this->id = $model->id;
		$this->name = $model->name;
		$this->supplier_cd = $model->supplier_cd;
		$this->tel = $model->tel;
		$this->email = $model->email;
		$this->address = $model->address;
		$this->contact_person = $model->contact_person;
		$this->mobile = $model->mobile;
		$this->qq = $model->qq;
		$this->other_contact = $model->other_contact;
		$this->notice = $model->notice;
		$this->bank = $model->bank;
		$this->open_account = $model->open_account;
		$this->account_owner = $model->account_owner;
		$this->account_no = $model->account_no;
		$this->term_of_payment = $model->term_of_payment;
		$this->remark = $model->remark;
	}
	
	public function create() {
		if (!$this->validate()) {
			return false;
		}

		$model = new Supplier();
		$model->supplier_cd = $this->supplier_cd;
		$model->name = $this->name;
		$model->tel = $this->tel;
		$model->email = $this->email;
		$model->address = $this->address;
		$model->contact_person = $this->contact_person;
		$model->mobile = $this->mobile;
		$model->qq = $this->qq;
		$model->other_contact = $this->other_contact;
		$model->notice = $this->notice;
		$model->bank = $this->bank;
		$model->open_account = $this->open_account;
		$model->account_owner = $this->account_owner;
		$model->account_no = $this->account_no;
		$model->term_of_payment = $this->term_of_payment;
		$model->remark = $this->remark;
		
		//$model->supplier_cd = 'temp';
		$model->create_by = Yii::app()->user->name;
		$model->create_date = new CDbExpression('NOW()');
		$model->last_update_by = Yii::app()->user->name;
		$model->last_update_date = new CDbExpression('NOW()');
		
		$result = $model->save();
		if ($result) {
			// Set supplier_cd = id
			/* $model->supplier_cd = $model->id;
			$result = $model->save(); */
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

		$model = Supplier::model()->findByPk($this->id);
		$model->name = $this->name;
		$model->supplier_cd = $this->supplier_cd;
		$model->tel = $this->tel;
		$model->email = $this->email;
		$model->address = $this->address;
		$model->contact_person = $this->contact_person;
		$model->mobile = $this->mobile;
		$model->qq = $this->qq;
		$model->other_contact = $this->other_contact;
		$model->notice = $this->notice;
		$model->bank = $this->bank;
		$model->open_account = $this->open_account;
		$model->account_owner = $this->account_owner;
		$model->account_no = $this->account_no;
		$model->term_of_payment = $this->term_of_payment;
		$model->remark = $this->remark;
		
		$model->last_update_by = Yii::app()->user->name;
		$model->last_update_date = new CDbExpression('NOW()');
		
		$saveAttributes = array('supplier_cd', 'name', 'tel', 'email', 'address', 'contact_person', 'mobile', 'qq', 'other_contact', 'notice', 'bank', 'open_account', 'account_owner', 'account_no', 'term_of_payment', 'remark');
	
		if ($model->save(true, $saveAttributes)) {
			return true;
		}
		else {
			$this->addErrors($model->errors);
			return false;
		}
	}
	
	public function delete() {
		$model = Supplier::model()->findByPk($this->id);
		return $model->delete();
	}
	
}