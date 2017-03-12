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
class ProductMasterVO extends ProductMaster
{
	public $s1_total_unit;
	public $s1_unit_1;
	public $s1_unit_2;
	
	public $s1cn_total_unit;
	public $s1cn_unit_1;
	public $s1cn_unit_2;
	
	public function getdisplay_s1_output_volume() {
		if ($this->s1_total_unit == NULL) {
			return '';
		} else {
			return $this->s1_total_unit.' / '.$this->s1_unit_1.' / '.$this->s1_unit_2;
		}
		
	}
	
	public function getdisplay_s1cn_output_volume() {
		if ($this->s1cn_total_unit == NULL) {
			return '';
		} else {
			return $this->s1cn_total_unit.' / '.$this->s1cn_unit_1.' / '.$this->s1cn_unit_2;
		}
	}
}