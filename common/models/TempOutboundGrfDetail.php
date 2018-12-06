<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "temp_outbound_grf_detail".
 *
 * @property int $id
 * @property int $id_outbound_grf
 * @property int $id_item_im
 * @property int $qty_req
 * @property int $qty_req_good
 * @property int $qty_req_not_good
 * @property int $qty_req_reject
 * @property int $status_item
 *
 * @property ItemIm $itemIm
 * @property OutboundGrf $outboundGrf
 */
class TempOutboundGrfDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_outbound_grf_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_grf', 'id_item_im', 'status_item'], 'required'],
            [['id', 'id_outbound_grf', 'id_item_im', 'qty_req', 'qty_req_good', 'qty_req_not_good', 'qty_req_reject', 'status_item'], 'default', 'value' => null],
            [['id', 'id_outbound_grf', 'id_item_im', 'qty_req', 'qty_req_good', 'qty_req_not_good', 'qty_req_reject', 'status_item'], 'integer'],
            [['id'], 'unique'],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => ItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_outbound_grf'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundGrf::className(), 'targetAttribute' => ['id_outbound_grf' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_grf' => 'Id Outbound Grf',
            'id_item_im' => 'Id Item Im',
            'qty_req' => 'Qty Req',
            'qty_req_good' => 'Qty Req Good',
            'qty_req_not_good' => 'Qty Req Not Good',
            'qty_req_reject' => 'Qty Req Reject',
            'status_item' => 'Status Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemIm()
    {
        return $this->hasOne(ItemIm::className(), ['id' => 'id_item_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrf()
    {
        return $this->hasOne(OutboundGrf::className(), ['id' => 'id_outbound_grf']);
    }
}
