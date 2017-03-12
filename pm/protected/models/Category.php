<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $name
 * @property string $create_date
 * @property string $create_by
 * @property string $last_update_date
 * @property string $last_update_by
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('create_by, last_update_by', 'length', 'max'=>20),
			array('create_date, create_by, last_update_date, last_update_by', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, name, create_date, create_by, last_update_date, last_update_by', 'safe', 'on'=>'search'),
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
			//'product_category'=>array(self::HAS_MANY, 'ProductCategory', 'category_id'),
			'products'=>array(self::HAS_MANY, 'ProductCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'name' => 'Name',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('name',$this->name);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('last_update_date',$this->last_update_date,true);
		$criteria->compare('last_update_by',$this->last_update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function findByProductId($product_id) {
		return $this->with('products')->findAll(array('condition' => 'product_id = :product_id', 'params' => array(':product_id' => $product_id)));
	}

	public function deleteWithChild($categoryId) {
		$subCategoryList = array();
		$subCategoryList = self::listSubCategory($subCategoryList, $categoryId, $lv);

		if (!empty($subCategoryList)) {
			foreach ($subCategoryList as $subCategory) {
				$model = Category::model()->findByPk($subCategory->id);
				$model->delete();
			}
		}

		$model = Category::model()->findByPk($categoryId);
		$model->delete();
	}

	public static function getDropDownFromCache() {
		$list = Yii::app()->cache->get(GlobalConstants::CACHE_CATEGORY);

		if($list===false) {
			$categories = self::listCategory();

			$list = array();
			foreach ($categories as $category) {
				$label = '';

				if ($category->level > 0) {
					for ($i = 0; $i < ($category->level - 1); $i++) {
						$label .= "　";
					}

					$label .= "|---";
				}

				$list[$category->id] = $label.$category->name;
			}

			Yii::app()->cache->set(GlobalConstants::CACHE_CATEGORY, $list, Yii::app()->params['dropdownCacheTime']);
		}

		return $list;
	}

	public static function deleteCache() {
		Yii::app()->cache->delete(GlobalConstants::CACHE_CATEGORY);
	}

	public static function listCategory() {
		$arr = array();

		$categories	= Category::model()
					->findAllByAttributes(array('parent_id'=>NULL));
		
		if (empty($categories)) {
			return $arr;
		}

		foreach ($categories as $category) {
			$vo = new CategoryVO();
			$vo->id = $category->id;
			$vo->name = $category->name;
			$vo->level = 0;
			$arr[] = $vo;

			$arr = self::listSubCategory($arr, $category->id, 1);
		}

		return $arr;
	}

	public static function listSubCategory(array $arr, $category_id, $lv) {
		$categories	= Category::model()
					->findAllByAttributes(array('parent_id'=>$category_id));

		if (empty($categories)) {
			return $arr;
		}

		foreach ($categories as $category) {
			$vo = new CategoryVO();
			$vo->id = $category->id;
			$vo->name = $category->name;
			$vo->level = $lv;
			$arr[] = $vo;

			$arr = self::listSubCategory($arr, $category->id, $lv + 1);
		}

		return $arr;
	}

}