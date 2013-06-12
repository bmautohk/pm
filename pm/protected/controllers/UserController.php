<?php
Yii::import('application.models.user.*');

class UserController extends Controller {
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		if (!GlobalFunction::isAdmin()) {
			$this->redirect(Yii::app()->createUrl('site/noPermission'));
		}
		else {
			$filterChain->run();
		}
	}
	
	public function actionIndex($msg=NULL) {
		$users = Authorize::model()->with('role')->with('user_supplier')->findAll();
		$this->render('list', array('users'=>$users, 'msg'=>$msg));
	}
	
	public function actionAdd() {
		$model = new MaintUserForm('add');
		
		if ($_POST['action']) {
			// Create product
			$model->attributes = $_POST['MaintUserForm'];
			
			if ($model->create()) {
				$msg = array('success'=>'User ['.$model->username.'] is created successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to create user!';
			}
		}
		
		$this->render('maint', array('model'=>$model, 'action'=>'add', 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionUpdate() {
		$model = new MaintUserForm('update');
		
		if ($_POST['action']) {
			// Update user
			$model->attributes = $_POST['MaintUserForm'];
			if ($model->update()) {
				$msg = array('success'=>'User ['.$model->username.'] is updated successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to update user!';
			}
		}
		else {
			// Retrieve user
			$username = $_GET['username'];
			$model->find($username);
		}
		
		$this->render('maint', array('model'=>$model, 'action'=>'update', 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionDelete() {
		$model = new MaintUserForm();
		$model->attributes = $_POST['MaintUserForm'];
		
		if ($model->delete()) {
			$successMsg = 'User ['.$model->username.'] is deleted successfully.';
		}
		else {
			$errorMsg = 'Fail to delete user ['.$model->username.']';
		}
		
		$msg = array('success'=>$successMsg, 'error'=>$errorMsg);
		$this->actionIndex($msg);
	}
}
