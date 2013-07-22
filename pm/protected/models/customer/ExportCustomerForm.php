<?php
class ExportCustomerForm extends CFormModel {
	
	public function export() {
		// Find all customers
		$criteria = new CDbCriteria();
		$criteria->order = 'id';
		
		$model = Customer::model();
		$model->setDbCriteria($criteria);
		
		$customers = $model->findAll();
		
		$this->generateExcel($customers);
	}
	
	public function generateExcel($customers) {
		// Output to excel
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
	
		// Set properties
		$objPHPExcel->getProperties()->setCreator("BM AUTO")
		->setLastModifiedBy("BM AUTO")
		->setTitle("Customer");
	
		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		// Header
		$i = 0;
		$sheet->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'name'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'id'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'fax'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'address'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'address2'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'email'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'cust_group'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'cust_type'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'where_to_find'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'where_to_find_detail'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'tel'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'tel2'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'mobile_no'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'mobile_no2'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'contact_person'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'contact_salesman'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'other_contact'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'website'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'vip'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'remark'))
			->setCellValueByColumnAndRow($i++, 1, Yii::t('customer_message', 'salesman_remark'));
		
		$rowNo = 1;
		foreach($customers as $customer) {
			$i = 0;
			$rowNo++;
			
			$cust_types = '';
			foreach ($customer->customerCustTypes as $cust_type) {
				$cust_types .= $cust_type->cust_type_id.',';
			}
			if ($cust_types != '') {
				$cust_types = substr($cust_types, 0, strlen($cust_types) - 1);
			}
			
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['name']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['id']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['fax']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['address']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['address2']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['email']);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $customer['cust_group']);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $cust_types);
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, $customer['where_to_find']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['where_to_find_detail']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['tel']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['tel2']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['mobile_no']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['mobile_no2']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['contact_person']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['contact_salesman']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['other_contact']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['website']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['vip']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['remark']);
			$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $customer['salesman_remark']);
		}
		
		header("Content-type:application/vnd.ms-excel;charset=euc");
		header('Content-Disposition: attachment;filename="customer.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}