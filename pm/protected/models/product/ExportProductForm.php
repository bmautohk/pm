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
			->setCellValueByColumnAndRow($i++, 1, '商品類別')
			->setCellValueByColumnAndRow($i++, 1, '材質')
			->setCellValueByColumnAndRow($i++, 1, '商品名EN')
			->setCellValueByColumnAndRow($i++, 1, '商品名CH')
			->setCellValueByColumnAndRow($i++, 1, '商品名JP')
			->setCellValueByColumnAndRow($i++, 1, '配件備忘')
			->setCellValueByColumnAndRow($i++, 1, '公司內部備忘')
			->setCellValueByColumnAndRow($i++, 1, 'PCS')
			->setCellValueByColumnAndRow($i++, 1, '顏色')
			->setCellValueByColumnAndRow($i++, 1, '顏色編號')
			->setCellValueByColumnAndRow($i++, 1, '供應商')
			->setCellValueByColumnAndRow($i++, 1, '模具費')
			->setCellValueByColumnAndRow($i++, 1, '最低起訂量')
			->setCellValueByColumnAndRow($i++, 1, '供应商報價')
			->setCellValueByColumnAndRow($i++, 1, '海渡價')
			->setCellValueByColumnAndRow($i++, 1, '其它價')
			->setCellValueByColumnAndRow($i++, 1, '原件樣品採購價')
			->setCellValueByColumnAndRow($i++, 1, '訂原件時間')
			->setCellValueByColumnAndRow($i++, 1, '原件收到日期')
			->setCellValueByColumnAndRow($i++, 1, '原件到廠日期')
			->setCellValueByColumnAndRow($i++, 1, '包裝备注')
			->setCellValueByColumnAndRow($i++, 1, '下單日期')
			->setCellValueByColumnAndRow($i++, 1, '开发進度及情况')
			->setCellValueByColumnAndRow($i++, 1, '寄往對車日期')
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
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $product['customer'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['prod_sn'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['status'] == 'A' ? 'OK' : '')
				->setCellValueByColumnAndRow($i++, $rowNo, $product['no_jp'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['factory_no'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['made'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['model'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['model_no'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['year'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['item_group'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['material'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['product_desc'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['product_desc_ch'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['product_desc_jp'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['accessory_remark'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['company_remark'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['pcs'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['colour'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['colour_no'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['supplier'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['molding'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['moq'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['cost'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['kaito'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['other'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['purchase_cost']);
			
			$sheet->getStyleByColumnAndRow($i, $rowNo)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['buy_date']));
			
			$sheet->getStyleByColumnAndRow($i, $rowNo)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['receive_date']));
			
			$sheet->getStyleByColumnAndRow($i, $rowNo)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['factory_date']));
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $product['pack_remark']);
			
			$sheet->getStyleByColumnAndRow($i, $rowNo)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['order_date']));
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $product['progress']);
			
			$sheet->getStyleByColumnAndRow($i, $rowNo)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['receive_model_date']));
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $product['person_in_charge'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['state']);
			
			$sheet->getStyleByColumnAndRow($i, $rowNo)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product['ship_date']));
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $product['market_research_price'])
				->setCellValueByColumnAndRow($i++, $rowNo, $product['yahoo_produce']);
				
				/* $sheet->getStyle('Y'.$rowNo)
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
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); */
		}
		
		header("Content-type:application/vnd.ms-excel;charset=euc");
		header('Content-Disposition: attachment;filename="product.xls"');
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