<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planning_osp_boq_p".
 *
 * @property string $boq_number
 * @property string $boq_date
 * @property integer $executor_type
 * @property string $location
 * @property integer $olt_hub_name
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property string $kmz_file
 * @property integer $status_listing
 * @property integer $id_planning_osp_bas
 * @property string $geom_point
 * @property string $geom_line
 * @property string $geom_area
 * @property string $revision_remark
 * @property integer $status_boq_p_detail
 * @property integer $status_final
 * @property string $document_upload
 * @property string $excel_file
 * @property integer $status_coordination
 * @property integer $olt_start
 * @property integer $olt_finish
 * @property integer $executor_name
 *
 * @property GovrelInternalCoordination $govrelInternalCoordination
 * @property LogGovrelInternalCoordination[] $logGovrelInternalCoordinations
 * @property LogOspDailyReport[] $logOspDailyReports
 * @property LogOspGrfVendor[] $logOspGrfVendors
 * @property LogOspWorkOrder[] $logOspWorkOrders
 * @property OspDailyReport[] $ospDailyReports
 * @property OspGrfVendor[] $ospGrfVendors
 * @property OspOltPort[] $ospOltPorts
 * @property OspRfa[] $ospRfas
 * @property OspWorkOrder[] $ospWorkOrders
 * @property OspManageOlt $oltHubName
 * @property OspManageOlt $oltStart
 * @property OspManageOlt $oltFinish
 * @property PlanningOspBas $idPlanningOspBas
 * @property Reference $executorType
 * @property StatusReference $statusListing
 * @property StatusReference $statusBoqPDetail
 * @property StatusReference $statusFinal
 * @property StatusReference $statusCoordination
 * @property User $createdBy
 * @property User $updatedBy
 * @property Vendor $executorName
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails
 */
class PlanningOspBoqP extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planning_osp_boq_p';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['boq_number', 'boq_date', 'created_by', 'created_date', 'status_listing', 'id_planning_osp_bas'], 'required'],
            [['boq_date', 'created_date', 'updated_date'], 'safe'],
            [['executor_type', 'olt_hub_name', 'created_by', 'updated_by', 'status_listing', 'id_planning_osp_bas', 'status_boq_p_detail', 'status_final', 'status_coordination', 'olt_start', 'olt_finish', 'executor_name'], 'integer'],
            [['geom_point', 'geom_line', 'geom_area', 'revision_remark'], 'string'],
            [['boq_number'], 'string', 'max' => 50],
            [['location', 'kmz_file', 'document_upload', 'excel_file'], 'string', 'max' => 255],
            [['boq_number'], 'unique'],
            [['olt_hub_name'], 'exist', 'skipOnError' => true, 'targetClass' => OspManageOlt::className(), 'targetAttribute' => ['olt_hub_name' => 'id']],
            [['olt_start'], 'exist', 'skipOnError' => true, 'targetClass' => OspManageOlt::className(), 'targetAttribute' => ['olt_start' => 'id']],
            [['olt_finish'], 'exist', 'skipOnError' => true, 'targetClass' => OspManageOlt::className(), 'targetAttribute' => ['olt_finish' => 'id']],
            [['id_planning_osp_bas'], 'exist', 'skipOnError' => true, 'targetClass' => PlanningOspBas::className(), 'targetAttribute' => ['id_planning_osp_bas' => 'id']],
            [['executor_type'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['executor_type' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['status_boq_p_detail'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_boq_p_detail' => 'id']],
            [['status_final'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_final' => 'id']],
            [['status_coordination'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_coordination' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['executor_name'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['executor_name' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'boq_number' => 'Boq Number',
            'boq_date' => 'Boq Date',
            'executor_type' => 'Executor Type',
            'location' => 'Location',
            'olt_hub_name' => 'Olt Hub Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'kmz_file' => 'Kmz File',
            'status_listing' => 'Status Listing',
            'id_planning_osp_bas' => 'Id Planning Osp Bas',
            'geom_point' => 'Geom Point',
            'geom_line' => 'Geom Line',
            'geom_area' => 'Geom Area',
            'revision_remark' => 'Revision Remark',
            'status_boq_p_detail' => 'Status Boq P Detail',
            'status_final' => 'Status Final',
            'document_upload' => 'Document Upload',
            'excel_file' => 'Excel File',
            'status_coordination' => 'Status Coordination',
            'olt_start' => 'Olt Start',
            'olt_finish' => 'Olt Finish',
            'executor_name' => 'Executor Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelInternalCoordination()
    {
        return $this->hasOne(GovrelInternalCoordination::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogGovrelInternalCoordinations()
    {
        return $this->hasMany(LogGovrelInternalCoordination::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOspDailyReports()
    {
        return $this->hasMany(LogOspDailyReport::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOspGrfVendors()
    {
        return $this->hasMany(LogOspGrfVendor::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOspWorkOrders()
    {
        return $this->hasMany(LogOspWorkOrder::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspDailyReports()
    {
        return $this->hasMany(OspDailyReport::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendors()
    {
        return $this->hasMany(OspGrfVendor::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspOltPorts()
    {
        return $this->hasMany(OspOltPort::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspRfas()
    {
        return $this->hasMany(OspRfa::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders()
    {
        return $this->hasMany(OspWorkOrder::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOltHubName()
    {
        return $this->hasOne(OspManageOlt::className(), ['id' => 'olt_hub_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOltStart()
    {
        return $this->hasOne(OspManageOlt::className(), ['id' => 'olt_start']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOltFinish()
    {
        return $this->hasOne(OspManageOlt::className(), ['id' => 'olt_finish']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanningOspBas()
    {
        return $this->hasOne(PlanningOspBas::className(), ['id' => 'id_planning_osp_bas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'executor_type']);
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
    public function getStatusBoqPDetail()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_boq_p_detail']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusFinal()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_final']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusCoordination()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_coordination']);
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
    public function getExecutorName()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'executor_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['id_planning_osp_boq_p' => 'id_planning_osp_bas']);
    }
}
