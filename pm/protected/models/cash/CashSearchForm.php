<?php
class CashSearchForm extends CFormModel {
	public $itemCount;
	
	public $pay_from;
	public $pay_to;
	public $account;
	public $desc;
	public $remark;
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('pay_from, pay_to, account, desc, remark', 'safe'),
		);
	}

	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL)
	{
		return new CActiveDataProvider(get_class(new Cash), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria()
	{
		$criteria = new CDbCriteria();
		
		$criteria->compare('pay_from', trim($this->pay_from), true);
		$criteria->compare('pay_to', trim($this->pay_to), true);
		$criteria->compare('account', trim($this->account), true);
		$criteria->compare('`desc`', trim($this->desc), true);
		$criteria->compare('remark', trim($this->remark), true);
		$criteria->compare('is_active', 'Y');
		
		$criteria->order = 'id desc';
		
		return $criteria;
	}

	public function deleteById($id) {
		$model = Cash::model()->findByPk($id);
		$model->is_active = 'N';
		$model->save();
	}
}