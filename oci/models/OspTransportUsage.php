<?php

namespace app\models;

use Yii;
use common\models\StatusReference;

class OspTransportUsage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'osp_transport_usage';
    }

    public function rules()
    {
        return [
            [['driver', 'id_transport', 'km_start', 'km_end', 'id_osp_wo_actual'], 'required'],
            [['id_transport', 'id_osp_wo_actual', 'km_start', 'km_end'], 'integer'],
            [['driver'], 'string', 'max' => 50],
            [['id_osp_wo_actual'], 'exist', 'skipOnError' => true, 'targetClass' => OspWoActual::className(), 'targetAttribute' => ['id_osp_wo_actual' => 'id_osp_wo']],
            [['id_transport'], 'exist', 'skipOnError' => true, 'targetClass' => Transport::className(), 'targetAttribute' => ['id_transport' => 'id']],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'driver' => 'Driver',
			'km_start' => 'Start (Km)',
            'km_end' => 'End (Km)',
            'id_transport' => 'Name Transport',
            'id' => 'ID',
            'id_osp_wo_actual' => 'Id Osp Wo Actual',
        ];
    }

    public function getIdOspWoActual()
    {
        return $this->hasOne(OspWoActual::className(), ['id_osp_wo' => 'id_osp_wo_actual']);
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
