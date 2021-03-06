<?php
class ApiImageMaintForm extends CFormModel {

	const IMAGE_TYPE_CASH = 'cash';
	const IMAGE_TYPE_INVOICE = 'invoice';
	const IMAGE_TYPE_PAYMENT = 'payment';
	
	public function uploadImage($cash_id, $image_type, $image_file) {
		if (!$this->isValidImageType($image_type)) {
			throw new Exception('Invalid image type['.$image_type.']');
		}

		$cash = Cash::model()->findByAttributes(array('id'=>$cash_id, 'is_active'=>'Y'));
		
		if ($cash === null) {
			throw new Exception('Record not found. Cash ID['.$cash_id.']');
		}

		if ($image_file === NULL) {
			throw new Exception('No image');
		}
		
		$image_name = $this->saveImage($cash_id, $image_type, $image_file);
		$this->assignCashImage($cash, $image_type, $image_name);
	}

	private function isValidImageType($image_type) {
		if ($image_type === ApiImageMaintForm::IMAGE_TYPE_CASH) {
			return ture;
		} if ($image_type === ApiImageMaintForm::IMAGE_TYPE_PAYMENT) {
			return ture;
		} if ($image_type === ApiImageMaintForm::IMAGE_TYPE_INVOICE) {
			return ture;
		} else {
			return false;
		}
	}

	private function saveImage($cash_id, $image_type, $image_file) {
		// Find extension
		$actual_file_name = $image_file["name"];
		$pos = strrpos($actual_file_name, '.');
		$ext = substr($actual_file_name, $pos + 1);
		
		$imgDir = Yii::app()->params['cash_image_dir'];

		// Define image name
		$target = $cash_id.'_'.$image_type.'_'.date('YmdHis').'.'.$ext;

		if (!file_exists($imgDir)) {
			mkdir($imgDir);
		}

		if (!move_uploaded_file($image_file["tmp_name"], $imgDir.$target)) {
			throw new Exception('Fail to upload image to directory['.$imgDir.']');
		}

		//TODO create thumbnail
		$thumbnailDir = Yii::app()->params['cash_thumbnail_dir'];

		if (!file_exists($thumbnailDir)) {
			mkdir($thumbnailDir);
		}

		if (!copy($imgDir.$target, $thumbnailDir.$target)) {
			throw new Exception('Fail to upload image to directory['.$thumbnailDir.']');
		}

		return $target;
	}

	private function assignCashImage($cash, $image_type, $image_name) {
		if ($image_type === ApiImageMaintForm::IMAGE_TYPE_CASH) {
			$this->deleteImage($cash->image_name);
			$cash->image_name = $image_name;
		} if ($image_type === ApiImageMaintForm::IMAGE_TYPE_PAYMENT) {
			$this->deleteImage($cash->payment_image);
			$cash->payment_image = $image_name;
		} if ($image_type === ApiImageMaintForm::IMAGE_TYPE_INVOICE) {
			$this->deleteImage($cash->invoice_image);
			$cash->invoice_image = $image_name;
		}

		$cash->save();
	}

	private function deleteImage($imageName) {
		if ($imageName == NULL || $imageName == '') {
			return;
		}

		$imgDir = Yii::app()->params['cash_image_dir'];
		$thumbnailDir = Yii::app()->params['cash_thumbnail_dir'];

		if (file_exists($imgDir.'/'.$imageName)) {
			unlink($imgDir.'/'.$imageName);
		}

		if (file_exists($thumbnailDir.'/'.$imageName)) {
			unlink($thumbnailDir.'/'.$imageName);
		}
	}

}