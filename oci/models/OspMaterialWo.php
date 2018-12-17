<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use common\models\Reference;
use corporate\models\Material;

class OspMaterialWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'osp_material_wo';
    }

    public function rules()
    {
        return [
            [['needed', 'id_osp_wo', 'id_material'], 'integer','min'=>0],
            [['id_osp_wo', 'id_material', 'uom', 'needed'], 'required'],
            [['uom'], 'string', 'max' => 20],
            [['id_material'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['id_material' => 'id']],
            [['id_osp_wo'], 'exist', 'skipOnError' => true, 'targetClass' => OspWorkOrder::className(), 'targetAttribute' => ['id_osp_wo' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'needed' => 'Needed',
            'uom' => 'UOM',
            'id_osp_wo' => 'WO Number',
            'id' => 'ID',
            'id_material' => 'Material Name',
        ];
    }

    public function getOspGrf()
    {
        return $this->hasOne(OspGrf::className(), ['id_osp_material_wo' => 'id']);
    }

    public function getOspMaterialUsage()
    {
        return $this->hasOne(OspMaterialUsage::className(), ['id_osp_material_wo' => 'id']);
    }

    public function getIdMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'id_material']);
    }

    public function getIdOspWo()
    {
        return $this->hasOne(OspWorkOrder::className(), ['id' => 'id_osp_wo']);
    }

	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

	public function getReferenceWorkType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'work_name']);
    }
}
