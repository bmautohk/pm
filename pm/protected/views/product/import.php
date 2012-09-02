 <div id="rightmain"> 
 	<div class="rightmain_content">
 		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
 		<br>
 		<div class="page_header">Upload Product</div>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'form1',
			'action'=>'import',
			'method'=>'POST',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		)); ?>
			<span class="input_label"><span>File Name:</span></span><? echo $form->fileField($model, 'uplFile'); ?>
			<? echo $form->error($model, 'uplFile');?>
			<input type="submit" name="action" value="<? echo Yii::t('common_message', 'import'); ?>" /><br><br>
		<? $this->endWidget(); ?>
	</div>
</div>