<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_wh_transfer_detail".
 *
 * @property integer $id
 * @property integer $id_inbound_wh
 * @property integer $id_item_im
 * @property integer $qty
 * @property string $delta
 *
 * @property InboundWhTransfer $idInboundWh
 * @property ItemIm $idItemIm
 * @property InboundWhTransferDetailSn[] $inboundWhTransferDetailSns
 */
class InboundWhTransferDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_wh_transfer_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inbound_wh', 'id_item_im'], 'required'],
            [['id_inbound_wh', 'id_item_im', 'qty', 'qty_good', 'qty_not_good', 'qty_reject', 'qty_good_dismantle', 'qty_not_good_dismantle'], 'integer'],

            [['id_inbound_wh'], 'exist', 'skipOnError' => true, 'targetClass' => InboundWhTransfer::className(), 'targetAttribute' => ['id_inbound_wh' => 'id_outbound_wh']],
            // [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemImDetail::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],

			[['qty_good', 'qty_not_good', 'qty_reject', 'qty_good_dismantle', 'qty_not_good_dismantle'], 'default', 'value' => 0],
			[['status_tagsn'], 'default', 'value' => 44], // Not Registered
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_wh' => 'Id Inbound Wh',
            'id_item_im' => 'Id Item Im',
            'qty' => 'Qty Terima',
			'status_tagsn' => 'Status',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInboundWh()
    {
        return $this->hasOne(InboundWhTransfer::className(), ['id_outbound_wh' => 'id_inbound_wh']);
    }

	public function getIdOutboundWhDetail()
    {
        return $this->hasOne(OutboundWhTransferDetail::className(), ['id' => 'id_outbound_wh_detail']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdItemIm()
    {
        // return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundWhTransferDetailSns()
    {
        return $this->hasMany(InboundWhTransferDetailSn::className(), ['id_inbound_wh_detail' => 'id']);
    }
}
