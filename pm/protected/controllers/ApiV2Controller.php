<?php
Yii::import('application.models.cash.*');

class ApiV2Controller extends ApiBaseController {

	public function actionImage() {
		$httpMethod = $_SERVER['REQUEST_METHOD'];

		$model = new ApiImageMaintForm();

		header('Content-type: application/json');

		try {
			if ($httpMethod == 'POST') {
				$cash_id = $_GET['cash_id'];
				$image_type = $_GET['image_type'];
				$image_file = $_FILES["image_file"];
				
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