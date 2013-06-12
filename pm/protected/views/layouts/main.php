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
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?=$baseUrl ?>/css/css.css" />
	<link rel="stylesheet" type="text/css" href="<?=$baseUrl ?>/css/style2.css" />
	
	<? Yii::app()->clientScript->registerCoreScript('jquery');?>

	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
</head>

<body>
	<div id="wrapper">
		<div id="header_main"> 
			<div id="welcome_msg">Welcome <?=Yii::app()->user->name ?> <a href="<?=$baseUrl ?>/site/logout" style="color:white; text-decoration:underline">(Logout)</a></div>
			<div id="name_main">BM AUTO ACCESSORIES (HK) CO. LTD.</div>
		</div>

		<div id="body_left_main">
			<div id="logo_main"><a href="<?=$baseUrl ?>/product"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png"/></a></div>
			<? if ($displayFormat == GlobalConstants::DISPLAY_FORMAT_EXCEL) {?>
				<a class="menubar" href="<?=$baseUrl ?>/product/changeDisplayFormat">Show Grid Format</a>
			<? } else {?>
				<a class="menubar" href="<?=$baseUrl ?>/product/changeDisplayFormat">Show Excel Format</a>
			<? } ?>
			<? foreach ($mades as $made) {?>
				<a class="menubar" href="<?=$baseUrl ?>/product/searchByFilter?ProductSearchForm%5Bmade%5D=<?=$made ?>"><?=$made ?></a>
			<? } ?>
			<a class="menubar" href="<?=$baseUrl ?>/product/showNotFinishItem">Show Not Finish Item</a>
			<? if (GlobalFunction::isAdmin()) { ?>
				<a class="menubar" href="<?=$baseUrl ?>/customer">Customer Management</a>
				<a class="menubar" href="<?=$baseUrl ?>/supplier">Supplier Management</a>
				<a class="menubar" href="<?=$baseUrl ?>/user">User Management</a>
				<a class="menubar" href="<?=$baseUrl ?>/role">Role Management</a>
				<a class="menubar" href="<?=$baseUrl ?>/roleMatrix">Role Matrix</a>
			<? } ?>
		</div>
		<div id="body_right_main">
			<?php echo $content; ?>
		</div>
		<div style="height:100px; float:right; width: 1024px;"></div>
	</div>
</body>
</html>
