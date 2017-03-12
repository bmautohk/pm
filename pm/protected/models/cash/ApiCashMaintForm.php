<?php
class ApiCashMaintForm extends CFormModel {
	
	public $id;
	public $pay_from;
	public $pay_to;
	public $account;
	public $desc;
	public $rmb;
	public $hkd;
	public $jpy;
	public $remark;
	public $submitted_by;
	
	public $image_file;
	
	public $error_messages;
	
	public function create() {
		$model = $this->convertToModel(new Cash());
		$model->is_active = 'Y';
		$model->created_by = $this->submitted_by;
		$model->last_updated_by = $this->submitted_by;
		
		if ($model->save()) {
			// Success
			
			// Save image
			/*if ($this->image_file != NULL) {
				$target = $this->saveImage($this->image_file, $model->id);
				
				if ($target == NULL) {
					$this->error_messages[] = 'Fail to upload image.';
					return false;
				} else {
					$model->image_name = $target;
					$model->save();
				}
			}*/
			
			$this->error_messages = NULL;
			$this->id = Yii::app()->db->getLastInsertID();
			return true;
		} else {
			// Fail
			$this->error_messages = array();
			 foreach ($model->errors as $errors) {
				foreach ($errors as $error) {
					$this->error_messages[] = $error;
				} 
			}
			
			return false;
		}
	}
	
	public function update() {
		$model = Cash::model()->findByAttributes(array('id'=>$this->id, 'is_active'=>'Y'));
		
		if ($model === null) {
			$this->error_messages = array();
			$this->error_messages[] = 'Record not found ID['.$this->id.']';
			return false;
		}
		
		$model = $this->convertToModel($model);
		$model->last_updated_by = $this->submitted_by;
		
		if ($model->save()) {
			// Success
			/*if ($this->image_data != NULL) {
				$image_file = UploadedFile::getInstances($this, 'image_data');
				$image_file->saveAs($imgDir.$model->id.'.'.$this->image_ext);
				
				$model->image_name = $model->id.'.'.$this->image_ext;
				$model->save();
			}*/
			
			// Save image
			/*if ($this->image_file != NULL) {
				$target = $this->saveImage($this->image_file, $model->id);
				
				if ($target == NULL) {
					$this->error_messages[] = 'Fail to upload image.';
					return false;
				} else {
					$model->image_name = $target;
					$model->save();
				}
			}*/
			
			$this->error_messages = NULL;
			return true;
		} else {
			// Fail
			$this->error_messages = array();
			 foreach ($model->errors as $errors) {
				foreach ($errors as $error) {
					$this->error_messages[] = $error;
				} 
			}
			
			return false;
		}
	}

	public function delete() {
		$this->error_messages = array();

		$model = Cash::model()->findByAttributes(array('id'=>$this->id, 'is_active'=>'Y'));
		
		if ($model === null) {
			$this->error_messages[] = 'Record not found ID['.$this->id.']';
			return false;
		}

		if ($model->created_by != $this->submitted_by && !GlobalFunction::isAdmin()) {
			$this->error_messages[] = "You dont have privilege to delete this cash. You must be administrator or cash's creator.";
			return false;
		}

		$model->is_active = 'N';
		$model->last_updated_by = $this->submitted_by;
		
		if ($model->save()) {
			$this->error_messages = NULL;
			return true;
		} else {
			// Fail
			$this->error_messages = array();
			 foreach ($model->errors as $errors) {
				foreach ($errors as $error) {
					$this->error_messages[] = $error;
				} 
			}
			
			return false;
		}
	}

	public function uploadImage() {
		$this->error_messages = array();

		$model = Cash::model()->findByAttributes(array('id'=>$this->id, 'is_active'=>'Y'));
		
		if ($model === null) {
			$this->error_messages[] = 'Record not found ID['.$this->id.']';
			return false;
		}

		if ($this->image_file === NULL) {
			$this->error_messages[] = 'No image';
			return false;
		}

		$target = $this->saveImage($this->image_file, $model->id);
				
		if ($target == NULL) {
			$this->error_messages[] = 'Fail to upload image.';
			return false;
		} else {
			$model->image_name = $target;
			$model->save();
			return true;
		}
	}
	
	private function saveImage($image_file, $id) {
		// Find extension
		$actual_file_name = $image_file["name"];
		$pos = strrpos($actual_file_name, '.');
		$ext = substr($actual_file_name, $pos + 1);
		
		$imgDir = Yii::app()->params['cash_image_dir'];
		
		$target = $id.'.'.$ext;
		
		if (!move_uploaded_file($image_file["tmp_name"], $imgDir.$target)) {
			return NULL;
		}
		
		return $target;
	}
	
	private function convertToModel($model) {
		$model->pay_from = $this->pay_from;
		$model->pay_to = $this->pay_to;
		$model->account = $this->account;
		$model->desc = $this->desc;
		$model->rmb = $this->rmb == "" ? NULL : $this->rmb;
		$model->hkd = $this->hkd == "" ? NULL : $this->hkd;
		$model->jpy = $this->jpy == "" ? NULL : $this->jpy;
		$model->remark = $this->remark;
		
		return $model;
	}
}