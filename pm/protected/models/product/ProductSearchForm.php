<?php
class ProductSearchForm extends CFormModel {
	public $itemCount;

	public $keyword;
	
	public $no_jp2;
	public $prod_sn2;
	
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
	public $produceStatus;
	
	public $isSearchNotFinish = 'N';
	public $isSearchNotShip = 'N';
	public $isSearchNotExhibit = 'N';
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('keyword, no_jp2, prod_sn2, customer, no_jp, factory_no, made, model, model_no, year, item_group, colour, material, pcsFrom, pcsTo, supplier, moldingFrom, moldingTo, kaitoFrom, kaitoTo, produceStatus, isSearchNotFinish, isSearchNotShip, isSearchNotExhibit, itemCount', 'safe'),
		);
	}
	
	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL)
	{
		
		$dataProvider = new CActiveDataProvider(get_class(new ProductMasterVO), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
		
		$noJPList = array();
		$produts = array();
		foreach($dataProvider->getData() as $data) {
			if (!empty($data->no_jp)) {
				$products[$data->no_jp] = $data;
				$noJPList[] = $data->no_jp;
			}
		}
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition('no_jp', $noJPList);
		
		$outputVolumes = ProductOutputVolume::model()->findAll($criteria);
		$outputVolumeMap = array();
		foreach ($outputVolumes as $outputVolume) {
			
			if ($outputVolume->source == ProductOutputVolume::SOURCE_S1) {
				$outputVolumeMap[$outputVolume->no_jp][ProductOutputVolume::SOURCE_S1] = $outputVolume;
			} else if ($outputVolume->source == ProductOutputVolume::SOURCE_S1CN) {
				$outputVolumeMap[$outputVolume->no_jp][ProductOutputVolume::SOURCE_S1CN] = $outputVolume;
			}
		}
		
		$result = array();
		foreach($dataProvider->getData() as $data) {
			if (!empty($data->no_jp)) {
				$outputVolumeArray = $outputVolumeMap[$data->no_jp]; 
				
				if (isset($outputVolumeArray[ProductOutputVolume::SOURCE_S1])) {
					$outputVolume = $outputVolumeArray[ProductOutputVolume::SOURCE_S1];
					$data->s1_total_unit = $outputVolume->total_unit;
					$data->s1_unit_1 = $outputVolume->unit_1;
					$data->s1_unit_2 = $outputVolume->unit_2;
				}
				
				if (isset($outputVolumeArray[ProductOutputVolume::SOURCE_S1CN])) {
					$outputVolume = $outputVolumeArray[ProductOutputVolume::SOURCE_S1CN];
					$data->s1cn_total_unit = $outputVolume->total_unit;
					$data->s1cn_unit_1 = $outputVolume->unit_1;
					$data->s1cn_unit_2 = $outputVolume->unit_2;
				}
				
				$result[] = $data;
			} else {
				$result[] = $data;
			}
		}
		
		$dataProvider->setData($result);
		
		return $dataProvider;
		
		/* return new CActiveDataProvider(get_class(new ProductMasterVO), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		)); */
	}
	
// Search by crtieria
	public function createCriteria($isExcelView)
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
		
		$criteria->select = 'id, customer, prod_sn, status, t.no_jp, factory_no, made, model, model_no, year, item_group, material, product_desc, product_desc_ch, product_desc_jp, '.
			'pcs, colour, colour_no, moq, molding, cost, kaito, other, buy_date, receive_date, supplier, purchase_cost, business_price, auction_price, kaito_price, factory_date, '.
			'pack_remark, order_date, progress, receive_model_date, person_in_charge, state, ship_date, market_research_price, yahoo_produce, accessory_remark, company_remark, '.
			'produce_status, is_monopoly, is_ship, is_exhibit, is_retail ';
			//'total_unit as total_unit, unit_1_mth as unit_1_mth, unit_2_week as unit_2_week';
		//$criteria->join = 'left outer join product_output_volume on t.no_jp = product_output_volume.no_jp';
		
		if ($this->isSearchNotFinish == 'Y') {
			$criteria->compare('produce_status', '<>'.GlobalConstants::PRODUCE_STATUS_COMPLETE);
			$criteria->compare('is_monopoly', '<> '.ProductMaster::IS_MONOPOLY_YES);
		} else if ($this->isSearchNotShip == 'Y') {
			$criteria->compare('is_ship', '<> '.ProductMaster::IS_SHIP_YES);
		} else if ($this->isSearchNotExhibit == 'Y') {
			$criteria->compare('is_exhibit', '<> '.ProductMaster::IS_EXHIBIT_YES);
		} else {
			$criteria->compare('no_jp', trim($this->no_jp2));
			$criteria->compare('prod_sn', trim($this->prod_sn2));
			
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
			
			$criteria->compare('produce_status', $this->produceStatus);
		}
		
		// If user is supplier, only search products belonging to this supplier
		if (GlobalFunction::isSupplier()) {
			$criteria->compare('supplier', GlobalFunction::getUserSupplier());
		}
		
		// If user is retailer, only search products which is available for retailer
		if (GlobalFunction::isRetail()) {
			$criteria->compare('is_retail', ProductMaster::IS_RETAIL_YES);
		}
		
		// User does not have right to see internal product, only serach products which is internal
		if (!GlobalFunction::isAllowInternal()) {
			$criteria->compare('is_internal', ProductMaster::IS_INTERNAL_NO);
		}
		
		//echo 'Allow Int?'.GlobalFunction::isAllowInternal();
		
		if (!$isExcelView) {
			//$criteria->order = 'create_date desc, no_jp, id';
			$criteria->order = 'prod_sn desc'; // PM1 & PM3 only
		}
		else {
			// Excel View
			$criteria->order = 'prod_sn desc';
		}

		return $criteria;
	}
	
