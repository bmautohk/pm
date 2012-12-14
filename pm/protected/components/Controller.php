<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	protected function requestAttrForSearch($model, $url) {
		// Match criteria to the form
		if (isset($_REQUEST[get_class($model)])) {
			$model->attributes = $_REQUEST[get_class($model)];
		}
		
		$isExcelView = GlobalFunction::getDisplayFormat() == GlobalConstants::DISPLAY_FORMAT_GRID ? false : true;;

		// Pagination configuration
		$pages = new CPagination();
		$pages->pageSize = $isExcelView ? Yii::app()->params['excelViewPageSize'] : Yii::app()->params['pageSize'];
		$pages->route = $url;
	
		if (!empty($model->keyword)) {
			// Search by keyword
			if (!isset($model->itemCount)) {
				// 1st search
				$pages->itemCount = $model->searchByKeywordItemCount();
				$model->itemCount = $pages->itemCount;
			}
			else {
				$pages->itemCount = $model->itemCount;
			}
			
			$data = $model->searchByKeywordCrtiera($pages, $isExcelView);
			
			return array(
					'model' => $model,
					'items' => $data,
					'pages' => $pages
			);
		}
		else {
			// Create criteria
			$criteria = $model->createCriteria($isExcelView);
			
			if (!isset($model->itemCount)) {
				// 1st search
				$dataProvider = $model->searchByCriteria($criteria, $pages);
				$model->itemCount = $dataProvider->totalItemCount;
			}
			else {
				$dataProvider = $model->searchByCriteria($criteria, $pages, $model->itemCount);
			}
			
			return array(
					'model' => $model,
					'items' => $dataProvider->getData(),
					'pages' => $pages
			);
		}
	}
	
	protected function searchByAttributes($searchModel, $url, $currPage) {
		$isExcelView = GlobalFunction::getDisplayFormat() == GlobalConstants::DISPLAY_FORMAT_GRID ? false : true;;
		
		// Pagination configuration
		$pages = new CPagination();
		$pages->pageSize = $isExcelView ? Yii::app()->params['excelViewPageSize'] : Yii::app()->params['pageSize'];
		$pages->route = $url;
		$pages->setCurrentPage($currPage < 0 ? 0 : $currPage);
		
		if (!empty($searchModel->keyword)) {
			// Search by keyword
			if (!isset($searchModel->itemCount)) {
				// 1st search
				$pages->itemCount = $searchModel->searchByKeywordItemCount();
				$searchModel->itemCount = $pages->itemCount;
			}
			else {
				$pages->itemCount = $searchModel->itemCount;
			}
			
			$data = $searchModel->searchByKeywordCrtiera($pages, $isExcelView);
			
			return array(
					'model' => $searchModel,
					'items' => $data,
					'pages' => $pages
			);
		}
		else {
			// Create criteria
			$criteria = $searchModel->createCriteria($isExcelView);
			
			if (!isset($searchModel->itemCount)) {
				// 1st search
				$dataProvider = $searchModel->searchByCriteria($criteria, $pages);
				$searchModel->itemCount = $dataProvider->totalItemCount;
			}
			else {
				$dataProvider = $searchModel->searchByCriteria($criteria, $pages, $searchModel->itemCount);
			}
			
			return array(
					'model' => $searchModel,
					'items' => $dataProvider->getData(),
					'pages' => $pages
			);
		}
	}
}