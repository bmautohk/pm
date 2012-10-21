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
			$keywords = explode(' ', $this->keyword);
			
			foreach ($keywords as $keyword) {
				$keyword = trim($keyword);
				if (empty($keyword)) {
					// SKip empty keyword
					continue;
				}
				
				$criteriaTmp = new CDbCriteria();
				$criteriaTmp->compare('customer', $keyword, true, 'OR');
				$criteriaTmp->compare('prod_sn', $keyword, true, 'OR');
				$criteriaTmp->compare('no_jp', $keyword, true, 'OR');
				$criteriaTmp->compare('factory_no', $keyword, true, 'OR');
				$criteriaTmp->compare('made', $keyword, true, 'OR');
				$criteriaTmp->compare('model', $keyword, true, 'OR');
				$criteriaTmp->compare('model_no', $keyword, true, 'OR');
				$criteriaTmp->compare('year', $keyword, true, 'OR');
				$criteriaTmp->compare('item_group', $keyword, true, 'OR');
				$criteriaTmp->compare('material', $keyword, true, 'OR');
				$criteriaTmp->compare('product_desc', $keyword, true, 'OR');
				$criteriaTmp->compare('product_desc_ch', $keyword, true, 'OR');
				$criteriaTmp->compare('product_desc_jp', $keyword, true, 'OR');
				$criteriaTmp->compare('colour', $keyword, true, 'OR');
				$criteriaTmp->compare('colour_no', $keyword, true, 'OR');
				$criteriaTmp->compare('supplier', $keyword, true, 'OR');
				$criteriaTmp->compare('pack_remark', $keyword, true, 'OR');
				$criteriaTmp->compare('progress', $keyword, true, 'OR');
				$criteriaTmp->compare('person_in_charge', $keyword, true, 'OR');
				$criteriaTmp->compare('state', $keyword, true, 'OR');
				$criteriaTmp->compare('yahoo_produce', $keyword, true, 'OR');
				$criteriaTmp->compare('accessory_remark', $keyword, true, 'OR');
				$criteriaTmp->compare('company_remark', $keyword, true, 'OR');
				$criteria->mergeWith($criteriaTmp);
			}
		}
		else {
			$criteria->compare('colour_no', trim($this->colour), true, 'OR');
			
			$criteria->compare('made', trim($this->made));
			
			$criteria->compare('customer', trim($this->customer), true);
			$criteria->compare('no_jp', trim($this->no_jp), true);
			$criteria->compare('factory_no',trim($this->factory_no), true);
			$criteria->compare('model', trim($this->model), true);
			$criteria->compare('model_no', trim($this->model_no), true);
			
			// Advance
			$criteria->compare('year', trim($this->year), true);
			$criteria->compare('item_group', trim($this->item_group), true);
			$criteria->compare('material', trim($this->material), true);
			
			$criteria->compare('pcs', '>='.$this->pcsFrom);
			$criteria->compare('pcs', '<='.$this->pcsTo);
			
			$criteria->compare('supplier', trim($this->supplier), true);
			
			$criteria->compare('molding', '>='.$this->moldingFrom);
			$criteria->compare('molding', '<='.$this->moldingTo);
			
			$criteria->compare('kaito', '>='.$this->kaitoFrom);
			$criteria->compare('kaito', '<='.$this->kaitoTo);
		}
		
		$criteria->order = 'create_date desc, no_jp, id';

		return $criteria;
	}
}