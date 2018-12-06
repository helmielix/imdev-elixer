<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "item_im".
 *
 * @property int $id
 * @property string $item_name
 * @property string $created_date
 * @property string $updated_date
 *
 * @property InboundGrfDetail[] $inboundGrfDetails
 * @property InboundGrfDetailSn[] $inboundGrfDetailSns
 * @property OutboundGrfDetail[] $outboundGrfDetails
 * @property OutboundGrfDetailSn[] $outboundGrfDetailSns
 * @property OutboundProductionDetail[] $outboundProductionDetails
 * @property StockOpnameInternalDetail[] $stockOpnameInternalDetails
 * @property TempOutboundGrfDetail[] $tempOutboundGrfDetails
 */
class ItemIm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_im';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name'], 'string'],
            [['created_date'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_name' => 'Item Name',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundGrfDetails()
    {
        return $this->hasMany(InboundGrfDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundGrfDetailSns()
    {
        return $this->hasMany(InboundGrfDetailSn::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrfDetails()
    {
        return $this->hasMany(OutboundGrfDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrfDetailSns()
    {
        return $this->hasMany(OutboundGrfDetailSn::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundProductionDetails()
    {
        return $this->hasMany(OutboundProductionDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockOpnameInternalDetails()
    {
        return $this->hasMany(StockOpnameInternalDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTempOutboundGrfDetails()
    {
        return $this->hasMany(TempOutboundGrfDetail::className(), ['id_item_im' => 'id']);
    }
}
