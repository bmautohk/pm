<? if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No order found!
	</div>
<? } else {
	$this->widget('SimplaPager', array('pages'=>$pages)); ?>

		<table class="product-excel-style" style="width:760px">
			<tr>
				<th style="width:50px">&nbsp;</th>
				<th><? echo Yii::t('order_message', 'order_id'); ?></th>
				<th><? echo Yii::t('order_message', 'customer_name'); ?></th>
				<th><? echo Yii::t('order_message', 'create_by'); ?></th>
				<th><? echo Yii::t('order_message', 'create_date'); ?></th>
			</tr>
		<? foreach($items as $order) { ?>
			<tr>
				<td><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" onclick="javascript:goUpdate('<?=$order->id ?>')" /></td>
				<td><?=$order->id ?></td>
				<td><?=$order->customer->name ?></td>
				<td><?=$order->create_by ?></td>
				<td><?=$order->create_date ?></td>
			</tr>
		<? }?>
		</table>

<? } ?>
