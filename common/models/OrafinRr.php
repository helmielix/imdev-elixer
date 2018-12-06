<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orafin_rr".
 *
 * @property integer $id
 * @property integer $rr_number
 * @property integer $pr_number
 * @property integer $po_number
 * @property string $supplier
 * @property string $rr_date
 * @property string $waranty
 * @property integer $status_listing
 *
 * @property InboundPo[] $inboundPos
 */
class OrafinRr extends \yii\db\ActiveRecord
{
    public $orafin_code;
	
    public static function tableName()
    {
        return 'orafin_rr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rr_number', 'pr_number', 'po_number', 'status_listing'], 'integer'],
            [['rr_date', 'waranty'], 'safe'],
            [['supplier'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rr_number' => 'Rr Number',
            'pr_number' => 'Pr Number',
            'po_number' => 'Po Number',
            'supplier' => 'Supplier',
            'rr_date' => 'Rr Date',
            'waranty' => 'Waranty',
            'status_listing' => 'Status Listing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPos()
    {
        return $this->hasMany(InboundPo::className(), ['id_orafin_rr' => 'id']);
    }
	
	public function getPrRr()
    {
        return $this->hasMany(OrafinViewMkmPrToPay::className(), ['rcv_no' => 'rr_number']);
    }
}
