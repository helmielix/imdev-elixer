<?php

namespace common\models;

use Yii;
use ap\models\OsVendorPobDetail;

/**
 * This is the model class for table "orafin_view_mkm_pr_to_pay".
 *
 * @property integer $id
 * @property string $po_num
 * @property string $pr_num
 * @property string $creation_date
 * @property string $item_description
 * @property string $uom
 * @property integer $quantity
 * @property string $pr_desc
 */
class OrafinViewMkmPrToPay extends \yii\db\ActiveRecord
{
   
	public $orafin_code, $orafin_name, $qty, $rr_number;
	
    public static function tableName()
    {
        return 'orafin_view_mkm_pr_to_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creation_date'], 'safe'],
            [['quantity'], 'integer'],
            [['po_num', 'pr_num'], 'string', 'max' => 20],
            [['item_description', 'pr_desc'], 'string', 'max' => 255],
            [['uom'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_num' => 'Po No',
            'pr_num' => 'Pr No',
            'creation_date' => 'Creation Date Po',
            'item_description' => 'Item Description Pr',
            'uom' => 'Uom',
            'quantity' => 'Quantity Po',
            'pr_desc' => 'pr_desc',
			'qty' => 'QTY RR',
			'orafin_name' => 'Nama Barang',
        ];
    }

    public function getPobDetail()
	{
		return $this->hasMany(OsVendorPobDetail::className(), ['po_number' => 'po_num']);
	}
	
	public function getOrafinmaster()
	{
		return $this->hasOne(MkmMasterItem::className(), ['item_code' => 'pr_item_code']);
	}

    public function getMasterItemIm()
    {
        return $this->hasMany(MasterItemIm::className(), ['orafin_code' => 'pr_item_code']);
    }
}
