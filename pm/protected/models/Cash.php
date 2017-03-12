<?php

/**
 * This is the model class for table "cash".
 *
 * The followings are the available columns in table 'cash':
 * @property integer $id
 * @property string $pay_from
 * @property string $pay_to
 * @property string $account
 * @property string $desc
 * @property string $rmb
 * @property string $hkd
 * @property string $jpy
 * @property string $remark
 * @property string $image_name
 * @property string $created_by
 * @property string $created_date
 * @property string $last_updated_by
 * @property string $last_updated_date
 */
class Cash extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cash the static model class
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
		return 'cash';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_date, last_updated_date', 'safe'),
			array('pay_from, pay_to', 'required'),
			array('pay_from, pay_to, account', 'length', 'max'=>100),
			array('desc, remark', 'length', 'max'=>255),
			//array('rmb, hkd, jpy', 'length', 'max'=>8),
			array('image_name', 'length', 'max'=>50),
			array('created_by, last_updated_by', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pay_from, pay_to, account, desc, rmb, hkd, jpy, remark, image_name, created_by, created_date, last_updated_by, last_updated_date', 'safe', 'on'=>'search'),
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
			'pay_from' => 'Pay From',
			'pay_to' => 'Pay To',
			'account' => 'Account',
			'desc' => 'Desc',
			'rmb' => 'Rmb',
			'hkd' => 'Hkd',
			'jpy' => 'Jpy',
			'remark' => 'Remark',
			'image_name' => 'Image Name',
			'created_by' => 'Created By',
			'created_date' => 'Create Date',
			'last_updated_by' => 'Last Updated By',
			'last_updated_date' => 'Last Updated Date',
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
		$criteria->compare('pay_from',$this->pay_from,true);
		$criteria->compare('pay_to',$this->pay_to,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('rmb',$this->rmb,true);
		$criteria->compare('hkd',$this->hkd,true);
		$criteria->compare('jpy',$this->jpy,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('image_name',$this->image_name,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('last_updated_by',$this->last_updated_by,true);
		$criteria->compare('last_updated_date',$this->last_updated_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->created_by = strtolower($this->created_by);
			$this->created_date = new CDbExpression('NOW()');
		}
		
		$this->last_updated_by = strtolower($this->last_updated_by);
		$this->last_updated_date = new CDbExpression('NOW()');
		
		return parent::beforeSave();
	}
}