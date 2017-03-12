<?php
Yii::import('application.models.category.*');

class CategoryController extends Controller {
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('category_management');
		$filterChain->run();
	}

	public function actionIndex($msg=NULL) {
		$model = new MaintCategoryForm();
		$categories = Category::listCategory();
		$this->render('list', array('categories'=>$categories, 'model'=>$model, 'msg'=>$msg));
	}
	
	public function actionAdd() {
		$this->checkPrivilege('category_management', RolePageMatrix::PERMISSION_WRITE);
		
		$model = new MaintCategoryForm('add');
		
		if ($_POST['action']) {
			// Create product
			$model->attributes = $_POST['MaintCategoryForm'];
			$model->newSubCategoryList = $_POST['MaintCategoryForm']['newSubCategoryList'];

			if ($model->create()) {
				$msg = array('success'=>'Cartegory ['.$model->name.'] is created successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to create category!';
			}
		}
		
		$this->render('maint', array('model'=>$model, 'action'=>'add', 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionUpdate() {
		$model = new MaintCategoryForm('update');
		
		if ($_POST['action']) {
			$this->checkPrivilege('category_management', RolePageMatrix::PERMISSION_WRITE);
			
			// Update category
			$model->attributes = $_POST['MaintCategoryForm'];
			$model->newSubCategoryList = $_POST['MaintCategoryForm']['newSubCategoryList'];
			if ($model->update()) {
				$msg = array('success'=>'Cartegory ['.$model->name.'] is updated successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$model->loadSubCategories();
				$errorMsg = 'Fail to update category!';
			}
		}
		else {
			// Retrieve category
			$id = $_GET['id'];
			$model->find($id);
			$model->loadSubCategories();
		}
		
		$this->render('maint', array('model'=>$model, 'action'=>'update', 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionDelete() {
		$this->checkPrivilege('category_management', RolePageMatrix::PERMISSION_WRITE);

		$model = new MaintCategoryForm();
		$model->attributes = $_POST['MaintCategoryForm'];

		$category = Category::model()->findByPk($model->id);
		
		if ($model->delete()) {
			$successMsg = 'Category ['.$category->name.'] is deleted successfully.';
		}
		else {
			$errorMsg = 'Fail to delete category ['.$category->name.']';
		}
		
		$categories = Category::listCategory();
		$this->render('list', array('categories'=>$categories, 'model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}

}