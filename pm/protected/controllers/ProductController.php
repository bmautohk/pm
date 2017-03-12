<?php
Yii::import('application.models.product.*');

class ProductController extends Controller {
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('product_management');
		$filterChain->run();
	}
	
	public function actionIndex() {
		$attr = $this->requestAttrForProductSearch(new ProductSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
	public function actionChangeDisplayFormat() {
		$currentDisplayFormat = GlobalFunction::getDisplayFormat();
		
		$session=new CHttpSession;
		$session->open();
		
		$session[GlobalConstants::SESSION_DISPLAY_FORMAT] = $currentDisplayFormat == GlobalConstants::DISPLAY_FORMAT_EXCEL ? 
			GlobalConstants::DISPLAY_FORMAT_GRID : GlobalConstants::DISPLAY_FORMAT_EXCEL;
		
		$session->close();
		$this->actionIndex();
	}
	
// Search function
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForProductSearch(new ProductSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Search Item Not Finish
	public function actionShowNotFinishItem() {
		$serachForm = new ProductSearchForm();
		$serachForm->isSearchNotFinish = 'Y';
		
		$attr = $this->requestAttrForProductSearch($serachForm, 'searchByFilter');
		$this->render('list', $attr);
	}

	public function actionShowNotShip() {
		$serachForm = new ProductSearchForm();
		$serachForm->isSearchNotShip = 'Y';
		
		$attr = $this->requestAttrForProductSearch($serachForm, 'searchByFilter');
		$this->render('list', $attr);
	}

	public function actionShowNotExhibit() {
		$serachForm = new ProductSearchForm();
		$serachForm->isSearchNotExhibit = 'Y';
		
		$attr = $this->requestAttrForProductSearch($serachForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
	public function actionDownloadByFilter() {
		$serachForm = new ProductSearchForm();
		$serachForm->attributes = $_REQUEST['ProductSearchForm'];
		
		
		if (!empty($serachForm->keyword)) {
			// Search by keyword
			$products = $serachForm->searchByKeywordCrtiera(NULL, true);
		}
		else {
			// Search by filter
			$criteria = $serachForm->createCriteria(true);
			
			$model = ProductMaster::model();
			$model->setDbCriteria($criteria);
			$products = $model->findAll();
		}
		
		$exportProductForm = new ExportProductForm();
		$exportProductForm->generateExcel($products);
	}
	
	/**
	 * Retrieve all existing models for selection
	 */
	public function actionGetModels() {
		$criteria = new CDbCriteria();
		$criteria->select = 'model';
		$criteria->distinct = true;
		$criteria->order = 'model';
		$criteria->condition = "model <> '' and model is not null";
		$items = ProductMaster::model()->findAll($criteria);
		$this->renderPartial('listModel', array('items'=>$items));
	}
	
// Add function
	public function actionAdd() {
		// Check authorization
		$this->checkPrivilege('product_management_add_product', RolePageMatrix::PERMISSION_WRITE);
		/* if (!GlobalFunction::isAdmin()) {
			$this->redirect(Yii::app()->createUrl('site/noPermission'));
		} */
		
		$action = 'add';
		$form = new ProductMaintForm();
		
		
		if (isset($_POST['action'])) {
			// Create product
			
			if ($form->add($_POST)) {
				$successMsg = '&#29986;&#21697;S/N ['.$form->product->prod_sn.'] is created successfully!'; // ���~S/N [XXX] is created successfully!
				$action = 'update';
				$this->render('maint', array('action'=>$action, 'model'=>$form->product, 'productForm'=>$form, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
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

			$model = new ProductMaster();
			$model->prod_sn = $maxProdSN->max_prod_sn === NULL ? 391 : $maxProdSN->max_prod_sn + 1;
			
			if ($model->prod_sn < 391) {
				$model->prod_sn = 391;
			}
			
			$model->is_internal = ProductMaster::IS_INTERNAL_YES;
			$form->product = $model;
		}

		$this->render('add', array('action'=>$action, 'model'=>$form->product, 'productForm'=>$form, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}
	
// Update function
	public function actionUpdate() {
		if (isset($_POST['action'])) {
			// Update product
			
			// Check authorization
			$this->checkPrivilege('product_management', RolePageMatrix::PERMISSION_WRITE);
			
			$form = new ProductMaintForm();

			if ($form->update($_POST)) {
				// Go back the search page
				$session=new CHttpSession;
				$session->open();
				$searchModel = new ProductSearchForm();
				$searchModel->attributes = $session[GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA];
				$attr = $this->searchProductByAttributes($searchModel, 'searchByFilter', $session[GlobalConstants::SESSION_CURR_PAGE] - 1);
					
				// Remove session attribute
				$session->remove(GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA);
				$session->remove(GlobalConstants::SESSION_CURR_PAGE);
					
				$this->render('list', array_merge($attr, array('msg'=>array('success'=>$form->message))));
				return;
			} else {
				$errorMsg = $form->message;
			}
			
			$model = $form->product;
			
		}
		else {
			// Retrieve product
			$id = $_GET['id'];
			$model = $this->loadProductMaster($id);

			$form = new ProductMaintForm();
			$form->load($model);
			
			// Store search critiera to session
			$session=new CHttpSession;
			$session->open();
			$session[GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA] = $_REQUEST['ProductSearchForm'];
			$session[GlobalConstants::SESSION_CURR_PAGE] = $_REQUEST['page'];
			$session->close();
		}
		
		$this->render('maint', array('action'=>'update', 'model'=>$model, 'productForm'=>$form, 'msg'=>array('success'=>$successMsg, 'error'=>$errorMsg)));
	}

// Delete Function
	public function actionDelete() {	
		// Check authorization
		if (!GlobalFunction::isAdmin()) {
			$this->redirect(Yii::app()->createUrl('site/noPermission'));
		}
		
		$id = $_GET['id'];
		$model = $this->loadProductMaster($id);
		
		$productCartCountModel = ProductCartCount::model()->findByAttributes(array('prod_sn'=>$model->prod_sn));
		
		$isSuccess = false;
		if (ProductCategory::model()->deleteByProductId($id) && $model->delete()) {
			if ($productCartCountModel != NULL) {
				if ($productCartCountModel->delete()) {
					$isSuccess = true;
				}
			} else {
				$isSuccess = true;
			}
		}
		
		if ($isSuccess) {
			$successMsg = '&#29986;&#21697;S/N ['.$model->prod_sn.'] is deleted successfully!';
		} else {
			$errorMsg = 'Fail to delete product!';
		}
		
		// Go back the search page
		$searchModel = new ProductSearchForm();
		$searchModel->attributes = $_REQUEST['ProductSearchForm'];
		if ($isSuccess) {
			$searchModel->itemCount = $searchModel->itemCount - 1;
		}
		$attr = $this->searchProductByAttributes($searchModel, 'searchByFilter', $_REQUEST['page'] - 1);
		
		$this->render('list', array_merge($attr, array('msg'=>array('success'=>$successMsg, 'error'=>$errorMsg))));
	}
	
	public function actionAddToCart() {
		$form = new CartForm();
		$form->addCart($_POST);
		
		echo '產品S/N ['.$form->message.'] is/are added to cart.';
	}
	
	public function actionShowCartProduct($errorMsg = NULL) {
		$form = new CartForm();
		$products = $form->getCartProduct();
		
		$this->render('checkout_cart', array('model'=>$form, 'items'=>$products, 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionExportCart() {
		$form = new CartForm();
		$form->attributes = $_REQUEST['CartForm'];
		
		if ($form->action == 'generate') {
			if (!$form->exportCart(true)) {
				$this->actionShowCartProduct($form->message);
			}
		} else if ($form->action == 'export') {
			if (!$form->exportCart(false)) {
				$this->actionShowCartProduct($form->message);
			}
		} else if ($form->action == 'clear') {
			$form->clearCart();
			$this->actionShowCartProduct();
		} else {
			$this->actionShowCartProduct();
		}
	}

	public function actionBack() {
		// Back to search page
		$session=new CHttpSession;
		$session->open();
		$searchModel = new ProductSearchForm();
		$searchModel->attributes = $session[GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA];
		$attr = $this->searchProductByAttributes($searchModel, 'searchByFilter', $session[GlobalConstants::SESSION_CURR_PAGE] - 1);
		
		// Remove session attribute
		$session->remove(GlobalConstants::SESSION_PRODUCT_SEARCH_CRITERIA);
		$session->remove(GlobalConstants::SESSION_CURR_PAGE);
		
		$this->render('list', $attr);
	}
	
	public function actionShow_image() {
		$prod_sn = $_GET['prod_sn'];
		
		// Find product image
		$imgDir = $imgDir = Yii::app()->params['image_dir'];
		$images = glob($imgDir.$prod_sn."_*.jpg");
		$this->renderPartial('show_image', array('images'=>$images));
	}
	
	public function actionShow_internal_image() {
		$prod_sn = $_GET['prod_sn'];
	
		// Find internal product image
		$imgDir = $imgDir = Yii::app()->params['internal_image_dir'];
		$images = glob($imgDir.$prod_sn."_i_*.jpg");
		$this->renderPartial('show_image', array('images'=>$images));
	}
	
	public function actionSearch_made() {
		$term = $_GET['term'];
		
		$criteria = new CDbCriteria();
		$criteria->select = 'made';
		$criteria->distinct = true;
		$criteria->compare('made', $term, true);
		$products = ProductMaster::model()->findAll($criteria);
		
		$result = array();
		foreach($products as $product) {
			$result[] = $product->made;
		}
		
		echo json_encode($result);
	}

	public function actionSearch_model() {
		$term = $_GET['term'];
	
		$criteria = new CDbCriteria();
		$criteria->select = 'model';
		$criteria->distinct = true;
		$criteria->compare('model', $term, true);
		$criteria->order = 'model';
		$products = ProductMaster::model()->findAll($criteria);
	
		$result = array();
		foreach($products as $product) {
			$result[] = $product->model;
		}
		
		echo json_encode($result);
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
	
	public function actionExport_with_volume() {
		$model = new ExportProductForm;
	
		$model->export(true);
	}
	
	
// Private function
	/* private function loadProductMaster($id) {
		if (GlobalFunction::isSupplier()) {
			$model = ProductMaster::model()->findByAttributes(array('id'=>$id, 'supplier'=>GlobalFunction::getUserSupplier()));
		}
		else {
			$model = ProductMaster::model()->findByAttributes(array('id'=>$id));
		}
		
		if($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else if (GlobalFunction::isRetail() && $model->is_retail != ProductMaster::IS_RETAIL_YES) {
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
?>