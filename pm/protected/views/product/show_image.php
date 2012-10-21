<? 
$baseUrl = Yii::app()->baseUrl;
foreach ($images as $image) {
	$splitStr = explode('/', $image);
	$imageName = end($splitStr);
?>
	<div style="float: left; margin-right: 10px;">
		<a href="<?=$baseUrl.'/'.$image ?>" target="_blank"><? echo CHtml::image('../'.$image, '', array('width'=>'160', 'height'=>'130', 'title'=>$imageName)) ?></a>
	</div>
<? } ?>