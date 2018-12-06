<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_repair_detail".
 *
 * @property integer $id
 * @property integer $id_outbound_repair
 * @property integer $id_item_im
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $status_listing
 * @property integer $req_reject
 * @property integer $req_good_dismantle
 * @property integer $req_not_good_dismantle
 *
 * @property MasterItemIm $idItemIm
 * @property OutboundRepair $idOutboundRepair
 * @property OutboundRepairDetailSn[] $outboundRepairDetailSns
 */
class OutboundRepairDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbound_repair_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_repair', 'id_item_im', 'status_listing'], 'required'],
            [['id_outbound_repair', 'id_item_im', 'req_good', 'req_not_good', 'status_listing', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_outbound_repair'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundRepair::className(), 'targetAttribute' => ['id_outbound_repair' => 'id_instruction_repair']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_repair' => 'Id Outbound Wh',
            'id_item_im' => 'Id Item Im',
            'req_good' => 'Req Good',
            'req_not_good' => 'Req Not Good',
            'status_listing' => 'Status Listing',
            'req_reject' => 'Req Reject',
            'req_good_dismantle' => 'Req Good Dismantle',
            'req_not_good_dismantle' => 'Req Not Good Dismantle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
    public function getIdOutboundRepair()
    {
        return $this->hasOne(OutboundRepair::className(), ['id_instruction_repair' => 'id_outbound_repair']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundRepairDetailSns()
    {
        return $this->hasMany(OutboundRepairDetailSn::className(), ['id_outbound_production_detail' => 'id']);
    }
}
