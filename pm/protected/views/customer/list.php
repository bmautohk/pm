<? $baseUrl = Yii::app()->request->baseUrl; ?>
<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
		<br>
	 	<div>
	 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('customer/add') ?>'" value="<? echo Yii::t('customer_message', 'add_customer'); ?>" />
	 	</div>
	 	
	 	<!-- Serach Criteria -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'searchForm',
			'action'=>Yii::app()->createUrl('customer/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Customer filter</div>
			
			<div class="grid_s">
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'name'); ?></span><span class="input_field"><? echo $form->textField($model, 'name'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'cust_cd'); ?></span><span class="input_field"><? echo $form->textField($model, 'cust_cd'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'tel'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'fax'); ?></span><span class="input_field"><? echo $form->textField($model, 'fax'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'address'); ?></span><span class="input_field"><? echo $form->textField($model, 'address'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s" style="width:120px"><? echo Yii::t('customer_message', 'contact_person'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_person'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'email'); ?></span><span class="input_field"><? echo $form->textField($model, 'email'); ?></span>
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
			<? include('customerPaging.php'); ?>
		</div>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'criteriaForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
			
			<input type="hidden" name="page" id="page" />
			<input type="hidden" name="id" id="id" />
			<? echo $form->hiddenField($model,'itemCount'); ?>
			<? echo $form->hiddenField($model,'name'); ?>
			<? echo $form->hiddenField($model,'cust_cd'); ?>
			<? echo $form->hiddenField($model,'tel'); ?>
			<? echo $form->hiddenField($model,'fax'); ?>
			<? echo $form->hiddenField($model,'address'); ?>
			<? echo $form->hiddenField($model,'contact_person'); ?>
			<? echo $form->hiddenField($model,'email'); ?>
			
		<? $this->endWidget(); ?>
		
		<div style="height:600px"></div>
	</div>
</div>

<script type="text/javascript">
function goUpdate(id) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/customer/update');
	$('#criteriaForm #id').val(id);
	$('#page').val($('#currPage').val());
	$('#criteriaForm').submit();
}

function goToPage(page) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/customer/searchByFilter');
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}

function goDelete(id) {
	if (confirm('Are you sure to delete?')) {
		$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/customer/delete');
		$('#criteriaForm #id').val(id);
		$('#page').val($('#currPage').val());
		$('#criteriaForm').submit();
	}
}

function clearSerachCriteria() {
	$('#searchForm input:text').val('');
}
</script>