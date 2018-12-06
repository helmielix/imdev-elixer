<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_grf_detail".
 *
 * @property integer $id
 * @property integer $id_outbound_grf
 * @property integer $qty_good
 * @property integer $qty_noot_good
 * @property integer $qty_reject
 * @property integer $qty_dismantle_good
 * @property integer $status_item
 * @property integer $qty_dismantle_ng
 * @property integer $qty_good_rec
 * @property integer $asset_barcode
 *
 * @property OutboundGrf $idOutboundGrf
 * @property OutboundGrfDetailSn[] $outboundGrfDetailSns
 */
class OutboundGrfDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $im_code, $name, $brand, $type, $warna, $sn_type, $description, $qty_request, $orafin_code;
    public static function tableName()
    {
        return 'outbound_grf_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_grf','status_listing'], 'required'],
            [['id_outbound_grf', 'qty_good', 'qty_noot_good', 'qty_reject', 'qty_dismantle_good', 'status_item', 'qty_dismantle_ng', 'qty_good_rec', 'asset_barcode','status_listing', 'id_item_im','qty_return'], 'integer'],
            [['im_code','name','brand', 'type','warna','description'], 'safe'],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemImDetail::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_outbound_grf'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundGrf::className(), 'targetAttribute' => ['id_outbound_grf' => 'id_instruction_grf']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_grf' => 'Id Outbound Grf',
            'id_item_im' => 'IM Code',
            'qty_return' => 'QTY Return',
            'qty_good' => 'Qty Good',
            'qty_noot_good' => 'Qty Noot Good',
            'qty_reject' => 'Qty Reject',
            'qty_dismantle_good' => 'Qty Dismantle Good',
            'status_item' => 'Status Item',
            'qty_dismantle_ng' => 'Qty Dismantle Ng',
            'qty_good_rec' => 'Qty Good Rec',
            'asset_barcode' => 'Asset Barcode',
            'status_listing' => 'Status Listing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMasterItemImDetail()
    {
        return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    }
	
	public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }

    public function getIdOutboundGrf()
    {
        return $this->hasOne(OutboundGrf::className(), ['id_instruction_grf' => 'id_outbound_grf']);
    }

    public function getStatusReference(){
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrfDetailSns()
    {
        return $this->hasMany(OutboundGrfDetailSn::className(), ['id_outbound_grf_detail' => 'id']);
    }
}
