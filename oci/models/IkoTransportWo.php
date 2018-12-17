<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class IkoTransportWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_transport_wo';
    }
    
    public function rules()
    {
        return [
            [['id_transport', 'id_iko_wo', 'fuel'], 'required'],
            [['id_transport', 'id_iko_wo'], 'integer'],
            [['fuel'], 'string', 'max' => 20],
            [['driver'], 'string', 'max' => 50],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWorkOrder::className(), 'targetAttribute' => ['id_iko_wo' => 'id']],
            [['id_transport'], 'exist', 'skipOnError' => true, 'targetClass' => Transport::className(), 'targetAttribute' => ['id_transport' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_transport' => 'Id Transport',
            'fuel' => 'Fuel',
            'driver' => 'Driver',
            'id_iko_wo' => 'Id Iko Wo',
        ];
    }

    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_iko_wo']);
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
