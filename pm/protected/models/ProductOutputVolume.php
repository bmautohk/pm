<?php

/**
 * This is the model class for table "product_output_volume".
 *
 * The followings are the available columns in table 'product_output_volume':
 * @property string $no_jp
 * @property integer $total_unit
 * @property integer $unit_1_mth
 * @property integer $unit_2_week
 */
class ProductOutputVolume extends CActiveRecord
{
	
	const SOURCE_S1 = "S1";
	const SOURCE_S1CN = "S1CN";
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductOutputVolume the static model class
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
		return 'product_output_volume';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_jp, total_unit, unit_1_mth, unit_2_week', 'required'),
			array('total_unit, unit_1_mth, unit_2_week', 'numerical', 'integerOnly'=>true),
			array('no_jp', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_jp, total_unit, unit_1_mth, unit_2_week', 'safe', 'on'=>'search'),
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
			'no_jp' => 'No Jp',
			'total_unit' => 'Total Unit',
			'unit_1_mth' => 'Unit 1 Mth',
			'unit_2_week' => 'Unit 2 Week',
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

		$criteria->compare('no_jp',$this->no_jp,true);
		$criteria->compare('total_unit',$this->total_unit);
		$criteria->compare('unit_1_mth',$this->unit_1_mth);
		$criteria->compare('unit_2_week',$this->unit_2_week);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}