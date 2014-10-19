<?php

/**
 * This is the model class for table "role_page_matrix".
 *
 * The followings are the available columns in table 'role_page_matrix':
 * @property integer $id
 * @property string $role_code
 * @property string $page
 * @property string $permission
 */
class RolePageMatrix extends CActiveRecord
{
	
	const PERMISSION_READ = 'R';
	const PERMISSION_WRITE = 'W';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RolePageMatrix the static model class
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
		return 'role_page_matrix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_code, page, permission', 'required'),
			array('role_code', 'length', 'max'=>20),
			array('page', 'length', 'max'=>50),
			array('permission', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role_code, page, permission', 'safe', 'on'=>'search'),
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
			'role_code' => 'Role Code',
			'page' => 'Page',
			'permission' => 'Permission',
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
		$criteria->compare('role_code',$this->role_code,true);
		$criteria->compare('page',$this->page,true);
		$criteria->compare('permission',$this->permission,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}