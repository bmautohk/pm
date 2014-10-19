<? $writePermission = GlobalFunction::checkPagePrivilege('supplier_management', RolePageMatrix::PERMISSION_WRITE); ?>
<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<? if ($action == 'add') {?>
		<div class="page_header">Supplier Creation</div>
	<? } else {?>
		<div class="page_header">Supplier Update</div>
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
					<span class="input_label"><? echo Yii::t('supplier_message', 'supplier_id'); ?></span><span class="input_field"><? echo $form->textField($model, 'id', array('readonly'=>true)); ?></span>
				</div>
			<? }?>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'supplier_cd'); ?></span><span class="input_field"><? echo $form->textField($model, 'supplier_cd'); ?></span>
			</div>
		
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'name'); ?></span><span class="input_field"><? echo $form->textField($model, 'name'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'tel'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'contact_person'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_person'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'mobile'); ?></span><span class="input_field"><? echo $form->textField($model, 'mobile'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'other_contact'); ?></span><span class="input_field"><? echo $form->textField($model, 'other_contact'); ?></span>
			</div>

			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'qq'); ?></span><span class="input_field"><? echo $form->textField($model, 'qq'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'notice'); ?></span><span class="input_field"><? echo $form->textField($model, 'notice'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'bank'); ?></span><span class="input_field"><? echo $form->textField($model, 'bank'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'open_account'); ?></span><span class="input_field"><? echo $form->textField($model, 'open_account'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'account_owner'); ?></span><span class="input_field"><? echo $form->textField($model, 'account_owner'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'account_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'account_no'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'term_of_payment'); ?></span><span class="input_field"><? echo $form->textField($model, 'term_of_payment'); ?></span>
			</div>
			
			<div class="grid_u-c1-textarea" style="width:500px">
				<span class="input_label"><? echo Yii::t('supplier_message', 'address'); ?></span><span class="input_field"><? echo $form->textarea($model, 'address', array('style'=>'width:250px')); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'email'); ?></span><span class="input_field"><? echo $form->textField($model, 'email'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('supplier_message', 'remark'); ?></span><span class="input_field"><? echo $form->textField($model, 'remark'); ?></span>
			</div>
			
			<br style="clear:both" />
		</div>
		
		<? if ($writePermission) {
			if ($action == 'add') {?>
				<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'add'); ?>" />
			<? } else {?>
				<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
		<? }
		} ?>
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