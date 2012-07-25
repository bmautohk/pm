<?php
Yii::import('application.models.product.*');

class ProductController extends Controller {
	
	public function actionIndex() {
		$this->render('list', array('model'=>new ProductSearchForm()));
	}
	
// Search function
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
			if ($_POST['action'] == 'Update') {
				// Update product
				$model = $this->loadProductMaster($_POST['ProductMaster']['id']);
				$model->attributes = $_POST['ProductMaster'];
				
				if ($model->save()) {
					$successMsg = '&#29986;&#21697;S/N ['.$model->prod_sn.'] is updated successfully!'; // 產品S/N [XXX] is updated successfully!
				
					// Go back the search page
					$session=new CHttpSession;
					$session->open();
					$searchModel = new ProductSearchForm();
					$searchModel->attributes = $session[GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA];
					$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[GlobalConstants::SESSION_CURR_PAGE] - 1);
				
					// Remove session attribute
					$session->remove(GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA);
					$session->remove(GlobalConstants::SESSION_CURR_PAGE);
				
					$this->render('list', array_merge($attr, array('msg'=>array('success'=>$successMsg))));
					return;
				}
				else {
					$errorMsg = 'Fail to update product!';
				}
			}
			else {
				// Back to search page
				$session=new CHttpSession;
				$session->open();
				$searchModel = new ProductSearchForm();
				$searchModel->attributes = $session[GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA];
				$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[GlobalConstants::SESSION_CURR_PAGE] - 1);
				
				// Remove session attribute
				$session->remove(GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA);
				$session->remove(GlobalConstants::SESSION_CURR_PAGE);
				
				$this->render('list', $attr);
				return;
			}
		}
		else {
			// Retrieve product
			$id = $_GET['id'];
			$model = $this->loadProductMaster($id);
			
			// Store search critiera to session
			$session=new CHttpSession;
			$session->open();
			$session[GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA] = $_REQUEST['ProductSearchForm'];
			$session[GlobalConstants::SESSION_CURR_PAGE] = $_REQUEST['page'];
			$session->close();
		}
		
		$this->render('maint', array('action'=>'update', 'model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}

// Import function
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
	
// Export function
	public function actionExport() {
		$model = new ExportProductForm;
		
		$model->export();
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