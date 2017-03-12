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
 * @property string $product_desc_ch
 * @property string $product_desc_jp
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
 * @property string $accessory_remark
 * @property string $company_remark
 */
class ProductMaster extends CActiveRecord
{
	public $max_prod_sn;
	
	const IS_MONOPOLY_NO = 0;
	const IS_MONOPOLY_YES = 1;
	
	const IS_RETAIL_NO = 0;
	const IS_RETAIL_YES = 1;
	
	const IS_INTERNAL_YES = 1;
	const IS_INTERNAL_NO = 0;

	const IS_SHIP_YES = 1;
	const IS_SHIP_NO = 0;

	const IS_EXHIBIT_YES = 1;
	const IS_EXHIBIT_NO = 0;

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
			array('prod_sn, made, status, produce_status, is_monopoly, is_retail, is_internal', 'required'),
			array('prod_sn, pcs, moq', 'numerical', 'integerOnly'=>true),
			//array('no_jp', 'unique', 'on'=>'save'), // Black PM no need unique checking
			array('molding, cost, kaito, other, purchase_cost, market_research_price, business_price, auction_price, kaito_price', 'numerical'),
			array('customer, made, model, model_no, year, item_group, material, colour, colour_no, supplier, progress, person_in_charge, state, yahoo_produce', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('no_jp', 'length', 'max'=>32),
			array('factory_no', 'length', 'max'=>50),
			array('id, product_desc, product_desc_en, product_desc_ch, product_desc_jp, buy_date, receive_date, factory_date, pack_remark, order_date, receive_model_date, ship_date, accessory_remark, company_remark, shop, is_ship, is_exhibit, create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer, prod_sn, status, no_jp, factory_no, made, model, model_no, year, item_group, material, product_desc, product_desc_ch, product_desc_jp, pcs, colour, colour_no, moq, molding, cost, kaito, other, buy_date, receive_date, supplier, purchase_cost, factory_date, pack_remark, order_date, progress, receive_model_date, person_in_charge, state, ship_date, market_research_price, yahoo_produce', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('product_message', 'id'),
			'customer' => Yii::t('product_message', 'customer'),
			'prod_sn' => Yii::t('product_message', 'prod_sn'),
			'status' => Yii::t('product_message', 'status'),
			'no_jp' => Yii::t('product_message', 'no_jp'),
			'factory_no' => Yii::t('product_message', 'factory_no'),
			'made' => Yii::t('product_message', 'made'),
			'model' => Yii::t('product_message', 'model'),
			'model_no' => Yii::t('product_message', 'model_no'),
			'year' => Yii::t('product_message', 'year'),
			'item_group' => Yii::t('product_message', 'item_group'),
			'material' => Yii::t('product_message', 'material'),
			'product_desc' => Yii::t('product_message', 'product_desc'),
			'product_desc_ch' => Yii::t('product_message', 'product_desc_ch'),
			'product_desc_jp' => Yii::t('product_message', 'product_desc_jp'),
			'pcs' => Yii::t('product_message', 'pcs'),
			'colour' => Yii::t('product_message', 'colour'),
			'colour_no' => Yii::t('product_message', 'colour_no'),
			'moq' => Yii::t('product_message', 'moq'),
			'molding' => Yii::t('product_message', 'molding'),
			'cost' => Yii::t('product_message', 'cost'),
			'kaito' => Yii::t('product_message', 'kaito'),
			'other' => Yii::t('product_message', 'other'),
			'business_price' => Yii::t('product_message', 'business_price'),
			'auction_price' => Yii::t('product_message', 'auction_price'),
			'kaito_price' =>  Yii::t('product_message', 'kaito_price'),
			'buy_date' => Yii::t('product_message', 'buy_date'),
			'receive_date' => Yii::t('product_message', 'receive_date'),
			'supplier' => Yii::t('product_message', 'supplier'),
			'purchase_cost' => Yii::t('product_message', 'purchase_cost'),
			'factory_date' => Yii::t('product_message', 'factory_date'),
			'pack_remark' => Yii::t('product_message', 'pack_remark'),
			'order_date' => Yii::t('product_message', 'order_date'),
			'progress' => Yii::t('product_message', 'progress'),
			'receive_model_date' => Yii::t('product_message', 'receive_model_date'),
			'person_in_charge' => Yii::t('product_message', 'person_in_charge'),
			'state' => Yii::t('product_message', 'state'),
			'ship_date' => Yii::t('product_message', 'ship_date'),
			'market_research_price' => Yii::t('product_message', 'market_research_price'),
			'yahoo_produce' => Yii::t('product_message', 'yahoo_produce'),
			'accessory_remark' => Yii::t('product_message', 'accessory_remark'),
			'company_remark' => Yii::t('product_message', 'company_remark'),
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
		$criteria->compare('product_desc_ch',$this->product_desc_ch,true);
		$criteria->compare('product_desc_jp',$this->product_desc_jp,true);
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
		
		if ($this->isNewRecord) {
			$this->create_date = new CDbExpression('NOW()');
		}
		
		$this->last_update_date = new CDbExpression('NOW()');
	
		return parent::beforeSave();
	}
	
	public static function getProduceStatusDropdown() {
		return array(
				''=>'',
				GlobalConstants::PRODUCE_STATUS_PREPARE=>Yii::t('common_message', 'produce_status_prepare'),
				GlobalConstants::PRODUCE_STATUS_BOOK=>Yii::t('common_message', 'produce_status_book'),
				GlobalConstants::PRODUCE_STATUS_MODELING=>Yii::t('common_message', 'produce_status_modeling'),
				GlobalConstants::PRODUCE_STATUS_CHECK=>Yii::t('common_message', 'produce_status_check'),
				GlobalConstants::PRODUCE_STATUS_EDIT=>Yii::t('common_message', 'produce_status_edit'),
				GlobalConstants::PRODUCE_STATUS_PAUSE=>Yii::t('common_message', 'produce_status_pause'),
				GlobalConstants::PRODUCE_STATUS_CANCEL=>Yii::t('common_message', 'produce_status_cancel'),
				//GlobalConstants::PRODUCE_STATUS_MONOPOLY=>Yii::t('common_message', 'produce_status_monopoly'),
				GlobalConstants::PRODUCE_STATUS_COMPLETE=>Yii::t('common_message', 'produce_status_complete'),
			);
	}
	
	public static function getProductMaster($id) {
		if (GlobalFunction::isSupplier()) {
			$model = self::model()->findByAttributes(array('id'=>$id, 'supplier'=>GlobalFunction::getUserSupplier()));
		}
		else {
			$model = self::model()->findByAttributes(array('id'=>$id));
		}
		
		if($model != null) {
			if (GlobalFunction::isRetail() && $model->is_retail != ProductMaster::IS_RETAIL_YES) {
				// View retail product only
				return null;
			}
			
			if (!GlobalFunction::isAllowInternal() && $model->is_internal == ProductMaster::IS_INTERNAL_YES) {
				// Not allow to view internal product
				return null;
			}
		}
		
		return $model;
	}
}