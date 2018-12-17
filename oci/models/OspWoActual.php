<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "osp_wo_actual".
 *
 * @property string $note
 * @property string $installation_date
 * @property integer $status_listing
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $id_osp_wo
 * @property string $revision_remark
 * @property integer $status_team
 * @property integer $status_tools
 * @property integer $status_material_used
 * @property integer $status_transport
 * @property integer $status_material_need
 * @property integer $status_grf
 * @property string $time_left_basecamp
 * @property string $time_arrived_basecamp
 * @property string $time_left_location
 * @property string $time_arrived_location
 *
 * @property OsGaBiayaJalanOsp[] $osGaBiayaJalanOsps
 * @property OspMaterialUsage[] $ospMaterialUsages
 * @property OspTeamWoActual[] $ospTeamWoActuals
 * @property OspToolsUsage[] $ospToolsUsages
 * @property OspTransportUsage[] $ospTransportUsages
 * @property OspWorkOrder $idOspWo
 * @property StatusReference $statusListing
 * @property StatusReference $statusTeam
 * @property StatusReference $statusTools
 * @property StatusReference $statusMaterialUsed
 * @property StatusReference $statusTransport
 * @property StatusReference $statusMaterialNeed
 * @property StatusReference $statusGrf
 * @property User $createdBy
 * @property User $updatedBy
 */
class OspWoActual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $stdk_number;
    public static function tableName()
    {
        return 'osp_wo_actual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note', 'revision_remark'], 'string'],
            [['installation_date', 'status_listing', 'created_by', 'created_date', 'id_osp_wo'], 'required'],
            [['installation_date', 'created_date', 'updated_date', 'time_left_basecamp', 'time_arrived_basecamp', 'time_left_location', 'time_arrived_location'], 'safe'],
            [['status_listing', 'created_by', 'updated_by', 'id_osp_wo', 'status_team', 'status_tools', 'status_material_used', 'status_transport', 'status_material_need', 'status_grf'], 'integer'],
            [['id_osp_wo'], 'exist', 'skipOnError' => true, 'targetClass' => OspWorkOrder::className(), 'targetAttribute' => ['id_osp_wo' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['status_team'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_team' => 'id']],
            [['status_tools'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_tools' => 'id']],
            [['status_material_used'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_material_used' => 'id']],
            [['status_transport'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_transport' => 'id']],
            [['status_material_need'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_material_need' => 'id']],
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
            'id_osp_wo' => 'Id Osp Wo',
            'revision_remark' => 'Revision Remark',
            'status_team' => 'Status Team',
            'status_tools' => 'Status Tools',
            'status_material_used' => 'Status Material Used',
            'status_transport' => 'Status Transport',
            'status_material_need' => 'Status Material Need',
            'status_grf' => 'Status Grf',
            'time_left_basecamp' => 'Time Left Basecamp',
            'time_arrived_basecamp' => 'Time Arrived Basecamp',
            'time_left_location' => 'Time Left Location',
            'time_arrived_location' => 'Time Arrived Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaBiayaJalanOsps()
    {
        return $this->hasMany(OsGaBiayaJalanOsp::className(), ['id_osp_wo_actual' => 'id_osp_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspMaterialUsages()
    {
        return $this->hasMany(OspMaterialUsage::className(), ['id_osp_wo_actual' => 'id_osp_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeamWoActuals()
    {
        return $this->hasMany(OspTeamWoActual::className(), ['id_osp_wo_actual' => 'id_osp_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspToolsUsages()
    {
        return $this->hasMany(OspToolsUsage::className(), ['id_osp_wo_actual' => 'id_osp_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTransportUsages()
    {
        return $this->hasMany(OspTransportUsage::className(), ['id_osp_wo_actual' => 'id_osp_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOspWo()
    {
        return $this->hasOne(OspWorkOrder::className(), ['id' => 'id_osp_wo']);
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
    public function getStatusMaterialNeed()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_material_need']);
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

    public function getOspWoActualStdks() 
   { 
       return $this->hasMany(OspWoActualStdk::className(), ['id_osp_wo' => 'id_osp_wo']); 
   } 
}
