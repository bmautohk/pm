<?php
class ApiBaseController extends CController {

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
}