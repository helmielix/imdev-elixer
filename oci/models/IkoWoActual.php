<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "iko_wo_actual".
 *
 * @property string $note
 * @property string $installation_date
 * @property integer $status_listing
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $id_iko_wo
 * @property string $revision_remark
 * @property integer $status_team
 * @property integer $status_tools
 * @property integer $status_material_used
 * @property integer $status_transport
 * @property integer $status_grf
 * @property integer $reason
 * @property string $time_left_basecamp
 * @property string $time_arrived_basecamp
 * @property string $time_left_location
 * @property string $time_arrived_location
 *
 * @property IkoMaterialUsage[] $ikoMaterialUsages
 * @property IkoTeamWoActual[] $ikoTeamWoActuals
 * @property IkoToolsUsage[] $ikoToolsUsages
 * @property IkoTransportUsage[] $ikoTransportUsages
 * @property IkoWorkOrder $idIkoWo
 * @property Reference $reason0
 * @property StatusReference $statusListing
 * @property StatusReference $statusTeam
 * @property StatusReference $statusTools
 * @property StatusReference $statusMaterialUsed
 * @property StatusReference $statusTransport
 * @property StatusReference $statusGrf
 * @property User $createdBy
 * @property User $updatedBy
 * @property OsGaBiayaJalanIko[] $osGaBiayaJalanIkos
 */
class IkoWoActual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iko_wo_actual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note', 'revision_remark'], 'string'],
            [['installation_date', 'status_listing', 'created_by', 'created_date', 'id_iko_wo'], 'required'],
            [['installation_date', 'created_date', 'updated_date', 'time_left_basecamp', 'time_arrived_basecamp', 'time_left_location', 'time_arrived_location'], 'safe'],
            [['status_listing', 'created_by', 'updated_by', 'id_iko_wo', 'status_team', 'status_tools', 'status_material_used', 'status_transport', 'status_grf', 'reason'], 'integer'],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWorkOrder::className(), 'targetAttribute' => ['id_iko_wo' => 'id']],
            [['reason'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['reason' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['status_team'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_team' => 'id']],
            [['status_tools'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_tools' => 'id']],
            [['status_material_used'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_material_used' => 'id']],
            [['status_transport'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_transport' => 'id']],
            [['status_grf'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_grf' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'note' => 'Note',
            'installation_date' => 'Installation Date',
            'status_listing' => 'Status Listing',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'id_iko_wo' => 'Id Iko Wo',
            'revision_remark' => 'Revision Remark',
            'status_team' => 'Status Team',
            'status_tools' => 'Status Tools',
            'status_material_used' => 'Status Material Used',
            'status_transport' => 'Status Transport',
            'status_grf' => 'Status Grf',
            'reason' => 'Reason',
            'time_left_basecamp' => 'Time Left Basecamp',
            'time_arrived_basecamp' => 'Time Arrived Basecamp',
            'time_left_location' => 'Time Left Location',
            'time_arrived_location' => 'Time Arrived Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoMaterialUsages()
    {
        return $this->hasMany(IkoMaterialUsage::className(), ['id_iko_wo_actual' => 'id_iko_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeamWoActuals()
    {
        return $this->hasMany(IkoTeamWoActual::className(), ['id_iko_wo_actual' => 'id_iko_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoToolsUsages()
    {
        return $this->hasMany(IkoToolsUsage::className(), ['id_iko_wo_actual' => 'id_iko_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTransportUsages()
    {
        return $this->hasMany(IkoTransportUsage::className(), ['id_iko_wo_actual' => 'id_iko_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_iko_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason0()
    {
        return $this->hasOne(Reference::className(), ['id' => 'reason']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusListing()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusTeam()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_team']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusTools()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_tools']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusMaterialUsed()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_material_used']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusTransport()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_transport']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusGrf()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_grf']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaBiayaJalanIkos()
    {
        return $this->hasMany(OsGaBiayaJalanIko::className(), ['id_iko_wo_actual' => 'id_iko_wo']);
    }
}
