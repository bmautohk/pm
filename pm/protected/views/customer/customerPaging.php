<? 
$writePermission = GlobalFunction::checkPagePrivilege('customer_management', RolePageMatrix::PERMISSION_WRITE);
if (!isset($items)) {
?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No customer found!
	</div>
<? } else {
	$this->widget('SimplaPager', array('pages'=>$pages)); ?>

		<table class="product-excel-style" style="width:760px">
			<tr>
				<th style="width:50px">&nbsp;</th>
				<? if ($writePermission) { ?><th style="width:50px">&nbsp;</th><? } ?>
				<th><? echo Yii::t('customer_message', 'name'); ?></th>
				<th><? echo Yii::t('customer_message', 'id'); ?></th>
				<th><? echo Yii::t('customer_message', 'tel'); ?></th>
				<th><? echo Yii::t('customer_message', 'address'); ?></th>
				<th><? echo Yii::t('customer_message', 'email'); ?></th>
			</tr>
		<? foreach($items as $customer) { ?>
			<tr>
				<td><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" onclick="javascript:goUpdate('<?=$customer->id ?>')" /></td>
				<? if ($writePermission) { ?><td><input type="button" value="<? echo Yii::t('common_message', 'delete'); ?>" onclick="javascript:goDelete('<?=$customer->id ?>')" /></td><? } ?>
				<td><?=$customer->name ?></td>
				<td><?=$customer->id ?></td>
				<td><?=$customer->tel ?></td>
				<td><?=$customer->address ?></td>
				<td><?=$customer->email ?></td>
			</tr>
		<? }?>
		</table>

<? } ?>
