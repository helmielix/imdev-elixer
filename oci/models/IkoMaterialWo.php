<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;
use corporate\models\Material;

class IkoMaterialWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_material_wo';
    }

    public function rules()
    {
        return [
            [['needed', 'id_iko_wo', 'id_material'], 'integer','min'=>0],
            [['id_iko_wo', 'id_material', 'needed'], 'required'],
            [['uom'], 'string', 'max' => 20],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWorkOrder::className(), 'targetAttribute' => ['id_iko_wo' => 'id']],
            [['id_material'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['id_material' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'needed' => 'Needed',
            'uom' => 'Uom',
            'id_iko_wo' => 'Id Iko Wo',
            'id' => 'ID',
            'id_material' => 'ID Material',
        ];
    }

    public function getIkoGrf()
    {
        return $this->hasOne(IkoGrf::className(), ['id_iko_material_wo' => 'id']);
    }

    public function getIkoMaterialUsage()
    {
        return $this->hasOne(IkoMaterialUsage::className(), ['id_iko_material_wo' => 'id']);
    }

    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_iko_wo']);
    }

    public function getIdMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'id_material']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
