<? foreach ($images as $image) {?>
	<div style="float: left; margin-right: 10px;">
		<? echo CHtml::image('../'.$image, '', array('width'=>'160', 'height'=>'130')) ?>
	</div>
<? } ?>