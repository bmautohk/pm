<?
$hasPermission = GlobalFunction::checkPagePrivilege('email_management');

$hasPrivilege = array();

$GLOBALS['hasPrivilege'] = array();
$GLOBALS['tableName'] = 'product_master';
$GLOBALS['roleMatrix'] = Yii::app()->user->getState('role_matrix');

function fieldChecking($model, $columnName) {
	global $hasPrivilege, $roleMatrix, $tableName;
	
	if (isset($hasPrivilege[$columnName])) {
		if ($hasPrivilege[$columnName]) {
			echo $model->$columnName;
		} else {
			echo '';
		}
	} else {
		
		if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
			$hasPrivilege[$columnName] = true;
			echo $model->$columnName;
		} else {
			$hasPrivilege[$columnName] = false;
			echo '';
		}
	}
}

?>

<div id="rightmain"> 
	<div class="rightmain_content">
		<br>
 		<div class="page_header">Checkout Cart</div>
 		
 		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
 		
 		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'form1',
			'action'=>'exportCart'
			)); ?>
			<? echo $form->hiddenField($model, 'action'); ?>
			
			<input type="button" onclick="javascript:generateOrder()" value="<? echo Yii::t('common_message', 'generate_order'); ?>" />
			<? if ($hasPermission) { ?>
				<input type="button" onclick="javascript:exportExcel()" value="<? echo Yii::t('common_message', 'export_excel'); ?>" />
			<? } ?>
			<input type="button" onclick="javascript:clearCart()" value="<? echo Yii::t('common_message', 'clear_cart'); ?>" />
			
			<br />
			
			<div class="grid_u-c1">
				<span class="input_label"><?=Yii::t('product_message', 'customer') ?></span><? echo $form->dropDownList($model, 'customer_id', Customer::getDropdown()); ?>
			</div>
		<? $this->endWidget(); ?>
		
		<table id="tbl_cart_product" class="product-excel-style" width="width: 1000px;">
			<tr>
				<th width="30"><? echo Yii::t('product_message', 'prod_sn'); ?></th>
				<th><? echo Yii::t('product_message', 'customer'); ?></th>
				<th><? echo Yii::t('product_message', 'status'); ?></th>
				<th><? echo Yii::t('product_message', 'no_jp'); ?></th>
				<th><? echo Yii::t('product_message', 'factory_no'); ?></th>
				<th><? echo Yii::t('product_message', 'model'); ?></th>
				<th><? echo Yii::t('product_message', 'model_no'); ?></th>
				<th><? echo Yii::t('product_message', 'year'); ?></th>
				<th><? echo Yii::t('product_message', 'material'); ?></th>
				<th><? echo Yii::t('product_message', 'product_desc'); ?></th>
				<th width="100"><? echo Yii::t('product_message', 'accessory_remark'); ?></th>
				<th width="100"><? echo Yii::t('product_message', 'company_remark'); ?></th>
				<th><? echo Yii::t('product_message', 'pcs'); ?></th>
				<th><? echo Yii::t('product_message', 'colour'); ?></th>
			</tr>
		<? foreach($items as $product) { ?>
			<tr>
				<td><? fieldChecking($product, 'prod_sn');?></td>
				<td><? fieldChecking($product, 'customer');?></td>
				<td><? fieldChecking($product, 'status');?></td>
				<td><? fieldChecking($product, 'no_jp');?></td>
				<td><? fieldChecking($product, 'factory_no');?></td>
				<td><? fieldChecking($product, 'model');?></td>
				<td><? fieldChecking($product, 'model_no');?></td>
				<td><? fieldChecking($product, 'year');?></td>
				<td><? fieldChecking($product, 'material');?></td>
				<td><? fieldChecking($product, 'product_desc');?></td>
				<td><? fieldChecking($product, 'accessory_remark');?></td>
				<td><? fieldChecking($product, 'company_remark');?></td>
				<td><? fieldChecking($product, 'pcs');?></td>
				<td><? fieldChecking($product, 'colour');?></td>
			</tr>
		<? }?>
		</table>
	</div>
</div>

<script type="text/javascript">
 	function generateOrder() {
 	 	$('#CartForm_action').val('generate');
 	 	$('#form1').submit();
 	}

 	function exportExcel() {
 		$('#CartForm_action').val('export');
 	 	$('#form1').submit();
 	}

 	function clearCart() {
 		$('#CartForm_action').val('clear');
 	 	$('#form1').submit();
 	}
</script>