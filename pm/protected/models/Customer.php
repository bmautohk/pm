<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property string $cust_cd
 * @property string $name
 * @property string $tel
 * @property string $fax
 * @property string $contact_person
 * @property string $address
 * @property string $email
 * @property string $create_date
 * @property string $create_by
 * @property string $last_update_date
 * @property string $last_update_by
 */
class Customer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customer the static model class
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
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cust_cd, email', 'required'),
			array('cust_cd, name, contact_person, address, email, create_by, last_update_by', 'length', 'max'=>255),
			array('tel, fax', 'length', 'max'=>15),
			array('create_date, last_update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cust_cd, name, tel, fax, contact_person, address, email, create_date, create_by, last_update_date, last_update_by', 'safe', 'on'=>'search'),
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
			'cust_cd' => 'Cust Cd',
			'name' => 'Name',
			'tel' => 'Tel',
			'fax' => 'Fax',
			'contact_person' => 'Contact Person',
			'address' => 'Address',
			'email' => 'Email',
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
		$criteria->compare('cust_cd',$this->cust_cd,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('last_update_date',$this->last_update_date,true);
		$criteria->compare('last_update_by',$this->last_update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}