<? 
$writePermission = GlobalFunction::checkPagePrivilege('supplier_management', RolePageMatrix::PERMISSION_WRITE);

if (!isset($items)) {?>

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
				<th><? echo Yii::t('supplier_message', 'name'); ?></th>
				<th><? echo Yii::t('supplier_message', 'supplier_id'); ?></th>
				<th><? echo Yii::t('supplier_message', 'tel'); ?></th>
				<th><? echo Yii::t('supplier_message', 'contact_person'); ?></th>
				<th><? echo Yii::t('supplier_message', 'mobile'); ?></th>
				<th><? echo Yii::t('supplier_message', 'other_contact'); ?></th>
				<th><? echo Yii::t('supplier_message', 'qq'); ?></th>
				<th><? echo Yii::t('supplier_message', 'notice'); ?></th>
				<th><? echo Yii::t('supplier_message', 'email'); ?></th>
			</tr>
		<? foreach($items as $supplier) { ?>
			<tr>
				<td><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" onclick="javascript:goUpdate('<?=$supplier->id ?>')" /></td>
				<? if ($writePermission) { ?><td><input type="button" value="<? echo Yii::t('common_message', 'delete'); ?>" onclick="javascript:goDelete('<?=$supplier->id ?>')" /></td><? } ?>
				<td><?=$supplier->name ?></td>
				<td><?=$supplier->id ?></td>
				<td><?=$supplier->tel ?></td>
				<td><?=$supplier->contact_person ?></td>
				<td><?=$supplier->mobile ?></td>
				<td><?=$supplier->other_contact ?></td>
				<td><?=$supplier->qq ?></td>
				<td><?=$supplier->notice ?></td>
				<td><?=$supplier->email ?></td>
			</tr>
		<? }?>
		</table>

<? } ?>

