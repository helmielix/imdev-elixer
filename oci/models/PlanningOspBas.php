<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
// use common\models\StatusReference;
// use common\models\Reference;

class PlanningOspBas extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'planning_osp_bas';
    }

    public function rules()
    {
        return [
            [['survey_date', 'work_type', 'bas_number', 'pic1', 'position1', 'status_listing', 'location', 'id_ca_ba_survey'], 'required'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
            [['note', 'geom', 'revision_remark'], 'string'],
            [['id_ca_ba_survey'], 'integer'],
            [['work_type', 'bas_number', 'pic1', 'position1', 'pic2', 'created_by', 'updated_by', 'position2'], 'string', 'max' => 50],
            [['status_listing'], 'string', 'max' => 15],
            [['location', 'uploaded_file'], 'string', 'max' => 255],
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
            'survey_date' => 'Survey Date',
            'work_type' => 'Work Type',
            'bas_number' => 'Bas Number',
            'pic1' => 'Pic1',
            'position1' => 'Position1',
            'pic2' => 'Pic2',
            'note' => 'Note',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'position2' => 'Position2',
            'status_listing' => 'Status Listing',
            'geom' => 'Geom',
            'location' => 'Location',
            'revision_remark' => 'Revision Remark',
            'id' => 'ID',
            'id_ca_ba_survey' => 'ID CA BA Survey',
            'uploaded_file' => 'Uploaded File',
        ];
    }

    public function getIdOspDistributionRoutes()
    {
        return $this->hasMany(OspDistributionRoute::className(), ['id_planning_osp_bas' => 'id']);
    }

    public function getIdCaBaSurvey()
    {
        return $this->hasOne(CaBaSurvey::className(), ['id' => 'id_ca_ba_survey']);
    }

    public function getIdCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    public function getIdPlanningOspBoqB()
    {
        return $this->hasOne(PlanningOspBoqB::className(), ['id_planning_osp_bas' => 'id']);
    }

    public function getIdPlanningOspBoqP()
    {
        return $this->hasOne(PlanningOspBoqP::className(), ['id_planning_osp_bas' => 'id']);
    }

    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
    public function getReferenceWorktype()
    {
        return $this->hasOne(Reference::className(), ['id' => 'work_type']);
    }
    public function getReferencePos1()
    {
        return $this->hasOne(Reference::className(), ['id' => 'position1']);
    }
}
