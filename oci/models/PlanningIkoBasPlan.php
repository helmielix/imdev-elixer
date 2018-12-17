<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class PlanningIkoBasPlan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'planning_iko_bas_plan';
    }

    public function rules()
    {
        return [
            [['id_ca_ba_survey', 'survey_date', 'work_type', 'bas_number', 'pic1', 'position1', 'created_by', 'created_date', 'status_listing'], 'required'],
            [['id_ca_ba_survey'], 'integer'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
            [['note', 'revision_remark', 'geom'], 'string'],
            [['work_type', 'bas_number', 'pic1', 'pic2', 'created_by', 'updated_by', 'project', 'project_type'], 'string', 'max' => 50],
            [['position1', 'position2'], 'string', 'max' => 20],
            [['uploaded_file'], 'string', 'max' => 255],
            [['status_listing'], 'string', 'max' => 15],
            [['bas_number'], 'unique'],
            [['id_ca_ba_survey'], 'exist', 'skipOnError' => true, 'targetClass' => CaBaSurvey::className(), 'targetAttribute' => ['id_ca_ba_survey' => 'id']],
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
            'id_ca_ba_survey' => 'Id Govrel Ba Distribution',
            'survey_date' => 'Survey Date',
            'work_type' => 'Work Type',
            'bas_number' => 'Bas Number',
            'pic1' => 'Pic1',
            'position1' => 'Position1',
            'pic2' => 'Pic2',
            'position2' => 'Position2',
            'note' => 'Note',
            'uploaded_file' => 'Uploaded File',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'geom' => 'Geom',
            'project' => 'Project',
            'project_type' => 'Project Type',
        ];
    }

    public function getHomepasses()
    {
        return $this->hasMany(Homepass::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
    }

    public function getIkoBasImplementation()
    {
        return $this->hasOne(IkoBasImplementation::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
    }

    public function getIkoItpAreas()
    {
        return $this->hasMany(IkoItpArea::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
    }

    public function getIdCaBaSurvey()
    {
        return $this->hasOne(CaBaSurvey::className(), ['id' => 'id_ca_ba_survey']);
    }

    public function getIdPlanningIkoBoqP()
    {
        return $this->hasOne(PlanningIkoBoqP::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
	
	public function getWorkType()
   {
       return $this->hasOne(Reference::className(), ['id' => 'work_type']);
   }
}
