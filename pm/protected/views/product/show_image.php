<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl ?>/css/style2.css" />

<? 
$baseUrl = Yii::app()->baseUrl;
foreach ($images as $image) {
	$splitStr = explode('/', $image);
	$imageName = end($splitStr);
?>
	<div class="show_product_image">
		<a href="<?=$baseUrl.'/'.$image ?>" target="_blank"><? echo CHtml::image('../'.$image, '', array('width'=>'160', 'height'=>'107', 'title'=>$imageName)) ?></a>
	</div>
<? } ?>