<?php
//Yii::import('application.extensions.*');
//require_once 'protected/extensions/PHPExcel/IOFactory.php';

class ImportProductForm extends CFormModel {

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

		//$objPHPExcel = new PHPExcel();
		$objPHPExcel = Yii::app()->excel;
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load($this->uplFile->tempName);
		
		// Once we have finished using the library, give back the
		// power to Yii...
		//spl_autoload_register(array('YiiBase','autoload'));
		
		$products = array();
		$failProducts = array();
		$today = date('Y-m-d');
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if ($rowNo == 1) {
				// Skip 1st row (i.e. header)
				continue;
			}

			$product = new ProductMaster();
			
			$i = 0;
			$product->customer = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->prod_sn = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->status = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue() == 'OK' ? 'A' : 'I';
			$product->no_jp = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue(); if ($product->no_jp === NULL) { $product->no_jp = ''; }
			$product->factory_no = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->made = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->model = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->model_no = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->year = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->item_group = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->material = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->product_desc = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->product_desc_ch = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->product_desc_jp = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->accessory_remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->company_remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->pcs = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->colour = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->colour_no = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->supplier = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->molding = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->moq = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->cost = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->kaito = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->other = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->purchase_cost = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->buy_date = $this->getFormatDate($worksheet->getCellByColumnAndRow($i++, $rowNo));
			$product->receive_date = $this->getFormatDate($worksheet->getCellByColumnAndRow($i++, $rowNo));
			$product->factory_date = $this->getFormatDate($worksheet->getCellByColumnAndRow($i++, $rowNo));
			$product->pack_remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->order_date = $this->getFormatDate($worksheet->getCellByColumnAndRow($i++, $rowNo));
			$product->progress = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->receive_model_date = $this->getFormatDate($worksheet->getCellByColumnAndRow($i++, $rowNo));
			$product->person_in_charge = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->state = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->ship_date = $this->getFormatDate($worksheet->getCellByColumnAndRow($i++, $rowNo));
			$product->market_research_price = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->yahoo_produce = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			
			$product->create_date = $today;
			
			if (!$product->validate()) {
				$failProducts[$rowNo] = $product;
				$isValid = false;
			}

			$products[] = $product;
		}
		
		if (!$isValid) {
			return array(false, $failProducts);
		}
		
		// Clear cache
		Yii::app()->cache->delete(GlobalConstants::CACHE_MADE);
		
		// Truncate product table
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('product_master');
		
		// Insert into DB
		 foreach ($products as $product) {
			$product->save(false);
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