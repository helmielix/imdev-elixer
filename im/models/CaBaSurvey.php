<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use common\models\Reference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

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
 *
 * @property Area $idArea
 * @property CaParameterSurvey[] $caParameterSurveys
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property Homepass[] $homepasses
 */
class CaBaSurvey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $rw, $owner, $file_iom, $file_xls, $file_doc, $file_pdf,  $files, $file;

	public $house_type, $property_area_type, $avr_occupancy_rate, $myr_population_hv, $dev_method, $access_to_sell, $competitors,
			$occupancy_use_dth;

    public static function tableName()
    {
        return 'ca_ba_survey';
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
            [['id_area', 'qty_hp_pot', 'survey_date', 'created_by', 'created_date', 'status_presurvey','status_listing', 'contact_survey', 'qty_soho_pot'], 'required'],
            [['qty_hp_pot', 'qty_soho_pot','status_listing','status_presurvey', 'status_iom', 'estimasi_homepass','iom_type'], 'integer'],
            [['notes', 'revision_remark'], 'string'],
            [['survey_date', 'created_date', 'updated_date', 'estimasi_homepass'], 'safe'],
            [['id_area',  ], 'string', 'max' => 25],
            [['no_iom'], 'string', 'max' => 50],
            [['house_type','property_area_type','avr_occupancy_rate','myr_population_hv','dev_method','access_to_sell','competitors','occupancy_use_dth'],'required', 'on'=>'update'],
            [[ 'location_description', 'doc_file', 'iom_file', 'pdf_file','xls_file','file_iom_rollout'], 'string', 'max' => 255],
            [['contact_survey'], 'string', 'max' => 16],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['id_area' => 'id']],
			[['rw'], 'string', 'max'=> 5],
			[['owner'], 'string', 'max'=> 20],
            [['geom'], 'safe'],
			// [['no_iom'], 'unique', 'on'=>'create_iom'],
			[['rw','owner'], 'required', 'on'=>['create', 'update_presurvey']],
			[['file_xls'], 'file',  'extensions' => 'xlsx', 'maxSize'=>1024*1024*5],
			[['file_pdf'], 'file',  'extensions' => 'pdf', 'maxSize'=>1024*1024*5],
			[['file_doc'], 'file',  'extensions' => 'pdf,jpg', 'maxSize'=>1024*1024*5],
			[['file_iom'], 'file',  'extensions' => 'pdf,jpg', 'maxSize'=>1024*1024*5],
			//[['file_xls'], 'required', 'on'=>'create'],
			[['file_pdf'], 'required', 'on'=>'create'],
			[['file_doc'], 'required', 'on'=>'create'],
			[['file_iom'], 'required', 'on'=>'create_iom'],
			[['revision_remark'], 'required', 'on'=>'revise'],
			[['iom_type','file_xls','file_doc','file_pdf', 'pic_survey'], 'required', 'on'=>'update'],
			[['id_area'], 'required', 'on'=>'update_presurvey'],
			[['house_type','property_area_type','avr_occupancy_rate','myr_population_hv','dev_method','access_to_sell','competitors','occupancy_use_dth', 'pic_survey'],'required', 'on'=>'update_no_file'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_area' => 'ID Area',
            'qty_hp_pot' => 'Qty Hp Pot',
            'notes' => 'Notes',
            'survey_date' => 'Survey Date',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_presurvey' => 'Status Pre-Survey',
            'status_listing' => 'Status Listing',
            'status_iom' => 'Status IOM',
            'iom_type' => 'IOM Type',
            'no_iom' => 'No IOM',
            'id' => 'ID',
            'dev_method' => 'Dev Method',
            'access_to_sell' => 'Access To Sell',
            'occupancy_use_dth' => 'Occupancy Use Dth',
            'competitors' => 'Competitors',
            'location_description' => 'Location Description',
            'pic_survey' => 'PIC Survey',
            'contact_survey' => 'Contact Survey',
            'pic_iom_special' => 'PIC IOM Special',
            'revision_remark' => 'Revision Remark',
            'qty_soho_pot' => 'Qty Soho Pot',
            'doc_file' => 'Doc File',
            'iom_file' => 'IOM File',
            'xls_file' => 'Homepass Excel File',
            'pdf_file' => 'APD Draft File',
            'file_doc' => 'BA Survey Doc File',
            'file_iom' => 'IOM Rollout File',
            'file_xls' => 'Homepass Excel File',
            'file_pdf' => 'APD Draft Files ',
            'geom' => 'Geom',
			'estimasi_homepass' => 'Estimasi Homepass'
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
     public function getPlanningIkoBasPlan()
   {
       return $this->hasOne(PlanningIkoBasPlan::className(), ['id_ca_ba_survey' => 'id']);
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

	public function getPicSurvey()
   {
       return $this->hasOne(Labor::className(), ['nik' => 'pic_survey']);
   }

   public function getPicIomSpecial()
   {
       return $this->hasOne(Labor::className(), ['nik' => 'pic_survey']);
   }







}
