<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<? $baseUrl = Yii::app()->request->baseUrl;

// Get selected made
$session=new CHttpSession;
$session->open();

if (isset($session["SELECTED_MADE"])) {
	$selectedMade = $session[GlobalConstants::SESSION_SELECTED_MADE];
}
else {
	$selectedMade = "TOYOTA";
}

$session->close();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?=$baseUrl ?>/css/css.css" />
	<link rel="stylesheet" type="text/css" href="<?=$baseUrl ?>/css/style2.css" />
	
	<? Yii::app()->clientScript->registerCoreScript('jquery');?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style="position: relative;background-color:;width:100%;">
	<div id="wrapper">
		<div id="header_main"> 
			<div id="welcome_msg">Welcome <?=Yii::app()->user->name ?></div>
			<div id="name_main">BM AUTO ACCESSORIES (HK) CO. LTD.</div>
		</div>

		<div id="body_left_main">
			<div id="logo_main"><a href="<?=$baseUrl ?>/product"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png"/></a></div>
			<a class="<?=($selectedMade=="TOYOTA"?"menubar_selected" : "menubar") ?>" href="<?=$baseUrl ?>/product?made=TOYOTA">TOYOTA</a>
			<a class="<?=($selectedMade=="HONDA"?"menubar_selected" : "menubar") ?>" href="<?=$baseUrl ?>/product?made=HONDA">HONDA</a>
			<a class="<?=($selectedMade=="SUZUKI"?"menubar_selected" : "menubar") ?>" href="<?=$baseUrl ?>/product?made=SUZUKI">SUZUKI</a>
			<a class="<?=($selectedMade=="MITSUBISHI"?"menubar_selected" : "menubar") ?>" href="<?=$baseUrl ?>/product?made=MITSUBISHI">MITSUBISHI</a>
		</div>
		<div id="body_right_main">
			<?php echo $content; ?>
		</div>
	</div>
</body>
</html>
