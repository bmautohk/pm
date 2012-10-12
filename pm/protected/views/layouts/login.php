<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<? 
if (Yii::app()->user->getState('role') == 'USER') {
	// User has not logged in yet, return to login page
	$this->redirect(Yii::app()->baseUrl.'/product');
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<!-- link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" /-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<!-- link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style2.css" />

	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
</head>

<body style="position: relative;background-color:black;width:100%;background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/bg.jpg');">

<div>
	<div id="header"></div>
	<div id="name">BM AUTO ACCESSORIES (HK) CO. LTD.</div>
	<div id="logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png"/></div>

	<div id="login">
		<?php echo $content; ?>
	</div>
</div>

</body>
</html>
