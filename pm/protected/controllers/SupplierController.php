<?php
Yii::import('application.models.supplier.*');

class SupplierController extends Controller {
	
	const SESSION_SEARCH_CRITERIA = "SESSION_SEARCH_CRITERIA_SUPPLIER";
	const SESSION_CURR_PAGE = "SESSION_CURR_PAGE_SUPPLIER";
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('supplier_management');
		$filterChain->run();
	}
	
	public function actionIndex() {
		$attr = $this->requestAttrForSearch(new SupplierSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Search function
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForSearch(new SupplierSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Add function
	public function actionAdd() {
		$this->checkPrivilege('supplier_management', RolePageMatrix::PERMISSION_WRITE);
		
		$model = new MaintSupplierForm('add');
	
		if ($_POST['action']) {
			// Create supplier
			$model->attributes = $_POST['MaintSupplierForm'];
				
			if ($model->create()) {
				// Back to searching page
				$msg = array('success'=>'Supplier ['.$model->name.'] is created successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to create supplier!';
			}
		}
	
		$this->render('maint', array('model'=>$model, 'action'=>'add', 'msg'=>array('error'=>$errorMsg)));
	}
	
// Update function
	public function actionUpdate() {
		$model = new MaintSupplierForm('update');

		if ($_POST['action']) {
			$this->checkPrivilege('supplier_management', RolePageMatrix::PERMISSION_WRITE);
			
			// Update Supplier
			$model->attributes = $_POST['MaintSupplierForm'];
			if ($model->update()) {
				// Go back the search page
				$session=new CHttpSession;
				$session->open();
				$searchModel = new SupplierSearchForm();
				$searchModel->attributes = $session[SESSION_SEARCH_CRITERIA];
				$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[SESSION_CURR_PAGE] - 1);
				
				// Remove session attribute
				$session->remove(SESSION_SEARCH_CRITERIA);
				$session->remove(SESSION_CURR_PAGE);

				$successMsg = 'Supplier ['.$model->name.'] is updated successfully!';
				$this->render('list', array_merge($attr, array('msg'=>array('success'=>$successMsg))));
				return;
			}
			else {
				$errorMsg = 'Fail to update supplier!';
			}
		}
		else {
			// Retrieve supplier
			$id = $_GET['id'];
			$model->find($id);
			
			// Store search critiera to session
			$session=new CHttpSession;
			$session->open();
			$session[SESSION_SEARCH_CRITERIA] = $_REQUEST['SupplierSearchForm'];
			$session[SESSION_CURR_PAGE] = $_REQUEST['page'];
			$session->close();
		}
	
		$this->render('maint', array('model'=>$model, 'action'=>'update', 'msg'=>array('error'=>$errorMsg)));
	}
	
// Delete function
	public function actionDelete() {
		$this->checkPrivilege('supplier_management', RolePageMatrix::PERMISSION_WRITE);
		
		$id = $_GET['id'];
		
		$model = new MaintSupplierForm('delete');
		$model->find($id);
	
		if ($model->delete()) {
			$successMsg = 'Supplier ['.$model->name.'] is deleted successfully.';
		}
		else {
			$errorMsg = 'Fail to delete Supplier ['.$model->name.']';
		}
	
		$msg = array('success'=>$successMsg, 'error'=>$errorMsg);
		
		$searchModel = new SupplierSearchForm();
		$searchModel->attributes = $_REQUEST['SupplierSearchForm'];
		$searchModel->itemCount = NULL; // Re-get the total item count
		$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $_REQUEST['page'] - 1);
		$this->render('list', array_merge($attr, array('msg'=>array('success'=>$successMsg))));
	}
	
	public function actionBack() {
		// Back to search page
		$session=new CHttpSession;
		$session->open();
		$searchModel = new SupplierSearchForm();
		$searchModel->attributes = $session[SESSION_SEARCH_CRITERIA];
		$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[SESSION_CURR_PAGE] - 1);
		
		// Remove session attribute
		$session->remove(SESSION_SEARCH_CRITERIA);
		$session->remove(SESSION_CURR_PAGE);
		
		$this->render('list', $attr);
	}
	
// Import function
	public function actionImport() {
		$model = new ImportSupplierForm;
	
		if(isset($_POST['ImportSupplierForm'])) {
			$model->attributes = $_POST['ImportSupplierForm'];
			$model->uplFile = CUploadedFile::getInstance($model,'uplFile');
				
			$result = $model->import();
			if ($result[0]) {
				// Success
				$successMsg = 'Supplier list is imported successfully!';
			}
			else {
				// Fail
				foreach($result[1] as $rowNo=>$supplier) {
					foreach($supplier->errors as $fieldInfo) {
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
		$model = new ExportSupplierForm;
	
		$model->export();
	}
}