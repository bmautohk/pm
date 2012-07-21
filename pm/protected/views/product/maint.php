<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jscal2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lang/en.js"></script>
<? $mades =  Made::getDropDownFromCache(); 

if (!in_array($model->made, $mades)) {
	$mades[$model->made] = $model->made;
}

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
				<span class="input_label"><? echo Yii::t('product_message', 'customer'); ?></span><? echo $form->textField($model,'customer', array('style'=>'width:314px')); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'prod_sn'); ?></span><? echo $form->textField($model,'prod_sn', array('style'=>'width:287px')); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'status'); ?></span><? echo $form->dropDownList($model, 'status', array('A', 'I'), array('style'=>'width:287px')); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'no_jp'); ?></span><? echo $form->textField($model,'no_jp', array('style'=>'width:314px')); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'factory_no'); ?></span><? echo $form->textField($model,'factory_no', array('style'=>'width:281px')); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'made'); ?></span><? echo $form->dropDownList($model, 'made', $mades, array('style'=>'width:314px')); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'model'); ?></span><? echo $form->textField($model,'model', array('style'=>'width:314px') ); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'model_no'); ?></span><? echo $form->textField($model,'model_no'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'year'); ?></span><? echo $form->textField($model,'year'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'item_group'); ?></span><? echo $form->textField($model,'item_group'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'material'); ?></span><? echo $form->textField($model,'material'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'product_desc'); ?></span><? echo $form->textField($model,'product_desc'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'remark'); ?></span><? echo $form->textField($model,'remark'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'photo_link'); ?></span><? echo $form->textField($model,'photo_link'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'pcs'); ?></span><? echo $form->textField($model,'pcs'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'colour'); ?></span><? echo $form->textField($model,'colour'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'colour_no'); ?></span><? echo $form->textField($model,'colour_no'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'moq'); ?></span><? echo $form->textField($model,'moq'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'molding'); ?></span><? echo $form->textField($model,'molding'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'cost'); ?></span><? echo $form->textField($model,'cost'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'kaito'); ?></span><? echo $form->textField($model,'kaito'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'other'); ?></span><? echo $form->textField($model,'other'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'buy_date'); ?></span><? echo $form->textField($model,'buy_date'); ?><input type="button" class="calendar_button" id="buyDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'receive_date'); ?></span><? echo $form->textField($model,'receive_date'); ?><input type="button" class="calendar_button" id="receiveDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'supplier'); ?></span><? echo $form->textField($model,'supplier'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'purchase_cost'); ?></span><? echo $form->textField($model,'purchase_cost'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'factory_date'); ?></span><? echo $form->textField($model,'factory_date'); ?><input type="button" class="calendar_button" id="factoryDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'pack_remark'); ?></span><? echo $form->textField($model,'pack_remark'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'order_date'); ?></span><? echo $form->textField($model,'order_date'); ?><input type="button" class="calendar_button" id="orderDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'progress'); ?></span><? echo $form->textField($model,'progress'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'receive_model_date'); ?></span><? echo $form->textField($model,'receive_model_date'); ?><input type="button" class="calendar_button" id="receiveModelDateBtn" value=" " />
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'person_in_charge'); ?></span><? echo $form->textField($model,'person_in_charge'); ?>
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'state'); ?></span><? echo $form->textField($model,'state'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'ship_date'); ?></span><? echo $form->textField($model,'ship_date'); ?><input type="button" class="calendar_button" id="shipDateBtn" value=" " />
			</div>
			
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('product_message', 'market_research_price'); ?></span><? echo $form->textField($model,'market_research_price'); ?>
			</div>
			<div class="grid-m2"></div>
			<div class="grid-c2">
				<span class="input_label"><? echo Yii::t('product_message', 'yahoo_produce'); ?></span><? echo $form->textField($model,'yahoo_produce'); ?>
			</div>
			<br style="clear:both" />
			
		</div>
		
		<? if ($action == 'update') {?>
			<input class="searchBtn" type="submit" name="action" value="Update" />
		<? } else {?>
			<input class="searchBtn" type="submit" name="action" value="Add" />
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
