<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jscal2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lang/en.js"></script>
<? 
/*$mades =  Made::getDropDownFromCache(); 

if (!in_array($model->made, $mades)) {
	$mades[$model->made] = $model->made;
}*/
?>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<? if ($action == 'update') {?>
		<div class="page_header">Product Update</div>
	<? } else {?>
		<div class="page_header">Product Creation</div>
	<? }?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<? echo $form->hiddenField($model,'id'); ?>
		<div class="grid">
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'customer'); ?></span></span><span class="input_field"><? echo $form->textField($model,'customer'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'prod_sn'); ?></span></span><span class="input_field"><? echo $form->textField($model,'prod_sn'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'status'); ?></span></span><? echo $form->dropDownList($model, 'status', array('A', 'I')); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'no_jp'); ?></span></span><span class="input_field"><? echo $form->textField($model,'no_jp'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'factory_no'); ?></span></span><span class="input_field"><? echo $form->textField($model,'factory_no'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'made'); ?></span></span><span class="input_field"><? echo $form->textField($model,'made'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'model'); ?></span></span><span class="input_field"><? echo $form->textField($model,'model'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'model_no'); ?></span></span><span class="input_field"><? echo $form->textField($model,'model_no'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'year'); ?></span></span><span class="input_field"><? echo $form->textField($model,'year'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'item_group'); ?></span></span><span class="input_field"><? echo $form->textField($model,'item_group'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'material'); ?></span></span><span class="input_field"><? echo $form->textField($model,'material'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'product_desc'); ?></span></span><span class="input_field"><? echo $form->textField($model,'product_desc'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'remark'); ?></span></span><span class="input_field"><? echo $form->textField($model,'remark'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'photo_link'); ?></span></span><span class="input_field"><? echo $form->textField($model,'photo_link'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'pcs'); ?></span></span><span class="input_field"><? echo $form->textField($model,'pcs'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'colour'); ?></span></span><span class="input_field"><? echo $form->textField($model,'colour'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'colour_no'); ?></span></span><span class="input_field"><? echo $form->textField($model,'colour_no'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'moq'); ?></span></span><span class="input_field"><? echo $form->textField($model,'moq'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'molding'); ?></span></span><span class="input_field"><? echo $form->textField($model,'molding'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'cost'); ?></span></span><span class="input_field"><? echo $form->textField($model,'cost'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'kaito'); ?></span></span><span class="input_field"><? echo $form->textField($model,'kaito'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'other'); ?></span></span><span class="input_field"><? echo $form->textField($model,'other'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'buy_date'); ?></span></span><? echo $form->textField($model,'buy_date'); ?><input type="button" class="calendar_button" id="buyDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'receive_date'); ?></span></span><? echo $form->textField($model,'receive_date'); ?><input type="button" class="calendar_button" id="receiveDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'supplier'); ?></span></span><span class="input_field"><? echo $form->textField($model,'supplier'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'purchase_cost'); ?></span></span><span class="input_field"><? echo $form->textField($model,'purchase_cost'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'factory_date'); ?></span></span><? echo $form->textField($model,'factory_date'); ?><input type="button" class="calendar_button" id="factoryDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'pack_remark'); ?></span></span><span class="input_field"><? echo $form->textField($model,'pack_remark'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'order_date'); ?></span></span><? echo $form->textField($model,'order_date'); ?><input type="button" class="calendar_button" id="orderDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'progress'); ?></span></span><span class="input_field"><? echo $form->textField($model,'progress'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'receive_model_date'); ?></span></span><? echo $form->textField($model,'receive_model_date'); ?><input type="button" class="calendar_button" id="receiveModelDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'person_in_charge'); ?></span></span><span class="input_field"><? echo $form->textField($model,'person_in_charge'); ?></span>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'state'); ?></span></span><span class="input_field"><? echo $form->textField($model,'state'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'ship_date'); ?></span></span><? echo $form->textField($model,'ship_date'); ?><input type="button" class="calendar_button" id="shipDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><span><? echo Yii::t('product_message', 'market_research_price'); ?></span></span><span class="input_field"><? echo $form->textField($model,'market_research_price'); ?></span>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><span><? echo Yii::t('product_message', 'yahoo_produce'); ?></span></span><span class="input_field"><? echo $form->textField($model,'yahoo_produce'); ?></span>
			</div>
			<br style="clear:both" />
			
		</div>
		
		<? if ($action == 'update') {?>
			<input class="searchBtn" type="submit" name="action" value="Update" />
			<input class="searchBtn" type="submit" name="action" value="Back" />
		<? } else {?>
			<input class="searchBtn" type="submit" name="action" value="Add" />
			<input class="searchBtn" type="button" onclick="window.location='../product'" value="Back" />
		<? } ?>
		
	<? $this->endWidget(); ?>
	
</div>

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
});
</script>
