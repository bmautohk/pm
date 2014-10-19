<?php
Yii::import('application.models.email.*');

class EmailController extends Controller {
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('email_management');
		$filterChain->run();
	}
	
	public function actionList() {
		$form = new EmailForm();
		$form->populate($_POST);

		if ($form->action == 'save') {
			$this->checkPrivilege('email_management', RolePageMatrix::PERMISSION_WRITE);
			$form->save();
		} else if ($form->action == 'delete') {
			$this->checkPrivilege('email_management', RolePageMatrix::PERMISSION_WRITE);
			$form->delete();
		} else {
			$form->init();
		}
		
		$this->render('list', array('model'=>$form));
	}
}