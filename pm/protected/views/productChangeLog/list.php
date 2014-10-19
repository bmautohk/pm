<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jscal2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lang/en.js"></script>

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
			'action'=>Yii::app()->createUrl('productChangeLog/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Log filter</div>
			
			<div class="grid_s">
				<div class="grid_u-c1" style="width:100%">
					<span class="input_label_s">Modify Date</span>
					<span>
						<? echo $form->textField($model, 'date_from', array('style'=>'width:100px')); ?><input type="button" class="calendar_button" id="date_from_btn" value=" " />
						to <? echo $form->textField($model, 'date_to', array('style'=>'width:100px')); ?><input type="button" class="calendar_button" id="date_to_btn" value=" " />
					</span>
				</div>
					
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'prod_sn'); ?></span><span class="input_field"><? echo $form->textField($model, 'prod_sn'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s">Column Name</span><span class="input_field"><? echo $form->dropDownList($model, 'column_name', $model->getColumnNameDropdown()); ?></span>
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
				<input type="button" id="download_btn" value="<? echo Yii::t('common_message', 'download'); ?>">
				<br>
			</div>
		<? $this->endWidget(); ?>
		
		<br />
		
		<div id="pagingDiv">
			<? include('productChangeLogPaging.php'); ?>
		</div>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'criteriaForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
			
			<input type="hidden" name="page" id="page" />
			<input type="hidden" name="id" id="id" />
			<? echo $form->hiddenField($model,'itemCount'); ?>
			<? echo $form->hiddenField($model,'date_from'); ?>
			<? echo $form->hiddenField($model,'date_to'); ?>
			<? echo $form->hiddenField($model,'prod_sn'); ?>
			<? echo $form->hiddenField($model,'column_name'); ?>
		<? $this->endWidget(); ?>
		
		<div style="height:600px"></div>
	</div>
</div>

<script type="text/javascript">
$(function() {
	Calendar.setup({
	    inputField : "ProductChangeLogSearchForm_date_from",
	    trigger    : "date_from_btn",
	    onSelect   : function() { this.hide() }
	});

	Calendar.setup({
	    inputField : "ProductChangeLogSearchForm_date_to",
	    trigger    : "date_to_btn",
	    onSelect   : function() { this.hide() }
	});

	$('#download_btn').click(function() {
		var origAction = $('#criteriaForm').attr('action');
		$('#criteriaForm').attr('action', '<?=Yii::app()->createUrl('productChangeLog/downloadByFilter'); ?>');
		$('#criteriaForm').submit();
	});
});

function goToPage(page) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/productChangeLog/searchByFilter');
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}

function clearSerachCriteria() {
	$('#searchForm input:text').val('');
	$('#searchForm select').val('');
}
</script>