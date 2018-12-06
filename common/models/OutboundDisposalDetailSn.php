<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "outbound_disposal_detail_sn".
 *
 * @property int $id
 * @property int $id_outbound_disposal_detail
 * @property int $serial_number
 * @property int $mac_address
 */
class OutboundDisposalDetailSn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound_disposal_detail_sn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_outbound_disposal_detail', 'serial_number', 'mac_address'], 'required'],
            [['id_outbound_disposal_detail', 'serial_number', 'mac_address'], 'default', 'value' => null],
            [['id_outbound_disposal_detail', 'serial_number', 'mac_address'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_disposal_detail' => 'Id Outbound Disposal Detail',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
        ];
    }
}
