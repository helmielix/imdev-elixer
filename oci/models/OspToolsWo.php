<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\StatusReference;

class OspToolsWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'osp_tools_wo';
    }

    public function rules()
    {
        return [
            [['id_osp_wo', 'id_tools', 'needed'], 'required'],
            [['id_osp_wo', 'id_tools'], 'integer'],
            [['needed'], 'required', 'on' => 'xls'],
			[['needed'],'integer','min'=>0],
            [['id_tools'], 'exist', 'skipOnError' => true, 'targetClass' => Tools::className(), 'targetAttribute' => ['id_tools' => 'id']],
            [['id_osp_wo'], 'exist', 'skipOnError' => true, 'targetClass' => OspWorkOrder::className(), 'targetAttribute' => ['id_osp_wo' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_osp_wo' => 'WO Number',
            'id_tools' => 'ID OSP Tools',
            'needed' => 'Needed',
        ];
    }

    public function getOspToolsUsage()
    {
        return $this->hasOne(OspToolsUsage::className(), ['id_osp_tools_wo' => 'id']);
    }

    public function getIdTools()
    {
        return $this->hasOne(Tools::className(), ['id' => 'id_tools']);
    }

    public function getIdOspWo()
    {
        return $this->hasOne(OspWorkOrder::className(), ['id' => 'id_osp_wo']);
    }

    public function getOspTransportUsage()
    {
        return $this->hasOne(OspTransportUsage::className(), ['id_osp_transport_wo' => 'id']);
    }
	
	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
