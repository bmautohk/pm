<? if (!isset($items)) {?>

<? } else if ($items == NULL || sizeOf($items) == 0) {?>
	<div class="scroll" id="prod_page">
		No product found!
	</div>
<? } else {


$tableName = 'product_master';
$roleMatrix = Yii::app()->user->getState('role_matrix');

function textField2($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="input_field2">';
        if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
        echo $form->textField($model, $attribute, $htmlOptions);
        }else{
        echo '<input type="text"/>';
        }
echo '</span>';
}

function textField($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="input_field">';
        if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
        echo $form->textField($model, $attribute, $htmlOptions);
        }else{
        echo '<input type="text"/>';
        }
echo '</span>';
}


function textArea($form, $model, $attribute, $roleMatrix, $tableName, $columnName, $htmlOptions=array()) {
         echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span>';
        if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
                echo $form->textArea($model, $attribute,$htmlOptions);
        }else{
        echo "<textarea></textarea>";
        }
        echo '</span>';
}

function datePicker($form, $model, $attribute, $roleMatrix, $tableName, $columnName) {
   echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span><span class="date_field">';
      if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
                echo $form->textField($model, $attribute);
        }else{
        echo '<input type="text"/>';
        }
echo '</span><input type="button" class="calendar_button" id="'.$attribute.'_btn" value=" " />';
}

function dropDownList($form, $model, $attribute, $options, $roleMatrix, $tableName, $columnName) {
        echo '<span class="input_label">'.Yii::t('product_message', $attribute).'</span>';
        if (GlobalFunction::checkPrivilege($roleMatrix, $tableName, $columnName)) {
                echo $form->dropDownList($model, $attribute, $options);
        }else{
                echo '<select> </select>';
        }
}
	$baseUrl = Yii::app()->request->baseUrl;
	$imgDir = Yii::app()->params['image_dir'];
	$internalImgDir = Yii::app()->params['internal_image_dir'];
?>
	<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>
	
	<? $form=$this->beginWidget('CActiveForm', array(
			'id'=>'pagingForm',
			'action'=>Yii::app()->createUrl('product/searchByFilter'),
			'method'=>'GET',
			'enableAjaxValidation'=>false,
		)); ?>

	<div class="scroll" id="prod_page">
		<?
		$i = 0; 
		foreach($items as $product) { ?>
			<div class="grid_p">
				<div class="grid_p-c1" style="border:1px solid #949599;">
					<? $images = glob($imgDir.$product->prod_sn."_*.jpg"); 
					if (!empty($images)) {?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/'.$images[0], '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? } else {
						$images = glob($internalImgDir.$product->prod_sn."_i_*.jpg");
						if (!empty($images)) {
					?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/'.$images[0], '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? } else {?>
						<a class='productdetail' href="javascript:goUpdate(<?=$product->id ?>)"><? echo CHtml::image($baseUrl.'/images/product/no_image.png', '', array('width'=>'160', 'height'=>'130')) ?></a>
					<? }
					} ?>
				</div>
				<div class="grid_p-c1">
					<div class="product_name">
						<?=$product->prod_sn ?><?if ($product->produce_status=="MO") { echo "<font color='red' >[专卖]</font>";} ?>
					</div>
					<? echo textField($form,$product,'made',$roleMatrix,$tableName,'made');?>
					<? echo textField($form,$product,'model',$roleMatrix,$tableName,'model');?>
					<? echo textField($form,$product,'pcs',$roleMatrix,$tableName,'pcs');?>
				</div>
				<div class="grid_p-c3">
					<? echo textField($form,$product,'product_desc',$roleMatrix,$tableName,'product_desc');?>
					<? echo textField2($form,$product,'product_desc_ch',$roleMatrix,$tableName,'product_desc_ch');?><? echo textField($form,$product,'accessory_remark',$roleMatrix,$tableName,'accessory_remark');?>
					<? echo textArea($form, $product, 'company_remark', $roleMatrix, $tableName, 'company_remark',array('style'=>'color:red','cols'=>'23','rows'=>'5')); ?>
					
					<div class="link">
						<input type="button" value="<? echo Yii::t('common_message', 'product_detail'); ?>" onclick="javascript:goUpdate(<?=$product->id ?>)" />
						<? if (GlobalFunction::isAdmin()) { ?>	
							<input type="button" onclick="javascript:goDelete(<?=$product->id ?>, <?=$product->prod_sn ?>)" value="<? echo Yii::t('common_message', 'delete_product'); ?>" />
						<? } ?>
					</div>
				</div>
			</div>
			
			<? if ($i % 2 == 0) {?>
				<div class="grid_p-m1"></div>
			<? 
					$i++;
				}
			else {
				$i = 0;
			}
			?>
		<? }?>
	</div>
	<br />
	<? $this->widget('SimplaPager', array('pages'=>$pages)); ?>
	
	<? $this->endWidget(); ?>
<? } ?>
