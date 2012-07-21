<?php

/**
 * This is the model class for table "product_master".
 *
 * The followings are the available columns in table 'product_master':
 * @property integer $id
 * @property string $customer
 * @property integer $prod_sn
 * @property string $status
 * @property string $no_jp
 * @property string $factory_no
 * @property string $made
 * @property string $model
 * @property string $model_no
 * @property string $year
 * @property string $item_group
 * @property string $material
 * @property string $product_desc
 * @property string $remark
 * @property string $photo_link
 * @property integer $pcs
 * @property string $colour
 * @property string $colour_no
 * @property integer $moq
 * @property double $molding
 * @property double $cost
 * @property double $kaito
 * @property double $other
 * @property string $buy_date
 * @property string $receive_date
 * @property string $supplier
 * @property double $purchase_cost
 * @property string $factory_date
 * @property string $pack_remark
 * @property string $order_date
 * @property string $progress
 * @property string $receive_model_date
 * @property string $person_in_charge
 * @property string $state
 * @property string $ship_date
 * @property double $market_research_price
 * @property string $yahoo_produce
 */
class ProductMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prod_sn, made, status', 'required'),
			array('prod_sn, pcs, moq', 'numerical', 'integerOnly'=>true),
			array('molding, cost, kaito, other, purchase_cost, market_research_price', 'numerical'),
			array('customer, made, model, model_no, year, item_group, material, photo_link, colour, colour_no, supplier, progress, person_in_charge, state, yahoo_produce', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('no_jp', 'length', 'max'=>32),
			array('factory_no', 'length', 'max'=>50),
			array('id, product_desc, remark, buy_date, receive_date, factory_date, pack_remark, order_date, receive_model_date, ship_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer, prod_sn, status, no_jp, factory_no, made, model, model_no, year, item_group, material, product_desc, remark, photo_link, pcs, colour, colour_no, moq, molding, cost, kaito, other, buy_date, receive_date, supplier, purchase_cost, factory_date, pack_remark, order_date, progress, receive_model_date, person_in_charge, state, ship_date, market_research_price, yahoo_produce', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer' => '&#23458;&#25142;', // 客戶
			'prod_sn' => '&#29986;&#21697;S/N', // 產品S/N
			'status' => 'STATUS',
			'no_jp' => '&#21697;&#30058;', // 品番
			'factory_no' => '&#24037;&#24288;&#32232;&#34399;', // 工廠編號 
			'made' => '&#36554;&#31278;', // 車種
			'model' => '&#36554;&#22411;', // 車型
			'model_no' => '&#22411;&#34399;', // 型號
			'year' => '&#24180;&#20221;', // 年份
			'item_group' => '&#21830;&#21697;&#21517;', // 商品名 
			'material' => '&#26448;&#36074;', // 材質
			'product_desc' => '&#21830;&#21697;&#35500;&#26126;1', // 商品説明1 
			'remark' => '&#21830;&#21697;&#35500;&#26126;2/&#37197;&#20214;&#22791;&#27880;', // 商品説明2/配件备注
			'photo_link' => '&#22270;&#29255;&#36229;&#38142;&#25509;', // 图片超链接
			'pcs' => 'PCS',
			'colour' => '&#38991;&#33394;', // 顏色 
			'colour_no' => '&#38991;&#33394;&#32232;&#34399;', // 顏色編號
			'moq' => '&#26368;&#20302;&#36215;&#35330;&#37327;', // 最低起訂量
			'molding' => '&#27169;&#20855;&#36027;', // 模具費
			'cost' => '&#20379;&#24212;&#21830;&#22577;&#20729;', // 供应商報價
			'kaito' => '&#28023;&#28193;', // 海渡
			'other' => '&#20854;&#20182;', // 其他
			'buy_date' => '&#35330;&#21407;&#20214;&#26178;&#38291;', // 訂原件時間
			'receive_date' => '&#21407;&#20214;&#25910;&#21040;&#26085;&#26399;', // 原件收到日期
			'supplier' => '&#20379;&#25033;&#21830;', // 供應商
			'purchase_cost' => '&#21407;&#20214;&#27171;&#21697;&#25505;&#36092;&#20729;', // 原件樣品採購價
			'factory_date' => '&#21407;&#20214;&#20132;&#20184;&#24037;&#24288;&#26085;&#26399;', // 原件交付工廠日期
			'pack_remark' => '&#21253;&#35037;&#22791;&#27880;', // 包裝备注
			'order_date' => '&#19979;&#21934;&#26085;&#26399;', // 下單日期
			'progress' => '&#24320;&#21457;&#36914;&#24230;&#21450;&#24773;&#20917;', // 开发進度及情况 
			'receive_model_date' => '&#25910;&#21040;&#27171;&#26495;~&#23492;&#24448;&#23565;&#36554;&#26085;&#26399;', // 收到樣板~寄往對車日期
			'person_in_charge' => '&#23565;&#36554;&#36000;&#36012;&#20154;', // 對車負責人
			'state' => '&#23565;&#36554;&#24773;&#27841;', // 對車情況
			'ship_date' => '&#20986;&#36135;&#26085;&#26399;', // 出货日期
			'market_research_price' => '&#24066;&#22330;&#35843;&#26597;&#30340;&#20215;&#26684;', // 市场调查的价格
			'yahoo_produce' => 'YAHOO&#20986;&#21697;', // YAHOO出品
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('customer',$this->customer,true);
		$criteria->compare('prod_sn',$this->prod_sn);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('no_jp',$this->no_jp,true);
		$criteria->compare('factory_no',$this->factory_no,true);
		$criteria->compare('made',$this->made,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('model_no',$this->model_no,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('item_group',$this->item_group,true);
		$criteria->compare('material',$this->material,true);
		$criteria->compare('product_desc',$this->product_desc,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('photo_link',$this->photo_link,true);
		$criteria->compare('pcs',$this->pcs);
		$criteria->compare('colour',$this->colour,true);
		$criteria->compare('colour_no',$this->colour_no,true);
		$criteria->compare('moq',$this->moq);
		$criteria->compare('molding',$this->molding);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('kaito',$this->kaito);
		$criteria->compare('other',$this->other);
		$criteria->compare('buy_date',$this->buy_date,true);
		$criteria->compare('receive_date',$this->receive_date,true);
		$criteria->compare('supplier',$this->supplier,true);
		$criteria->compare('purchase_cost',$this->purchase_cost);
		$criteria->compare('factory_date',$this->factory_date,true);
		$criteria->compare('pack_remark',$this->pack_remark,true);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('progress',$this->progress,true);
		$criteria->compare('receive_model_date',$this->receive_model_date,true);
		$criteria->compare('person_in_charge',$this->person_in_charge,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('ship_date',$this->ship_date,true);
		$criteria->compare('market_research_price',$this->market_research_price);
		$criteria->compare('yahoo_produce',$this->yahoo_produce,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		if (empty($this->buy_date)) {
			$this->buy_date = null;
		} 
		
		if (empty($this->receive_date)) {
			$this->receive_date = null;
		}
		
		if (empty($this->factory_date)) {
			$this->factory_date = null;
		}
		
		if (empty($this->order_date)) {
			$this->order_date = null;
		}
		
		if (empty($this->receive_model_date)) {
			$this->receive_model_date = null;
		}
		
		if (empty($this->ship_date)) {
			$this->ship_date = null;
		}
	
		return parent::beforeSave();
	}
}