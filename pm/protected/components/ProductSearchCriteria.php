<?php
Yii::import('zii.widgets.CPortlet');

class ProductSearchCriteria extends CPortlet {
	
	public $searchForm;
	public $isShowDownloadButton = false;

	protected function renderContent() {
		$this->render('productSearchCriteria');
	}
}
?>