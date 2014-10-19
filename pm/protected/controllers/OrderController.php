<?php
Yii::import('application.models.order.*');

class OrderController extends Controller {
	
	const SESSION_SEARCH_CRITERIA = "SESSION_SEARCH_CRITERIA_ORDER";
	const SESSION_CURR_PAGE = "SESSION_CURR_PAGE_ORDER";
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('order_management');
		$filterChain->run();
	}

	public function actionIndex() {
		$attr = $this->requestAttrForSearch(new OrderSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForSearch(new OrderSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
	public function actionView() {
		$order_id = $_REQUEST['id'];

		// Store search critiera to session
		$session=new CHttpSession;
		$session->open();
		$session[SESSION_SEARCH_CRITERIA] = $_REQUEST['OrderSearchForm'];
		$session[SESSION_CURR_PAGE] = $_REQUEST['page'];
		$session->close();
		
		$model = new OrderMaintForm();
		$model->retrieve($order_id);

		$this->render('maint', array('model'=>$model));
	}
	
	public function actionBack() {
		// Back to search page
		$session=new CHttpSession;
		$session->open();
		$searchModel = new OrderSearchForm();
		$searchModel->attributes = $session[SESSION_SEARCH_CRITERIA];
		$attr = $this->searchByAttributes($searchModel, 'searchByFilter', $session[SESSION_CURR_PAGE] - 1);
	
		// Remove session attribute
		$session->remove(SESSION_SEARCH_CRITERIA);
		$session->remove(SESSION_CURR_PAGE);
	
		$this->render('list', $attr);
	}
}