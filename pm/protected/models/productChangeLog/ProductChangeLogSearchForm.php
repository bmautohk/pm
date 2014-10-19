<?php
require_once 'protected/extensions/PHPExcel/CachedObjectStorageFactory.php';
require_once 'protected/extensions/PHPExcel/Settings.php';

class ProductChangeLogSearchForm extends CFormModel {
	public $itemCount;
	
	public $date_from;
	public $date_to;
	public $prod_sn;
	public $column_name;
	
	public function rules() {
		return array(
			array('itemCount, prod_sn, column_name, date_from, date_to', 'safe')
		);
	}
	
	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL) {
		return new CActiveDataProvider(get_class(new ProductChangeLog), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria() {
		$criteria = new CDbCriteria();
		$criteria->order = 'id desc';
		
		$criteria->compare('create_date', '>='.$this->date_from);
		
		if (!empty($this->date_to)) {
			$date = new DateTime($this->date_to);
			$date->modify('+1 day'); // Add 1 day
			$criteria->compare('create_date', '<'.$date->format('Y-m-d'));
		}
		
		$criteria->compare('prod_sn', $this->prod_sn);
		$criteria->compare('column_name', $this->column_name);
		
		return $criteria;
	}
	
	public function generateExcel() {
		$model = ProductChangeLog::model();
		$model->setDbCriteria($this->createCriteria());
		
		$logs = $model->findAll();
		
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		
		// Output to excel
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("BM AUTO")
		->setLastModifiedBy("BM AUTO")
		->setTitle("Product");
		
		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		// Header
		$i = 0;
		$sheet->setCellValueByColumnAndRow($i++, 1, 'Modify Date');
		$sheet->setCellValueByColumnAndRow($i++, 1, Yii::t('product_message', 'prod_sn'));
		$sheet->setCellValueByColumnAndRow($i++, 1, 'Column Name');
		$sheet->setCellValueByColumnAndRow($i++, 1, 'Old Value');
		$sheet->setCellValueByColumnAndRow($i++, 1, 'New Value');
		$sheet->setCellValueByColumnAndRow($i++, 1, 'Changed By');
		
		$rowNo = 1;
		foreach($logs as $log) {
			$i = 0;
			$rowNo++;
			
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $log->create_date);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $log->prod_sn);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, Yii::t('product_message', $log->column_name));
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $log->old_value);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $log->new_value);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $log->create_by);
		}
		
		header("Content-type:application/vnd.ms-excel;charset=euc");
		header('Content-Disposition: attachment;filename="product_change_log.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	public function getColumnNameDropdown() {
		$product = new ProductMaster();
		$options = array(''=>'All');
		$options = array_merge($options, $product->attributeLabels());
		unset($options['id']);
		
		return $options;
	}
}