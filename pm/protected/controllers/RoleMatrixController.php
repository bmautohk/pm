<?php
Yii::import('application.models.roleMatrix.*');

class RoleMatrixController extends Controller {
	
	public function filters() {
		return array(
				'accessControl'
		);
	}
	
	public function filterAccessControl($filterChain) {
		$this->checkPrivilege('role_matrix');
		$filterChain->run();
	}
	
	public function actionIndex($msg=NULL) {
		$model = new MaintRoleMatrixForm();
		$model->initColumnMatrixAction();
		
		$this->render('role_column_matrix', array('model'=>$model, 'msg'=>$msg));
	}
	
	public function actionChangeView() {
		$model = new MaintRoleMatrixForm();
		$model->action = $_REQUEST['MaintRoleMatrixForm']['action'];

		if  ($model->action == 'column') {
			$model->initColumnMatrixAction();
			$this->render('role_column_matrix', array('model'=>$model, 'msg'=>$msg));
		} else {
			$model->initPageMatrixAction();
			$this->render('role_page_matrix', array('model'=>$model, 'msg'=>$msg));
		}
	}
	
	public function actionUpdateColumnMatrix() {
		$this->checkPrivilege('role_matrix', RolePageMatrix::PERMISSION_WRITE);
		
		$model = new MaintRoleMatrixForm();
		$msg = array();
		
		if (isset($_POST['action'])) {
			$form = new MaintRoleMatrixForm();
			$form->saveColumnMatrixAction($_POST);
			$msg = array('success'=>'The role column matrix is updated successfully!');
		}
		
		$model->initColumnMatrixAction();
		$this->render('role_column_matrix', array('model'=>$model, 'msg'=>$msg));
	}
	
	public function actionUpdatePageMatrix() {
		$this->checkPrivilege('role_matrix', RolePageMatrix::PERMISSION_WRITE);
		
		$model = new MaintRoleMatrixForm();
		$msg = array();
		
		if (isset($_POST['action'])) {
			$form = new MaintRoleMatrixForm();
			$form->savePageMatrixAction($_POST);
			$msg = array('success'=>'The role page matrix is updated successfully!');
		}
		
		$model->initPageMatrixAction();
		$this->render('role_page_matrix', array('model'=>$model, 'msg'=>$msg));
	}
}