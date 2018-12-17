<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class CaBaSurvey extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ca_ba_survey';
    }

    public function rules()
    {
        return [
            [['id_area', 'qty_hp_pot', 'survey_date', 'created_by', 'created_date', 'status_listing', 'iom_type', 'potency_type', 'avr_occupancy_rate', 'property_area_type', 'house_type', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'pic_survey', 'contact_survey', 'qty_soho_pot'], 'required'],
            [['qty_hp_pot', 'qty_soho_pot'], 'integer'],
            [['notes', 'revision_remark', 'geom'], 'string'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
            [['id_area', 'iom_type', 'potency_type'], 'string', 'max' => 25],
            [['created_by', 'updated_by', 'no_iom', 'pic_survey', 'pic_iom_special'], 'string', 'max' => 50],
            [['status_listing', 'status_iom', 'status_presurvey'], 'string', 'max' => 15],
            [['avr_occupancy_rate'], 'string', 'max' => 8],
            [['property_area_type', 'house_type', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'location_description', 'doc_file', 'iom_file', 'xls_file', 'pdf_file'], 'string', 'max' => 255],
            [['contact_survey'], 'string', 'max' => 16],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['id_area' => 'id']],
        ];
    }
	
	public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new \yii\db\Expression('NOW()'),
            ],            
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

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
            'doc_file' => 'Doc File',
            'iom_file' => 'Iom File',
            'xls_file' => 'Xls File',
            'geom' => 'Geom',
            'pdf_file' => 'Pdf File',
            'status_presurvey' => 'Status Presurvey',
        ];
    }

    public function getIdArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'id_area']);
    }

    public function getCaParameterSurveys()
    {
        return $this->hasMany(CaParameterSurvey::className(), ['id_ca_ba_survey' => 'id']);
    }

    public function getIdPlanningIkoBasPlan()
    {
        return $this->hasOne(PlanningIkoBasPlan::className(), ['id_ca_ba_survey' => 'id']);
    }

    public function getHomepasses()
    {
        return $this->hasMany(Homepass::className(), ['id_ca_ba_survey' => 'id']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}

    public function getReferenceIomType()
    {
    return $this->hasOne(Reference::className(), ['id' => 'iom_type']);
    }

    public function getReferenceProperty()
    {
    return $this->hasOne(Reference::className(), ['id' => 'property_area_type']);
    }

    public function getReferenceHouse()
    {
    return $this->hasOne(Reference::className(), ['id' => 'house_type']);
    }
}
