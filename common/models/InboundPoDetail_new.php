<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "inbound_po_detail".
 *
 * @property int $id
 * @property int $id_inbound_po
 * @property int $id_item_im
 * @property int $qty
 * @property int $status_listing
 * @property string $orafin_code
 *
 * @property InboundPo $inboundPo
 * @property StatusReference $statusListing
 * @property InboundPoDetailSn[] $inboundPoDetailSns
 */
class InboundPoDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound_po_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_inbound_po', 'id_item_im', 'qty', 'status_listing'], 'default', 'value' => null],
            [['id_inbound_po', 'id_item_im', 'qty', 'status_listing'], 'integer'],
            [['orafin_code'], 'string', 'max' => 255],
            [['id_inbound_po'], 'exist', 'skipOnError' => true, 'targetClass' => InboundPo::className(), 'targetAttribute' => ['id_inbound_po' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_po' => 'Id Inbound Po',
            'id_item_im' => 'Id Item Im',
            'qty' => 'Qty',
            'status_listing' => 'Status Listing',
            'orafin_code' => 'Orafin Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPo()
    {
        return $this->hasOne(InboundPo::className(), ['id' => 'id_inbound_po']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusListing()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPoDetailSns()
    {
        return $this->hasMany(InboundPoDetailSn::className(), ['id_inbound_po_detail' => 'id']);
    }
}
