<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_production_detail_set_item_sn".
 *
 * @property integer $id
 * @property integer $id_outbound_production_detail_set_item
 * @property string $serial_number
 * @property string $mac_address
 * @property string $condition
 *
 * @property OutboundProductionDetailSetItem $idOutboundProductionDetailSetItem
 */
class OutboundProductionDetailSetItemSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbound_production_detail_set_item_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_production_detail_set_item', 'serial_number', 'mac_address', 'condition'], 'required'],
            [['id_outbound_production_detail_set_item'], 'integer'],
            [['serial_number', 'mac_address'], 'string', 'max' => 255],
            [['condition'], 'string', 'max' => 20],
            [['id_outbound_production_detail_set_item'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundProductionDetailSetItem::className(), 'targetAttribute' => ['id_outbound_production_detail_set_item' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_production_detail_set_item' => 'Id Outbound Production Detail Set Item',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
            'condition' => 'Condition',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOutboundProductionDetailSetItem()
    {
        return $this->hasOne(OutboundProductionDetailSetItem::className(), ['id' => 'id_outbound_production_detail_set_item']);
    }
}
