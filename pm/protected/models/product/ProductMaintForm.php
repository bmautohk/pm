<?php

class ProductMaintForm extends CFormModel {
	
	public $message;
	
	public $product;

	public $shopList;

	public $categoryIdList;

	public function load($product) {
		$productCcategories = ProductCategory::model()->findByProductId($product->id);

		$this->shopList = array();
		foreach (explode(',', $product->shop) as $shop) {
			$this->shopList[] = $shop;
		}
		
		$this->categoryIdList = array();
		foreach ($productCcategories as $productCcategory) {
			$this->categoryIdList[] = $productCcategory->category_id;
		}
	}

	public function add($post) {
		$this->product = new ProductMaster();
		$this->product->attributes = $post['ProductMaster'];
		$this->product->setScenario('save');

		$this->categoryIdList = $_POST['ProductMaintForm']['categoryIdList'];
		$this->shopList = $_POST['ProductMaintForm']['shopList'];

		$this->updateShop();
			
		if ($this->product->save()) {
			$product_id = Yii::app()->db->getLastInsertID();
			
			// Save category
			$this->addCategory($this->product->id, $this->categoryIdList);

			return true;
		} else {
			return false;
		}
	}

	public function update($post) {
		$this->product = $this->loadProductMaster($post['ProductMaster']['id']);
		$this->product->attributes = $post['ProductMaster'];
		$this->product->setScenario('save');

		$this->categoryIdList = $_POST['ProductMaintForm']['categoryIdList'];
		$this->shopList = $_POST['ProductMaintForm']['shopList'];

		$this->updateShop();

		$changeLogs = $this->prepareChangeLog($this->product->id);

		if ($this->product->save()) {
			// Save category
			$this->addCategory($this->product->id, $this->categoryIdList);
			
			// Add change log
			foreach ($changeLogs as $log) {
				$log->save();
			}
			
			$this->message = '&#29986;&#21697;S/N ['.$this->product->prod_sn.'] is updated successfully!'; // S/N [XXX] is updated successfully!
			return true;
		}
		else {
			$this->message = 'Fail to update product!';
			return false;
		}
	}

	public function updateShop() {
		$roleMatrix = Yii::app()->user->getState('role_matrix');
		if (!GlobalFunction::checkPrivilege($roleMatrix, 'product_master', 'shop')) {
			return;
		}

		$shops = NULL;
		if (!empty($this->shopList)) {
			foreach ($this->shopList as $shop) {
				if ($shops === NULL) {
					$shops = $shop;
				} else {
					$shops .= ','.$shop;
				}
			}
		}

		$this->product->shop = $shops;
	}

	public function addCategory($product_id, $newCategoryIdList) {
		$roleMatrix = Yii::app()->user->getState('role_matrix');
		if (!GlobalFunction::checkPrivilege($roleMatrix, 'product_master', 'category_id')) {
			return;
		}

		$origCategoryList = Category::model()->findByProductId($product_id);
		$tmpNewCategoryIdList = $newCategoryIdList;

		$existingCategoryList = ProductCategory::model()->findByProductId($product_id);

		if ($tmpNewCategoryIdList === NULL) {
			$tmpNewCategoryIdList = array();
		}

		$isChange = false;
		foreach ($existingCategoryList as $existingCategory) {
			$key = array_search($existingCategory->category_id, $tmpNewCategoryIdList);
			
			if ($key === FALSE) {
				$isChange = true;
				$existingCategory->delete();
			} else {
				unset($tmpNewCategoryIdList[$key]);
			}
		}

		if (!empty($tmpNewCategoryIdList)) {
			$isChange = true;

			foreach ($tmpNewCategoryIdList as $newCaregoryId) {
				$productCategory = new ProductCategory();
				$productCategory->product_id = $product_id;
				$productCategory->category_id = $newCaregoryId;
				$productCategory->save();
			}
		}

		// Product changes log
		if ($isChange) {
			$origCategoryNameList = NULL;
			foreach($origCategoryList as $category) {
				if ($origCategoryNameList === NULL) {
					$origCategoryNameList = $category->name;
				} else {
					$origCategoryNameList .= ','.$category->name;
				}
			}

			$newCategoryNameList = NULL;
			if (!empty($newCategoryIdList)) {
				foreach ($newCategoryIdList as $categoryId) {
					$category = Category::model()->findByPk($categoryId);
					if ($newCategoryNameList === NULL) {
						$newCategoryNameList = $category->name;
					} else {
						$newCategoryNameList .= ','.$category->name;
					}
				}
			}

			$log = new ProductChangeLog();
			$log->prod_sn = $this->product->prod_sn;
			$log->column_name = 'Category';
			$log->old_value = $origCategoryNameList;
			$log->new_value = $newCategoryNameList;
			$log->create_by = Yii::app()->user->name;
			$log->save();
		}
	}

	private function prepareChangeLog($product_id) {
		$origModel = $this->loadProductMaster($product_id);

		$logs = array();
		foreach ($origModel->attributes as $columnName=>$value) {
			if ($columnName == 'last_update_date') {
				continue;
			}
			
			if ($this->product->$columnName != $value) {
				$log = new ProductChangeLog();
				$log->prod_sn = $this->product->prod_sn;
				$log->column_name = $columnName;
				$log->old_value = $value;
				$log->new_value = $this->product->$columnName;
				$log->create_by = Yii::app()->user->name;
				$logs[] = $log;
			}
		}

		return $logs;
	}
	
	/* private function loadProductMaster($id) {
		if (GlobalFunction::isSupplier()) {
			$model = ProductMaster::model()->findByAttributes(array('id'=>$id, 'supplier'=>GlobalFunction::getUserSupplier()));
		}
		else {
			$model = ProductMaster::model()->findByAttributes(array('id'=>$id));
		}
	
		if ($model === null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	} */
	
	private function loadProductMaster($id) {
		$model = ProductMaster::getProductMaster($id);
	
		if ($model === null) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			return $model;
		}
	}
}