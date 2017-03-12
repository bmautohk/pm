<?
$writePermission = GlobalFunction::checkPagePrivilege('category_management', RolePageMatrix::PERMISSION_WRITE);

?>

<div class="rightmain_content">
	<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
	
	<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
	
	<? if ($action == 'add') {?>
		<div class="page_header">Category Creation</div>
	<? } else {?>
		<div class="page_header">Category Update</div>
	<? } ?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$action,
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
		<? echo $form->hiddenField($model, 'id'); ?>

		<div style="width:400px">
			<div class="grid-c1">
				<span class="input_label"><? echo Yii::t('category_message', 'name'); ?></span>
				<span class="input_field"><? echo $form->textField($model, 'name'); ?></span>
			</div>
			
			<div>
				<span class="input_label"><? echo Yii::t('category_message', 'sub_category'); ?></span>
			</div>

			<div>
				<span class="input_field">
					<table id="tb_sub_cat" class="product-excel-style">
						<tr>
							<th><input id="btn_add_sub_cat" type="button" value="+" /></th>
							<th>Name</th>
						</tr>
						<? foreach ($model->existingSubCategoryList as $category) { ?>
							<tr>
								<td></td>
								<td><?=$category->name ?></td>
							</tr>
						<? } ?>

						<? 
						if (!empty($model->newSubCategoryList)) {
							foreach ($model->newSubCategoryList as $categoryName) { ?>
								<tr>
									<td></td>
									<td><input type="text" name="MaintCategoryForm[newSubCategoryList][]" value="<?=$categoryName ?>" /></td>
								</tr>
						<? 	}
						} ?>
						
					</table>
				</span>
			</div>
			
			
			<br style="clear:both" />
		</div>
		
		<? if ($writePermission) {
			if ($action == 'add') {?>
				<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'add'); ?>" />
			<? } else {?>
				<input class="searchBtn" type="submit" name="action" value="<? echo Yii::t('common_message', 'update'); ?>" />
			<? }
		} ?>
		<input class="searchBtn" type="button" onclick="window.location='../category'" value="<? echo Yii::t('common_message', 'back'); ?>" />
		
	<? $this->endWidget(); ?>
</div>

<div style="height:600px"></div>

<script type="text/javascript">
	$(function() {
		$('#btn_add_sub_cat').click(function() {
			$('#tb_sub_cat tr:last').after('<tr><td></td><td><input type="text" name="MaintCategoryForm[newSubCategoryList][]" /></td></tr>');
		});
	});
</script>
