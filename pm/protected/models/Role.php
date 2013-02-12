<?php

/**
 * This is the model class for table "role".
 *
 * The followings are the available columns in table 'role':
 * @property string $role_code
 * @property string $role
 */
class Role extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Role the static model class
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
		return 'role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_code, role', 'required'),
			array('role_code', 'length', 'max'=>1),
			array('role', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('role_code, role', 'safe', 'on'=>'search'),
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
				'role_matrix'=>array(self::HAS_MANY, 'RoleMatrix', 'role_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role_code' => 'Role Code',
			'role' => 'Role',
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

		$criteria->compare('role_code',$this->role_code,true);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getDropDownFromCache() {
		$list = Yii::app()->cache->get(GlobalConstants::CACHE_ROLE);
		if($list===false) {
			$criteria = new CDbCriteria();
			$criteria->order = 'role';
				
			$model = self::model();
			$model->setDbCriteria($criteria);
			$result = $model->findAll();
	
			$list = array();
			foreach ($result as $item) {
				$list[$item->role_code] = $item->role;
			}
	
			Yii::app()->cache->set(GlobalConstants::CACHE_ROLE, $list, Yii::app()->params['dropdownCacheTime']);
		}
		return $list;
	}
}