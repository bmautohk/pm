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
		<br>
	 	
	 	<!-- Serach Criteria -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'searchForm',
			'action'=>Yii::app()->createUrl('order/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Order filter</div>
			
			<div class="grid_s">
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('order_message', 'customer_name'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'customer_id', Customer::getDropdown(true)); ?></span>
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
		
		<br />
		
		<div id="pagingDiv">
			<? include('orderPaging.php'); ?>
		</div>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'criteriaForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
			
			<input type="hidden" name="page" id="page" />
			<input type="hidden" name="id" id="id" />
			<? echo $form->hiddenField($model,'itemCount'); ?>
			<? echo $form->hiddenField($model,'customer_id'); ?>
		<? $this->endWidget(); ?>
		
		<div style="height:600px"></div>
	</div>
</div>

<script type="text/javascript">
function goUpdate(id) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/order/view');
	$('#criteriaForm #id').val(id);
	$('#page').val($('#currPage').val());
	$('#criteriaForm').submit();
}

function goToPage(page) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/order/searchByFilter');
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}

function clearSerachCriteria() {
	$('#searchForm input:text').val('');
	$('#searchForm select').val('');
}
</script>