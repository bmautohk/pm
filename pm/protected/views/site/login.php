<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action'=>'site/login',
	'enableAjaxValidation'=>false,
)); ?>
	<div id="loginform">
		<label id="username_l">Username</label><?php echo $form->textField($model,'username'); ?><br />
		
		<label id="password_l">Password</label><?php echo $form->passwordField($model,'password'); ?><br />
		
		<input type="submit" id="submit" value="Submit"/>
		<?php echo $form->checkBox($model,'rememberMe'); ?>Remember me
	</div>
<?php $this->endWidget(); ?>

