<?php
Yii::import('application.models.cash.*');

class CashController extends Controller {
	
	const SESSION_SEARCH_CRITERIA = "SESSION_SEARCH_CRITERIA_CASH";
	const SESSION_CURR_PAGE = "SESSION_CURR_PAGE_CASH";
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('cash_management');
		$filterChain->run();
	}
	
	public function actionIndex() {
		$attr = $this->requestAttrForSearch(new CashSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
// Search function
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForSearch(new CashSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}

	public function actionDelete() {
		$this->checkPrivilege('cash_management', RolePageMatrix::PERMISSION_WRITE);

		$form = new CashSearchForm();
		$id = $_GET['id'];
		$form->deleteById($id);

		$attr = $this->requestAttrForSearch(new CashSearchForm, 'searchByFilter');
		$attr['msg'] = array('success'=>'Delete successfully!');
		$this->render('list', $attr);
	}
	
	public function actionBack() {
		// Back to search page
		$session=new CHttpSession;
		$session->open();
		$searchModel = new CashSearchForm();
		$searchModel->attributes = $session[SESSION_SEARCH_CRITERIA];
		$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[SESSION_CURR_PAGE] - 1);
		
		// Remove session attribute
		$session->remove(SESSION_SEARCH_CRITERIA);
		$session->remove(SESSION_CURR_PAGE);
		
		$this->render('list', $attr);
	}

	public function actionImage_upload() {
		$this->render('image_upload');
	}

}