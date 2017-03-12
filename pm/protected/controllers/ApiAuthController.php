<?php
Yii::import('application.models.cash.*');

class ApiAuthController extends CController {

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
	
	public function actionIndex() {
		$post = file_get_contents("php://input");
		$data = CJSON::decode($post, true);
		
		$model = new LoginForm;
		
		$model->username = $data['id'];
		$model->password = $data['password'];
		
		if ($model->validate() && $model->login()) {
			$is_valid = true;

			//$this->sendResponse(200, array('access_token'=>$model->getToken()));
			$this->sendResponse(200);

		} else {
			$is_valid = false;

			$this->sendResponse(400, array('error'=>'Invalid user.'));
		}
	}
	

}