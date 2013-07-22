<?php
class MaintCustomerForm extends CFormModel {

	public $id;
	public $name;
	public $fax;
	public $address;
	public $address2;
	public $email;
	public $cust_group;
	public $cust_types;
	public $where_to_find;
	public $where_to_find_detail;
	public $tel;
	public $tel2;
	public $mobile_no;
	public $mobile_no2;
	public $contact_person;
	public $contact_salesman;
	public $other_contact;
	public $website;
	public $vip;
	public $remark;
	public $salesman_remark;
	
	public function rules() {
		return array(
				array('cust_group, cust_types, where_to_find, name', 'required'),
				array('id', 'safe', 'on'=>'add'),
				array('tel, tel2, fax', 'length', 'max'=>'15'),
				array('mobile_no, mobile_no2', 'length', 'max'=>'50'),
				array('name, where_to_find_detail, contact_person, contact_salesman, other_contact, address, address2, email, website, remark, salesman_remark', 'length', 'max'=>'255'),
				array('id', 'required', 'on'=>'update,delete'),
				array('vip', 'safe'),
		);
	}
	
	public function find($id) {
		$model = Customer::model()->findByPk($id);
		
		$this->id = $model->id;
		$this->name = $model->name;
		$this->fax = $model->fax;
		$this->address = $model->address;
		$this->address2 = $model->address2;
		$this->email = $model->email;
		$this->cust_group = $model->cust_group;
		$this->where_to_find = $model->where_to_find;
		$this->where_to_find_detail = $model->where_to_find_detail;
		$this->tel = $model->tel;
		$this->tel2 = $model->tel2;
		$this->mobile_no = $model->mobile_no;
		$this->mobile_no2 = $model->mobile_no2;
		$this->contact_person = $model->contact_person;
		$this->contact_salesman = $model->contact_salesman;
		$this->other_contact = $model->other_contact;
		$this->website = $model->website;
		$this->vip = $model->vip;
		$this->remark = $model->remark;
		$this->salesman_remark = $model->salesman_remark;
		
		$this->cust_types = array();
		foreach($model->customerCustTypes() as $customer_cust_type) {
			$this->cust_types[] = $customer_cust_type->cust_type_id;
		}
	}
	
	public function create() {
		if (!$this->validate()) {
			return false;
		}

		$model = new Customer();
		$model->name = $this->name;
		$model->fax = $this->fax;
		$model->address = $this->address;
		$model->address2 = $this->address2;
		$model->email = $this->email;
		$model->cust_group = $this->cust_group;
		$model->where_to_find = $this->where_to_find;
		$model->where_to_find_detail = $this->where_to_find_detail;
		$model->tel = $this->tel;
		$model->tel2 = $this->tel2;
		$model->mobile_no = $this->mobile_no;
		$model->mobile_no2 = $this->mobile_no2;
		$model->contact_person = $this->contact_person;
		$model->contact_salesman = $this->contact_salesman;
		$model->other_contact = $this->other_contact;
		$model->website = $this->website;
		$model->vip = $this->vip;
		$model->remark = $this->remark;
		$model->salesman_remark = $this->salesman_remark;

		$model->create_by = Yii::app()->user->name;
		$model->create_date = new CDbExpression('NOW()');
		$model->last_update_by = Yii::app()->user->name;
		$model->last_update_date = new CDbExpression('NOW()');
		
		$result = $model->save();
		if ($result) {
			// Save cust_type
			foreach ($this->cust_types as $cust_type) {
				$custTypeModel = new CustomerCustType();
				$custTypeModel->customer_id = $model->id;
				$custTypeModel->cust_type_id = $cust_type;
				$custTypeModel->save();
			}
			
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
		$model->fax = $this->fax;
		$model->address = $this->address;
		$model->address2 = $this->address2;
		$model->email = $this->email;
		$model->cust_group = $this->cust_group;
		$model->where_to_find = $this->where_to_find;
		$model->where_to_find_detail = $this->where_to_find_detail;
		$model->tel = $this->tel;
		$model->tel2 = $this->tel2;
		$model->mobile_no = $this->mobile_no;
		$model->mobile_no2 = $this->mobile_no2;
		$model->contact_person = $this->contact_person;
		$model->contact_salesman = $this->contact_salesman;
		$model->other_contact = $this->other_contact;
		$model->website = $this->website;
		$model->vip = $this->vip;
		$model->remark = $this->remark;
		$model->salesman_remark = $this->salesman_remark;
		
		$model->last_update_by = Yii::app()->user->name;
		$model->last_update_date = new CDbExpression('NOW()');
	
		$saveAttributes = array('name', 'fax', 'address', 'address2', 'email', 'cust_group', 'cust_type', 'where_to_find', 'where_to_find_detail', 'tel', 'tel2',
				'mobile_no', 'mobile_no2', 'contact_person', 'contact_salesman', 'other_contact', 'website', 'vip', 'remark', 'salesman_remark', 'last_update_date', 'last_update_by');

		// Validate
		if ($model->validate()) {
			if ($this->where_to_find != GlobalConstants::WHERE_TO_FIND_CUSTOMER_TARGET_CUSTOMER && empty($this->where_to_find_detail)) {
				$this->addErrors(array('where_to_find_detail'=>'Please fill in where to find.'));
				return false;
			}
		}
		else {
			$this->addErrors($model->errors);
			return false;
		}
		
		// Save
		if ($model->save(false, $saveAttributes)) {
			// Delete existing cust type
			CustomerCustType::model()->deleteAllByAttributes(array('customer_id'=>$model->id));
			
			// Save cust_type
			foreach ($this->cust_types as $cust_type) {
				$custTypeModel = new CustomerCustType();
				$custTypeModel->customer_id = $model->id;
				$custTypeModel->cust_type_id = $cust_type;
				$custTypeModel->save();
			}
			
			return true;
		}
		else {
			$this->addErrors($model->errors);
			return false;
		}
	}
	
	public function delete() {
		$model = Customer::model()->findByPk($this->id);
		if ($model->delete()) {
			// Delete existing cust type
			return CustomerCustType::model()->deleteAllByAttributes(array('customer_id'=>$model->id)) > 0 ? true : false;
		} else {
			return false;
		}
	}
}