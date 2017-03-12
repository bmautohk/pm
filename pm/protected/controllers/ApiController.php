<?php
Yii::import('application.models.cash.*');

class ApiController extends CController {

	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		/*$headers = apache_request_headers();
		$token = $headers['Authorization'];
		if (empty($token) || !$this->checkPrivilegeByToken($token)) {
			$this->sendResponse(500, array('error'=>'No authority'));
			return;
		}*/

		if (!$this->checkPrivilege('mobile')) {
			$this->sendResponse(500, array('error'=>'No authority'));
			return;
		}

		$filterChain->run();
	}

	protected function checkPrivilege($page, $permission=NULL) {
		if (Yii::app()->user->isGuest) {
			return false;
		}

		if (!GlobalFunction::checkPagePrivilege('mobile')) {
			return false;
		}

		return true;
	}
	
	public function init() {
		parent::init();
		
		Yii::app()->attachEventHandler('onError', array($this,'handleError'));
		Yii::app()->attachEventHandler('onException', array($this,'handleError'));
	}
	
	public function handleError(CEvent $event) {
		if ($event instanceof CExceptionEvent) {
			$this->sendResponse($event->exception->statusCode, $event->exception->getMessage());
	    }
	
	    $event->handled = TRUE;
	}

	protected function sendResponse($status = 200, $body = '', $contentType = 'application/json') {
		// Set the status
		$statusHeader = 'HTTP/1.1 ' . $status;
		header($statusHeader);
		// Set the content type
		header('Content-type: ' . $contentType);
	
		echo CJSON::encode($body);
		Yii::app()->end();
	}

	protected function checkPrivilegeByToken($token) {
		$user = Authorize::model()->findByAttributes(array('access_token' => $token));

		return $user === null ? false : true;
	}
	
	public function actionCreateCash() {
		if (!$this->checkPrivilege('mobile', RolePageMatrix::PERMISSION_WRITE)) {
			$this->sendResponse(500, array('error'=>'No authority'));
			return;
		}

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
		if (!$this->checkPrivilege('mobile', RolePageMatrix::PERMISSION_WRITE)) {
			$this->sendResponse(500, array('error'=>'No authority'));
			return;
		}

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
		if (!$this->checkPrivilege('mobile', RolePageMatrix::PERMISSION_WRITE)) {
			$this->sendResponse(500, array('error'=>'No authority'));
			return;
		}

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
		echo CJSON::encode($searchResult);
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

}