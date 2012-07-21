<?php
//Yii::import('application.extensions.*');
require_once 'protected/extensions/PHPExcel/IOFactory.php';

class ImportProductForm extends CFormModel {
	
	public $uplFile;
	
	/*public function rules() {
		return array(
				array('uplFile', 'file', 'types'=>'csv'),
		);
	}*/
	
	public function import() {
		$isValid = true;

		//$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load($this->uplFile->tempName);
		
		$products = array();
		$failProducts = array();
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if ($rowNo == 1) {
				// Skip 1st row (i.e. header)
				continue;
			}

			$product = new ProductMaster();
			
			$i = 0;
			$product->customer = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->prod_sn = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->status = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue() == 'OK' ? 'A' : 'I';
			$product->no_jp = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->factory_no = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->made = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->model = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->model_no = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->year = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->item_group = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->material = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->product_desc = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->remark = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->photo_link = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->pcs = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->colour = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->colour_no = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->moq = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->molding = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->cost = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->kaito = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->other = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			
			$i = $i+2; // Skip 2 columns
			
			$product->buy_date = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->receive_date = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->supplier = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->purchase_cost = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->factory_date = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->pack_remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->order_date = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->progress = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->receive_model_date = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->person_in_charge = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->state = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			$product->ship_date = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->market_research_price = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$product->yahoo_produce = conv($worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue());
			
			if (!$product->validate()) {
				$failProducts[$rowNo] = $product;
				$isValid = false;
			}

			$products[] = $product;
		}
		
		if (!$isValid) {
			return array(false, $failProducts);
		}
		
		// Insert into DB
		foreach ($products as $product) {
			$product->save(false);
		}
		
		return array(true);
	}
}

function conv($str) {
	return mb_convert_encoding($str,"EUC-JP","UTF-8");
}

?>