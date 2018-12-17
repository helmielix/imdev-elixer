<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_region
 * @property integer $id_province
 *
 * @property CaIomAndCity[] $caIomAndCities
 * @property Province $idProvince
 * @property Region $idRegion
 * @property District[] $districts
 * @property LogCaIomAndCity[] $logCaIomAndCities
 * @property LogOspManageOlt[] $logOspManageOlts
 * @property LogPlanningOspBas[] $logPlanningOspBas
 * @property LogPlanningOspManageOlt[] $logPlanningOspManageOlts
 * @property OsOutsourcePersonil[] $osOutsourcePersonils
 * @property PlanningOspBas[] $planningOspBas
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'id_province'], 'required'],
            [['id', 'id_region', 'id_province'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['name', 'id_province'], 'unique', 'targetAttribute' => ['name', 'id_province'], 'message' => 'The combination of Name and Id Province has already been taken.'],
          //  [['id_province'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['id_province' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['id_region' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'id_region' => 'Id Region',
            'id_province' => 'Id Province',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaIomAndCities()
    {
        return $this->hasMany(CaIomAndCity::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'id_province']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'id_region']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogCaIomAndCities()
    {
        return $this->hasMany(LogCaIomAndCity::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOspManageOlts()
    {
        return $this->hasMany(LogOspManageOlt::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPlanningOspBas()
    {
        return $this->hasMany(LogPlanningOspBas::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPlanningOspManageOlts()
    {
        return $this->hasMany(LogPlanningOspManageOlt::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['id_city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas()
    {
        return $this->hasMany(PlanningOspBas::className(), ['id_city' => 'id']);
    }
}
