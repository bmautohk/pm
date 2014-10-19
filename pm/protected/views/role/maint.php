<?
$writePermission = GlobalFunction::checkPagePrivilege('role_management', RolePageMatrix::PERMISSION_WRITE);

if ($action == 'add') {
	$roleCodeReadonly = false;
}
else {
	$roleCodeReadonly = true;
}
?>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<? if ($action == 'add') {?>
		<div class="page_header">Role Creation</div>
	<? } else {?>
		<div class="page_header">Role Update</div>
	<? } ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<div style="width:400px">
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('role_message', 'role_code'); ?></span><span class="input_field"><? echo $form->textField($model, 'role_code', array('readonly'=>$roleCodeReadonly)); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('role_message', 'role'); ?></span><span class="input_field"><? echo $form->textField($model, 'role'); ?></span>
			</div>
			
			<br style="clear:both" />
		</div>
		
		<? if ($writePermission) {
			if ($action == 'add') { ?>
				<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'add'); ?>" />
			<? } else {?>
				<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
			<? }
		} ?>
		<input class="searchBtn" type="button" onclick="window.location='../role'" value="<? echo Yii::t('common_message', 'back'); ?>" />
		
	<? $this->endWidget(); ?>
</div>

<div style="height:600px"></div>
