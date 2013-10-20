<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css" />

<!--style>
.ui-widget-content a {
	color:white;
}
</style-->

<? $model = $this->searchForm; ?>

	<br>
	<? if (GlobalFunction::isAdmin()) {?>
 	<div>
 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('product/import') ?>'" value="<? echo Yii::t('common_message', 'import_product'); ?>" />
 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('product/export') ?>'" value="<? echo Yii::t('common_message', 'export_product'); ?>" /><br>
		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('product/add') ?>'" value="<? echo Yii::t('common_message', 'add_product'); ?>" /><br><br>
	</div>
	<? } ?>
	 
	<? 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'keywordForm1',
			'action'=>Yii::app()->createUrl('product/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<? echo $form->hiddenField($model, 'made'); ?>
		
			<? echo $form->textField($model,'keyword', array('size'=>'100', 'placeholder'=>'Enter Keyword')); ?><input type="submit" id="search_by_keyword" value="<? echo Yii::t('common_message', 'search'); ?>">
		<? $this->endWidget(); ?>
		
		<? 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'keywordForm2',
			'action'=>Yii::app()->createUrl('product/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<? echo $form->hiddenField($model, 'made'); ?>
			<? echo $form->textField($model,'no_jp2', array('size'=>'100', 'placeholder'=>'Enter 品番')); ?><input type="submit" id="search_by_no_jp" value="<? echo Yii::t('common_message', 'search'); ?>">
		<? $this->endWidget(); ?>
		
		<? 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'keywordForm3',
			'action'=>Yii::app()->createUrl('product/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<? echo $form->hiddenField($model, 'made'); ?>
			<? echo $form->textField($model,'prod_sn2', array('size'=>'100', 'placeholder'=>'Enter 產品S/N')); ?><input type="submit" id="search_by_prod_sn" value="<? echo Yii::t('common_message', 'search'); ?>">
		<? $this->endWidget(); ?>
		
		<br>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'form2',
			'action'=>Yii::app()->createUrl('product/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="page_header">Goods filter</div>
			
			<div class="grid_s">
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'customer'); ?></span><span class="input_field"><? echo $form->textField($model, 'customer'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'no_jp'); ?></span><span class="input_field"><? echo $form->textField($model, 'no_jp'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'factory_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'factory_no'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'made'); ?></span><span class="input_field"><? echo $form->textField($model, 'made'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'model'); ?></span><span class=""><? echo $form->textField($model, 'model', array('style'=>'height:18px;width:240px')); ?></span>
					<span><input type="button" id="select_model_button" value="<?=Yii::t('common_message', 'select'); ?>" /></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'model_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'model_no'); ?></span>
				</div>
				<br style="clear:both" />
			</div>
			
			<div id="advanceFilter" class="grid" style="display:none">
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'year'); ?></span><span class="input_field"><? echo $form->textField($model, 'year'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'item_group'); ?></span><span class="input_field"><? echo $form->textField($model, 'item_group'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'colour_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'colour'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'material'); ?></span><span class="input_field"><? echo $form->textField($model, 'material'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s">PCS</span><span class="input_from_to_field"><? echo $form->textField($model, 'pcsFrom', array('size'=>10)); ?> To <? echo $form->textField($model, 'pcsTo', array('size'=>10)); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'supplier'); ?></span><span class="input_field"><? echo $form->textField($model, 'supplier'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'molding'); ?></span><span class="input_from_to_field"><? echo $form->textField($model, 'moldingFrom', array('size'=>10)); ?> To <? echo $form->textField($model, 'moldingTo', array('size'=>10)); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('product_message', 'kaito'); ?></span><span class="input_from_to_field"><? echo $form->textField($model, 'kaitoFrom', array('size'=>10)); ?> To <? echo $form->textField($model, 'kaitoTo', array('size'=>10)); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('product_message', 'produce_status'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'produceStatus', array_merge(array(''=>''), ProductMaster::getProduceStatusDropdown())); ?></span>
				</div>
				<div class="grid_s-c2">
					
				</div>
			</div>

			<br>
			<div style="width:100%; text-align:center">
				<input type="submit" value="<? echo Yii::t('common_message', 'search'); ?>">
				<? if ($this->isShowDownloadButton && GlobalFunction::isAdmin()) {?>
					<input type="button" id="download_btn" value="<? echo Yii::t('common_message', 'download'); ?>">
				<? }?>
				<br>
			</div>
			
			<a href="javascript:showAdvanceFilter()">
				<div class="advance_filter"></div>
			</a>
		<? $this->endWidget(); ?>
		
<div id="model_dialog" title="<? echo Yii::t('common_message', 'select_model'); ?>" style="background-color:black">
	<div id="model_dialog_content">
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$('#keywordForm1').submit(function() {
			if ($('#ProductSearchForm_keyword').val() != '') {
				return true;
			}
			else {
				alert('Please fill in keyword!');
				return false;
			}
		});

		$('#keywordForm2').submit(function() {
			if ($('#ProductSearchForm_no_jp2').val() != '') {
				return true;
			}
			else {
				alert('Please fill in 品番!');
				return false;
			}
		});

		$('#keywordForm3').submit(function() {
			if ($('#ProductSearchForm_prod_sn').val() != '') {
				return true;
			}
			else {
				alert('Please fill in 產品S/N!');
				return false;
			}
		});
		
		$('#select_model_button').click(function() {
			$.post('<?=Yii::app()->request->baseUrl ?>/product/getModels', function(data) {
				  $('#model_dialog_content').html(data);
				  $("#model_dialog").dialog( "open" );
			});
        });

		$( "#model_dialog" ).dialog({
			autoOpen: false,
			height: 500,
			width: 250,
			modal: true
		});
		
		$('#download_btn').click(function() {
			var origAction = $('#criteriaForm').attr('action');
			$('#criteriaForm').attr('action', '<?=Yii::app()->createUrl('product/downloadByFilter'); ?>');
			$('#criteriaForm').submit();
			$('#criteriaForm').attr('action', origAction);
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

	function selectModel(model) {
		$('#ProductSearchForm_model').val(model);
		$("#model_dialog").dialog( "close" );
	}
</script>
