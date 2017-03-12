<? 
$baseUrl = Yii::app()->request->baseUrl;
$imgDir = Yii::app()->params['cash_image_dir'];

$writePermission = GlobalFunction::checkPagePrivilege('cash_management', RolePageMatrix::PERMISSION_WRITE);

if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No customer found!
	</div>
<? } else {
	$this->widget('SimplaPager', array('pages'=>$pages)); ?>

		<table class="product-excel-style" style="width:760px">
			<tr>
				<th><? echo Yii::t('cash_message', 'pay_from'); ?></th>
				<th><? echo Yii::t('cash_message', 'pay_to'); ?></th>
				<th><? echo Yii::t('cash_message', 'account'); ?></th>
				<th><? echo Yii::t('cash_message', 'desc'); ?></th>
				<th><? echo Yii::t('cash_message', 'rmb'); ?></th>
				<th><? echo Yii::t('cash_message', 'hkd'); ?></th>
				<th><? echo Yii::t('cash_message', 'jpy'); ?></th>
				<th><? echo Yii::t('cash_message', 'remark'); ?></th>
				<th><? echo Yii::t('cash_message', 'image'); ?></th>
				<th><? echo Yii::t('cash_message', 'created_by'); ?></th>
				<th><? echo Yii::t('cash_message', 'created_date'); ?></th>

				<? if ($writePermission) { ?>
					<th></th>
				<? } ?>
			</tr>
		<? foreach($items as $item) { ?>
			<tr>
				<td><?=$item->pay_from ?></td>
				<td><?=$item->pay_to ?></td>
				<td><?=$item->account ?></td>
				<td><?=$item->desc ?></td>
				<td><?=$item->rmb ?></td>
				<td><?=$item->hkd ?></td>
				<td><?=$item->jpy ?></td>
				<td><?=$item->remark ?></td>
				<td>
					<?
					if ($item->image_name !== NULL) {
						echo CHtml::image($baseUrl.'/'.$imgDir.$item->image_name, '', array('width'=>'160', 'height'=>'130'));
					}
					?>
				</td>
				<td><?=$item->created_by ?></td>
				<td><?=$item->created_date ?></td>

				<? if ($writePermission) { ?>
					<td>
						<input type="button" onclick="javascript:goDelete(<?=$item->id ?>)" value="<? echo Yii::t('common_message', 'delete'); ?>" />
					</td>
				<? } ?>
			</tr>
		<? }?>
		</table>

<? } ?>

