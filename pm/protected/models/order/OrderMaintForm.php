<?php
class OrderMaintForm extends CFormModel {

	public $order;
	
	public $orderDetails;
	
	public function rules() {
		return array(
			array('order_id, order, orderDetails', 'safe')
		);
	}
	
	public function retrieve($order_id) {
		// Retrieve order
		$this->order = Order::model()->findByPk($order_id);
		
		$criteria = new CDbCriteria();
		$criteria->compare('order_id', $order_id);
		$criteria->with = 'productMaster';
		$model = OrderDetail::model();
		$model->setDbCriteria($criteria);
		$this->orderDetails = $model->findAll();
	}
}