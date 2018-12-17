<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "os_ga_vehicle_iko_detail".
 *
 * @property integer $id
 * @property integer $id_os_ga_vehicle_parameter
 * @property integer $id_os_ga_vehicle_iko
 * @property string $stdk_number
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $id_os_ga_driver_parameter
 *
 * @property OsGaBiayaJalanIko $osGaBiayaJalanIko
 * @property OsGaDriverParameter $idOsGaDriverParameter
 * @property OsGaVehicleIko $idOsGaVehicleIko
 * @property OsGaVehicleParameter $idOsGaVehicleParameter
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsGaVehicleIkoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $car_rental_cost,$parking_cost,$toll_cost,$plate_number;

    public static function tableName()
    {
        return 'os_ga_vehicle_iko_detail';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_os_ga_vehicle_parameter', 'id_os_ga_vehicle_iko', 'created_by', 'updated_by', 'id_os_ga_driver_parameter'], 'integer'],
            [['id_os_ga_driver_parameter', 'stdk_number'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['stdk_number'], 'string', 'max' => 50],
            [['id_os_ga_driver_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsGaDriverParameter::className(), 'targetAttribute' => ['id_os_ga_driver_parameter' => 'id']],
            [['id_os_ga_vehicle_iko'], 'exist', 'skipOnError' => true, 'targetClass' => OsGaVehicleIko::className(), 'targetAttribute' => ['id_os_ga_vehicle_iko' => 'id_iko_wo']],
            [['id_os_ga_vehicle_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsGaVehicleParameter::className(), 'targetAttribute' => ['id_os_ga_vehicle_parameter' => 'id']],
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
            'id_os_ga_vehicle_parameter' => 'Id Os Ga Vehicle Parameter',
            'id_os_ga_vehicle_iko' => 'Id Os Ga Vehicle Iko',
            'stdk_number' => 'Stdk Number',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'id_os_ga_driver_parameter' => 'Id Os Ga Driver Parameter',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaBiayaJalanIko()
    {
        return $this->hasOne(OsGaBiayaJalanIko::className(), ['id_os_ga_vehicle_iko_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsGaDriverParameter()
    {
        return $this->hasOne(OsGaDriverParameter::className(), ['id' => 'id_os_ga_driver_parameter']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsGaVehicleIko()
    {
        return $this->hasOne(OsGaVehicleIko::className(), ['id_iko_wo' => 'id_os_ga_vehicle_iko']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsGaVehicleParameter()
    {
        return $this->hasOne(OsGaVehicleParameter::className(), ['id' => 'id_os_ga_vehicle_parameter']);
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

    public function getStatusReferenceBiayaJalan()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing_biaya_jalan']);
    }
}
