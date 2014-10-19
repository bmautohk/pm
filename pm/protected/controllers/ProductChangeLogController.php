<?php
Yii::import('application.models.productChangeLog.*');

class ProductChangeLogController extends Controller {
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('product_change_log');
		$filterChain->run();
	}

	public function actionIndex() {
		$attr = $this->requestAttrForSearch(new ProductChangeLogSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
	public function actionSearchByFilter() {
		$attr = $this->requestAttrForSearch(new ProductChangeLogSearchForm, 'searchByFilter');
		$this->render('list', $attr);
	}
	
	public function actionDownloadByFilter() {
		$serachForm = new ProductChangeLogSearchForm();
		$serachForm->attributes = $_REQUEST['ProductChangeLogSearchForm'];
		
		$serachForm->generateExcel();
	}
}