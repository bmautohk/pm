<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<? 
// Verify the user
if (Yii::app()->user->isGuest) {
	// User has not logged in yet, return to login page
	$this->redirect(Yii::app()->homeUrl);
}

$baseUrl = Yii::app()->request->baseUrl;
$mades =  Made::getDropDownFromCache();

$displayFormat = GlobalFunction::getDisplayFormat();

$roleMatrix = Yii::app()->user->getState('role_matrix');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?=$baseUrl ?>/css/css.css" />
	<link rel="stylesheet" type="text/css" href="<?=$baseUrl ?>/css/style2.css" />
	
	<? Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<? Yii::app()->clientScript->registerCoreScript('jquery-ui'); ?>

	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
</head>

<body>
	<div id="wrapper">
		<div id="header_main"> 
			<div id="welcome_msg">Welcome <?=Yii::app()->user->name ?> <a href="<?=$baseUrl ?>/site/logout" style="color:white; text-decoration:underline">(Logout)</a></div>
			<div id="name_main">Superior Auto Accessories Co LTD</div>
		</div>

		<div id="body_left_main">
			<div id="logo_main"><a href="<?=$baseUrl ?>/product"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png"/></a></div>
			
			<? if (GlobalFunction::checkPagePrivilege('product_management')) {
				if ($displayFormat == GlobalConstants::DISPLAY_FORMAT_EXCEL) {?>
					<a class="menubar" href="<?=$baseUrl ?>/product/changeDisplayFormat">Show Grid Format</a>
				<? } else {?>
					<a class="menubar" href="<?=$baseUrl ?>/product/changeDisplayFormat">Show Excel Format</a>
				<? } ?>
			 
				<a class="menubar" href="<?=$baseUrl ?>/product/showNotFinishItem">Show Not Finish Item</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('customer_management')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/customer">Customer Management</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('supplier_management')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/supplier">Supplier Management</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('order_management')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/order">Order Management</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('user_management')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/user">User Management</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('role_management')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/role">Role Management</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('role_matrix')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/roleMatrix">Role Matrix</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('product_change_log')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/productChangeLog">Product Change Log</a>
			<? } ?>
			
			<? if (GlobalFunction::checkPagePrivilege('email_management')) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/email/list">Email Management</a>
			<? } ?>
			
		</div>
		<div id="body_right_main">
			<?php echo $content; ?>
		</div>
		<div style="height:100px; float:right; width: 1024px;"></div>
	</div>
</body>
</html>
