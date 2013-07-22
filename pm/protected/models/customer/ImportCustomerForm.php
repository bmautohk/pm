<?php
ini_set('max_execution_time', 500);

class ImportCustomerForm extends CFormModel {

	public $uplFile;
	
	public function rules() {
		return array(
				array('uplFile', 'required', 'message'=>'Please browse a file'),
		);
	}
	
	public function import() {
		$isValid = true;
		
		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->uplFile->tempName);
		
		$customers = array();
		$customerCustTypes = array();
		$failCustomer = array();
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if ($rowNo == 1) {
				// Skip 1st row (i.e. header)
				continue;
			}
		
			$customer = new Customer('import');
				
			$i = 0;
			$customer->name = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->id = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->fax = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->address = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->address2 = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->email = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->cust_group = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$cust_type_ids = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->where_to_find = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->where_to_find_detail = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->tel = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->tel2 = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->mobile_no = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->mobile_no2 = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->contact_person = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->contact_salesman = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->other_contact = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->website = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->vip = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			$customer->salesman_remark = $worksheet->getCellByColumnAndRow($i++, $rowNo)->getValue();
			
			$customer->create_by = Yii::app()->user->name;
			$customer->create_date = new CDbExpression('NOW()');
			$customer->last_update_by = Yii::app()->user->name;
			$customer->last_update_date = new CDbExpression('NOW()');
			
			// Set cust_type
			if ($cust_type_ids != '') {
				foreach(explode(',', $cust_type_ids) as $cust_type_id) {
					$customer_cust_type = new CustomerCustType();
					$customer_cust_type->customer_id = $customer->id;
					$customer_cust_type->cust_type_id = $cust_type_id;
					$customerCustTypes[] = $customer_cust_type;
				}
			}
			
			if (!$customer->validate()) {
				$failCustomer[$rowNo] = $customer;
				$isValid = false;
			}
		
			$customers[] = $customer;
		}
		
		if (!$isValid) {
			return array(false, $failCustomer);
		}
		
		// Clear cache
		Yii::app()->cache->delete(GlobalConstants::CACHE_MADE);
		
		// Truncate customer_cust_type
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('customer_cust_type');
		
		// Truncate customer table
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('customer');
		
		// Insert into DB
		foreach ($customers as $customer) {
			$customer->save(false);
			foreach ($customerCustTypes as $customer_cust_type) {
				$customer_cust_type->save(false);
			}
		}
		
		return array(true);
	}

}