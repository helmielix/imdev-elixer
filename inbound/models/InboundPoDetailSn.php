<?php

namespace inbound\models;

use Yii;

/**
 * This is the model class for table "inbound_po_detail_sn".
 *
 * @property integer $id
 * @property integer $id_inbound_po_detail
 * @property string $serial_number
 * @property string $mac_address
 *
 * @property InboundPoDetail $idInboundPoDetail
 */
class InboundPoDetailSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_po_detail_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inbound_po_detail'], 'integer'],
            [['serial_number', 'mac_address'], 'string', 'max' => 255],
            [['id_inbound_po_detail'], 'exist', 'skipOnError' => true, 'targetClass' => InboundPoDetail::className(), 'targetAttribute' => ['id_inbound_po_detail' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_po_detail' => 'Id Inbound Po Detail',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInboundPoDetail()
    {
        return $this->hasOne(InboundPoDetail::className(), ['id' => 'id_inbound_po_detail']);
    }
}
