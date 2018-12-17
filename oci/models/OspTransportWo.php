<?php

namespace app\models;

use Yii;
use common\models\StatusReference;

class OspTransportWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'osp_transport_wo';
    }

    public function rules()
    {
        return [
            [['id_transport', 'id_osp_wo', 'driver'], 'required'],
            [['id_transport', 'id_osp_wo'], 'integer'],
            [['driver'], 'string', 'max' => 255],
            [['id_osp_wo'], 'exist', 'skipOnError' => true, 'targetClass' => OspWorkOrder::className(), 'targetAttribute' => ['id_osp_wo' => 'id']],
            [['id_transport'], 'exist', 'skipOnError' => true, 'targetClass' => Transport::className(), 'targetAttribute' => ['id_transport' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_transport' => 'ID Transport',
            //'km_start' => 'Start (Km)',
            'driver' => 'Driver',
            'id_osp_wo' => 'ID Wo',
        ];
    }
	

    public function getOspTransportUsage()
    {
        return $this->hasOne(OspTransportUsage::className(), ['id_osp_transport_wo' => 'id']);
    }

    public function getIdWo()
    {
        return $this->hasOne(OspWorkOrder::className(), ['id' => 'id_osp_wo']);
    }

    public function getIdTransport()
    {
        return $this->hasOne(Transport::className(), ['id' => 'id_transport']);
    }
	
	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
