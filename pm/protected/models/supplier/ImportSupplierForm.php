<?php
//Yii::import('application.extensions.*');
//require_once 'protected/extensions/PHPExcel/IOFactory.php';
//ini_set('memory_limit', '300M');
ini_set('max_execution_time', 500);

class ImportSupplierForm extends CFormModel {

	public $uplFile;
	
	public function rules() {
		return array(
				array('uplFile', 'safe'),
		);
	}
	
	public function import() {
		// get a reference to the path of PHPExcel classes 
		//$phpExcelPath = Yii::getPathOfAlias('ext');
		
		// Turn off our amazing library autoload
		//spl_autoload_unregister(array('YiiBase','autoload'));
		//spl_autoload_register(array('YiiBase','autoload'));
		
		// making use of our reference, include the main class
		// when we do this, phpExcel has its own autoload registration
		// procedure (PHPExcel_Autoloader::Register();)
		//include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		
		$isValid = true;

		$objPHPExcel = new PHPExcel();
		//$objPHPExcel = Yii::app()->excel;
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->uplFile->tempName);
		
		// Once we have finished using the library, give back the
		// power to Yii...
		//spl_autoload_register(array('YiiBase','autoload'));
		
		$username = Yii::app()->user->name;
		
		$suppliers = array();
		$failSuppliers = array();
		$today = date('Y-m-d');
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if ($rowNo == 1) {
				// Skip 1st row (i.e. header)
				continue;
			}

			$supplier = new Supplier();
			
			$i = 0;
			$supplier->id =$worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->supplier_cd = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->name = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->tel = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->contact_person = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->mobile = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->other_contact = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->qq =$worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->notice = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->bank = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->open_account = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->account_owner = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->account_no = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->term_of_payment =$worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->address = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->email = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$supplier->remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			
			$supplier->create_by = $username;
			$supplier->create_date = new CDbExpression('NOW()');
			$supplier->last_update_by = $username;
			$supplier->last_update_date = new CDbExpression('NOW()');
			
			if (!$supplier->validate()) {
				$failSuppliers[$rowNo] = $supplier;
				$isValid = false;
			}

			$suppliers[] = $supplier;
		}
		
		if (!$isValid) {
			return array(false, $failSuppliers);
		}
		
		// Clear cache
		Yii::app()->cache->delete(GlobalConstants::CACHE_MADE);
		
		// Truncate supplier table
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('supplier');
		
		// Insert into DB
		 foreach ($suppliers as $supplier) {
			$supplier->save(false);
		}
		
		return array(true);
	}
	
	private function getFormatDate($cell) {
		$dateValue = $cell->getValue();
		if(PHPExcel_Shared_Date::isDateTime($cell)) {
			$dateValue = PHPExcel_Style_NumberFormat::toFormattedString($dateValue, "dd-mm-yyyy");
		}
		
		if ($dateValue != null && $dateValue != '') {
			return date('Y-m-d', strtotime($dateValue));
		}
		else {
			return NULL;
		}
	}
}

?>