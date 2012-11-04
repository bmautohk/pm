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
	
// Search by crtieria
	public function createCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria();

		/* if (!empty($this->keyword)) {
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
		else { */
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
		//}
		
		$criteria->order = 'create_date desc, no_jp, id';

		return $criteria;
	}
	
// Search by keyword
	public function searchByKeywordCrtiera($pages, $itemCount)
	{
		// Set page count
		$keywords = $this->getKeywords();
		
		$sql = $this->createKeywordCriteria($keywords);
		//$sql .= ' ORDER BY create_date desc, no_jp, id LIMIT '.$pages->pageSize.' OFFSET '.($pages->pageSize * $pages->getCurrentPage(false));
		
		$conn = Yii::app()->db;
		$command = $conn->createCommand($sql);
		$i = 0;
		foreach ($keywords as $keyword) {
			$command->bindValue(":keyword_$i", '%'.$keyword.'%', PDO::PARAM_STR);
			$i++;
		}
		
		$data = array();
		$dataReader = $command->query();
		foreach ($dataReader as $row) {
			$product = new ProductMaster();
			$product->id = $row['id'];
			$product->no_jp = $row['no_jp'];
			$product->prod_sn = $row['prod_sn'];
			$product->made = $row['made'];
			$product->model = $row['model'];
			$product->pcs = $row['pcs'];
			$product->product_desc = $row['product_desc'];
			$product->product_desc_ch = $row['product_desc_ch'];
			$product->accessory_remark = $row['accessory_remark'];
			$data[] = $product;
		}
		
		return $data;
	}
	
	public function searchByKeywordItemCount() {
		$keywords = $this->getKeywords();
		
		$sql = $this->createKeywordCriteria($keywords);
		$sql = 'SELECT count(1) cnt FROM ('.$sql.') tmp2 ';
		
		$conn = Yii::app()->db;
		$command = $conn->createCommand($sql);
		$i = 0;
		foreach ($keywords as $keyword) {
			$command->bindValue(":keyword_$i", '%'.$keyword.'%', PDO::PARAM_STR);
			$i++;
		}
		
		$dataReader = $command->query();
		//$row = $dataReader->current();
		foreach ($dataReader as $row) {
			$itemCount = $row['cnt'];
		}
		
		return $itemCount;
	}
	
	private function getKeywords() {
		$keywords = explode(' ', $this->keyword);
		
		$newKeywords = array();
		foreach ($keywords as $keyword) {
			$keyword = trim($keyword);
			if (empty($keyword)) {
				// SKip empty keyword
				continue;
			}
			
			$newKeywords[] = $keyword;
		}
		
		return $newKeywords;
	}
	
	private function createKeywordCriteria($keywords) {
		$sql = '';
		$i = 0;
		$isAddUnion = false;
		foreach ($keywords as $keyword) {	
			if ($isAddUnion) {
				$sql .= ' union all ';
			}
			else {
				$isAddUnion = true;
			}
				
			$sql .= "SELECT id, no_jp, prod_sn, made, model, pcs, product_desc, product_desc_ch, accessory_remark, create_date
			FROM product_master
			WHERE customer like :keyword_$i
			OR prod_sn like :keyword_$i
			OR no_jp like :keyword_$i
			OR factory_no like :keyword_$i
			OR made like :keyword_$i
			OR model like :keyword_$i
			OR model_no like :keyword_$i
			OR year like :keyword_$i
			OR item_group like :keyword_$i
			OR material like :keyword_$i
			OR product_desc like :keyword_$i
			OR product_desc_ch like :keyword_$i
			OR product_desc_jp like :keyword_$i
			OR colour like :keyword_$i
			OR colour_no like :keyword_$i
			OR supplier like :keyword_$i
			OR pack_remark like :keyword_$i
			OR progress like :keyword_$i
			OR person_in_charge like :keyword_$i
			OR state like :keyword_$i
			OR yahoo_produce like :keyword_$i
			OR accessory_remark like :keyword_$i
			OR company_remark like :keyword_$i
			";
				
			$i++;
		}
		
		$sql = 'SELECT *
		FROM ('.$sql.') tmp
		GROUP BY id, no_jp, prod_sn, made, model, pcs, product_desc, product_desc_ch, accessory_remark, create_date ';
		
		if (sizeof($keywords) > 1) {
			$sql .= ' HAVING COUNT(id) > 1';
		}
		
		return $sql;
	}
}