<?php
require_once 'protected/extensions/PHPExcel/CachedObjectStorageFactory.php';
require_once 'protected/extensions/PHPExcel/Settings.php';

class CartForm extends CFormModel {
	
	public $message;
	
	public function addCart($post) {
		$productSNs = $post['add_to_cart'];
		
		if ($productSNs == NULL) {
			$this->message = '';
			return;
		}
		
		// Store cart product to session
		$session = new CHttpSession;
		$session->open();
		
		if (!isset($session[GlobalConstants::SESSION_CART_PRODUCT])) {
			$cartProducts = array();
		} else {
			$cartProducts = $session[GlobalConstants::SESSION_CART_PRODUCT];
		}
		
		$message = '';
		foreach ($productSNs as $productSN) {
			if (!in_array($productSN, $cartProducts)) {
				$cartProducts[] = $productSN;
			}
			$message .= $productSN.', ';
		}
		
		$session[GlobalConstants::SESSION_CART_PRODUCT] = $cartProducts;
		
		$session->close();
		
		$this->message = substr($message, 0, sizeof($message) - 3);
	}
	
	public function getCartProduct() {
		$session = new CHttpSession;
		$session->open();
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition('prod_sn', $session[GlobalConstants::SESSION_CART_PRODUCT]);
		$criteria->order = 'prod_sn';
			
		$model = ProductMaster::model();
		$model->setDbCriteria($criteria);
		
		$products = $model->findAll();

		$session->close();
		
		return $products;
	}
	
	public function exportCart() {
		$session = new CHttpSession;
		$session->open();
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition('prod_sn', $session[GlobalConstants::SESSION_CART_PRODUCT]);
		$criteria->order = 'prod_sn';
			
		$model = ProductMaster::model();
		$model->setDbCriteria($criteria);
		
		$products = $model->findAll();

		$this->generateExcel($products);
		
		// Add count
		foreach ($session[GlobalConstants::SESSION_CART_PRODUCT] as $productSN) {
			$model = ProductCartCount::model()->findByAttributes(array('prod_sn'=>$productSN));
			if ($model == NULL) {
				// Create new record
				$model = new ProductCartCount();
				$model->prod_sn = $productSN;
				$model->count = 1;
				$model->save();
			} else {
				// Update existing record
				$model->count += 1;
				$model->save();
			}
		}

		// Clear seesion
		$session->remove(GlobalConstants::SESSION_CART_PRODUCT);
		
		$session->close();
	}
	
	private function generateExcel($products) {
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		
		$columnNames = array(
				'customer',
				'prod_sn',
				'status',
				'no_jp',
				'factory_no',
				'made',
				'model',
				'model_no',
				'year',
				'item_group',
				'material',
				'product_desc',
				'product_desc_ch',
				'product_desc_jp',
				'accessory_remark',
				'company_remark',
				'pcs',
				'colour',
				'colour_no',
				'supplier',
				'molding',
				'moq',
				'cost',
				'kaito',
				'other',
				'purchase_cost',
				'buy_date',
				'receive_date',
				'factory_date',
				'pack_remark',
				'order_date',
				'progress',
				'receive_model_date',
				'person_in_charge',
				'state',
				'ship_date',
				'market_research_price',
				'yahoo_produce',
				'produce_status',
				'is_monopoly'
		);
		
		$dateColumnNames = array(
			'buy_date',
			'receive_date',
			'factory_date',
			'order_date',
			'receive_model_date',
			'ship_date'
		);
		
		$roleMatrix = Yii::app()->user->getState('role_matrix');
		foreach ($columnNames as $idx=>$columnName) {
			if (!GlobalFunction::checkPrivilege($roleMatrix, 'product_master', $columnName)) {
				//$sheet->removeColumnByIndex($i);
				unset($columnNames[$idx]);
			}
		}

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
		foreach ($columnNames as $columnName) {
			$sheet->setCellValueByColumnAndRow($i++, 1, Yii::t('product_message', $columnName));
			
			if (in_array($columnName, $dateColumnNames)) {
				$sheet->getStyleByColumnAndRow($i-1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			}
		}
		
		$rowNo = 1;
		foreach($products as $product) {
			$i = 0;
			$rowNo++;
			foreach ($columnNames as $columnName) {
				if ($columnName == 'status') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['status'] == 'A' ? 'OK' : '');
				} else if ($columnName == 'is_monopoly') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['is_monopoly'] == 0 ? 'No' : 'Yes');
				} else if (in_array($columnName, $dateColumnNames)) {
					$sheet->setCellValueByColumnAndRow($i++, $rowNo, CartForm::strToExcelDate($product[$columnName]));
				} else {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product[$columnName]);
				}
			}
		}
		
		header("Content-type:application/vnd.ms-excel;charset=euc");
		header('Content-Disposition: attachment;filename="product.xls"');
		header('Cache-Control: max-age=0');
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	private static function strToExcelDate($dateStr) {
		if ($dateStr != NULL && $dateStr != '') {
			$date = strtotime($dateStr);
			return date('d-m-Y', $date);
		}
		else {
			return NULL;
		}
	}
}