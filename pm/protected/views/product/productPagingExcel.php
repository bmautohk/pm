<? if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No product found!
	</div>
<? } else {
$tableName = 'product_master';
$roleMatrix = Yii::app()->user->getState('role_matrix');

function fieldChecking($model,  $roleMatrix, $tableName, $columnName) {
        if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
        echo $model->$columnName; 
        }else{
        echo '';
        }
}

	$baseUrl = Yii::app()->request->baseUrl;
?>
	<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>

		<table class="product-excel-style" width="width: 1000px;">
			<tr>
				<th>&nbsp;</th>
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
				<td><input type="button" value="<? echo Yii::t('common_message', 'product_detail'); ?>" onclick="javascript:goUpdate(<?=$product->id ?>)"/></td>
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
			</tr>
		<? }?>
		</table>

<? } ?>
