<?
if ($action == 'add') {
	$usernameReadonly = false;
}
else {
	$usernameReadonly = true;
}
?>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<? if ($action == 'add') {?>
		<div class="page_header">User Creation</div>
	<? } else {?>
		<div class="page_header">User Update</div>
	<? } ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<div style="width:400px">
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('user_message', 'username'); ?></span><span class="input_field"><? echo $form->textField($model, 'username', array('readonly'=>$usernameReadonly)); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('user_message', 'password'); ?></span><span class="input_field"><? echo $form->passwordField($model, 'password'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('user_message', 'role'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'role_code', array_merge(array(''=>''), Role::getDropDownFromCache())); ?></span>
			</div>
			
			<div id="supplier_div" class="grid-c1" <? if ($model->role_code != GlobalConstants::ROLE_SUPPLIER) { ?>style="display:none" <? } ?>>
				<span class="input_label"><? echo Yii::t('user_message', 'supplier'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'supplier', $model->getSupplierDropdown()); ?></span>
			</div>
			
			<br style="clear:both" />
		</div>
		
		<? if ($action == 'add') {?>
			<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'add'); ?>" />
		<? } else {?>
			<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
		<? } ?>
		<input class="searchBtn" type="button" onclick="window.location='../user'" value="<? echo Yii::t('common_message', 'back'); ?>" />
		
	<? $this->endWidget(); ?>
</div>

<div style="height:600px"></div>

<script type="text/javascript">
	$(function() {
		$('#MaintUserForm_role_code').change(function() {
			if ($(this).val() == 'SU') {
				$('#supplier_div').show();
			}
			else {
				$('#supplier_div').hide();
			}
		});
	});
</script>
