<?php
Yii::import('application.models.product.*');

class ProductController extends Controller {
	
	public function actionIndex() {
		// Set selected made
		$session=new CHttpSession;
		$session->open();

		if (isset($_GET['made'])) {
			$session[GlobalConstants::SESSION_SELECTED_MADE] = $_GET['made'];
		}
		
		$searchForm = new ProductSearchForm();
		$searchForm->made = $session[GlobalConstants::SESSION_SELECTED_MADE];
		
		$session->close();

		$this->render('list', array('model'=>$searchForm));
	}
	
// Search function
	public function actionSearchByKeyword() {
		$attr = $this->requestAttrForSearch(new ProductSearchForm, 'searchByKeyword');
		$this->render('list', $attr);
	}
	
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForSearch(new ProductSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Add function
	public function actionAdd() {
		$action = 'add';
		$model = new ProductMaster();
		
		if (isset($_POST['action'])) {
			// Create product
			$model->attributes = $_POST['ProductMaster'];
			
			if ($model->save()) {
				$successMsg = '&#29986;&#21697;S/N ['.$model->prod_sn.'] is created successfully!'; // 產品S/N [XXX] is created successfully!
				$action = 'update';
			}
			else {
				$errorMsg = 'Fail to create product!';
			}
		}

		$this->render('maint', array('action'=>$action, 'model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}
	
// Update function
	public function actionUpdate() {
		if (isset($_POST['action'])) {
			// Update product
			$model = $this->loadProductMaster($_POST['ProductMaster']['id']);
			$model->attributes = $_POST['ProductMaster'];
		
			if ($model->save()) {
				$successMsg = '&#29986;&#21697;S/N ['.$model->prod_sn.'] is updated successfully!'; // 產品S/N [XXX] is updated successfully!
			}
			else {
				$errorMsg = 'Fail to update product!';
			}
		}
		else {
			// Retrieve product
			$id = $_GET['id'];
			$model = $this->loadProductMaster($id);
		}
		
		$this->render('maint', array('action'=>'update', 'model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}
	
	public function actionImport() {
		$model = new ImportProductForm;
	
		if(isset($_POST['ImportProductForm'])) {
			$model->attributes = $_POST['ImportProductForm'];
			$model->uplFile = CUploadedFile::getInstance($model,'uplFile');
			
			$result = $model->import();
			if ($result[0]) {
				// Success
				$successMsg = 'Product list is imported successfully!';
			}
			else {
				// Fail
				foreach($result[1] as $rowNo=>$product) {
					foreach($product->errors as $fieldInfo) {
						foreach($fieldInfo as $error) {
							$errorMsg .= 'Row['.$rowNo.']: '.$error.'<br>';
						}
					}
				}
			}
		}
	
		$this->render('import', array('model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}
	
// Private function
	private function loadProductMaster($id) {
		$model = ProductMaster::model()->findByAttributes(array('id'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}
?>