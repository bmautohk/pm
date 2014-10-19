<? $writePermission = GlobalFunction::checkPagePrivilege('email_management', RolePageMatrix::PERMISSION_WRITE); ?>

<style>
	.input_label_s {
		width: 120px;
	}
	
	.input_field select {
		margin-left: 0px;
		height: 24px;
	}
</style>

<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'saveForm',
			'action'=>NULL,
			'method'=>'POST'
			)); ?>
			
			
			<? echo $form->hiddenField($model, 'action'); 
			echo $form->hiddenField($model, 'id');
			?>

			<div id="pagingDiv">
				<? if ($writePermission) { ?>
					<input type="button" value="Add Row" onclick="addRow()" />
					<input type="button" value="Save" onclick="goSave()" />
				<? } ?>
				
				<table id="maint_form" class="product-excel-style" style="width:760px">
					<tr>
						<? if ($writePermission) { ?><th style="width:50px">&nbsp;</th><? } ?>
						<th>Email</th>
					</tr>
				<? foreach ($model->existingEmails as $email) { ?>
					<tr>
						<? if ($writePermission) { ?><td><input type="button" value="<? echo Yii::t('common_message', 'delete'); ?>" onclick="javascript:goDelete('<?=$email->id ?>')" /></td><? } ?>
						<td><?=$email->email_address ?></td>
					</tr>
				<? }?>
				
				<? foreach ($model->emails as $idx=>$email) { ?>
					<tr>
						<td></td>
						<td><? echo $form->textField($email, '['.$idx.']email_address'); ?></td>
					</tr>
				<? } ?>
				</table>
			</div>

		<? $this->endWidget(); ?>
		
		<span>
		Remarks:<br>
		The above email address will receive the following email:<br>
		1. Daily product change log
		</<span>
		
		<div style="height:600px"></div>
	</div>
</div>

<script type="text/javascript">
var noOfRow = <?=sizeOf($model->emails) ?>;
function goDelete(id) {
	if (confirm('Are you sure to delete?')) {
		$('#saveForm #EmailForm_action').val('delete');
		$('#saveForm #EmailForm_id').val(id);
		$('#saveForm').submit();
	}
}

function goSave() {
	$('#saveForm #EmailForm_action').val('save');
	$('#saveForm').submit();
}

function addRow() {
	$('#maint_form tr:last').after('<tr><td></td><td><input name="Email[' + noOfRow + '][email_address]" id="Email_' + noOfRow + '_email_address" type="text" maxlength="50"/></td></tr>'); 
	noOfRow++;
}
</script>