<?php
Yii::import('application.models.customer.*');

class CustomerController extends Controller {
	
	const SESSION_SEARCH_CRITERIA = "SESSION_SEARCH_CRITERIA_CUSTOMER";
	const SESSION_CURR_PAGE = "SESSION_CURR_PAGE_CUSTOMER";
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		if (!GlobalFunction::isAdmin()) {
			$this->redirect(Yii::app()->createUrl('site/noPermission'));
		}
		else {
			$filterChain->run();
		}
	}
	
	public function actionIndex() {
		$attr = $this->requestAttrForSearch(new CustomerSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Search function
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForSearch(new CustomerSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Add function
	public function actionAdd() {
		$model = new MaintCustomerForm('add');
	
		if ($_POST['action']) {
			// Create customer
			$model->attributes = $_POST['MaintCustomerForm'];
				
			if ($model->create()) {
				// Back to searching page
				$msg = array('success'=>'Customer ['.$model->name.'] is created successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to create customer!';
			}
		}
	
		$this->render('maint', array('model'=>$model, 'action'=>'add', 'msg'=>array('error'=>$errorMsg)));
	}
	
// Update function
	public function actionUpdate() {
		$model = new MaintCustomerForm('update');

		if ($_POST['action']) {
			// Update customer
			$model->attributes = $_POST['MaintCustomerForm'];
			if ($model->update()) {
				// Go back the search page
				$session=new CHttpSession;
				$session->open();
				$searchModel = new CustomerSearchForm();
				$searchModel->attributes = $session[SESSION_SEARCH_CRITERIA];
				$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[SESSION_CURR_PAGE] - 1);
				
				// Remove session attribute
				$session->remove(SESSION_SEARCH_CRITERIA);
				$session->remove(SESSION_CURR_PAGE);

				$successMsg = 'Customer ['.$model->name.'] is updated successfully!';
				$this->render('list', array_merge($attr, array('msg'=>array('success'=>$successMsg))));
				return;
			}
			else {
				$errorMsg = 'Fail to update customer!';
			}
		}
		else {
			// Retrieve customer
			$id = $_GET['id'];
			$model->find($id);
			
			// Store search critiera to session
			$session=new CHttpSession;
			$session->open();
			$session[SESSION_SEARCH_CRITERIA] = $_REQUEST['CustomerSearchForm'];
			$session[SESSION_CURR_PAGE] = $_REQUEST['page'];
			$session->close();
		}
	
		$this->render('maint', array('model'=>$model, 'action'=>'update', 'msg'=>array('error'=>$errorMsg)));
	}
	
// Delete function
	public function actionDelete() {
		$id = $_GET['id'];
		
		$model = new MaintCustomerForm('delete');
		$model->find($id);
	
		if ($model->delete()) {
			$successMsg = 'Customer ['.$model->name.'] is deleted successfully.';
		}
		else {
			$errorMsg = 'Fail to delete customer ['.$model->name.']';
		}
	
		$msg = array('success'=>$successMsg, 'error'=>$errorMsg);
		
		$searchModel = new CustomerSearchForm();
		$searchModel->attributes = $_REQUEST['CustomerSearchForm'];
		$searchModel->itemCount = NULL; // Re-get the total item count
		$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $_REQUEST['page'] - 1);
		$this->render('list', array_merge($attr, array('msg'=>array('success'=>$successMsg))));
	}
	
	public function actionBack() {
		// Back to search page
		$session=new CHttpSession;
		$session->open();
		$searchModel = new CustomerSearchForm();
		$searchModel->attributes = $session[SESSION_SEARCH_CRITERIA];
		$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[SESSION_CURR_PAGE] - 1);
		
		// Remove session attribute
		$session->remove(SESSION_SEARCH_CRITERIA);
		$session->remove(SESSION_CURR_PAGE);
		
		$this->render('list', $attr);
	}
}