// Search by keyword
	public function searchByKeywordCrtiera($pages, $isExcelView)
	{
		// Set page count
		$keywords = $this->getKeywords();
		
		$sql = $this->createKeywordCriteria($keywords);
		
		if (!$isExcelView) {
			$sql .= ' ORDER BY create_date desc, no_jp, id ';
		}
		else {
			// Excel View
			$sql .= ' ORDER BY prod_sn desc ';
		}
		
		if ($pages !== NULL) {
			$sql .= ' LIMIT '.$pages->pageSize.' OFFSET '.($pages->pageSize * $pages->getCurrentPage(false));
		}
		
		$conn = Yii::app()->db;
		$command = $conn->createCommand($sql);
		$i = 0;
		foreach ($keywords as $keyword) {
			$command->bindValue(":keyword_$i", '%'.$keyword.'%', PDO::PARAM_STR);
			$i++;
		}
		
		if (GlobalFunction::isSupplier()) {
			$command->bindValue(":supplier", GlobalFunction::getUserSupplier(), PDO::PARAM_STR);
		}
		
		$data = array();
		$dataReader = $command->query();
		foreach ($dataReader as $row) {
			$product = new ProductMasterVO();
			$product->id = $row['id'];
			$product->customer = $row['customer'];
			$product->prod_sn = $row['prod_sn'];
			$product->status = $row['status'];
			$product->no_jp = $row['no_jp'];
			$product->factory_no = $row['factory_no'];
			$product->made = $row['made'];
			$product->model = $row['model'];
			$product->model_no = $row['model_no'];
			$product->year = $row['year'];
			$product->item_group = $row['item_group'];
			$product->material = $row['material'];
			$product->product_desc = $row['product_desc'];
			$product->product_desc_ch = $row['product_desc_ch'];
			$product->product_desc_jp = $row['product_desc_jp'];
			$product->pcs = $row['pcs'];
			$product->colour = $row['colour'];
			$product->colour_no = $row['colour_no'];
			$product->moq = $row['moq'];
			$product->molding = $row['molding'];
			$product->cost = $row['cost'];
			$product->kaito = $row['kaito'];
			$product->other = $row['other'];
			$product->buy_date = $row['buy_date'];
			$product->receive_date = $row['receive_date'];
			$product->supplier = $row['supplier'];
			$product->purchase_cost = $row['purchase_cost'];
			$product->factory_date = $row['factory_date'];
			$product->pack_remark = $row['pack_remark'];
			$product->order_date = $row['order_date'];
			$product->progress = $row['progress'];
			$product->receive_model_date = $row['receive_model_date'];
			$product->person_in_charge = $row['person_in_charge'];
			$product->state = $row['state'];
			$product->ship_date = $row['ship_date'];
			$product->market_research_price = $row['market_research_price'];
			$product->yahoo_produce = $row['yahoo_produce'];
			$product->accessory_remark = $row['accessory_remark'];
			$product->company_remark = $row['company_remark'];
			$product->produce_status = $row['produce_status'];
			$product->is_monopoly = $row['is_monopoly'];
			$product->is_exhibit = $row['is_exhibit'];
			$product->is_ship = $row['is_ship'];
			
			// Get output volume
			$criteria = new CDbCriteria();
			$criteria->compare('no_jp', $product->no_jp);
			$outputVolumes = ProductOutputVolume::model()->findAll($criteria);
			
			foreach ($outputVolumes as $outputVolume) {
				if ($outputVolume->source == ProductOutputVolume::SOURCE_S1) {
					$product->s1_total_unit = $outputVolume->total_unit;
					$product->s1_unit_1 = $outputVolume->unit_1;
					$product->s1_unit_2 = $outputVolume->unit_2;
				} else if ($outputVolume->source == ProductOutputVolume::SOURCE_S1CN) {
					$product->s1cn_total_unit = $outputVolume->total_unit;
					$product->s1cn_unit_1 = $outputVolume->unit_1;
					$product->s1cn_unit_2 = $outputVolume->unit_2;
				}
			}
			
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
		
		if (GlobalFunction::isSupplier()) {
			$command->bindValue(":supplier", GlobalFunction::getUserSupplier(), PDO::PARAM_STR);
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

			//total_unit, unit_1_mth, unit_2_week
			// left outer join product_output_volume on product_master.no_jp = product_output_volume.no_jp
			$sql .= "SELECT id,customer,prod_sn,status,product_master.no_jp,factory_no,made,model,model_no,year,item_group,material,
			product_desc,product_desc_ch,product_desc_jp,pcs,colour,colour_no,moq,molding,cost,kaito,other,buy_date,receive_date,supplier,
			purchase_cost,factory_date,pack_remark,order_date,progress,receive_model_date,person_in_charge,state,ship_date,market_research_price,
			yahoo_produce,accessory_remark,company_remark,produce_status,is_monopoly,is_ship,is_exhibit,is_retail,is_internal,create_date
			
			FROM product_master 
			
			WHERE customer like :keyword_$i
			OR prod_sn like :keyword_$i
			OR product_master.no_jp like :keyword_$i
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
		FROM ('.$sql.') tmp WHERE 1 = 1 ';
		
		// If user is supplier, only search products belonging to this supplier
		if (GlobalFunction::isSupplier()) {
			$sql .= ' AND supplier = :supplier ';
		}
		
		// If user is retailer, only search products which is available for retailer
		if (GlobalFunction::isRetail()) {
			$sql .= ' AND is_retail = '.ProductMaster::IS_RETAIL_YES.' ';
		}
		
		// User does not have right to see internal product
		if (!GlobalFunction::isAllowInternal()) {
			$sql .= ' AND is_internal = '.ProductMaster::IS_INTERNAL_NO.' ';
		}
		
		$sql .= ' GROUP BY id,customer,prod_sn,status,no_jp,factory_no,made,model,model_no,year,item_group,material,product_desc,product_desc_ch,product_desc_jp,pcs,colour,colour_no,moq,molding,cost,kaito,other,buy_date,receive_date,supplier,purchase_cost,factory_date,pack_remark,order_date,progress,receive_model_date,person_in_charge,state,ship_date,market_research_price,yahoo_produce,accessory_remark,company_remark,produce_status,create_date ';
		
		if (sizeof($keywords) > 1) {
			$sql .= ' HAVING COUNT(id) > 1';
		}
		
		return $sql;
	}
}