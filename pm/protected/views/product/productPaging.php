<? if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No product found!
	</div>
<? } else {
	$baseUrl = Yii::app()->request->baseUrl;
	$imgDir = Yii::app()->params['image_dir'];
?>
	<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>
	<div class="scroll" id="prod_page">
		<?
		$i = 0; 
		foreach($items as $product) {?>
			<div class="grid_p">
				<div class="grid_p-c1" style="border:1px solid #949599;">
					<? $images = glob($imgDir.$product->no_jp."_*.jpg"); 
					if (!empty($images)) {?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/'.$images[0], '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? } else {?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/images/product/no_image.png', '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? }?>
				</div>
				<div class="grid_p-c1">
					<div class="product_name">
						<?=$product->no_jp ?>
					</div>
					<span class="input_label"><? echo Yii::t('product_message', 'made'); ?></span><span class="input_field"><? echo $form->textField($product,'made'); ?></span>
					<span class="input_label"><? echo Yii::t('product_message', 'model'); ?></span><span class="input_field"><? echo $form->textField($product,'model'); ?></span>
					<span class="input_label"><? echo Yii::t('product_message', 'pcs'); ?></span><span class="input_field"><? echo $form->textField($product,'pcs'); ?></span>
				</div>
				<div style="float: left; margin-top: 5px;">
					<span class="input_label"><? echo Yii::t('product_message', 'product_desc'); ?></span><span class="input_field"><? echo $form->textField($product,'product_desc'); ?></span>				
					<span class="input_label"><? echo Yii::t('product_message', 'remark'); ?></span><span class="input_field"><? echo $form->textField($product,'remark'); ?></span>
					
					<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" /></a>
				</div>
			</div>
			
			<? if ($i % 2 == 0) {?>
				<div class="grid_p-m1"></div>
			<? 
					$i++;
				}
			else {
				$i = 0;
			}
			?>
		<? }?>
	</div>
<? } ?>