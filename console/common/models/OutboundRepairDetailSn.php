<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_repair_detail_sn".
 *
 * @property integer $id
 * @property integer $id_outbound_repair_detail
 * @property integer $serial_number
 * @property integer $mac_address
 * @property string $condition
 *
 * @property OutboundRepairDetail $idOutboundRepairDetail
 */
class OutboundRepairDetailSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbound_repair_detail_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_repair_detail', 'serial_number', 'mac_address', 'condition'], 'required'],
            [['id_outbound_repair_detail'], 'integer'],
            [['condition'], 'string', 'max' => 20],
            [['serial_number', 'mac_address'], 'string', 'max' => 255],
            [['id_outbound_repair_detail'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundRepairDetail::className(), 'targetAttribute' => ['id_outbound_repair_detail' => 'id']],
			['serial_number', 'unique', 'targetAttribute' => ['id_outbound_repair_detail', 'serial_number'], 'message' => '{value} has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_repair_detail' => 'Id Outbound Wh Detail',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
            'condition' => 'Condition',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOutboundRepairDetail()
    {
        return $this->hasOne(OutboundRepairDetail::className(), ['id' => 'id_outbound_repair_detail']);
    }
}
