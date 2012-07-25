<?php

/**
 * This is the model class for table "made".
 *
 * The followings are the available columns in table 'made':
 * @property integer $made_id
 * @property string $made
 */
class Made extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Made the static model class
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
		return 'vw_made';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('made', 'safe', 'on'=>'search'),
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
			'made' => 'Made',
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

		$criteria->compare('made',$this->made,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getDropDownFromCache() {
		$list = Yii::app()->cache->get(GlobalConstants::CACHE_MADE);
		if($list===false) {
			$criteria = new CDbCriteria();
			$criteria->order = 'made';
			
			$model = self::model();
			$model->setDbCriteria($criteria);
			$result = $model->findAll(array('select'=>'made'));
	
			$list = array();
			foreach ($result as $item) {
				$list[$item['made']] = $item['made'];
			}
	
			Yii::app()->cache->set(GlobalConstants::CACHE_MADE, $list, Yii::app()->params['dropdownCacheTime']);
		}
		return $list;
	}
}