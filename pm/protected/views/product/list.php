 <div id="rightmain">
 
 	<div class="rightmain_content">
 		<br>
	 	<div>
			<input type="button" onclick="location.href='<?=Yii::app()->createUrl('product/add') ?>'" value="+ ADD NEW PRODUCT" /><br><br>
		</div>
	 
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'form1',
			'action'=>Yii::app()->createUrl('product/searchByKeyword'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<? echo $form->hiddenField($model, 'made'); ?>
		
			<? echo $form->textField($model,'keyword', array('size'=>'100', 'placeholder'=>'Enter Keyword')); ?><input type="button" id="search_by_keyword" value="Search">
		<? $this->endWidget(); ?>
		
		<br>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'form2',
			'action'=>Yii::app()->createUrl('product/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Goods filter</div>
			
			<div class="grid">
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('product_message', 'customer'); ?></span><? echo $form->textField($model, 'customer', array('style'=>'width:314px')); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'no_jp'); ?></span><? echo $form->textField($model, 'no_jp', array('style'=>'width:314px')); ?><br/>
				</div>
				
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('product_message', 'factory_no'); ?></span><? echo $form->textField($model, 'factory_no', array('style'=>'width:282px')); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'made'); ?></span><? echo $form->textField($model, 'made', array('readonly'=>true, 'style'=>'width:314px')); ?>
				</div>
				
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('product_message', 'model'); ?></span><? echo $form->textField($model, 'model', array('style'=>'width:314px')); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'model_no'); ?></span><? echo $form->textField($model, 'model_no', array('style'=>'width:314px')); ?>
				</div>
				<br style="clear:both" />
			</div>
			
			<div id="advanceFilter" class="grid" style="display:none">
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('product_message', 'year'); ?></span><? echo $form->textField($model, 'year', array('style'=>'width:314px')); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'item_group'); ?></span><? echo $form->textField($model, 'item_group', array('style'=>'width:298px')); ?>
				</div>
				
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('product_message', 'colour').'/'.Yii::t('product_message', 'colour_no'); ?></span><? echo $form->textField($model, 'colour', array('style'=>'width:246px')); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'material'); ?></span><? echo $form->textField($model, 'material', array('style'=>'width:314px')); ?>
				</div>
				
				<div class="grid-c1">
					<span class="input_label">PCS</span><? echo $form->textField($model, 'pcsFrom', array('size'=>10)); ?> To <? echo $form->textField($model, 'pcsTo', array('size'=>10)); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'supplier'); ?></span><? echo $form->textField($model, 'supplier', array('style'=>'width:298px')); ?>
				</div>
				
				<div class="grid-c1">
					<span class="input_label"><? echo Yii::t('product_message', 'molding'); ?></span><? echo $form->textField($model, 'moldingFrom', array('size'=>10)); ?> To <? echo $form->textField($model, 'moldingTo', array('size'=>10)); ?>
				</div>
				<div class="grid-m2"></div>
				<div class="grid-c2">
					<span class="input_label"><? echo Yii::t('product_message', 'kaito'); ?></span><? echo $form->textField($model, 'kaitoFrom', array('size'=>10)); ?> To <? echo $form->textField($model, 'kaitoTo', array('size'=>10)); ?>
				</div>				
			</div>

			<br>
			<div style="width:100%; text-align:center"><input type="submit" value="Search"><br></div>
			
			<a href="javascript:showAdvanceFilter()">
				<div class="advance_filter"></div>
			</a>
		<? $this->endWidget(); ?>
		
		<div id="pagingDiv">
			<? include('productPaging.php');?>
		</div>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'criteriaForm',
			'action'=>NULL,
			'method'=>'GET'
			)); ?>
				<input type="hidden" name="page" id="page" />
				<? echo $form->hiddenField($model,'itemCount'); ?>
				<? echo $form->hiddenField($model,'keyword'); ?>
				<? echo $form->hiddenField($model,'customer'); ?>
				<? echo $form->hiddenField($model,'no_jp'); ?>
				<? echo $form->hiddenField($model,'factory_no'); ?>
				<? echo $form->hiddenField($model,'made'); ?>
				<? echo $form->hiddenField($model,'model'); ?>
				<? echo $form->hiddenField($model,'model_no'); ?>
				
				<? echo $form->hiddenField($model,'year'); ?>
				<? echo $form->hiddenField($model,'item_group'); ?>
				<? echo $form->hiddenField($model,'colour'); ?>
				<? echo $form->hiddenField($model,'material'); ?>
				<? echo $form->hiddenField($model,'pcsFrom'); ?>
				<? echo $form->hiddenField($model,'pcsTo'); ?>
				<? echo $form->hiddenField($model,'supplier'); ?>
				<? echo $form->hiddenField($model,'moldingFrom'); ?>
				<? echo $form->hiddenField($model,'moldingTo'); ?>
				<? echo $form->hiddenField($model,'kaitoFrom'); ?>
				<? echo $form->hiddenField($model,'kaitoTo'); ?>
		<? $this->endWidget(); ?>
	</div>
</div>

<script type="text/javascript">
$(function() {
	$('#search_by_keyword').click(function() {
		if ($('#ProductSearchForm_keyword').val() == '') {
			alert('Please fill in keyword!');
		}
		else {
			$('#form1').submit();
		}
	});
});

function showAdvanceFilter() {
	if ($('#advanceFilter').css('display') == 'none') {
		$('#advanceFilter').show();
	}
	else {
		$('#advanceFilter').hide();
	}
}

function goToPage(url, page) {
	$('#criteriaForm').attr('action', url);
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}
	
function goToSpecificPage(url) {
	if(event.keyCode==13) {
		goToPage(url, $('#currPage').val());
	}
}
</script>