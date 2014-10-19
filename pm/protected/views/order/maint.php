<?
$order = $model->order;
$orderDetails = $model->orderDetails; 
?>

<style>
.grid-c1 select {
	width: 150px;
}
</style>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	<br>

	<div class="page_header">Order Detail</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<div style="width:400px">
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('order_message', 'order_id'); ?></span><span class="input_field"><? echo $form->textField($order, 'id', array('readonly'=>true)); ?></span>
			</div>
		
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('order_message', 'customer_name'); ?></span><span class="input_field"><? echo $form->textField($order->customer, 'name', array('readonly'=>true)); ?></span>
			</div>
			
			<br style="clear:both" />
		</div>
		
		<table class="product-excel-style" width="width: 1000px;">
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
				<th><? echo Yii::t('product_message', 'accessory_remark'); ?></th>
				<th><? echo Yii::t('product_message', 'company_remark'); ?></th>
				<th><? echo Yii::t('product_message', 'pcs'); ?></th>
				<th><? echo Yii::t('product_message', 'colour'); ?></th>
			</tr>
		<? foreach($orderDetails as $orderDetail) {
			$productMaster = $orderDetail->productMaster;
		?>
			<tr>
				<td><?=$orderDetail->prod_sn ?></td>
				<td><?=$productMaster->customer ?></td>
				<td><?=$productMaster->status ?></td>
				<td><?=$productMaster->no_jp ?></td>
				<td><?=$productMaster->factory_no ?></td>
				<td><?=$productMaster->model ?></td>
				<td><?=$productMaster->model_no ?></td>
				<td><?=$productMaster->year ?></td>
				<td><?=$productMaster->material ?></td>
				<td><?=$productMaster->product_desc ?></td>
				<td><?=$productMaster->accessory_remark ?></td>
				<td><?=$productMaster->company_remark ?></td>
				<td><?=$productMaster->pcs ?></td>
				<td><?=$productMaster->colour ?></td>
			</tr>
		<? }?>
		</table>
		
		<input class="searchBtn" type="button" onclick="back()" value="<? echo Yii::t('common_message', 'back'); ?>" />
		
	<? $this->endWidget(); ?>
</div>

<div style="height:600px"></div>

<script type="text/javascript">
function back() {
	$('#form1').attr('action', 'back');
	$('#form1').submit();
}
</script>