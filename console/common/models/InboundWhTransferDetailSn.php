<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_wh_transfer_detail_sn".
 *
 * @property integer $id
 * @property integer $id_inbound_wh_detail
 * @property integer $serial_number
 * @property integer $mac_address
 *
 * @property InboundWhTransferDetail $idInboundWhDetail
 */
class InboundWhTransferDetailSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $total_condition;
    public static function tableName()
    {
        return 'inbound_wh_transfer_detail_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inbound_wh_detail', 'condition'], 'required'],
			[['serial_number'], 'required', 'when' => function($model){
                    return (empty($model->mac_address));
                }
            ],
			[['mac_address'], 'required', 'when' => function($model){
                    return (empty($model->serial_number));
                }
            ],
			[['serial_number'], 'match', 'pattern' => '/^[a-zA-Z0-9_]*$/'],
			[['mac_address'], 'match', 'pattern' => '/^[a-zA-Z0-9_:]*$/'],
            [['id_inbound_wh_detail'], 'integer'],
            [['id_inbound_wh_detail'], 'exist', 'skipOnError' => true, 'targetClass' => InboundWhTransferDetail::className(), 'targetAttribute' => ['id_inbound_wh_detail' => 'id']],
			
			['serial_number', 'unique', 'targetAttribute' => ['id_inbound_wh_detail', 'serial_number'], 'message' => 'Serial Number :{value} has already been taken.'],
			['mac_address', 'unique', 'targetAttribute' => ['id_inbound_wh_detail', 'mac_address'], 'message' => 'Mac Address :{value} has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_wh_detail' => 'Id Inbound Wh Detail',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInboundWhDetail()
    {
        return $this->hasOne(InboundWhTransferDetail::className(), ['id' => 'id_inbound_wh_detail']);
    }
}
