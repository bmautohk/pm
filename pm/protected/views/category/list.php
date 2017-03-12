<?
$baseUrl = Yii::app()->request->baseUrl;
$writePermission = GlobalFunction::checkPagePrivilege('category_management', RolePageMatrix::PERMISSION_WRITE);
?>
<div id="rightmain">
	<div class="rightmain_content">
		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
		<? echo CHtml::errorSummary($model, '', '', array('class'=>'errorMsg')); ?>
		<br>
		
		<? if ($writePermission) { ?>
		 	<div>
		 		<input type="button" onclick="location.href='<?=Yii::app()->createUrl('category/add') ?>'" value="<? echo Yii::t('category_message', 'add_category'); ?>" />
		 	</div>
	 	<? } ?>
	
		<table class="product-excel-style">
			<tr>
				<th>&nbsp;</th>
				<? if ($writePermission) { ?><th>&nbsp;</th><? } ?>
				<th><? echo Yii::t('category_message', 'name'); ?></th>
			</tr>
		<? foreach($categories as $category) { ?>
			<tr>
				<td><input type="button" value="<? echo Yii::t('common_message', 'detail'); ?>" onclick="location.href='<?=Yii::app()->createUrl('category/update?id='.$category->id) ?>';" /></td>
				<? if ($writePermission) { ?><td><input type="button" value="<? echo Yii::t('common_message', 'delete'); ?>" onclick="javascript:goDelete('<?=$category->id ?>')" /></td><? } ?>
				<td>
					<?
					if ($category->level > 0) {

						for ($i = 0; $i < ($category->level - 1); $i++) {
							echo "　";
						}

						echo "|---";
					}
					?>
					<?=$category->name ?>
				</td>
			</tr>
		<? }?>
		</table>
		
		<div style="height:600px"></div>
	</div>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form1',
		'action'=>$baseUrl.'/category/delete',
		'method'=>'POST',
		'enableAjaxValidation'=>false,
	)); ?>
	
	<? echo $form->hiddenField(new MaintCategoryForm(), 'id'); ?>
	
<? $this->endWidget(); ?>

<script type="text/javascript">
function goDelete(id) {
	if (confirm('Are you sure to delete?')) {
		$('#MaintCategoryForm_id').val(id);
		$('#form1').submit();
	}
}
</script>
