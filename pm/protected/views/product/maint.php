<style>
	.ui-menu .ui-menu-item a {font-size: 0.4em; }

	[type="checkbox"] {
		height:24px;
	}

	.shop_list {
		background-color: #e6e7e9;
		margin-right: 20px;
	}

	.shop_list input[type="checkbox"] {
		height: auto;
	}
</style>
<?
$tableName = 'product_master';
$roleMatrix = Yii::app()->user->getState('role_matrix');


function textField($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
	
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
	echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="input_field">';
		echo $form->textField($model, $attribute, $htmlOptions);
	} else {
	echo '<span class="input_label"></span><span class="input_field">';
		echo '<input type="text"/>';
	}
	echo '</span>';
}

/*function textField($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
        if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
                echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="input_field">'.$form->textField($model, $attribute, $htmlOptions).'</span>';
        }
}*/

function textArea($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
	
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
	echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span>';
		echo $form->textArea($model, $attribute);
	} else {
	echo '<span class="input_label"></span><span>';
		echo "<textarea></textarea>";
	}
	echo '</span>';
}
/*
function textArea($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
		echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span>'.$form->textArea($model, $attribute).'</span>';
	}
}*/

function datePicker($form, $model, $attribute, $roleMatrix, $tableName, $columnName) {
	
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
	echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="date_field">';
		echo $form->textField($model, $attribute);
	} else {
	echo '<span class="input_label"></span><span class="date_field">';
		echo '<input type="text"/>';
	}
	echo '</span><input type="button" class="calendar_button" id="'.$attribute.'_btn" value=" " />';
}
/*
function datePicker($form, $model, $attribute, $roleMatrix, $tableName, $columnName) {
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
		echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="date_field">'.$form->textField($model, $attribute).'</span><input type="button" class="calendar_button" id="'.$attribute.'_btn" value=" " />';
	}
}*/

function dropDownList($form, $model, $attribute, $options, $roleMatrix, $tableName, $columnName) {
	
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
	echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span>';
		echo $form->dropDownList($model, $attribute, $options);
	} else {
	echo '<span class="input_label"></span>';
		echo '<select> </select>';
	}
}
/*
function dropDownList($form, $model, $attribute, $options, $roleMatrix, $tableName, $columnName) {
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
		echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span>'.$form->dropDownList($model, $attribute, $options);
	}
}*/

function checkbox($form, $model, $attribute, $roleMatrix, $tableName, $columnName) {
	
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
		echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span>';
		echo $form->checkbox($model, $attribute);
	}
}

function shopCheckboxList($form, $model, $roleMatrix, $tableName, $columnName) {
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
		echo $form->checkBoxList($model, 'shopList',
				array('AUCTION'=>'AUCTION', 'SHOPPING'=>'SHOPPING','RAKUTEN'=>'RAKUTEN', 'AMAZON'=>'AMAZON', 'OWN WEB'=>'OWN WEB', 'FACEBOOK'=>'FACEBOOK', 'IG'=>'IG', 'EBAY'=>'EBAY'),
				array('template'=>'<span class="shop_list">{label}{input}</span>', 'separator'=>''));
	}
}

function listbox($form, $model, $attribute, $data, $options, $roleMatrix, $tableName, $columnName) {
	
	if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
		echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span>';
		echo $form->listbox($model, $attribute, $data, $options);
	}
}
?>

<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jscal2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lang/en.js"></script>

