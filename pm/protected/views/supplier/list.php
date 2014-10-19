<?
$baseUrl = Yii::app()->request->baseUrl;
$writePermission = GlobalFunction::checkPagePrivilege('supplier_management', RolePageMatrix::PERMISSION_WRITE);
?>
<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
		<br>
		
		<? if ($writePermission) { ?>
			<div>
	 			<input type="button" onclick="location.href='<?=Yii::app()->createUrl('supplier/import') ?>'" value="<? echo Yii::t('supplier_message', 'import_excel'); ?>" />
	 			<input type="button" onclick="location.href='<?=Yii::app()->createUrl('supplier/export') ?>'" value="<? echo Yii::t('supplier_message', 'export_excel'); ?>" />
	 		</div>
		
		 	<div>
		 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('supplier/add') ?>'" value="<? echo Yii::t('supplier_message', 'add_supplier'); ?>" />
		 	</div>
	 	<? } ?>
	 	
	 	<!-- Serach Criteria -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'searchForm',
			'action'=>Yii::app()->createUrl('supplier/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Supplier filter</div>
			
			<div class="grid_s">
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'name'); ?></span><span class="input_field"><? echo $form->textField($model, 'name'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'supplier_id'); ?></span><span class="input_field"><? echo $form->textField($model, 'supplier_id'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'tel'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'contact_person'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_person'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'mobile'); ?></span><span class="input_field"><? echo $form->textField($model, 'mobile'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s" style="width:100px"><? echo Yii::t('supplier_message', 'other_contact'); ?></span><span class="input_field"><? echo $form->textField($model, 'other_contact'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'qq'); ?></span><span class="input_field"><? echo $form->textField($model, 'qq'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'notice'); ?></span><span class="input_field"><? echo $form->textField($model, 'notice'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'bank'); ?></span><span class="input_field"><? echo $form->textField($model, 'bank'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'open_account'); ?></span><span class="input_field"><? echo $form->textField($model, 'open_account'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'account_owner'); ?></span><span class="input_field"><? echo $form->textField($model, 'account_owner'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'account_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'account_no'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'term_of_payment'); ?></span><span class="input_field"><? echo $form->textField($model, 'term_of_payment'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'address'); ?></span><span class="input_field"><? echo $form->textField($model, 'address'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('supplier_message', 'email'); ?></span><span class="input_field"><? echo $form->textField($model, 'email'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					
				</div>
				
				<br style="clear:both" />
			</div>

			<br>
			<div style="width:100%; text-align:center">
				<input type="submit" value="<? echo Yii::t('common_message', 'search'); ?>">
				<input type="button" value="<? echo Yii::t('common_message', 'reset'); ?>" onclick="clearSerachCriteria()">
				<br>
			</div>
		<? $this->endWidget(); ?>
		
		<div id="pagingDiv">
			<? include('supplierPaging.php'); ?>
		</div>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'criteriaForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
			
			<input type="hidden" name="page" id="page" />
			<input type="hidden" name="id" id="id" />
			<?
			echo $form->hiddenField($model,'name');
			echo $form->hiddenField($model,'supplier_id');
			echo $form->hiddenField($model,'supplier_cd');
			echo $form->hiddenField($model,'tel');
			echo $form->hiddenField($model,'email');
			echo $form->hiddenField($model,'address');
			echo $form->hiddenField($model,'contact_person');
			echo $form->hiddenField($model,'mobile');
			echo $form->hiddenField($model,'qq');
			echo $form->hiddenField($model,'other_contact');
			echo $form->hiddenField($model,'notice');
			echo $form->hiddenField($model,'bank');
			echo $form->hiddenField($model,'open_account');
			echo $form->hiddenField($model,'account_owner');
			echo $form->hiddenField($model,'account_no');
			echo $form->hiddenField($model,'term_of_payment');
			?>
		<? $this->endWidget(); ?>
		
		<div style="height:600px"></div>
	</div>
</div>

<script type="text/javascript">
function goUpdate(id) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/supplier/update');
	$('#criteriaForm #id').val(id);
	$('#page').val($('#currPage').val());
	$('#criteriaForm').submit();
}

function goToPage(page) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/supplier/searchByFilter');
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}

function goDelete(id) {
	if (confirm('Are you sure to delete?')) {
		$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/supplier/delete');
		$('#criteriaForm #id').val(id);
		$('#page').val($('#currPage').val());
		$('#criteriaForm').submit();
	}
}

function clearSerachCriteria() {
	$('#searchForm input:text').val('');
}
</script>