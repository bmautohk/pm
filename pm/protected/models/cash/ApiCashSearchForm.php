<?php
class ApiCashSearchForm extends CFormModel {
	public $page;
	public $page_size = 10;
	public $userid;
	
	public function rules() {
		return array(
				array('page, page_size', 'safe'),
				array('userid', 'required'),
		);
	}
	
	public function search() {
		$criteria = new CDbCriteria();
		$criteria->compare('is_active', 'Y');
		$criteria->compare('created_by', strtolower($this->userid));
		$criteria->order = 'id desc';
		
		if ($this->page != NULL) {
			$pages = new CPagination();
			$pages->pageSize = $this->page_size;
			$pages->setCurrentPage($this->page < 0 ? 0 : $this->page);
			
			$dataProvider = new CActiveDataProvider(Cash, array(
					'criteria'=>$criteria,
					'pagination'=>$pages,
			));
			
			$data = $dataProvider->getData();
		} else {
			$data = Cash::model()->findAll($criteria);
		}
			
		$imgDir = Yii::app()->params['cash_image_url'];
		
		$result = array();
		foreach($data as $cash) {
			$vo = new CashVO();
			$vo->convertFromModel($cash);
			$vo->setImageURL($imgDir);
			$result[] = $vo;
		}
		
		return $result;
	}

	public function searchByCashId($id, $userId) {
		$cash = Cash::model()->findByAttributes(array('id'=>$id, 'is_active'=>'Y', 'created_by'=>$userId));

		if ($cash != NULL) {
			$vo = new CashDetailVO();
			$vo->convertFromModel($cash);

			$imgDir = Yii::app()->params['cash_image_url'];
			$vo->setImageURL($imgDir);

			$imgDir = Yii::app()->params['cash_thumbnail_url'];
			$vo->setThumbnailURL($imgDir);
			
			return $vo;
		} else {
			return NULL;
		}
	}
}