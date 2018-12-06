<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use common\models\Reference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "log_ca_ba_survey".
 *
 * @property integer $idlog
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
 * @property string $doc_file
 * @property string $iom_file
 * @property string $kmz_file
 * @property string $geom
 */
class LogCaBaSurvey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $rw, $owner, $file_iom, $file_xls, $file_doc, $file_pdf, $kmz_file, $file;
	
	public $house_type, $property_area_type, $avr_occupancy_rate, $myr_population_hv, $dev_method, $access_to_sell, $competitors, 
			$occupancy_use_dth;
		
    public static function tableName()
    {
        return 'log_ca_ba_survey';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qty_hp_pot', 'id', 'qty_soho_pot'], 'integer'],
            [['notes', 'revision_remark', 'geom'], 'string'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
			[['house_type','property_area_type','avr_occupancy_rate','myr_population_hv','dev_method','access_to_sell','competitors','occupancy_use_dth'],'required', 'on'=>'update'],
            [['id_area'], 'string', 'max' => 25],
            [['no_iom',  'pic_iom_special'], 'string', 'max' => 50],
            [['avr_occupancy_rate'], 'string', 'max' => 8],
            [['property_area_type', 'house_type', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'location_description', 'doc_file', 'iom_file', 'kmz_file'], 'string', 'max' => 255],
            [['contact_survey'], 'string', 'max' => 16],
			[['rw','owner'], 'required', 'on'=>'create'],
			[['file_xls'], 'file',  'extensions' => 'xlsx', 'maxSize'=>1024*1024*5],
			[['file_pdf'], 'file',  'extensions' => 'pdf', 'maxSize'=>1024*1024*5],
			[['file_doc'], 'file',  'extensions' => 'pdf,jpg', 'maxSize'=>1024*1024*5],
			[['file_iom'], 'file',  'extensions' => 'pdf,jpg', 'maxSize'=>1024*1024*5],
			[['file_xls'], 'required', 'on'=>'create'],
			[['file_pdf'], 'required', 'on'=>'create'],
			[['file_doc'], 'required', 'on'=>'create'],
			[['file_iom'], 'required', 'on'=>'create_iom'],
			[['revision_remark'], 'required', 'on'=>'revise'],
			[['iom_type','file','file_doc'], 'required', 'on'=>'update'],
			[['status_iom', 'status_listing','status_presurvey'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
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
            'kmz_file' => 'Kmz File',
            'geom' => 'Geom',
        ];
    }
	
	 public function getIdArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaParameterSurveys()
    {
        return $this->hasMany(CaParameterSurvey::className(), ['id_ca_ba_survey' => 'id']);
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
        return $this->hasMany(Homepass::className(), ['id_ca_ba_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['id_ca_ba_survey' => 'id']);
    }
	
	public function getStatusReferencePreSurvey()
	{
		return $this->hasOne(StatusReference::classname(), ['id' => 'status_presurvey']);
	}
	
	public function getStatusReferenceIom()
	{
		return $this->hasOne(StatusReference::classname(), ['id' => 'status_iom']);
	}
	
	public function getStatusReferenceListing()
	{
		return $this->hasOne(StatusReference::classname(), ['id' => 'status_listing']);
	}
	
	public function getReference()
	{
		return $this->hasOne(Reference::classname(), ['id' => 'iom_type']);
	}
}
