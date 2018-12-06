<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_wh_transfer_detail".
 *
 * @property integer $id
 * @property integer $id_outbound_wh
 * @property integer $id_item_im
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $status_listing
 * @property integer $req_reject
 * @property integer $req_good_dismantle
 * @property integer $req_not_good_dismantle
 *
 * @property MasterItemIm $idItemIm
 * @property OutboundWhTransfer $idOutboundWh
 * @property OutboundWhTransferDetailSn[] $outboundWhTransferDetailSns
 */
class OutboundWhTransferDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbound_wh_transfer_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_wh', 'id_item_im', 'status_listing'], 'required'],
            [['id_outbound_wh', 'id_item_im', 'req_good', 'req_not_good', 'status_listing', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
            // [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemImDetail::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_outbound_wh'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundWhTransfer::className(), 'targetAttribute' => ['id_outbound_wh' => 'id_instruction_wh']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_wh' => 'Id Outbound Wh',
            'id_item_im' => 'IM Code',
            'req_good' => 'Request Good',
            'req_not_good' => 'Request Not Good',
            'status_listing' => 'Status Listing',
            'req_reject' => 'Request Reject',
            'req_good_dismantle' => 'Request Good Dismantle',
            'req_not_good_dismantle' => 'Request Not Good Dismantle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getIdMasterItemImDetail()
    // {
    //     return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    // }
    public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }

	public function getStatusReference(){
		return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOutboundWh()
    {
        return $this->hasOne(OutboundWhTransfer::className(), ['id_instruction_wh' => 'id_outbound_wh']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundWhTransferDetailSns()
    {
        return $this->hasMany(OutboundWhTransferDetailSn::className(), ['id_outbound_production_detail' => 'id']);
    }
}
