<?php
class CustomerSearchForm extends CFormModel {
	public $itemCount;
	
	public $keyword;
	
	public $id;
	public $name;
	public $fax;
	public $address;
	public $address2;
	public $contact_person;
	public $other_contact;
	public $email;
	public $cust_group;
	public $cust_type;
	public $where_to_find;
	public $where_to_find_detail;
	public $tel;
	public $tel2;
	public $mobile_no;
	public $mobile_no2;
	public $contact_salesman;
	public $website;
	public $vip;
	public $remark;
	public $salesman_remark;
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword, id, name, fax, address, address2, contact_person, other_contact, email, cust_group, cust_type, where_to_find, where_to_find_detail, tel, tel2, mobile_no, mobile_no2, contact_salesman, website, vip, remark, salesman_remark, itemCount', 'safe'),
		);
	}

	public function searchByCriteria($criteria, $pages, $totalItemCount = NULL)
	{
		return new CActiveDataProvider(get_class(new Customer), array(
				'criteria'=>$criteria,
				'pagination'=>$pages,
				'totalItemCount'=>$totalItemCount
		));
	}
	
	public function createCriteria()
	{
		$criteria = new CDbCriteria();
		$criteria->distinct = true;
		$criteria->select = 't.*';
		$criteria->join = 'LEFT JOIN customer_cust_type ON customer_cust_type.customer_id = t.id';
		$criteria->order = 'id desc';
		
		$criteria->compare('name', trim($this->name), true);
		$criteria->compare('id', trim($this->id));
		
		$criteria->compare('contact_person', trim($this->contact_person), true);
		if (cust_group != '') {
			$criteria->compare('cust_group', $this->cust_group);
		}
		
		$criteria->compare('where_to_find', $this->where_to_find);
		if (!empty($this->where_to_find)) {
			$criteria->compare('where_to_find_detail', trim($this->where_to_find_detail), true);
		}
		if (!empty($this->cust_type)) {
			$criteria->addInCondition('customer_cust_type.cust_type_id', $this->cust_type);
		}
		
		$criteria->compare('tel', trim($this->tel), true);
		$criteria->compare('fax', trim($this->fax), true);
		
		$criteria->compare('tel2', trim($this->tel2), true);
		$criteria->compare('mobile_no', trim($this->mobile_no), true);
		
		$criteria->compare('email', trim($this->email), true);
		$criteria->compare('mobile_no2', trim($this->mobile_no2), true);
		
		$criteria->compare('other_contact', trim($this->other_contact), true);
		$criteria->compare('website', trim($this->website), true);
		
		$criteria->compare('address', trim($this->address), true);
		if ($this->vip != '') {
			$criteria->compare('vip', $this->vip);
		}
		
		$criteria->compare('address2', trim($this->address2), true);
		
		$criteria->compare('remark', trim($this->remark), true);

		$criteria->compare('contact_salesman', trim($this->contact_salesman), true);

		$criteria->compare('salesman_remark', trim($this->salesman_remark), true);
		
		return $criteria;
	}
	
// Search by keyword
	public function searchByKeywordCrtiera($pages)
	{
		// Set page count
		$keywords = $this->getKeywords();
	
		$sql = $this->createKeywordCriteria($keywords);

		$sql .= ' ORDER BY id desc';
	
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

		$data = array();
		$dataReader = $command->query();
		foreach ($dataReader as $row) {
			$customer = new Customer();
			$customer->id = $row['id'];
			$customer->name = $row['name'];
			$customer->cust_cd = $row['cust_cd'];
			$customer->fax = $row['fax'];
			$customer->address = $row['address'];
			$customer->address2 = $row['address2'];
			$customer->email = $row['email'];
			$customer->cust_group = $row['cust_group'];
			$customer->where_to_find = $row['where_to_find'];
			$customer->where_to_find_detail = $row['where_to_find_detail'];
			$customer->tel = $row['tel'];
			$customer->tel2 = $row['tel2'];
			$customer->mobile_no = $row['mobile_no'];
			$customer->mobile_no2 = $row['mobile_no2'];
			$customer->contact_person = $row['contact_person'];
			$customer->contact_salesman = $row['contact_salesman'];
			$customer->other_contact = $row['other_contact'];
			$customer->website = $row['website'];
			$customer->vip = $row['vip'];
			$customer->remark = $row['remark'];
			$customer->salesman_remark = $row['salesman_remark'];
						
			$data[] = $customer;
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
	
			$sql .= "SELECT id,name,cust_cd,fax,address,address2,email,cust_group,where_to_find,where_to_find_detail,tel,tel2,mobile_no,mobile_no2,contact_person,contact_salesman,other_contact,website,vip,remark,salesman_remark
			FROM customer
			WHERE 
			name like :keyword_$i
			OR id like :keyword_$i
			OR fax like :keyword_$i
			OR address like :keyword_$i
			OR address2 like :keyword_$i
			OR email like :keyword_$i
			OR where_to_find_detail like :keyword_$i
			OR tel like :keyword_$i
			OR tel2 like :keyword_$i
			OR mobile_no like :keyword_$i
			OR mobile_no2 like :keyword_$i
			OR contact_person like :keyword_$i
			OR contact_salesman like :keyword_$i
			OR other_contact like :keyword_$i
			OR website like :keyword_$i
			OR remark like :keyword_$i
			OR salesman_remark like :keyword_$i
			";
	
			$i++;
		}
	
		$sql = 'SELECT *
		FROM ('.$sql.') tmp';
	
		$sql .= ' GROUP BY id,name,cust_cd,fax,address,address2,email,cust_group,where_to_find,where_to_find_detail,tel,tel2,mobile_no,mobile_no2,contact_person,contact_salesman,other_contact,website,vip,remark,salesman_remark ';
	
		if (sizeof($keywords) > 1) {
			$sql .= ' HAVING COUNT(id) > 1';
		}
	
		return $sql;
	}
}