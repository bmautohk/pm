<?php
Yii::import('application.models.product.*');

class ProductController extends Controller {
	
	public function actionIndex() {
		$attr = $this->requestAttrForSearch(new ProductSearchForm, 'searchByFilter');
		$this->render('list', $attr);
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
				$this->render('maint', array('action'=>$action, 'model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
				return;
			}
			else {
				$errorMsg = 'Fail to create product!';
			}
		}
		else {
			// Find next prod SN
			$criteria = new CDbCriteria();
			$criteria->select='MAX(prod_sn) as max_prod_sn';
			$maxProdSN = ProductMaster::model()->find($criteria);
			$model->prod_sn = $maxProdSN->max_prod_sn === NULL ? 391 : $maxProdSN->max_prod_sn + 1;
			
			if ($model->prod_sn < 391) {
				$model->prod_sn = 391;
			}
		}

		$this->render('add', array('action'=>$action, 'model'=>$model, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}
	
// Update function
	public function actionUpdate() {
		if (isset($_POST['action'])) {
			if ($_POST['act'] == 'update') {
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
	
	public function actionShow_image() {
		$no_jp = $_GET['no_jp'];
		
		// Find product image
		$imgDir = $imgDir = Yii::app()->params['image_dir'];
		$images = glob($imgDir.$no_jp."_*.jpg");
		$this->renderPartial('show_image', array('images'=>$images));
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