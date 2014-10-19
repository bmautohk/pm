<? $writePermission = GlobalFunction::checkPagePrivilege('role_matrix', RolePageMatrix::PERMISSION_WRITE); ?>
<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'viewForm',
		'action'=>Yii::app()->request->baseUrl.'/roleMatrix/changeView',
		'enableAjaxValidation'=>false,
	));
	
	echo $form->dropDownList($model, 'action', array('column'=>'Product Column Permission', 'page'=>'Page Permission'), array('onchange'=>'changeView()'));
	$this->endWidget(); ?>
	
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>Yii::app()->request->baseUrl.'/roleMatrix/updatePageMatrix',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<table class="product-excel-style" style="width: 1000px;">
			<tr>
				<th style="width:140px">&nbsp;</th>
				<? foreach ($model->roles as $role) {?>
					<th><?=$role->role ?></th>
				<? }?>
			</tr>
			<? foreach (MaintRoleMatrixForm::$pages as $page) {?>
				<tr>
					<td><?=Yii::t('role_matrix_message', $page) ?></td>
					<? foreach ($model->roles as $role) {?>
						<td>
							<? echo CHtml::dropDownList("page_permissions[".$role->role_code."][".$page."]",
									(isset($model->page_permissions[$role->role_code][$page]) ? $model->page_permissions[$role->role_code][$page] : ''),
									array(''=>'', 'R'=>'Read', 'W'=>'Write')); ?>
						</td>
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