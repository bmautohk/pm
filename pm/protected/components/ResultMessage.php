<?php
Yii::import('zii.widgets.CPortlet');

class ResultMessage extends CPortlet
{
	public $msg;

	protected function renderContent()
	{
		$this->render('resultMessage');
	}
}
?>