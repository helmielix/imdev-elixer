<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class IkoWorkOrder extends \yii\db\ActiveRecord
{
	public $total_personil, $team_leader;

    public static function tableName()
    {
        return 'iko_work_order';
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

    public function rules()
    {
        return [
            [['wo_date', 'work_date', 'work_name', 'wo_number', 'id_iko_itp_daily', 'installation_date'], 'required'],
            [['wo_date', 'created_date', 'updated_date', 'installation_date','departure','total_personil','team_leader'], 'safe'],
            [['note', 'revision_remark'], 'string'],
            [['id_iko_itp_daily', 'status_listing','status_listing', 'status_team', 'status_tools', 'status_transport', 'status_material_need','status_grf', 'created_by', 'updated_by', 'work_name', 'status_im'], 'integer'],
            [['work_date', 'location', 'wo_number'], 'string', 'max' => 50],
            [['revision_remark'], 'required', 'on' => ['revise', 'reject']],
            [['wo_number'], 'unique'],
            [['id_iko_itp_daily'], 'exist', 'skipOnError' => true, 'targetClass' => IkoItpDaily::className(), 'targetAttribute' => ['id_iko_itp_daily' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'wo_date' => 'WO Date',
            'work_date' => 'Work Date',
            'work_name' => 'Work Name',
            'location' => 'Location',
            'note' => 'Note',
            'status_listing' => 'Status Listing',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'wo_number' => 'WO Number',
            'id' => 'ID',
            'id_iko_itp_daily' => 'ID IKO ITP Daily',
            'revision_remark' => 'Revision Remark',
            'status_team' => 'Status Team',
            'status_tools' => 'Status Tools',
            'status_transport' => 'Status Transport',
            'status_material_need' => 'Status Material Need',
            'status_grf' => 'Status Grf',
            'status_im' => 'Status IM',
            'installation_date' => 'Installation Date',
			'departure' => 'Jam Keberangkatan',
			// 'total_personil' => ''

        ];
    }

    public function getIkoBorrowingTools()
    {
        return $this->hasMany(IkoBorrowingTools::className(), ['id_wo' => 'id']);
    }

    public function getIkoMaterialWos()
    {
        return $this->hasMany(IkoMaterialWo::className(), ['id_iko_wo' => 'id']);
    }

    public function getIdIkoTeamWo()
    {
        return $this->hasOne(IkoTeamWo::className(), ['id_iko_wo' => 'id']);
    }

    public function getIkoToolsWos()
    {
        return $this->hasMany(IkoToolsWo::className(), ['id_iko_wo' => 'id']);
    }

    public function getIkoTransportWos()
    {
        return $this->hasMany(IkoTransportWo::className(), ['id_iko_wo' => 'id']);
    }

    public function getIkoWoActual()
    {
        return $this->hasOne(IkoWoActual::className(), ['id_iko_wo' => 'id']);
    }

    public function getIdIkoItpDaily()
    {
        return $this->hasOne(IkoItpDaily::className(), ['id' => 'id_iko_itp_daily']);
    }

    public function getProblems()
    {
        return $this->hasMany(Problem::className(), ['id_wo' => 'id']);
    }

	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}

    public function getStatusReferenceTools()
    {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_tools']);
    }

    public function getStatusReferenceMaterial()
    {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_material_need']);
    }

    public function getStatusReferenceTransport()
    {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_transport']);
    }

    public function getStatusReferenceGrf()
    {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_grf']);
    }

    public function getReferenceWorkname()
    {
    return $this->hasOne(Reference::className(), ['id' => 'work_name']);
    }
    public function getOsGaVehicleIko()
    {
        return $this->hasOne(OsGaVehicleIko::className(), ['id_iko_wo' => 'id']);
    }
}
