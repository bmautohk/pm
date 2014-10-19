<?
$baseUrl = Yii::app()->request->baseUrl;
$writePermission = GlobalFunction::checkPagePrivilege('role_management', RolePageMatrix::PERMISSION_WRITE);
?>
<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
		<br>
		
		<? if ($writePermission) { ?>
		 	<div>
		 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('role/add') ?>'" value="<? echo Yii::t('role_message', 'add_role'); ?>" />
		 	</div>
	 	<? } ?>
	
		<table class="product-excel-style">
			<tr>
				<th>&nbsp;</th>
				<? if ($writePermission) { ?><th>&nbsp;</th><? } ?>
				<th><? echo Yii::t('role_message', 'role_code'); ?></th>
				<th><? echo Yii::t('role_message', 'role'); ?></th>
			</tr>
		<? foreach($roles as $role) { ?>
			<tr>
				<td><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" onclick="location.href='<?=Yii::app()->createUrl('role/update?role_code='.$role->role_code) ?>';" /></td>
				<? if ($writePermission) { ?><td><input type="button" value="<? echo Yii::t('common_message', 'delete'); ?>" onclick="javascript:goDelete('<?=$role->role_code ?>')" /></td><? } ?>
				<td><?=$role->role_code ?></td>
				<td><?=$role->role ?></td>
			</tr>
		<? }?>
		</table>
		
		<div style="height:600px"></div>
	</div>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$baseUrl.'/role/delete',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
	
	<? echo $form->hiddenField(new MaintRoleForm(), 'role_code'); ?>
	
<? $this->endWidget(); ?>

<script type="text/javascript">
function goDelete(role) {
	if (confirm('Are you sure to delete?')) {
		$('#MaintRoleForm_role_code').val(role);
		$('#form1').submit();
	}
}
</script>