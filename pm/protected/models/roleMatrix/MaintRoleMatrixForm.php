<?php
class MaintRoleMatrixForm extends CFormModel {
	
	public static $columns = array(
		'customer',
		'prod_sn',
		'status',
		'no_jp',
		'factory_no',
		'made',
		'model',
		'model_no',
		'year',
		'item_group',
		'material',
		'product_desc',
		'product_desc_ch',
		'product_desc_jp',
		'accessory_remark',
		'company_remark',
		'pcs',
		'colour',
		'colour_no',
		'supplier',
		'molding',
		'moq',
		'cost',
		'kaito',
		'other',
		'purchase_cost',
		'business_price',
		'auction_price',
		'kaito_price',
		'buy_date',
		'receive_date',
		'factory_date',
		'pack_remark',
		'order_date',
		'progress',
		'receive_model_date',
		'person_in_charge',
		'state',
		'ship_date',
		'market_research_price',
		'yahoo_produce',
		'produce_status',
		'shop',
		'is_monopoly',
		'is_retail',
		'is_internal',
		'is_exhibit',
		'is_ship',
		'output_volume',
		'category_id',
		'packing_size_w',
		'packing_size_h',
		'packing_size_d',
		'gross_weight',
		'safe_stock',
	);
	
	public static $pages = array(
			'product_management',
			'product_management_add_product', // 新加一筆產品資料
			'customer_management',
			'supplier_management',
			'category_management',
			'order_management',
			'cash_management',
			'user_management',
			'role_management',
			'role_matrix',
			'product_change_log',
			'email_management',
			'export_excel',
			'mobile',
	);
	public $name = 'aaa';
	public $action;
	public $roles;
	public $column_permissions;
	public $page_permissions;
	
	public function initColumnMatrixAction() {
		$this->action = 'column';
		
		// Retrieve roles
		$this->roles = Role::model()->findAll();
		
		// Retrieve column permission
		$roleColumnMatrixes = RoleColumnMatrix::model()->findAll();
		foreach ($roleColumnMatrixes as $roleColumnMatrix) {
			$this->column_permissions[$roleColumnMatrix->role_code][$roleColumnMatrix->column_name] = 1;
		}
	}
	
	public function initPageMatrixAction() {
		$this->action = 'page';
		
		// Retrieve roles
		$this->roles = Role::model()->findAll();
		
		// Retrieve page permission
		$rolePageMatrixes = RolePageMatrix::model()->findAll();
		foreach ($rolePageMatrixes as $rolePageMatrix) {
			$this->page_permissions[$rolePageMatrix->role_code][$rolePageMatrix->page] = $rolePageMatrix->permission;
		}
	}
	
	public function saveColumnMatrixAction($post) {
		$column_permissions = $post['column_permissions'];

		// Add new role column matrix record
		$roleColumnMatrixes = array();
		foreach ($column_permissions as $role_code=>$columns) {
			foreach($columns as $column=>$value) {
				$roleColumnMatrix = new RoleColumnMatrix();
				$roleColumnMatrix->role_code = $role_code;
				$roleColumnMatrix->table_name = 'product_master';
				$roleColumnMatrix->column_name = $column;
				$roleColumnMatrixes[] = $roleColumnMatrix;
			}
		}

		// Truncate role column matrix
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('role_column_matrix');

		foreach ($roleColumnMatrixes as $roleColumnMatrix) {
			$roleColumnMatrix->save();
		}
	}
	
	public function savePageMatrixAction($post) {
		$page_permissions = $post['page_permissions'];
		
		// Add new role column matrix record
		$rolePageMatrixes = array();
		foreach ($page_permissions as $role_code=>$pages) {
			foreach($pages as $page=>$permission) {
				$rolePageMatrix = new RolePageMatrix();
				$rolePageMatrix->role_code = $role_code;
				$rolePageMatrix->page = $page;
				$rolePageMatrix->permission = $permission;
				$rolePageMatrixes[] = $rolePageMatrix;
			}
		}

		// Truncate role column matrix
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('role_page_matrix');

		foreach ($rolePageMatrixes as $rolePageMatrix) {
			$rolePageMatrix->save();
		}
	}
}