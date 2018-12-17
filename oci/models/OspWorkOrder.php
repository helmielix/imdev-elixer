<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
// use common\models\StatusReference;

class OspWorkOrder extends \yii\db\ActiveRecord
{
	public $total_personil,$province,$city, $team_leader;

    public static function tableName()
    {
        return 'osp_work_order';
    }

    public function rules()
    {
        return [
            [['wo_date', 'work_name', 'prepared_by', 'implemented_by', 'installation_date', 'wo_number', 'id_planning_osp_boq_p', 'wo_type'], 'required'],
            [['wo_date', 'installation_date', 'created_date', 'updated_date','departure','team_leader'], 'safe'],
            [['id_planning_osp_boq_p', 'status_listing', 'status_material_need', 'status_transport', 'status_team', 'status_tools', 'status_material_used', 'status_grf', 'created_by', 'wo_type', 'status_im'], 'integer'],
            [['revision_remark', 'note'], 'string'],
            [['work_name', 'work_type', 'location'], 'string', 'max' => 50],
            [['prepared_by', 'implemented_by', 'passed_by', 'wo_number'], 'string', 'max' => 255],
            [['province', 'city', 'location'], 'required', 'on'=>'create'],
            [['id_planning_osp_boq_p'], 'exist', 'skipOnError' => true, 'targetClass' => PlanningOspBoqP::className(), 'targetAttribute' => ['id_planning_osp_boq_p' => 'id_planning_osp_bas']],
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
            'wo_date' => 'WO Date',
            'work_name' => 'Work Name',
            'prepared_by' => 'Prepared By',
            'implemented_by' => 'Implemented By',
            'passed_by' => 'Passed By',
            'installation_date' => 'Installation Date',
            'status_listing' => 'Status Listing',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated  Date',
            'wo_number' => 'WO Number',
            'id' => 'ID',
            'revision_remark' => 'Revision Remark',
            'status_material_need' => 'Status Material Need',
            'status_transport' => 'Status Transport',
            'status_team' => 'Status Team',
            'status_tools' => 'Status Tools',
            'status_material_used' => 'Status Material Used',
            'status_grf' => 'Status GRF',
            'status_im' => 'Status IM',
            'work_type' => 'Work Type',
            'location' => 'Location',
            'note' => 'Note',
            'id_planning_osp_boq_p' => 'ID Planning as Plan BOQ OSP',
            'wo_type' => 'Work Order Type',
			'departure' => 'Jam Keberangkatan',
        ];
    }

    public function getOspMaterialWos()
    {
        return $this->hasMany(OspMaterialWo::className(), ['id_osp_wo' => 'id']);
    }

    public function getOspProblems()
    {
        return $this->hasMany(OspProblem::className(), ['id_osp_wo' => 'id']);
    }

    public function getOspTeamWo()
    {
        return $this->hasOne(OspTeamWo::className(), ['id_osp_wo' => 'id']);
    }

    public function getOspToolsWos()
    {
        return $this->hasMany(OspToolsWo::className(), ['id_osp_wo' => 'id']);
    }

    public function getOspTransportWos()
    {
        return $this->hasMany(OspTransportWo::className(), ['id_osp_wo' => 'id']);
    }

    public function getOspWoActual()
    {
        return $this->hasOne(OspWoActual::className(), ['id_osp_wo' => 'id']);
    }

    public function getIdPlanningOspBoqP()
    {
        return $this->hasOne(PlanningOspBoqP::className(), ['id_planning_osp_bas' => 'id_planning_osp_boq_p']);
    }

	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    public function getStatusReferenceTeam()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_team']);
    }

    public function getStatusReferenceTools()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_tools']);
    }

    public function getStatusReferenceMaterial()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_material_used']);
    }

    public function getStatusReferenceTransport()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_transport']);
    }

    public function getStatusReferenceGrf()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_grf']);
    }

    public function getReferenceType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'wo_type']);
    }

    public function getReferenceWorkType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'work_name']);
    }

	public function getOsGaVehicleOsp()
   {
       return $this->hasOne(OsGaVehicleOsp::className(), ['id_osp_wo' => 'id']);
   }
}
