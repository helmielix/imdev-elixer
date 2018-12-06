<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_wh_transfer_detail_sn".
 *
 * @property integer $id
 * @property integer $id_outbound_wh_detail
 * @property integer $serial_number
 * @property integer $mac_address
 * @property string $condition
 *
 * @property OutboundWhTransferDetail $idOutboundWhDetail
 */
class OutboundWhTransferDetailSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbound_wh_transfer_detail_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_wh_detail', 'condition'], 'required'],
			[['serial_number'], 'required', 'when' => function($model){
                    return (empty($model->mac_address));
                }
            ],
			[['mac_address'], 'required', 'when' => function($model){
                    return (empty($model->serial_number));
                }
            ],
            [['id_outbound_wh_detail'], 'integer'],
            [['condition'], 'string', 'max' => 20],
			[['serial_number'], 'match', 'pattern' => '/^[a-zA-Z0-9_]*$/'],
			[['mac_address'], 'match', 'pattern' => '/^[a-zA-Z0-9_:]*$/'],
            [['serial_number', 'mac_address'], 'string', 'max' => 255],
            [['id_outbound_wh_detail'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundWhTransferDetail::className(), 'targetAttribute' => ['id_outbound_wh_detail' => 'id']],
			['serial_number', 'unique', 'targetAttribute' => ['id_outbound_wh_detail', 'serial_number'], 'message' => 'Serial Number :{value} has already been taken.'],
			['mac_address', 'unique', 'targetAttribute' => ['id_outbound_wh_detail', 'mac_address'], 'message' => 'Mac Address :{value} has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_wh_detail' => 'Id Outbound Wh Detail',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
            'condition' => 'Condition',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOutboundWhDetail()
    {
        return $this->hasOne(OutboundWhTransferDetail::className(), ['id' => 'id_outbound_wh_detail']);
    }
}
