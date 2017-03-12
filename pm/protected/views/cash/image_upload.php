
<div class="rightmain_content">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>'../api/image',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>
		<div class="page_header">Cash Image Upload</div>

		<div style="width:400px">
			<div class="grid-c1">
				<span class="input_label">Cash ID</span>
				<span class="input_field"><input type="text" name="id" /></span>
			</div>
			
			<div>
				<span class="input_label">File</span>
				<input type="file" name="image_file" />
			</div>

			<br style="clear:both" />
		</div>
		
		<input class="searchBtn" type="submit" name="action" value="Upload" />

	<? $this->endWidget(); ?>
</div>
