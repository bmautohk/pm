<?php
class GlobalFunction {
	
	public static function isAdmin() {
		$role = Yii::app()->user->getState('role');
		return $role == GlobalConstants::ROLE_ADMIN || $role == GlobalConstants::ROLE_SUPERADMIN;
	}
	
	public static function isSupplier() {
		return Yii::app()->user->getState('role') == GlobalConstants::ROLE_SUPPLIER;
	}
	
	public static function isRetail() {
		return Yii::app()->user->getState('is_retail');
	}
	
	public static function isAllowInternal() {
		return Yii::app()->user->getState('is_allow_internal');
	}
	
	public static function getUserSupplier() {
		return Yii::app()->user->getState('supplier');
	}
	
	public static function getDisplayFormat() {
		$session=new CHttpSession;
		$session->open();
		
		$displayFormat = $session[GlobalConstants::SESSION_DISPLAY_FORMAT];
		return $displayFormat === NULL ? GlobalConstants::DISPLAY_FORMAT_GRID : $displayFormat;
	}
	
	public static function checkPrivilege($roleMatrix, $tableName, $columnName) {
		if (isset($roleMatrix[$tableName]) && in_array($columnName, $roleMatrix[$tableName])) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function checkPagePrivilege($page, $permission=NULL) {
		$rolePageMatrixes = Yii::app()->user->getState('role_page_matrix');
		
		if (!array_key_exists($page, $rolePageMatrixes)) {
			return false;
		} else if ($permission != NULL && $rolePageMatrixes[$page] != $permission) {
			return false;
		} else {
			return true;
		}
	}
}