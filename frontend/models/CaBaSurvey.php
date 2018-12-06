<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ca_ba_survey".
 *
 * @property string $id_area
 * @property integer $qty_hp_pot
 * @property string $notes
 * @property string $survey_date
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 * @property string $status_listing
 * @property string $status_iom
 * @property string $iom_type
 * @property string $potency_type
 * @property string $no_iom
 * @property string $avr_occupancy_rate
 * @property integer $id
 * @property string $geom
 * @property string $property_area_type
 * @property string $house_type
 * @property string $myr_population_hv
 * @property string $dev_method
 * @property string $access_to_sell
 * @property string $occupancy_use_dth
 * @property string $competitors
 * @property string $location_description
 * @property string $pic_survey
 * @property string $contact_survey
 * @property string $pic_iom_special
 * @property string $revision_remark
 * @property integer $qty_soho_pot
 *
 * @property Area $idArea
 * @property CaParameterSurvey[] $caParameterSurveys
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property Homepass[] $homepasses
 * @property Homepass[] $homepasses0
 */
class CaBaSurvey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ca_ba_survey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_area', 'qty_hp_pot', 'survey_date', 'created_by', 'created_date', 'status_listing', 'iom_type', 'potency_type', 'avr_occupancy_rate', 'property_area_type', 'house_type', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'pic_survey', 'contact_survey', 'qty_soho_pot'], 'required'],
            [['qty_hp_pot', 'qty_soho_pot'], 'integer'],
            [['notes', 'geom', 'revision_remark'], 'string'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
            [['id_area', 'iom_type', 'potency_type'], 'string', 'max' => 20],
            [['created_by', 'updated_by', 'no_iom', 'pic_survey', 'pic_iom_special'], 'string', 'max' => 50],
            [['status_listing', 'status_iom'], 'string', 'max' => 15],
            [['avr_occupancy_rate'], 'string', 'max' => 8],
            [['property_area_type', 'house_type', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'location_description'], 'string', 'max' => 255],
            [['contact_survey'], 'string', 'max' => 16],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['id_area' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_area' => 'Id Area',
            'qty_hp_pot' => 'Qty Hp Pot',
            'notes' => 'Notes',
            'survey_date' => 'Survey Date',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'status_iom' => 'Status Iom',
            'iom_type' => 'Iom Type',
            'potency_type' => 'Potency Type',
            'no_iom' => 'No Iom',
            'avr_occupancy_rate' => 'Avr Occupancy Rate',
            'id' => 'ID',
            'geom' => 'Geom',
            'property_area_type' => 'Property Area Type',
            'house_type' => 'House Type',
            'myr_population_hv' => 'Myr Population Hv',
            'dev_method' => 'Dev Method',
            'access_to_sell' => 'Access To Sell',
            'occupancy_use_dth' => 'Occupancy Use Dth',
            'competitors' => 'Competitors',
            'location_description' => 'Location Description',
            'pic_survey' => 'Pic Survey',
            'contact_survey' => 'Contact Survey',
            'pic_iom_special' => 'Pic Iom Special',
            'revision_remark' => 'Revision Remark',
            'qty_soho_pot' => 'Qty Soho Pot',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaParameterSurveys()
    {
        return $this->hasMany(CaParameterSurvey::className(), ['id_ba_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['id_ca_ba_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomepasses()
    {
        return $this->hasMany(Homepass::className(), ['id_ba_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomepasses0()
    {
        return $this->hasMany(Homepass::className(), ['id_ca_ba_survey' => 'id']);
    }
}
