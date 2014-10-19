<? if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No product found!
	</div>
<? } else {
$tableName = 'product_master';
$roleMatrix = Yii::app()->user->getState('role_matrix');

$GLOBALS['hasPrivilege'] = array();

function fieldChecking($model, $roleMatrix, $tableName, $columnName) {
	global $hasPrivilege;
	
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
function fieldLabelChecking( $roleMatrix, $tableName, $columnName) {
	global $hasPrivilege;
	
	if (isset($hasPrivilege[$columnName])) {
		if ($hasPrivilege[$columnName]) {
			echo Yii::t('product_message', $columnName);
		 }
	} else {
		if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
			$hasPrivilege[$columnName] = true;
			echo Yii::t('product_message', $columnName);
		} 
	}
}
	$baseUrl = Yii::app()->request->baseUrl;
	$imgDir = Yii::app()->params['image_dir'];
	$internalImgDir = Yii::app()->params['internal_image_dir'];
?>
	<input type="button" onclick="javascript:add_to_cart()" value="<? echo Yii::t('common_message', 'add_to_cart'); ?>" />
	<input type="button" onclick="javascript:checkout_cart()" value="<? echo Yii::t('common_message', 'checkout_cart'); ?>" />
	
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'pagingForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
	<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>
	
		<table class="product-excel-style" width="width: 1000px;">
			<tr>
				<th></th>
				<th>&nbsp;</th>
				<th width="30"><? fieldLabelChecking($roleMatrix,$tableName,'prod_sn');?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'customer'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'status'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'no_jp'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'factory_no'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'model'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'model_no'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'year'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'material'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'product_desc'); ?></th>
				<th width="100"><? fieldLabelChecking($roleMatrix,$tableName,'accessory_remark'); ?></th>
				<th width="100"><? fieldLabelChecking($roleMatrix,$tableName,'company_remark'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'pcs'); ?></th>
				<th><? fieldLabelChecking($roleMatrix,$tableName,'colour'); ?></th>
				<? if (GlobalFunction::isAdmin()) { ?><th></th><? } ?>
			</tr>
		<? foreach($items as $product) { ?>
			<tr>
				<td><input type="checkbox" name="add_to_cart[]" value="<?=$product->prod_sn ?>" /></td>
				<td>
					<? $images = glob($imgDir.$product->prod_sn."_*.jpg"); 
					if (!empty($images)) {?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/'.$images[0], '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? } else {
						$images = glob($internalImgDir.$product->prod_sn."_i_*.jpg");
						if (!empty($images)) {
					?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/'.$images[0], '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? } else {?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/images/product/no_image.png', '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? }
					} ?>
				</td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'prod_sn');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'customer');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'status');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'no_jp');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'factory_no');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'model');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'model_no');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'year');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'material');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'product_desc');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'accessory_remark');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'company_remark');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'pcs');?></td>
				<td><? fieldChecking($product,$roleMatrix,$tableName,'colour');?></td>
				<? if (GlobalFunction::isAdmin()) { ?>	
					<td><input type="button" onclick="javascript:goDelete(<?=$product->id ?>, <?=$product->prod_sn ?>)" value="<? echo Yii::t('common_message', 'delete_product'); ?>" /></td>
				<? } ?>
			</tr>
		<? }?>
		</table>

		<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>
		
		<? $this->endWidget(); ?>
<? } ?>

<script type="text/javascript">
	function add_to_cart() {
		$.ajax({
			type: 'POST',
			url: '<? echo Yii::app()->request->baseUrl; ?>/product/addToCart',
			data: $('#pagingForm').serialize()
		})
		.done(function(data) {
			$('input:checkbox[name="add_to_cart[]"]').prop('checked', false);
			alert(data);
		});
	}

	function checkout_cart() {
		window.location.href = '<? echo Yii::app()->request->baseUrl; ?>/product/showCartProduct';
	}
</script>