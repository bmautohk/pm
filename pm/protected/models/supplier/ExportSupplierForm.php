<?php
require_once 'protected/extensions/PHPExcel/CachedObjectStorageFactory.php';
require_once 'protected/extensions/PHPExcel/Settings.php';
class ExportSupplierForm extends CFormModel {
	
	public function export() {
		// Find all suppliers
		$criteria = new CDbCriteria();
		$criteria->order = 'id';
		
		//$criteria->condition = "id = '1'"; // testing
		
		$model = Supplier::model();
		$model->setDbCriteria($criteria);
		
		$suppliers = $model->findAll();
		
		$this->generateExcel($suppliers);
	}
	
	private function generateExcel($suppliers) {
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		
		$columnNames = array(
				'id',
				'supplier_cd',
				'name',
				'tel',
				'contact_person',
				'mobile',
				'other_contact',
				'qq',
				'notice',
				'bank',
				'open_account',
				'account_owner',
				'account_no',
				'term_of_payment',
				'address',
				'email',
				'remark',
		);

		// Output to excel
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
	
		// Set properties
		$objPHPExcel->getProperties()->setCreator("BM AUTO")
		->setLastModifiedBy("BM AUTO")
		->setTitle("Supplier");
	
		$sheet = $objPHPExcel->setActiveSheetIndex(0);
	
		// Header
		$rowNo = 1;

		$i = 0;
		foreach ($columnNames as $columnName) {
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('supplier_message', $columnName));
				
			/* if (in_array($columnName, $dateColumnNames)) {
				$sheet->getStyleByColumnAndRow($i-1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			} */
		}
	
		foreach($suppliers as $supplier) {
			$i = 0;
			$rowNo++;
			foreach ($columnNames as $columnName) {
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $supplier[$columnName]);
			}
		}
	
		header("Content-type:application/vnd.ms-excel;charset=utf8");
		header('Content-Disposition: attachment;filename="supplier.xls"');
		header('Cache-Control: max-age=0');
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	private static function strToExcelDate($dateStr) {
		if ($dateStr != NULL && $dateStr != '') {
			//return PHPExcel_Shared_Date::stringToExcel($dateStr);
			$date = strtotime($dateStr);
			return date('d-m-Y', $date);
		}
		else {
			return NULL;
		}
	}
}