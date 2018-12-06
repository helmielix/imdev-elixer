<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use common\models\Reference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class PlanningIkoBasPlan extends \yii\db\ActiveRecord
{
    public $file;

    public static function tableName()
    {
        return 'planning_iko_bas_plan';
    }

    public function rules()
    {
        return [
            [['survey_date', 'work_type', 'bas_number', 'pic1', 'position1', 'status_listing', 'id_ca_ba_survey'], 'required'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
            [['note', 'revision_remark', 'geom'], 'string'],
            [['id_ca_ba_survey', 'status_listing', 'created_by', 'updated_by', 'work_type'], 'integer'],
            [['bas_number', 'pic1', 'pic2'], 'string', 'max' => 50],
            [['position1', 'position2'], 'string', 'max' => 20],
            [['uploaded_file'], 'string', 'max' => 255],
            [['bas_number'], 'unique'],
            [['pic2', 'position2'], 'match', 'pattern' => '/^([A-Za-z]\w+\s?)*$/'],
            [['pic2'], 'required', 'when' => function($model){
                    return (!empty($model->position2));
                }, 'whenClient' => 'function(attribute,value){return ($("#planningikobasplan-position2").val() != "")}'
            ],
            [['id_ca_ba_survey'], 'exist', 'skipOnError' => true, 'targetClass' => CaBaSurvey::className(), 'targetAttribute' => ['id_ca_ba_survey' => 'id']],
            [['file'], 'file',  'extensions' => 'pdf,jpg,png', 'maxSize'=>1024*1024*5],
            [['file'], 'required', 'on'=> 'create'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'survey_date' => 'Survey Date',
            'work_type' => 'Work Type',
            'bas_number' => 'BAS Number',
            'pic1' => 'PIC 1',
            'position1' => 'Position 1',
            'pic2' => 'PIC 2',
            'position2' => 'Position 2',
            'note' => 'Note',
            'uploaded_file' => 'Uploaded File',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'geom' => 'Geom',
            'id_ca_ba_survey' => 'Id Ca Ba Survey',
            'project' => 'Project',
            'project_type' => 'Project Type',
            'file' => 'File'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomepasses()
    {
        return $this->hasMany(Homepass::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpAreas()
    {
        return $this->hasMany(IkoItpArea::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCaBaSurvey()
    {
        return $this->hasOne(CaBaSurvey::className(), ['id' => 'id_ca_ba_survey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanningIkoBoqP()
    {
        return $this->hasOne(PlanningIkoBoqP::className(), ['id_planning_iko_bas_plan' => 'id_ca_ba_survey']);
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
    public function getReferenceWorktype()
    {
    	return $this->hasOne(Reference::className(), ['id' => 'work_type']);
    }
}
