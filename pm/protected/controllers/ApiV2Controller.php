<?php
Yii::import('application.models.cash.*');

class ApiV2Controller extends ApiBaseController {

	public function actionImage() {
		$httpMethod = $_SERVER['REQUEST_METHOD'];

		$model = new ApiImageMaintForm();

		header('Content-type: application/json');

		try {
			if ($httpMethod == 'POST') {
				$cash_id = $_POST['cash_id'];
				$image_type = $_POST['image_type'];
				$image_file = $_FILES['file'];
				$model->uploadImage($cash_id, $image_type, $image_file);
				$this->sendResponse(200);

			} else {
				$this->sendResponse(404);
			}
		} catch (Exception $e) {
			$this->sendResponse(500, array('error'=>$e->getMessage()));
		}
	}

}