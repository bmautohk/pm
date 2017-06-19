<?php
Yii::import('application.models.cash.*');

class ApiController extends ApiBaseController {
	
	public function actionCreateCash() {
		$post = file_get_contents("php://input");
		$data = CJSON::decode($post, true);
		
		$model = new ApiCashMaintForm();
		$model->setAttributes($data, false);
		//$model->setAttributes($_POST, false);
		
		//$model->image_file = $_FILES["image_file"];
		
		if ($model->create()) {
			$this->sendResponse(200, array('id'=>$model->id));
		} else {
			$this->sendResponse(500, array('errors'=>$model->error_messages));
		}
	}
	
	public function actionUpdateCash() {
		$post = file_get_contents("php://input");
		$data = CJSON::decode($post, true);
		
		$model = new ApiCashMaintForm();
		$model->setAttributes($data, false);
		//$model->setAttributes($_POST, false);
		
		//$model->image_file = $_FILES["image_file"];
		
		if ($model->update()) {
			$this->sendResponse(200, array('id'=>$model->id));
		} else {
			$this->sendResponse(500, array('errors'=>$model->error_messages));
		}
	}

	public function actionDeleteCash() {
		$post = file_get_contents("php://input");
		$data = CJSON::decode($post, true);
		
		$model = new ApiCashMaintForm();
		$model->setAttributes($data, false);
		
		if ($model->delete()) {
			$this->sendResponse(200);
		} else {
			$this->sendResponse(500, array('errors'=>$model->error_messages));
		}
	}
	
	public function actionGetCashes() {
		
		$model = new ApiCashSearchForm();
		$model->setAttributes($_GET);
		
		if (!$model->validate()) {
			throw new CHttpException(400, 'Missing parameter');
		}
		
		$searchResult = $model->search();
		header('Content-type: application/json');
		echo CJSON::encode($searchResult);
	}

	public function actionGetCash() {
		$id = Yii::app()->getRequest()->getQuery('id');

		if ($id == NULL) {
			throw new CHttpException(400, 'Missing parameter');
		}

		$model = new ApiCashSearchForm();
		$searchResult = $model->searchByCashId($id, Yii::app()->user->id);

		if ($searchResult != NULL) {
			header('Content-type: application/json');
			echo CJSON::encode($searchResult);
		} else {
			throw new CHttpException(404, 'Record not found');
		}
	}


	public function actionImage() {
		$model = new ApiCashMaintForm();

		if (isset($_GET['id'])) {
			$model->id = $_GET['id'];
		} else {
			$model->id = $_POST['id'];
		}

		$model->image_file = $_FILES["image_file"];
		if ($model->uploadImage()) {
			$this->sendResponse(200);
		} else {
			$this->sendResponse(500, array('errors'=>$model->error_messages));
		}
	}
	
	public function actionProduct() {
		$no_jp = $_GET['no_jp'];
		
		$criteria = new CDbCriteria();
		$criteria->compare('no_jp', $no_jp);
		
		$data = ProductMaster::model()->find($criteria);
		
		header('Access-Control-Allow-Origin: *');
		echo CJSON::encode($data == null ? '' : $data);
	}

	public function actionLogout() {
   		Yii::app()->user->logout();
   		$this->sendResponse(200);
   	}

}