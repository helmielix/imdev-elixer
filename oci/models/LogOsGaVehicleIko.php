<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_ga_vehicle_iko".
 *
 * @property integer $id
 * @property integer $id_os_ga_vehicle_parameter
 * @property integer $id_iko_wo
 * @property string $stdk_number
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 * @property integer $id_os_ga_driver_parameter
 *
 * @property OsGaDriverParameter $idOsGaDriverParameter
 * @property OsGaVehicleParameter $idOsGaVehicleParameter
 * @property IkoWorkOrder $idIkoWo
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogOsGaVehicleIko extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     
    public $id_iko_work_order, $wo_number; 
     
    public static function tableName()
    {
        return 'log_os_ga_vehicle_iko';
    }

    /**
     * @inheritdoc
     */
     
     
    public function rules()
    {
        return [
            [[ 'id_iko_wo', 'created_by', 'updated_by', 'status_listing', 'id_iko_work_order'], 'integer'],
            [['status_listing'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
           // [['id_os_ga_driver_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsGaDriverParameter::className(), //'targetAttribute' => ['id_os_ga_driver_parameter' => 'id']],
           // [['id_os_ga_vehicle_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsGaVehicleParameter::className(), //'targetAttribute' => ['id_os_ga_vehicle_parameter' => 'id']],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWorkOrder::className(), 'targetAttribute' => ['id_iko_wo' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
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
            'id_iko_wo' => 'Id Iko Wo',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getIdOsGaDriverParameter()
    // {
        // return $this->hasOne(OsGaDriverParameter::className(), ['id' => 'id_os_ga_driver_parameter']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getIdOsGaVehicleParameter()
    // {
        // return $this->hasOne(OsGaVehicleParameter::className(), ['id' => 'id_os_ga_vehicle_parameter']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_iko_wo']);
    }
    
    public function getIdIkoWoActual()
    {
        return $this->hasOne(IkoWoActual::className(), ['id_iko_wo' => 'id_iko_wo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     **/
     public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
    public function getOsGaVehicleIkoDetails()
    {
        return $this->hasMany(OsGaVehicleIkoDetail::className(), ['id_os_ga_vehicle_iko' => 'id_iko_wo']);
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
    
    public function getStatusReferenceDetail()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing_detail']);
    }
}
