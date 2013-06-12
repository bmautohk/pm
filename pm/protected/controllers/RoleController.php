<?php
Yii::import('application.models.role.*');

class RoleController extends Controller {
	
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
		$roles = Role::model()->findAll();
		$this->render('list', array('roles'=>$roles, 'msg'=>$msg));
	}
	
	public function actionAdd() {
		$model = new MaintRoleForm('add');
		
		if ($_POST['action']) {
			// Create role
			$model->attributes = $_POST['MaintRoleForm'];
			
			if ($model->create()) {
				$msg = array('success'=>'User ['.$model->role.'] is created successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to create role!';
			}
		}
		
		$this->render('maint', array('model'=>$model, 'action'=>'add', 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionUpdate() {
		$model = new MaintRoleForm('update');
		
		if ($_POST['action']) {
			// Update role
			$model->attributes = $_POST['MaintRoleForm'];
			if ($model->update()) {
				$msg = array('success'=>'Role ['.$model->role.'] is updated successfully!');
				$this->actionIndex($msg);
				return;
			}
			else {
				$errorMsg = 'Fail to update user!';
			}
		}
		else {
			// Retrieve role
			$role_code = $_GET['role_code'];
			$model->find($role_code);
		}
		
		$this->render('maint', array('model'=>$model, 'action'=>'update', 'msg'=>array('error'=>$errorMsg)));
	}
	
	public function actionDelete() {
		$model = new MaintRoleForm('delete');
		$model->attributes = $_POST['MaintRoleForm'];
		
		if ($model->delete()) {
			$successMsg = 'Role ['.$model->role_code.'] is deleted successfully.';
		}
		else {
			$errorMsg = 'Fail to delete role ['.$model->role.']';
		}
		
		$msg = array('success'=>$successMsg, 'error'=>$errorMsg);
		$this->actionIndex($msg);
	}
}
