<? if (!isset($items)) {?>
	
<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No product found!
	</div>
<? } else {?>
	<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>
	<div class="scroll" id="prod_page">
		<table cellspacing="0" cellpadding="0" border="0">
			<? foreach($items as $product) {?>
			<tr>
				<td valign='top' width='15%' height='184' class='newitem'><a class='productdetail' href="update?id=<?=$product->id ?>"><img src='../images/product/no_image.png'></a></td>
				<td width='2%'></td>
				<td valign='top' width='15%' height='184' class='newitem'>
					<? echo Yii::t('product_message', 'prod_sn'); ?>: <a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><?=$product->prod_sn ?></a><br><br>
					<? echo Yii::t('product_message', 'no_jp'); ?>: <?=$product->no_jp ?><br><br>
					<? echo Yii::t('product_message', 'made'); ?>: <?=$product->made ?><br><br>
					<? echo Yii::t('product_message', 'model'); ?>: <?=$product->model ?>
				</td>
			</tr>
			<? }?>
		</table>
	</div>
<? } ?>