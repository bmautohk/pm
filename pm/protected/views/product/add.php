<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jscal2.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lang/en.js"></script>

<style>
	.ui-menu .ui-menu-item a {font-size: 0.4em; }
</style>
<? 
/*$mades =  Made::getDropDownFromCache(); 

if (!in_array($model->made, $mades)) {
	$mades[$model->made] = $model->made;
}*/
?>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<div class="page_header">Product Creation</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<? echo $form->hiddenField($model,'id'); ?>
		<div style="width:400px">
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'customer'); ?></span><span class="input_field"><? echo $form->textField($model,'customer'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'prod_sn'); ?></span><span class="input_field"><? echo $form->textField($model,'prod_sn', array('readonly'=>true)); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'status'); ?></span><? echo $form->dropDownList($model, 'status', array('A'=>'Active', 'I'=>'Inactive')); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'no_jp'); ?></span><span class="input_field"><? echo $form->textField($model,'no_jp'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'factory_no'); ?></span><span class="input_field"><? echo $form->textField($model,'factory_no'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'made'); ?></span><span class="input_field"><? echo $form->textField($model,'made'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'model'); ?></span><span class="input_field"><? echo $form->textField($model,'model'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'model_no'); ?></span><span class="input_field"><? echo $form->textField($model,'model_no'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'year'); ?></span><span class="input_field"><? echo $form->textField($model,'year'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'item_group'); ?></span><span class="input_field"><? echo $form->textField($model,'item_group'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'material'); ?></span><span class="input_field"><? echo $form->textField($model,'material'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'product_desc'); ?></span><span class="input_field"><? echo $form->textField($model,'product_desc'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'product_desc_ch'); ?></span><span class="input_field"><? echo $form->textField($model,'product_desc_ch'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'product_desc_jp'); ?></span><span class="input_field"><? echo $form->textField($model,'product_desc_jp'); ?></span>
			</div>
			
			<div class="grid-c1-textarea">
				<span class="input_label"><? echo Yii::t('product_message', 'accessory_remark'); ?></span><span><? echo $form->textArea($model,'accessory_remark'); ?></span>
			</div>
			
			<div class="grid-c1-textarea">
				<span class="input_label"><? echo Yii::t('product_message', 'company_remark'); ?></span><span><? echo $form->textArea($model,'company_remark'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'pcs'); ?></span><span class="input_field"><? echo $form->textField($model,'pcs'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'colour'); ?></span><span class="input_field"><? echo $form->textField($model,'colour'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'colour_no'); ?></span><span class="input_field"><? echo $form->textField($model,'colour_no'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'supplier'); ?></span><span class="input_field"><? echo $form->textField($model,'supplier'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'molding'); ?></span><span class="input_field"><? echo $form->textField($model,'molding'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'moq'); ?></span><span class="input_field"><? echo $form->textField($model,'moq'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'cost'); ?></span><span class="input_field"><? echo $form->textField($model,'cost'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'kaito'); ?></span><span class="input_field"><? echo $form->textField($model,'kaito'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'other'); ?></span><span class="input_field"><? echo $form->textField($model,'other'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'purchase_cost'); ?></span><span class="input_field"><? echo $form->textField($model,'purchase_cost'); ?></span>
				
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'buy_date'); ?></span><span class="date_field"><? echo $form->textField($model,'buy_date'); ?></span><input type="button" class="calendar_button" id="buyDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'receive_date'); ?></span><span class="date_field"><? echo $form->textField($model,'receive_date'); ?></span><input type="button" class="calendar_button" id="receiveDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'factory_date'); ?></span><span class="date_field"><? echo $form->textField($model,'factory_date'); ?></span><input type="button" class="calendar_button" id="factoryDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'pack_remark'); ?></span><span class="input_field"><? echo $form->textField($model,'pack_remark'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'order_date'); ?></span><span class="date_field"><? echo $form->textField($model,'order_date'); ?></span><input type="button" class="calendar_button" id="orderDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'progress'); ?></span><span class="input_field"><? echo $form->textField($model,'progress'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'receive_model_date'); ?></span><span class="date_field"><? echo $form->textField($model,'receive_model_date'); ?></span><input type="button" class="calendar_button" id="receiveModelDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'person_in_charge'); ?></span><span class="input_field"><? echo $form->textField($model,'person_in_charge'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'state'); ?></span><span class="input_field"><? echo $form->textField($model,'state'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'ship_date'); ?></span><span class="date_field"><? echo $form->textField($model,'ship_date'); ?></span><input type="button" class="calendar_button" id="shipDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'market_research_price'); ?></span><span class="input_field"><? echo $form->textField($model,'market_research_price'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'yahoo_produce'); ?></span><span class="input_field"><? echo $form->textField($model,'yahoo_produce'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'produce_status'); ?></span><? echo $form->dropDownList($model, 'produce_status', ProductMaster::getProduceStatusDropdown()); ?>
			</div>
			
			<br style="clear:both" />
			
		</div>
		
		<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'add'); ?>" />
		<input class="searchBtn" type="button" onclick="window.location='../product'" value="<? echo Yii::t('common_message', 'back'); ?>" />
		
	<? $this->endWidget(); ?>
	
	<? if ($action == 'update') {?>
		<!-- Show image -->
		<iframe style="width:100%" src="<? echo Yii::app()->request->baseUrl; ?>/product/show_image?no_jp=<?=$model->no_jp ?>"></iframe>
	<? }?>
</div>

<div style="height:50px"></div>

<script type="text/javascript">
$(function() {
	Calendar.setup({
	    inputField : "ProductMaster_buy_date",
	    trigger    : "buyDateBtn",
	    onSelect   : function() { this.hide() }
	});

	Calendar.setup({
	    inputField : "ProductMaster_receive_date",
	    trigger    : "receiveDateBtn",
	    onSelect   : function() { this.hide() }
	});

	Calendar.setup({
	    inputField : "ProductMaster_factory_date",
	    trigger    : "factoryDateBtn",
	    onSelect   : function() { this.hide() }
	});

	Calendar.setup({
	    inputField : "ProductMaster_order_date",
	    trigger    : "orderDateBtn",
	    onSelect   : function() { this.hide() }
	});

	Calendar.setup({
	    inputField : "ProductMaster_receive_model_date",
	    trigger    : "receiveModelDateBtn",
	    onSelect   : function() { this.hide() }
	});

	Calendar.setup({
	    inputField : "ProductMaster_ship_date",
	    trigger    : "shipDateBtn",
	    onSelect   : function() { this.hide() }
	});

	$("#ProductMaster_made").autocomplete({
		source: "search_made",
	});

	$("#ProductMaster_model").autocomplete({
		source: "search_model",
	});
});
</script>
