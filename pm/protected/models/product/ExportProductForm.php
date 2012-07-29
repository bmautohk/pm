<?php
class ExportProductForm extends CFormModel {
	public function export() {
		// Find all products
		$criteria = new CDbCriteria();
		$criteria->order = 'id';
			
		$model = ProductMaster::model();
		$model->setDbCriteria($criteria);
		
		$products = $model->findAll();
		
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
		$sheet->setCellValueByColumnAndRow($i++, 1, '客戶')
			->setCellValueByColumnAndRow($i++, 1, '產品S/N')
			->setCellValueByColumnAndRow($i++, 1, 'STATUS')
			->setCellValueByColumnAndRow($i++, 1, '品番')
			->setCellValueByColumnAndRow($i++, 1, '工廠編號')
			->setCellValueByColumnAndRow($i++, 1, '車種')
			->setCellValueByColumnAndRow($i++, 1, '車型')
			->setCellValueByColumnAndRow($i++, 1, '型號')
			->setCellValueByColumnAndRow($i++, 1, '年份')
			->setCellValueByColumnAndRow($i++, 1, '商品名')
			->setCellValueByColumnAndRow($i++, 1, '材質')
			->setCellValueByColumnAndRow($i++, 1, '商品説明1')
			->setCellValueByColumnAndRow($i++, 1, '商品説明2/配件备注')
			->setCellValueByColumnAndRow($i++, 1, '图片超链接')
			->setCellValueByColumnAndRow($i++, 1, 'PCS')
			->setCellValueByColumnAndRow($i++, 1, '顏色')
			->setCellValueByColumnAndRow($i++, 1, '顏色編號')
			->setCellValueByColumnAndRow($i++, 1, '最低起訂量')
			->setCellValueByColumnAndRow($i++, 1, '模具費')
			->setCellValueByColumnAndRow($i++, 1, '供应商報價')
			->setCellValueByColumnAndRow($i++, 1, '海渡')
			->setCellValueByColumnAndRow($i++, 1, '其他')
			->setCellValueByColumnAndRow($i++, 1, '')
			->setCellValueByColumnAndRow($i++, 1, '')
			->setCellValueByColumnAndRow($i++, 1, '訂原件時間')
			->setCellValueByColumnAndRow($i++, 1, '原件收到日期')
			->setCellValueByColumnAndRow($i++, 1, '供應商')
			->setCellValueByColumnAndRow($i++, 1, '原件樣品採購價')
			->setCellValueByColumnAndRow($i++, 1, '原件交付工廠日期')
			->setCellValueByColumnAndRow($i++, 1, '包裝备注')
			->setCellValueByColumnAndRow($i++, 1, '下單日期')
			->setCellValueByColumnAndRow($i++, 1, '开发進度及情况')
			->setCellValueByColumnAndRow($i++, 1, '收到樣板~寄往對車日期')
			->setCellValueByColumnAndRow($i++, 1, '對車負責人')
			->setCellValueByColumnAndRow($i++, 1, '對車情況')
			->setCellValueByColumnAndRow($i++, 1, '出货日期')
			->setCellValueByColumnAndRow($i++, 1, '市场调查的价格')
			->setCellValueByColumnAndRow($i++, 1, 'YAHOO出品')
		;
		
		$rowNo = 1;
		foreach($products as $product) {
			$i = 0;
			$rowNo++;
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['customer']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['prod_sn']))
				->setCellValueByColumnAndRow($i++, $rowNo, $product['status'] == 'A' ? 'OK' : '')
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['no_jp']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['factory_no']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['made']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['model']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['model_no']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['year']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['item_group']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['material']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['product_desc']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['remark']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['photo_link']))
				->setCellValueByColumnAndRow($i++, $rowNo, $product['pcs'])
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['colour']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['colour_no']))
				->setCellValueByColumnAndRow($i++, $rowNo, $product['moq'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['molding'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['cost'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['kaito'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['other'])
				->setCellValueByColumnAndRow($i++, $rowNo, '')
				->setCellValueByColumnAndRow($i++, $rowNo, '')
				->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['buy_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['receive_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['supplier']))
				->setCellValueByColumnAndRow($i++, $rowNo, $product['purchase_cost'])
				->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['factory_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['pack_remark']))
				->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['order_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['progress']))
				->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['receive_model_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['person_in_charge']))
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['state']))
				->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['ship_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, $product['market_research_price'])
				->setCellValueByColumnAndRow($i++, $rowNo, $this->conv($product['yahoo_produce']))
				;
				
				$sheet->getStyle('Y'.$rowNo)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('Z'.$rowNo)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('AC'.$rowNo)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('AE'.$rowNo)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('AG'.$rowNo)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('AJ'.$rowNo)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		}
		
		header("Content-type:application/vnd.ms-excel;charset=euc");
		header('Content-Disposition: attachment;filename="product.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	private function conv($str) {
		return iconv('euc-jp', "UTF-8", $str);
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