<?php
class CashDetailVO {
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
	public $invoice_image;
	public $payment_image;
	public $created_by;
	public $created_date;
	public $image_url;
	public $invoice_image_url;
	public $payment_image_url;
	public $thumbnail_url;
	public $invoice_thumbnail_url;
	public $payment_thumbnail_url;
	
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
		$this->invoice_image = $model->invoice_image;
		$this->payment_image = $model->payment_image;
		$this->created_by = $model->created_by;
		$this->created_date = date('Y-m-d', strtotime($model->created_date));
	}
	
	public function setImageURL($url) {
		if (!empty($this->image_name)) {
			$this->image_url = $url.$this->image_name;
		}

		if (!empty($this->invoice_image)) {
			$this->invoice_image_url = $url.$this->invoice_image;
		}

		if (!empty($this->payment_image)) {
			$this->payment_image_url = $url.$this->payment_image;
		}
	}

	public function setThumbnailURL($url) {
		if (!empty($this->image_name)) {
			$this->thumbnail_url = $url.$this->image_name;
		}

		if (!empty($this->invoice_image)) {
			$this->invoice_thumbnail_url = $url.$this->invoice_image;
		}

		if (!empty($this->payment_image)) {
			$this->payment_thumbnail_url = $url.$this->payment_image;
		}
	}
}
