<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property integer $id
 * @property string $type
 * @property integer $total
 * @property string $unit
 *
 * @property IkoGrfVendorDetail[] $ikoGrfVendorDetails
 * @property IkoMaterialUsage[] $ikoMaterialUsages
 * @property IkoMaterialWo[] $ikoMaterialWos
 * @property NetproGrfDetail[] $netproGrfDetails
 * @property NetproListStockBufferDetail[] $netproListStockBufferDetails
 * @property OspGrfVendorDetail[] $ospGrfVendorDetails
 * @property OspMaterialUsage[] $ospMaterialUsages
 * @property OspMaterialWo[] $ospMaterialWos
 * @property OspmGrfDetail[] $ospmGrfDetails
 * @property OspmListStockBufferDetail[] $ospmListStockBufferDetails
 * @property OspmMaterialUsage[] $ospmMaterialUsages
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['unit'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'total' => 'Total',
            'unit' => 'Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendorDetails()
    {
        return $this->hasMany(IkoGrfVendorDetail::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoMaterialUsages()
    {
        return $this->hasMany(IkoMaterialUsage::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoMaterialWos()
    {
        return $this->hasMany(IkoMaterialWo::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfDetails()
    {
        return $this->hasMany(NetproGrfDetail::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproListStockBufferDetails()
    {
        return $this->hasMany(NetproListStockBufferDetail::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendorDetails()
    {
        return $this->hasMany(OspGrfVendorDetail::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspMaterialUsages()
    {
        return $this->hasMany(OspMaterialUsage::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspMaterialWos()
    {
        return $this->hasMany(OspMaterialWo::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmGrfDetails()
    {
        return $this->hasMany(OspmGrfDetail::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmListStockBufferDetails()
    {
        return $this->hasMany(OspmListStockBufferDetail::className(), ['id_material' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmMaterialUsages()
    {
        return $this->hasMany(OspmMaterialUsage::className(), ['id_material' => 'id']);
    }
}
