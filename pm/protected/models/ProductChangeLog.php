<?php

/**
 * This is the model class for table "product_change_log".
 *
 * The followings are the available columns in table 'product_change_log':
 * @property integer $id
 * @property integer $prod_sn
 * @property string $column_name
 * @property string $old_value
 * @property string $new_value
 * @property string $create_date
 */
class ProductChangeLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductChangeLog the static model class
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
		return 'product_change_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prod_sn, column_name, old_value, new_value, create_by, create_date', 'safe'),
			array('prod_sn', 'numerical', 'integerOnly'=>true),
			array('column_name', 'length', 'max'=>50),
			array('old_value, new_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, prod_sn, column_name, old_value, new_value, create_date', 'safe', 'on'=>'search'),
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
			'prod_sn' => 'Prod Sn',
			'column_name' => 'Column Name',
			'old_value' => 'Old Value',
			'new_value' => 'New Value',
			'create_date' => 'Create Date',
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
		$criteria->compare('prod_sn',$this->prod_sn);
		$criteria->compare('column_name',$this->column_name,true);
		$criteria->compare('old_value',$this->old_value,true);
		$criteria->compare('new_value',$this->new_value,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}