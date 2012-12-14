<? $baseUrl = Yii::app()->request->baseUrl; ?>
<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
		<br>
	 	<div>
	 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('user/add') ?>'" value="<? echo Yii::t('user_message', 'add_user'); ?>" />
	 	</div>
	
		<table class="product-excel-style">
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th><? echo Yii::t('user_message', 'username'); ?></th>
				<th><? echo Yii::t('user_message', 'role'); ?></th>
				<th><? echo Yii::t('user_message', 'supplier'); ?></th>
				<th><? echo Yii::t('user_message', 'last_login'); ?></th>
			</tr>
		<? foreach($users as $user) { ?>
			<tr>
				<td><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" onclick="location.href='<?=Yii::app()->createUrl('user/update?username='.$user->username) ?>';" /></td>
				<td><input type="button" value="<? echo Yii::t('common_message', 'delete'); ?>" onclick="javascript:goDelete('<?=$user->username ?>')" /></td>
				<td><?=$user->username ?></td>
				<td><?=$user->role->role ?></td>
				<td><?=$user->user_supplier->supplier ?></td>
				<td><?=$user->last_login ?></td>
			</tr>
		<? }?>
		</table>
		
		<div style="height:600px"></div>
	</div>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$baseUrl.'/user/delete',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
	
	<? echo $form->hiddenField(new MaintUserForm(), 'username'); ?>
	
<? $this->endWidget(); ?>

<script type="text/javascript">
function goDelete(username) {
	if (confirm('Are you sure to delete?')) {
		$('#MaintUserForm_username').val(username);
		$('#form1').submit();
	}
}
</script>