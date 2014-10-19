<?php
class SupplierSearchForm extends CFormModel {
	public $itemCount;
	
	public $name;
	public $supplier_id;
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
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, supplier_id, supplier_cd, tel, email, address, contact_person, mobile, qq, other_contact, notice, bank, open_account, account_owner, account_no, term_of_payment, itemCount', 'safe'),
		);
	}

	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL)
	{
		return new CActiveDataProvider(get_class(new Supplier), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria()
	{
		$criteria = new CDbCriteria();
		
		$criteria->compare('name', trim($this->name), true);
		$criteria->compare('id', trim($this->supplier_id));
		$criteria->compare('supplier_cd', trim($this->supplier_cd), true);
		$criteria->compare('tel', trim($this->tel), true);
		$criteria->compare('email', trim($this->email), true);
		$criteria->compare('address', trim($this->address), true);
		$criteria->compare('contact_person', trim($this->contact_person), true);
		$criteria->compare('mobile', trim($this->mobile), true);
		$criteria->compare('qq', trim($this->qq), true);
		$criteria->compare('other_contact', trim($this->other_contact), true);
		$criteria->compare('notice', trim($this->notice), true);
		$criteria->compare('bank', trim($this->bank), true);
		$criteria->compare('open_account', trim($this->open_account), true);
		$criteria->compare('account_owner', trim($this->account_owner), true);
		$criteria->compare('account_no', trim($this->account_no), true);
		$criteria->compare('term_of_payment', trim($this->term_of_payment), true);
		
		$criteria->order = 'id desc';
		
		return $criteria;
	}
}