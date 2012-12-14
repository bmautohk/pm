<?php
class GlobalFunction {
	
	public static function isAdmin() {
		return Yii::app()->user->getState('role') == GlobalConstants::ROLE_ADMIN;
	}
	
	public static function isSupplier() {
		return Yii::app()->user->getState('role') == GlobalConstants::ROLE_SUPPLIER;
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
		if (GlobalFunction::isAdmin()) {
			return true;
		}
		else if (isset($roleMatrix[$tableName]) && in_array($columnName, $roleMatrix[$tableName])) {
			return true;
		}
		else {
			return false;
		}
	}
}