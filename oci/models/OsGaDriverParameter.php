<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_ga_driver_parameter".
 *
 * @property integer $id
 * @property integer $driver_status
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $driver_name
 * @property string $created_date
 * @property string $updated_date
 *
 * @property StatusReference $driverStatus
 * @property User $createdBy
 * @property User $updatedBy
 * @property OsGaVehicleIko[] $osGaVehicleIkos
 * @property OsGaVehicleOsp[] $osGaVehicleOsps
 */
class OsGaDriverParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_ga_driver_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['driver_status', 'created_by', 'updated_by','status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['driver_name'], 'string', 'max' => 50],
			 [['revision_remark'], 'string'],
            [['driver_status'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['driver_status' => 'id']],
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
            'id' => 'ID',
            'driver_status' => 'Driver Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'driver_name' => 'Driver Name',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
			'status_listing' => 'Status Listing',
			'revision_remark' => 'Revision Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
   public function getStatusReferenceDriver()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'driver_status']);
    }

	public function getReferenceVehicleType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'vehicle_type']);
    }

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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaVehicleIkos()
    {
        return $this->hasMany(OsGaVehicleIko::className(), ['id_os_ga_driver_parameter' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaVehicleOsps()
    {
        return $this->hasMany(OsGaVehicleOsp::className(), ['id_os_ga_driver_parameter' => 'id']);
    }
}
