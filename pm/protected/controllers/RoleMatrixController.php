<?php
Yii::import('application.models.roleMatrix.*');

class RoleMatrixController extends Controller {
	
	public function actionIndex($msg=NULL) {
		$model = new MaintRoleMatrixForm();
		$model->hasRight = array();
		
		$roles = Role::model()->findAll("role_code <> 'AD' ");
		foreach ($roles as $role) {
			$model->hasRight[$role->role_code] = array();
		}
		
		$roleMatrixes = RoleMatrix::model()->findAll();
		foreach ($roleMatrixes as $roleMatrix) {
			$model->hasRight[$roleMatrix->role_code][$roleMatrix->column_name] = 'Y';
		}
		
		$this->render('maint', array('model'=>$model, 'roles'=>$roles, 'msg'=>$msg));
	}
	
	public function actionUpdate() {
		$msg = array();
		
		if (isset($_POST['action'])) {
			$hasRights = $_POST['hasRight'];
			
			// Truncate role matrix
			$command = Yii::app()->db->createCommand();
			$command->truncateTable('role_matrix');
			
			foreach ($hasRights as $role_code=>$columns) {
				foreach($columns as $column=>$value) {
					$roleMatrix = new RoleMatrix();
					$roleMatrix->role_code = $role_code;
					$roleMatrix->table_name = 'product_master';
					$roleMatrix->column_name = $column;
					$roleMatrix->save();
				}
			}
			
			$msg = array('success'=>'The role matrix is updated successfully!');
		}
		$this->actionIndex($msg);
	}
}