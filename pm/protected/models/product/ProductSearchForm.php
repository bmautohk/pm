<?php
class ProductSearchForm extends CFormModel {
	public $itemCount;

	public $keyword;
	public $customer;
	public $no_jp;
	public $factory_no;
	public $made;
	public $model;
	public $model_no;
	
	public $year;
	public $item_group;
	public $colour;
	public $material;
	public $pcsFrom;
	public $pcsTo;
	public $supplier;
	public $moldingFrom;
	public $moldingTo;
	public $kaitoFrom;
	public $kaitoTo;
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('keyword, customer, no_jp, factory_no, made, model, model_no, year, item_group, colour, material, pcsFrom, pcsTo, supplier, moldingFrom, moldingTo, kaitoFrom, kaitoTo, itemCount', 'safe'),
		);
	}
	
	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL)
	{
		return new CActiveDataProvider(get_class(new ProductMaster), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria();

		if (!empty($this->keyword)) {
			$criteria->compare('customer', $this->keyword, true, 'OR');
			$criteria->compare('prod_sn', $this->keyword, true, 'OR');
			$criteria->compare('no_jp', $this->keyword, true, 'OR');
			$criteria->compare('factory_no', $this->keyword, true, 'OR');
			$criteria->compare('model', $this->keyword, true, 'OR');
			$criteria->compare('model_no', $this->keyword, true, 'OR');
			$criteria->compare('year', $this->keyword, true, 'OR');
			$criteria->compare('item_group', $this->keyword, true, 'OR');
			$criteria->compare('material', $this->keyword, true, 'OR');
			$criteria->compare('product_desc', $this->keyword, true, 'OR');
			$criteria->compare('remark', $this->keyword, true, 'OR');
			$criteria->compare('colour', $this->keyword, true, 'OR');
			$criteria->compare('colour_no', $this->keyword, true, 'OR');
			$criteria->compare('supplier', $this->keyword, true, 'OR');
			$criteria->compare('pack_remark', $this->keyword, true, 'OR');
			$criteria->compare('progress', $this->keyword, true, 'OR');
			$criteria->compare('person_in_charge', $this->keyword, true, 'OR');
			$criteria->compare('state', $this->keyword, true, 'OR');
			$criteria->compare('yahoo_produce', $this->keyword, true, 'OR');
		}
		else {
			$criteria->compare('colour', $this->colour, true);
			$criteria->compare('colour_no', $this->colour, true, 'OR');
			
			$criteria->compare('made', $this->made);
			
			$criteria->compare('customer', $this->customer, true);
			$criteria->compare('no_jp', $this->no_jp, true);
			$criteria->compare('factory_no', $this->factory_no, true);
			$criteria->compare('model', $this->model, true);
			$criteria->compare('model_no', $this->model_no, true);
			
			// Advance
			$criteria->compare('year', $this->year, true);
			$criteria->compare('item_group', $this->item_group, true);
			$criteria->compare('material', $this->material, true);
			
			$criteria->compare('pcs', '>='.$this->pcsFrom);
			$criteria->compare('pcs', '<='.$this->pcsTo);
			
			$criteria->compare('supplier', $this->supplier, true);
			
			$criteria->compare('molding', '>='.$this->moldingFrom);
			$criteria->compare('molding', '<='.$this->moldingTo);
			
			$criteria->compare('kaito', '>='.$this->kaitoFrom);
			$criteria->compare('kaito', '<='.$this->kaitoTo);
		}
		
		$criteria->order = 'no_jp, id';

		return $criteria;
	}
}