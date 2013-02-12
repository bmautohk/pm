<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>Yii::app()->request->baseUrl.'/roleMatrix/update',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		
		<table class="product-excel-style" width="width: 1000px;">
			<tr>
				<th>&nbsp;</th>
				<? foreach ($roles as $role) {?>
					<th><?=$role->role ?></th>
				<? }?>
			</tr>
			<? foreach (MaintRoleMatrixForm::$columns as $column) {?>
				<tr>
					<td><?=Yii::t('product_message', $column) ?></td>
					<? foreach ($roles as $role) {?>
						<td><?=CHtml::checkBox("hasRight[".$role->role_code."][".$column."]", isset($model->hasRight[$role->role_code][$column])) ?></td>
					<? }?>
				</tr>
			<? }?>
		</table>
		
		<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
	<? $this->endWidget(); ?>
</div>