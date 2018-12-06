<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use common\models\Reference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class PlanningIkoBoqP extends \yii\db\ActiveRecord
{
    public $file;
    public $file_upload_kmz;
    public $file_upload_xls;

    public static function tableName()
    {
        return 'planning_iko_boq_p';
    }

    public function rules()
    {
        return [
            [['id_planning_iko_bas_plan', 'boq_number', 'boq_date', 'status_listing', 'implementer'], 'required'],
            [['id_planning_iko_bas_plan', 'status_listing', 'status_final', 'status_boq_p_detail', 'created_by', 'updated_by', 'olt_hub_name'], 'integer'],
            [['boq_date', 'created_date', 'updated_date'], 'safe'],
            [['revision_remark', 'geom'], 'string'],
            [['revision_remark'], 'required', 'on' => 'view'],
            [['boq_number', 'implementer'], 'string', 'max' => 50],
            [['location', 'document_upload', 'kmz_file', 'excel_file'], 'string', 'max' => 255],
            [['boq_number'], 'unique'],
            [['id_planning_iko_bas_plan'], 'exist', 'skipOnError' => true, 'targetClass' => PlanningIkoBasPlan::className(), 'targetAttribute' => ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']],
            [['file'], 'file',  'extensions' => 'pdf,jpg,png', 'maxSize'=>1024*1024*5],
            [['file_upload_kmz'], 'file',  'extensions' => 'kmz', 'maxSize'=>1024*1024*5],
            [['file_upload_xls'], 'file',  'extensions' => 'xls,xlsx', 'maxSize'=>1024*1024*5],
            [['file', 'file_upload_kmz', 'file_upload_xls'], 'required', 'on'=> 'create'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_planning_iko_bas_plan' => 'Id Planning Iko BAS Plan',
            'boq_number' => 'BOQ Number',
            'bas_number' => 'BAS Number',
            'boq_date' => 'BOQ Date',
            'location' => 'Location',
            'olt_hub_name' => 'Olt Hub Name',
            'version' => 'Version',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'geom' => 'Geom',
            'status_boq_p_detail' => 'Status BOQ P Detail',
            'implementer' => 'Implementer',
            'document_upload' => 'Document Upload',
            'file' => 'File Document',
            'file_upload_kmz' => 'File KMZ',
            'file_upload_xls' => 'Excel file',
        ];
    }

    public function getIkoDailyReports()
    {
        return $this->hasMany(IkoDailyReport::className(), ['id_planning_iko_boq_p' => 'id_planning_iko_bas_plan']);
    }

    public function getIkoGrfVendors()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['id_planning_iko_boq_p' => 'id_planning_iko_bas_plan']);
    }

    public function getIdPlanningIkoBasPlan()
    {
        return $this->hasOne(PlanningIkoBasPlan::className(), ['id_ca_ba_survey' => 'id_planning_iko_bas_plan']);
    }

    public function getIdIkoRfa()
    {
        return $this->hasMany(IkoRfa::className(), ['id_planning_iko_boq_p' => 'id_planning_iko_bas_plan']);
    }

    public function getGovrelBaDistribution() 
   { 
       return $this->hasOne(GovrelBaDistribution::className(), ['id_planning_iko_boq_p' => 'id_planning_iko_bas_plan']); 
   } 


    public function getPlanningIkoBoqPDetails()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['id_planning_iko_boq_p' => 'id_planning_iko_bas_plan']);
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

    public function getStatusReference()
    {
    	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
    public function getStatusReferenceFinal()
    {
    	return $this->hasOne(StatusReference::className(), ['id' => 'status_final']);
    }
    public function getStatusReferenceDetail()
    {
    	return $this->hasOne(StatusReference::className(), ['id' => 'status_boq_p_detail']);
    }
    public function getReferenceLastExe()
    {
    	return $this->hasOne(Reference::className(), ['id' => 'last_executor']);
    }
}