<div class="rightmain_content">

	<? $this->widget('ProductSearchCriteria', array('searchForm'=>new ProductSearchForm())); ?>

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
		<input type="hidden" name="act" id="act" value="update" />
		<div class="grid_u">
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'customer', $roleMatrix, $tableName, 'customer'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'prod_sn', $roleMatrix, $tableName, 'prod_sn', array('readonly'=>true)); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo dropDownList($form, $model, 'status', array('A'=>'Active', 'I'=>'Inactive'), $roleMatrix, $tableName, 'status'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'no_jp', $roleMatrix, $tableName, 'no_jp'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'factory_no', $roleMatrix, $tableName, 'factory_no'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'made', $roleMatrix, $tableName, 'made'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'model', $roleMatrix, $tableName, 'model'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'model_no', $roleMatrix, $tableName, 'model_no'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'year', $roleMatrix, $tableName, 'year'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'item_group', $roleMatrix, $tableName, 'item_group'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'material', $roleMatrix, $tableName, 'material'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'product_desc', $roleMatrix, $tableName, 'product_desc'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'product_desc_ch', $roleMatrix, $tableName, 'product_desc_ch'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'product_desc_jp', $roleMatrix, $tableName, 'product_desc_jp'); ?>
			</div>
			
			<div class="grid_u-c1-textarea">
				<? echo textArea($form, $model, 'accessory_remark', $roleMatrix, $tableName, 'accessory_remark'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c1-textarea">
				<? echo textArea($form, $model, 'company_remark', $roleMatrix, $tableName, 'company_remark'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'pcs', $roleMatrix, $tableName, 'pcs'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'colour', $roleMatrix, $tableName, 'colour'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'colour_no', $roleMatrix, $tableName, 'colour_no'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'supplier', $roleMatrix, $tableName, 'supplier'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'molding', $roleMatrix, $tableName, 'molding'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'moq', $roleMatrix, $tableName, 'moq'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'cost', $roleMatrix, $tableName, 'cost'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'kaito', $roleMatrix, $tableName, 'kaito'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'other', $roleMatrix, $tableName, 'other'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'purchase_cost', $roleMatrix, $tableName, 'purchase_cost'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'business_price', $roleMatrix, $tableName, 'business_price'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'auction_price', $roleMatrix, $tableName, 'auction_price'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'kaito_price', $roleMatrix, $tableName, 'kaito_price'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				
			</div>
			
			<div class="grid_u-c1">
				<? echo datePicker($form, $model, 'buy_date', $roleMatrix, $tableName, 'buy_date'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo datePicker($form, $model, 'receive_date', $roleMatrix, $tableName, 'receive_date'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo datePicker($form, $model, 'factory_date', $roleMatrix, $tableName, 'factory_date'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'pack_remark', $roleMatrix, $tableName, 'pack_remark'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo datePicker($form, $model, 'order_date', $roleMatrix, $tableName, 'order_date'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'progress', $roleMatrix, $tableName, 'progress'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo datePicker($form, $model, 'receive_model_date', $roleMatrix, $tableName, 'receive_model_date'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'person_in_charge', $roleMatrix, $tableName, 'person_in_charge'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'state', $roleMatrix, $tableName, 'state'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo datePicker($form, $model, 'ship_date', $roleMatrix, $tableName, 'ship_date'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'market_research_price', $roleMatrix, $tableName, 'market_research_price'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'yahoo_produce', $roleMatrix, $tableName, 'yahoo_produce'); ?>
			</div>
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'packing_size_d', $roleMatrix, $tableName, 'packing_size_d'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'packing_size_w', $roleMatrix, $tableName, 'packing_size_w'); ?>
			
			</div>
			
			
			<div class="grid_u-c1">
				<? echo textField($form, $model, 'packing_size_h', $roleMatrix, $tableName, 'packing_size_h'); ?>
			
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
				<? echo textField($form, $model, 'gross_weight', $roleMatrix, $tableName, 'gross_weight'); ?>
			</div>

			<div class="grid_u-c1">
				<? echo textField($form, $model, 'safe_stock', $roleMatrix, $tableName, 'safe_stock'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
			</div>
			
			<div class="grid_u-c1" style="height:50px">
				<? echo dropDownList($form, $model, 'produce_status', ProductMaster::getProduceStatusDropdown(), $roleMatrix, $tableName, 'produce_status'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2" style="height:50px">
				<? echo shopCheckboxList($form, $productForm, $roleMatrix, $tableName, 'shop'); ?>
			</div>

			<div class="grid_u-c1">
				<? echo checkbox($form, $model, 'is_retail', $roleMatrix, $tableName, 'is_retail'); ?>
			</div>
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2">
			</div>


			<div class="grid_u-c2" style="height:150px">
				<? echo listbox($form, $productForm, 'categoryIdList', Category::getDropDownFromCache(), array('multiple'=>'multiple', 'size'=>'8'), $roleMatrix, $tableName, 'category_id'); ?>
			</div>
			
			<div class="grid_u-m2"></div>
			<div class="grid_u-c2" style="height:150px">
				<? echo checkbox($form, $model, 'is_monopoly', $roleMatrix, $tableName, 'is_monopoly'); ?>
				<br />
				<? echo checkbox($form, $model, 'is_internal', $roleMatrix, $tableName, 'is_internal'); ?>
				<br />
				<? echo checkbox($form, $model, 'is_exhibit', $roleMatrix, $tableName, 'is_exhibit'); ?>
				<br />
				<? echo checkbox($form, $model, 'is_ship', $roleMatrix, $tableName, 'is_ship'); ?>
			<br style="clear:both" />
			
		</div>
		
		<? if (GlobalFunction::checkPagePrivilege('product_management', RolePageMatrix::PERMISSION_WRITE)) {?>
			<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
		<? } ?>
		<input class="searchBtn" type="button" name="action" value="<? echo Yii::t('common_message', 'back'); ?>" onclick="back()" />
	<? $this->endWidget(); ?>
	
	<!-- Show image -->
	<iframe style="width:100%; height:250px" src="<? echo Yii::app()->request->baseUrl; ?>/product/show_image?prod_sn=<?=$model->prod_sn ?>"></iframe>
	<div style="height:30px"></div>
	<iframe style="width:100%; height:250px" src="<? echo Yii::app()->request->baseUrl; ?>/product/show_internal_image?prod_sn=<?=$model->prod_sn ?>"></iframe>
	
</div>

<div style="height:50px"></div>

<script type="text/javascript">
$(function() {
	if ($('#ProductMaster_buy_date').length > 0) {
		Calendar.setup({
		    inputField : "ProductMaster_buy_date",
		    trigger    : "buy_date_btn",
		    onSelect   : function() { this.hide() }
		});
	}

	if ($('#ProductMaster_receive_date').length > 0) {
		Calendar.setup({
		    inputField : "ProductMaster_receive_date",
		    trigger    : "receive_date_btn",
		    onSelect   : function() { this.hide() }
		});
	}

	if ($('#ProductMaster_factory_date').length > 0) {
		Calendar.setup({
		    inputField : "ProductMaster_factory_date",
		    trigger    : "factory_date_btn",
		    onSelect   : function() { this.hide() }
		});
	}

	if ($('#ProductMaster_order_date').length > 0) {
		Calendar.setup({
		    inputField : "ProductMaster_order_date",
		    trigger    : "order_date_btn",
		    onSelect   : function() { this.hide() }
		});
	}

	if ($('#ProductMaster_receive_model_date').length > 0) {
		Calendar.setup({
		    inputField : "ProductMaster_receive_model_date",
		    trigger    : "receive_model_date_btn",
		    onSelect   : function() { this.hide() }
		});
	}

	if ($('#ProductMaster_ship_date').length > 0) {
		Calendar.setup({
		    inputField : "ProductMaster_ship_date",
		    trigger    : "ship_date_btn",
		    onSelect   : function() { this.hide() }
		});
	}

	$("#ProductMaster_made").autocomplete({
		source: "search_made",
	});

	$("#ProductMaster_model").autocomplete({
		source: "search_model",
	});
});

function back() {
	$('#form1').attr('action', 'back');
	$('#form1').submit();
}
</script>
