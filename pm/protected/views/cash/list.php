<?
$baseUrl = Yii::app()->request->baseUrl;

?>
<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
		<br>
		
	 	<!-- Serach Criteria -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'searchForm',
			'action'=>Yii::app()->createUrl('cash/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Cash filter</div>
			
			<div class="grid_s">
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('cash_message', 'pay_from'); ?></span><span class="input_field"><? echo $form->textField($model, 'pay_from'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('cash_message', 'pay_to'); ?></span><span class="input_field"><? echo $form->textField($model, 'pay_to'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('cash_message', 'account'); ?></span><span class="input_field"><? echo $form->textField($model, 'account'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('cash_message', 'desc'); ?></span><span class="input_field"><? echo $form->textField($model, 'desc'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('cash_message', 'remark'); ?></span><span class="input_field"><? echo $form->textField($model, 'remark'); ?></span>
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
			<? include('cashPaging.php'); ?>
		</div>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'criteriaForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
			
			<input type="hidden" name="page" id="page" />
			<input type="hidden" name="id" id="id" />
			<?
			echo $form->hiddenField($model,'pay_from');
			echo $form->hiddenField($model,'pay_to');
			echo $form->hiddenField($model,'account');
			echo $form->hiddenField($model,'desc');
			echo $form->hiddenField($model,'remark');
			?>
		<? $this->endWidget(); ?>
		
		<div style="height:600px"></div>
	</div>
</div>

<script type="text/javascript">

function goToPage(page) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/cash/searchByFilter');
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}

function clearSerachCriteria() {
	$('#searchForm input:text').val('');
}

function goDelete(id) {
	if (confirm("Are you sure to delete?")) {
		$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/cash/delete');
		$('#criteriaForm #id').val(id);
		$('#page').val($('#currPage').val());
		$('#criteriaForm').submit();
	}
}

</script>