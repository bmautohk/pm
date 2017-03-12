<?php
require_once 'protected/extensions/PHPExcel/CachedObjectStorageFactory.php';
require_once 'protected/extensions/PHPExcel/Settings.php';
class ExportProductForm extends CFormModel {
	
	public function export($show_volume = false) {
		// Find all products
		$criteria = new CDbCriteria();
		$criteria->order = 'prod_sn';
		
		//$criteria->condition = "prod_sn = '3716'"; // testing
		
		$model = ProductMaster::model();
		$model->setDbCriteria($criteria);
		
		$products = $model->findAll();
		
		$this->generateExcel($products, $show_volume);
	}
	
	private function generateExcel($products, $show_volume) {
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
				'business_price',
				'auction_price',
				'kaito_price',
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
				'shop',
				'is_monopoly',
				'is_retail',
				'is_internal',
				'is_exhibit',
				'is_ship',
				'category_id'
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
				unset($columnNames[$idx]);
			}
		}
		
		$isDisplayVolume = false;
		if ($show_volume) {
			if (GlobalFunction::checkPrivilege($roleMatrix, 'product_master', 'output_volume')) {
				// User has privilige to see product output volume
				$isDisplayVolume = true;
				
				// Get output volume
				$outputVolumeMap = array();

				$outputVolumes = ProductOutputVolume::model()->findAll();
				foreach ($outputVolumes as $outputVolume) {
					$outputVolumeMap[$outputVolume->no_jp][$outputVolume->source] = $outputVolume;
				}
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
	
		/**
		 * Write headers
		 */
		$rowNo = 1;

		$i = 0;
		foreach ($columnNames as $columnName) {
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', $columnName));
				
			if (in_array($columnName, $dateColumnNames)) {
				$sheet->getStyleByColumnAndRow($i-1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			}
		}
		
		if ($isDisplayVolume) {
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', 'display_S1_output_volume'));
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', 'display_S1_output_volume_1month'));
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', 'display_S1_output_volume_2weeks'));
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', 'display_S1CN_output_volume'));
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', 'display_S1CN_output_volume_1month'));
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, Yii::t('product_message', 'display_S1CN_output_volume_2weeks'));
		}

		/**
		 * Write product lines
		 */
		foreach($products as $product) {
			$i = 0;
			$rowNo++;
			foreach ($columnNames as $columnName) {
				if ($columnName == 'status') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['status'] == 'A' ? 'OK' : '');
				} else if ($columnName == 'is_monopoly') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['is_monopoly'] == 0 ? 'No' : 'Yes');
				} else if ($columnName == 'is_retail') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['is_retail'] == 0 ? 'No' : 'Yes');
				} else if ($columnName == 'is_internal') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['is_internal'] == 0 ? 'No' : 'Yes');
				} else if ($columnName == 'is_exhibit') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['is_exhibit'] == 0 ? 'No' : 'Yes');
				} else if ($columnName == 'is_ship') {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product['is_ship'] == 0 ? 'No' : 'Yes');
				} else if ($columnName == 'category_id') {
					// Category list
					

					$categoryList = Category::model()->findByProductId($product->id);

					$categoryNameList = NULL;
					if (!empty($categoryList)) {
						foreach ($categoryList as $category) {
							if ($categoryNameList === NULL) {
								$categoryNameList = $category->name;
							} else {
								$categoryNameList .= ','.$category->name;
							}
						}
					}

					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $categoryNameList);

				} else if (in_array($columnName, $dateColumnNames)) {
					$sheet->setCellValueByColumnAndRow($i++, $rowNo, ExportProductForm::strToExcelDate($product[$columnName]));
				} else {
					$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $product[$columnName]);
				}
			}
			
			// Write product output volume
			if ($isDisplayVolume) {
				$volume = $outputVolumeMap[$product->no_jp][ProductOutputVolume::SOURCE_S1];
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $volume->total_unit);
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $volume->unit_1);
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $volume->unit_2);
				
				$volume = $outputVolumeMap[$product->no_jp][ProductOutputVolume::SOURCE_S1CN];
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $volume->total_unit);
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $volume->unit_1);
				$sheet->setCellValueExplicitByColumnAndRow($i++, $rowNo, $volume->unit_2);
			}
		}
	
		header("Content-type:application/vnd.ms-excel;charset=utf8");
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