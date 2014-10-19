<? $writePermission = GlobalFunction::checkPagePrivilege('role_matrix', RolePageMatrix::PERMISSION_WRITE); ?>
<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'viewForm',
		'action'=>Yii::app()->request->baseUrl.'/roleMatrix/changeView',
		//'method'=>'GET',
		'enableAjaxValidation'=>false,
	));
	
	echo $form->dropDownList($model, 'action', array('column'=>'Product Column Permission', 'page'=>'Page Permission'), array('onchange'=>'changeView()'));
	
	$this->endWidget(); ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>Yii::app()->request->baseUrl.'/roleMatrix/updateColumnMatrix',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<table class="product-excel-style" width="width: 1000px;">
			<tr>
				<th>&nbsp;</th>
				<? foreach ($model->roles as $role) {?>
					<th><?=$role->role ?></th>
				<? }?>
			</tr>
			<? foreach (MaintRoleMatrixForm::$columns as $column) {?>
				<tr>
					<td><?=Yii::t('product_message', $column) ?></td>
					<? foreach ($model->roles as $role) {?>
						<td><?=CHtml::checkBox("column_permissions[".$role->role_code."][".$column."]", isset($model->column_permissions[$role->role_code][$column])) ?></td>
					<? }?>
				</tr>
			<? }?>
		</table>
		
		<? if ($writePermission) { ?>
			<input class="updateBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
		<? } ?>
	<? $this->endWidget(); ?>
</div>

<script type="text/javascript">
	function changeView() {
		$('#viewForm').submit();
	}
</script>