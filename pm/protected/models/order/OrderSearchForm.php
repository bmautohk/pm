<?php
class OrderSearchForm extends CFormModel {
	public $itemCount;
	
	public $customer_id;
	
	public function rules() {
		return array(
			array('itemCount, customer_id', 'safe')
		);
	}
	
	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL) {
		return new CActiveDataProvider(get_class(new Order), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria() {
		$criteria = new CDbCriteria();
		$criteria->with = 'customer';
		$criteria->order = 't.id desc';
		
		$criteria->compare('customer_id', $this->customer_id);
		
		return $criteria;
	}
}