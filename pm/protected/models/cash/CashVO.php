<?php
class CashVO {
	public $id;
	public $pay_from;
	public $pay_to;
	public $account;
	public $desc;
	public $rmb;
	public $hkd;
	public $jpy;
	public $remark;
	public $image_name;
	public $created_by;
	public $created_date;
	public $image_url;
	
	public function convertFromModel($model) {
		$this->id = $model->id;
		$this->pay_from = $model->pay_from;
		$this->pay_to = $model->pay_to;
		$this->account = $model->account;
		$this->desc = $model->desc;
		$this->rmb = $model->rmb;
		$this->hkd = $model->hkd;
		$this->jpy = $model->jpy;
		$this->remark = $model->remark;
		$this->image_name = $model->image_name;
		$this->created_by = $model->created_by;
		$this->created_date = date('Y-m-d', strtotime($model->created_date));
	}
	
	public function setImageURL($imagePath) {
		if (!empty($this->image_name)) {
			$this->image_url = $imagePath.$this->image_name;
		}
	}
}
