<? 
$writePermission = GlobalFunction::checkPagePrivilege('customer_management', RolePageMatrix::PERMISSION_WRITE);
$baseUrl = Yii::app()->request->baseUrl;
$custGroupOptions = CustGroup::getDropDownFromCache();
$custGroupOptions[''] = '';
?>

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
		
		<? if ($writePermission) {?>
	 	<div>
	 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('customer/import') ?>'" value="<? echo Yii::t('customer_message', 'import_customer'); ?>" />
	 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('customer/export') ?>'" value="<? echo Yii::t('customer_message', 'export_customer'); ?>" /><br />
	 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('customer/add') ?>'" value="<? echo Yii::t('customer_message', 'add_customer'); ?>" />
	 	</div>
	 	<br />
	 	<? }?>
	 	
	 	<? 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'keywordForm',
			'action'=>Yii::app()->createUrl('customer/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>
			<? echo $form->textField($model,'keyword', array('size'=>'100', 'placeholder'=>'Enter Keyword')); ?><input type="submit" id="search_by_keyword" value="<? echo Yii::t('common_message', 'search'); ?>">
		<? $this->endWidget(); ?>
		
		<br>
	 	
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
					<span class="input_label_s"><? echo Yii::t('customer_message', 'id'); ?></span><span class="input_field"><? echo $form->textField($model, 'id'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'contact_person'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_person'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'cust_group'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'cust_group', $custGroupOptions); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'where_to_find'); ?></span><span class="input_field"><? echo $form->textField($model, 'where_to_find'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2" style="height:100px">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'cust_type'); ?></span><span class="input_field"><?  echo $form->dropDownList($model, 'cust_type', CustType::getDropDownFromCache(), array('multiple'=>true, 'style'=>'height:100px')); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'tel'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'fax'); ?></span><span class="input_field"><? echo $form->textField($model, 'fax'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'tel2'); ?></span><span class="input_field"><? echo $form->textField($model, 'tel2'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'mobile_no'); ?></span><span class="input_field"><? echo $form->textField($model, 'mobile_no'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'email'); ?></span><span class="input_field"><? echo $form->textField($model, 'email'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'mobile_no2'); ?></span><span class="input_field"><? echo $form->textField($model, 'mobile_no2'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'other_contact'); ?></span><span class="input_field"><? echo $form->textField($model, 'other_contact'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'website'); ?></span><span class="input_field"><? echo $form->textField($model, 'website'); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'address'); ?></span><span class="input_field"><? echo $form->textField($model, 'address'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'vip'); ?></span><span class="input_field"><? echo $form->dropDownList($model, 'vip', array(''=>'', '1'=>'Yes', '0'=>'No')); ?></span>
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'address2'); ?></span><span class="input_field"><? echo $form->textField($model, 'address2'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s"><? echo Yii::t('customer_message', 'remark'); ?></span><span class="input_field"><? echo $form->textField($model, 'remark'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s" style="width:130px"><? echo Yii::t('customer_message', 'contact_salesman'); ?></span><span class="input_field"><? echo $form->textField($model, 'contact_salesman'); ?></span>
				</div>
				<div class="grid_s-m2"></div>
				<div class="grid_s-c2">
					
				</div>
				
				<div class="grid_s-c1">
					<span class="input_label_s" style="width:130px"><? echo Yii::t('customer_message', 'salesman_remark'); ?></span><span class="input_field"><? echo $form->textField($model, 'salesman_remark'); ?></span>
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
			<? echo $form->hiddenField($model,'keyword'); ?>
			<? echo $form->hiddenField($model,'name'); ?>
			<? echo $form->hiddenField($model,'id'); ?>
			<? echo $form->hiddenField($model,'fax'); ?>
			<? echo $form->hiddenField($model,'address'); ?>
			<? echo $form->hiddenField($model,'address2'); ?>
			<? echo $form->hiddenField($model,'email'); ?>
			<? echo $form->hiddenField($model,'cust_group'); ?>
			<? 
			if ($model->cust_type != NULL) {
				foreach ($model->cust_type as $key=>$val) {
					echo $form->hiddenField($model,'cust_type['.$key.']'); 
				}
			}
			?>
			<? echo $form->hiddenField($model,'where_to_find'); ?>
			<? echo $form->hiddenField($model,'where_to_find_detail'); ?>
			<? echo $form->hiddenField($model,'tel'); ?>
			<? echo $form->hiddenField($model,'tel2'); ?>
			<? echo $form->hiddenField($model,'mobile_no'); ?>
			<? echo $form->hiddenField($model,'mobile_no2'); ?>
			<? echo $form->hiddenField($model,'contact_person'); ?>
			<? echo $form->hiddenField($model,'contact_salesman'); ?>
			<? echo $form->hiddenField($model,'other_contact'); ?>
			<? echo $form->hiddenField($model,'website'); ?>
			<? echo $form->hiddenField($model,'vip'); ?>
			<? echo $form->hiddenField($model,'remark'); ?>
			<? echo $form->hiddenField($model,'salesman_remark'); ?>
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
	$('#searchForm select').val('');
}
</script>