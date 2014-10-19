<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $id
 * @property string $name
 * @property string $supplier_cd
 * @property string $tel
 * @property string $email
 * @property string $address
 * @property string $contact_person
 * @property string $mobile
 * @property string $qq
 * @property string $other_contact
 * @property string $remark
 * @property string $bank
 * @property string $open_account
 * @property string $account_owner
 * @property string $account_no
 * @property string $term_of_payment
 * @property string $create_date
 * @property string $create_by
 * @property string $last_update_date
 * @property string $last_update_by
 */
class Supplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Supplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, supplier_cd, create_by, last_update_by', 'required'),
			array('name, supplier_cd, email, address, contact_person, remark, bank, open_account, term_of_payment, create_by, last_update_by', 'length', 'max'=>255),
			array('tel', 'length', 'max'=>15),
			array('mobile, qq, other_contact, account_owner', 'length', 'max'=>20),
			array('account_no', 'length', 'max'=>40),
			array('create_date, last_update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, supplier_cd, tel, email, address, contact_person, mobile, qq, other_contact, remark, bank, open_account, account_owner, account_no, term_of_payment, create_date, create_by, last_update_date, last_update_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'supplier_cd' => 'Supplier Code',
			'tel' => 'Tel',
			'email' => 'Email',
			'address' => 'Address',
			'contact_person' => 'Contact Person',
			'mobile' => 'Mobile',
			'qq' => 'Qq',
			'other_contact' => 'Other Contact',
			'remark' => 'Remark',
			'bank' => 'Bank',
			'open_account' => 'Open Account',
			'account_owner' => 'Account Owner',
			'account_no' => 'Account No',
			'term_of_payment' => 'Term Of Payment',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'last_update_date' => 'Last Update Date',
			'last_update_by' => 'Last Update By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('supplier_cd',$this->supplier_cd,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('other_contact',$this->other_contact,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('open_account',$this->open_account,true);
		$criteria->compare('account_owner',$this->account_owner,true);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('term_of_payment',$this->term_of_payment,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('last_update_date',$this->last_update_date,true);
		$criteria->compare('last_update_by',$this->last_update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}