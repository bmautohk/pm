<?
if (!Yii::app()->user->isGuest) {
	// User has not logged in yet, return to login page
	$this->redirect(Yii::app()->createUrl('product'));
} 
?>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action'=>Yii::app()->request->baseUrl.'/site/login',
	'enableAjaxValidation'=>false,
)); ?>
	<div id="loginform">
		<? echo CHtml::error($model,'password', array('class'=>'errorMsg', 'style'=>'width:200px; margin-left:auto; margin-right:auto')); ?>
	
		<label id="username_l">Username</label><?php echo $form->textField($model,'username'); ?><br />
		
		<label id="password_l">Password</label><?php echo $form->passwordField($model,'password'); ?><br />
		
		<input type="submit" id="submit" value="Submit"/>
		<?php echo $form->checkBox($model,'rememberMe'); ?>Remember me
	</div>
<?php $this->endWidget(); ?>
