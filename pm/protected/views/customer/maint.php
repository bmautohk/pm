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
					<span class="input_label"><? echo Yii::t('customer_message', 'cust_cd'); ?></span><span class="input_field"><? echo $form->textField($model, 'cust_cd', array('readonly'=>true)); ?></span>
				</div>
			<? }?>
		
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'name'); ?></span><span class="input_field"><? echo $form->textField($model, 'name'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'tel'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'fax'); ?></span><span class="input_field"><? echo $form->textField($model, 'fax'); ?></span>
			</div>
			
			<div class="grid_u-c1-textarea" style="width:500px">
				<span class="input_label"><? echo Yii::t('customer_message', 'address'); ?></span><span class="input_field"><? echo $form->textarea($model, 'address', array('style'=>'width:250px')); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'contact_person'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_person'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('customer_message', 'email'); ?></span><span class="input_field"><? echo $form->textField($model, 'email'); ?></span>
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
</script>