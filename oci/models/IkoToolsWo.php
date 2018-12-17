<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class IkoToolsWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_tools_wo';
    }

    public function rules()
    {
        return [
            [['id_iko_wo', 'id_tools', 'needed'], 'required'],
            [['id_iko_wo', 'id_tools', 'needed'], 'integer','min'=>0],
            [['id_tools'], 'exist', 'skipOnError' => true, 'targetClass' => Tools::className(), 'targetAttribute' => ['id_tools' => 'id']],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWorkOrder::className(), 'targetAttribute' => ['id_iko_wo' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_iko_wo' => 'Id Iko Wo',
            'id_tools' => 'Id Iko Tools',
            'needed' => 'Needed',
        ];
    }

    public function getIkoToolsUsage()
    {
        return $this->hasOne(IkoToolsUsage::className(), ['id_iko_tools_wo' => 'id']);
    }

    public function getIdTools()
    {
        return $this->hasOne(Tools::className(), ['id' => 'id_tools']);
    }

    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_iko_wo']);
    }

    public function getIkoTransportUsage()
    {
        return $this->hasOne(IkoTransportUsage::className(), ['id_iko_transport_wo' => 'id']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
