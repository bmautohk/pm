<?
if ($model->where_to_find == GlobalConstants::WHERE_TO_FIND_CUSTOMER_TARGET_CUSTOMER) {
	$where_to_find_disabled = true;
} else {
	$where_to_find_disabled = false;
}
?>

<style>
.grid-c1 select {
	width: 150px;
}
</style>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<? if ($action == 'add') {?>
		<div class="page_header">Customer Creation</div>
	<? } else {?>
		<div class="page_header">Customer Update</div>
	<? } ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<? echo $form->hiddenField($model, 'id'); ?>
	
		<div style="width:400px">
			<? if ($action != 'add') {?>
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('customer_message', 'id'); ?></span><span class="input_field"><? echo $form->textField($model, 'id', array('readonly'=>true)); ?></span>
				</div>
			<? }?>
		
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'name'); ?></span><span class="input_field"><? echo $form->textField($model, 'name'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'cust_group'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'cust_group', CustGroup::getDropDownFromCache()); ?></span>
			</div>
			
			<div class="grid-c1" style="height:auto">
				<span class="input_label"><? echo Yii::t('customer_message', 'cust_type'); ?></span><span class="input_field"><? echo $form->checkBoxList($model, 'cust_types', CustType::getDropDownFromCache(), array('style'=>'width:40px')); ?></span>
			</div>
			
			<div class="grid-c1" style="height:60px">
				<span class="input_label" style="height:46px"><? echo Yii::t('customer_message', 'where_to_find'); ?></span>
				<span class="input_field"><? echo $form->dropDownList($model, 'where_to_find', CustWhereToFind::getDropDownFromCache(), array('onchange'=>'whereToFindChange(this)')); 
				echo $form->textField($model, 'where_to_find_detail', array('disabled'=>$where_to_find_disabled)); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'tel'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'tel2'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel2'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'fax'); ?></span><span class="input_field"><? echo $form->textField($model, 'fax'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'mobile_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'mobile_no'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'mobile_no2'); ?></span><span class="input_field"><? echo $form->textField($model, 'mobile_no2'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'other_contact'); ?></span><span class="input_field"><? echo $form->textField($model, 'other_contact'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'contact_person'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_person'); ?></span>
			</div>
			
			<div class="grid_u-c1-textarea" style="width:500px">
				<span class="input_label"><? echo Yii::t('customer_message', 'address'); ?></span><span class="input_field"><? echo $form->textarea($model, 'address', array('style'=>'width:250px')); ?></span>
			</div>
			
			<div class="grid_u-c1-textarea" style="width:500px">
				<span class="input_label"><? echo Yii::t('customer_message', 'address2'); ?></span><span class="input_field"><? echo $form->textarea($model, 'address2', array('style'=>'width:250px')); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'email'); ?></span><span class="input_field"><? echo $form->textField($model, 'email'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'website'); ?></span><span class="input_field"><? echo $form->textField($model, 'website'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'vip'); ?></span><span class="input_field"><? echo $form->checkBox($model, 'vip', array('style'=>'width:40px')); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label" style="width:130px"><? echo Yii::t('customer_message', 'contact_salesman'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_salesman', array('style'=>'width:239px')); ?></span>
			</div>
			
			<div class="grid_u-c1-textarea" style="width:500px">
				<span class="input_label"><? echo Yii::t('customer_message', 'remark'); ?></span><span class="input_field"><? echo $form->textarea($model, 'remark', array('style'=>'width:250px')); ?></span>
			</div>
			
			<div class="grid_u-c1-textarea" style="width:500px">
				<span class="input_label"><? echo Yii::t('customer_message', 'salesman_remark'); ?></span><span class="input_field"><? echo $form->textarea($model, 'salesman_remark', array('style'=>'width:250px')); ?></span>
			</div>
			
			<br style="clear:both" />
		</div>
		
		<? if ($action == 'add') {?>
			<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'add'); ?>" />
		<? } else {?>
			<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
		<? } ?>
		<input class="searchBtn" type="button" onclick="back()" value="<? echo Yii::t('common_message', 'back'); ?>" />
		
	<? $this->endWidget(); ?>
</div>

<div style="height:600px"></div>

<script type="text/javascript">
function back() {
	$('#form1').attr('action', 'back');
	$('#form1').submit();
}

function whereToFindChange(elem) {
	if ($(':checked', elem).val() == <?=GlobalConstants::WHERE_TO_FIND_CUSTOMER_TARGET_CUSTOMER ?>) {
		$('#MaintCustomerForm_where_to_find_detail').attr('disabled', true);
	}
	else {
		$('#MaintCustomerForm_where_to_find_detail').attr('disabled', false);
	}
}
</script>