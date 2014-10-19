<? if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No log found!
	</div>
<? } else {
	$this->widget('SimplaPager', array('pages'=>$pages)); ?>

		<table class="product-excel-style" style="width:760px">
			<tr>
				<th>Modify Date</th>
				<th><? echo Yii::t('product_message', 'prod_sn'); ?></th>
				<th>Column Name</th>
				<th>Old Value</th>
				<th>New Value</th>
				<th>Changed By</th>
			</tr>
		<? foreach($items as $log) { ?>
			<tr>
				<td><?=$log->create_date ?></td>
				<td><?=$log->prod_sn ?></td>
				<td><? echo Yii::t('product_message', $log->column_name); ?></td>
				<td><?=$log->old_value ?></td>
				<td><?=$log->new_value ?></td>
				<td><?=$log->create_by ?></td>
			</tr>
		<? }?>
		</table>

<? } ?>
