<?php

class ProductMaintForm extends CFormModel {
	
	public $message;
	
	public $product;

	public function update($post) {
		$this->product = $this->loadProductMaster($post['ProductMaster']['id']);
		$this->product->attributes = $post['ProductMaster'];
		$this->product->setScenario('save');
		
		$origModel = $this->loadProductMaster($post['ProductMaster']['id']);
			
		if ($this->product->save()) {
			// Add change log
			foreach ($origModel->attributes as $columnName=>$value) {
				if ($this->product->$columnName != $value) {
					$log = new ProductChangeLog();
					$log->prod_sn = $this->product->prod_sn;
					$log->column_name = $columnName;
					$log->old_value = $value;
					$log->new_value = $this->product->$columnName;
					$log->create_by = Yii::app()->user->name;
					if (!$log->save()) {
						var_dump($log->errors);
					}
				}
			}
			
			$this->message = '&#29986;&#21697;S/N ['.$this->product->prod_sn.'] is updated successfully!'; // S/N [XXX] is updated successfully!
			return true;
		}
		else {
			$this->message = 'Fail to update product!';
			return false;
		}
	}
	
	private function loadProductMaster($id) {
		if (GlobalFunction::isSupplier()) {
			$model = ProductMaster::model()->findByAttributes(array('id'=>$id, 'supplier'=>GlobalFunction::getUserSupplier()));
		}
		else {
			$model = ProductMaster::model()->findByAttributes(array('id'=>$id));
		}
	
		if ($model === null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
}