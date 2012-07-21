<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form1',
	'action'=>'import',
	'method'=>'POST',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	<strong>Upload Product</strong><br>
	File Name: <? echo $form->fileField($model, 'uplFile'); ?>
	<? echo $form->error($model, 'uplFile');?>
	<input type="submit" name="action" value="Upload" /><br><br>
<? $this->endWidget(); ?>
