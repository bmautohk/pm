 <div id="rightmain">
 
 	<div class="rightmain_content">
 		<? $this->widget('ResultMessage', array('msg'=>$msg)); ?>
 		
		<? $this->widget('ProductSearchCriteria', array('searchForm'=>$model, 'isShowDownloadButton'=>true)); ?>
		
		<div id="pagingDiv">
		<? 
			$session=new CHttpSession;
			$session->open();
			$displayFormat = $session[GlobalConstants::SESSION_DISPLAY_FORMAT];
			
			if ($displayFormat == GlobalConstants::DISPLAY_FORMAT_EXCEL) {
				include('productPagingExcel.php');
			}
			else {?>
				
				<? include('productPaging.php'); ?>
				
			<? } ?>
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
				
				<? echo $form->hiddenField($model,'produceStatus'); ?>
				<? echo $form->hiddenField($model,'isSearchNotFinish'); ?>
		<? $this->endWidget(); ?>
	</div>
</div>

<script type="text/javascript">
function goUpdate(id) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/product/update');
	$('#criteriaForm #id').val(id);
	$('#page').val($('#currPage').val());
	$('#criteriaForm').submit();
}

function goToPage(page) {
	$('#criteriaForm').attr('action', '<? echo Yii::app()->request->baseUrl; ?>/product/searchByFilter');
	$('#page').attr('value', page);
	$('#criteriaForm').submit();
}
</script>