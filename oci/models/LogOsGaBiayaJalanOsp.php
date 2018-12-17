<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_os_ga_biaya_jalan_osp".
 *
 * @property integer $idlog
 * @property integer $id_os_ga_vehicle_osp_detail
 * @property integer $mobil_rental
 * @property integer $car_rental_cost
 * @property integer $parking_cost
 * @property integer $toll_cost
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 * @property integer $fuel_cost
 *
 * @property OsGaVehicleOspDetail $idOsGaVehicleOspDetail
 */
class LogOsGaBiayaJalanOsp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc

     */
	 public $id_os_ga_vehicle_parameter, $id_osp_wo, $stdk_number, $wo_number, $vehicle_name;

    public static function tableName()
    {
        return 'log_os_ga_biaya_jalan_osp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_os_ga_vehicle_osp_detail', 'mobil_rental', 'car_rental_cost', 'parking_cost', 'toll_cost', 'created_by', 'updated_by', 'status_listing', 'fuel_cost'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['id_os_ga_vehicle_osp_detail'], 'exist', 'skipOnError' => true, 'targetClass' => OsGaVehicleOspDetail::className(), 'targetAttribute' => ['id_os_ga_vehicle_osp_detail' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id_os_ga_vehicle_osp_detail' => 'Id Os Ga Vehicle Osp Detail',
            'mobil_rental' => 'Mobil Rental',
            'car_rental_cost' => 'Car Rental Cost',
            'parking_cost' => 'Parking Cost',
            'toll_cost' => 'Toll Cost',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'fuel_cost' => 'Fuel Cost',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsGaVehicleOspDetail()
    {
        return $this->hasOne(OsGaVehicleOspDetail::className(), ['id' => 'id_os_ga_vehicle_osp_detail']);
    }

	public function getReferenceMobilRental()
    {
        return $this->hasOne(Reference::className(), ['id' => 'mobil_rental']);
    }

	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
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
}
