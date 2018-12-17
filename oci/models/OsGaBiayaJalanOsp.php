<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;


use Yii;

/**
 * This is the model class for table "os_ga_biaya_jalan_osp".
 *
 * @property integer $id
 * @property integer $mobil_rental
 * @property integer $id_osp_wo_actual
 * @property integer $car_rental_cost
 * @property integer $parking_cost
 * @property integer $toll_cost
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property OspWoActual $idOspWoActual
 * @property Reference $mobilRental
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsGaBiayaJalanOsp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $id_vehicle_osp, $id_osp_wo, $stdk_number, $wo_number, $vehicle_name, $status_listing_biaya_jalan, $upload_file;

    public static function tableName()
    {
        return 'os_ga_biaya_jalan_osp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_osp_wo','id_vehicle_osp','mobil_rental', 'id_os_ga_vehicle_osp_detail'], 'integer'],
            [['mobil_rental', 'id_os_ga_vehicle_osp_detail', 'parking_cost', 'toll_cost','fuel_cost'],'required'],
            [['created_date', 'updated_date', 'receipt_file'], 'safe'],
		    [['revision_remark'], 'string'],
			[['fuel_cost','toll_cost','parking_cost'],'integer','min'=>1],
			[['car_rental_cost'], 'integer', 'min' => 0],
            [['upload_file'], 'string', 'max' => 255]
           // [['mobil_rental'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['mobil_rental' => 'id']],
           // [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
           // [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
           // [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobil_rental' => 'Taxi',
            'id_os_ga_vehicle_osp_detail' => 'Id OS GA Vehicle OSP',
			'car_rental_cost' => 'Taxi Cost',
            'parking_cost' => 'Parking Cost',
            'toll_cost' => 'Toll Cost',
			'fuel_cost' => 'Fuel Cost',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'receipt_file' => 'Receipt_file'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
	 public function getIdOsGaVehicleOspDetail()
    {
        return $this->hasOne(OsGaVehicleOspDetail::className(), ['id' => 'id_os_ga_vehicle_osp_detail']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceMobilRental()
    {
        return $this->hasOne(Reference::className(), ['id' => 'mobil_rental']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
}
