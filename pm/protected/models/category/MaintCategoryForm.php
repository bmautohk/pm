<?php
class MaintCategoryForm extends CFormModel {
	public $id;
	public $name;
	public $existingSubCategoryList = array();
	public $newSubCategoryList = array();
	
	public function rules() {
		return array(
			array('name', 'required'),
			array('name', 'uniqueName'),
			array('id, parent_id', 'safe'),
		);
	}
	
	public function find($id) {
		$model = Category::model()->findByPk($id);
		$this->id = $model->id;
		$this->name = $model->name;
	}

	public function loadSubCategories() {
		$this->existingSubCategoryList = Category::model()
					->findAllByAttributes(array('parent_id'=>$this->id));
	}
	
	public function create() {
		if (!$this->validate()) {
			return false;
		}

		if (!$this->validateSubCat()) {
			return false;
		}
		
		$model = new Category();
		$model->name = $this->name;
		$model->parent_id = NULL;
		
		if ($model->save()) {
			$this->id = Yii::app()->db->getLastInsertID();

			if (!empty($this->newSubCategoryList)) {
				foreach ($this->newSubCategoryList as $newCat) {
					$model = new Category();
					$model->name = $newCat;
					$model->parent_id = $this->id;
					$model->save();
				}
			}

			Category::deleteCache();

			return true;
		} else {
			return false;
		}
	}
	
	public function update() {
		if (!$this->validate()) {
			return false;
		}

		if (!$this->validateSubCat()) {
			return false;
		}
		
		$model = Category::model()->findByPk($this->id);
		$model->name = $this->name;
		
		$saveAttributes = array('name', 'last_update_date', 'last_update_by');
		
		if ($model->save(true, $saveAttributes)) {

			if (!empty($this->newSubCategoryList)) {
				foreach ($this->newSubCategoryList as $newCat) {
					$model = new Category();
					$model->name = $newCat;
					$model->parent_id = $this->id;
					$model->save();
				}
			}

			Category::deleteCache();

			return true;
		} else {
			return false;
		}

		return true;
	}
	
	public function delete() {
		if ($this->isProductUsing($this->id)) {
			return false;
		}

		// Delete category
		Category::model()->deleteWithChild($this->id);

		Category::deleteCache();

		return true;
	}
	
	public function uniqueName($attribute, $params) {
		$criteria = new CDbCriteria();
		$criteria->compare('name', $this->$attribute);
		$criteria->compare('id', '<>'.$this->id);

		$model = Category::model();
		$model->setDbCriteria($criteria);
		
		$categoryList = $model->findAll();

		if ($categoryList != null) {
			$this->addError($attribute, 'Category ['.$this->$attribute.'] has already existed!');
		}
	}

	private function validateSubCat() {
		$isValid = true;

		$newCatNameArr = array();
		$newCatNameArr[] = $this->name;

		if (!empty($this->newSubCategoryList)) {
			foreach ($this->newSubCategoryList as $newCatName) {
				if (in_array($newCatName, $newCatNameArr)) {
					$isValid = false;
					$this->addError($attribute, 'Sub-category ['.$newCatName.'] has already existed!');
					continue;
				}

				$model = Category::model()
						->findAllByAttributes(array('name'=>$newCatName));

				if ($model != null) {
					$isValid = false;
					$this->addError($attribute, 'Sub-category ['.$newCatName.'] has already existed!');
				} else {
					$newCatNameArr[] = $newCatName;
				}
			}
		}

		return $isValid;
	}

	private function isProductUsing($categoryId) {
		$productCategory = ProductCategory::model()
					->findAllByAttributes(array('category_id'=>$categoryId));

		if ($productCategory != null) {
			$this->addError($attribute, 'Category is used by product(s)!');
			return true;
		}

		// Find all child category ID
		$subCatetoryList = array();
		$subCatetoryList = Category::listSubCategory($subCatetoryList, $categoryId, 0);

		$isExist = false;
		if (!empty($subCatetoryList)) {
			foreach ($subCatetoryList as $subCategory) {
				echo 'ID: '.$subCategory->id;
				$productCategory = ProductCategory::model()
					->findAllByAttributes(array('category_id'=>$subCategory->id));

				if ($productCategory != null) {
					$this->addError($attribute, 'Its sub-category is used by product(s)!');
					$isExist = true;
					break;
				}
			}
		}

		return $isExist;
	}
}