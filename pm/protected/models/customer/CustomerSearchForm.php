<?php
class CustomerSearchForm extends CFormModel {
	public $itemCount;
	
	public $name;
	public $cust_cd;
	public $tel;
	public $fax;
	public $address;
	public $contact_person;
	public $email;
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, cust_cd, tel, fax, address, contact_person, email, itemCount', 'safe'),
		);
	}

	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL)
	{
		return new CActiveDataProvider(get_class(new Customer), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria()
	{
		$criteria = new CDbCriteria();
		
		$criteria->compare('name', trim($this->name), true);
		$criteria->compare('cust_cd', trim($this->cust_cd), true);
		$criteria->compare('tel', trim($this->tel), true);
		$criteria->compare('fax', trim($this->fax), true);
		$criteria->compare('address', trim($this->address), true);
		$criteria->compare('contact_person', trim($this->contact_person), true);
		$criteria->compare('email', trim($this->email), true);
		
		$criteria->order = 'id desc';
		
		return $criteria;
	}
}