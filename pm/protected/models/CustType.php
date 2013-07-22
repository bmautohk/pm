<?php

/**
 * This is the model class for table "cust_type".
 *
 * The followings are the available columns in table 'cust_type':
 * @property integer $id
 * @property string $desc
 */
class CustType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CustType the static model class
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
		return 'cust_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desc', 'required'),
			array('desc', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, desc', 'safe', 'on'=>'search'),
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
			'desc' => 'Desc',
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
		$criteria->compare('desc',$this->desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getDropDownFromCache() {
		$list = Yii::app()->cache->get(GlobalConstants::CACHE_CUST_TYPE);
		if($list===false) {
			$criteria = new CDbCriteria();
			$criteria->order = 'id';
				
			$model = self::model();
			$model->setDbCriteria($criteria);
			$result = $model->findAll();
	
			$list = array();
			foreach ($result as $item) {
				$list[$item['id']] = $item['desc'];
			}
	
			Yii::app()->cache->set(GlobalConstants::CACHE_CUST_TYPE, $list, Yii::app()->params['dropdownCacheTime']);
		}
		return $list;
	}
}