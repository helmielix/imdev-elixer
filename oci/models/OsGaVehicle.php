<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;


use Yii;

/**
 * This is the model class for table "os_ga_vehicle".
 *
 * @property integer $id
 * @property integer $id_os_ga_vehicle_parameter
 * @property integer $id_wo
 * @property integer $vehicle
 * @property string $plate_number
 * @property string $stdk_number
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 */
class OsGaVehicle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_ga_vehicle';
    }

    /**
     * @inheritdoc
     */
	 
	public $id_iko_wo, $id_osp_wo; 
    public function rules()
    {
        return [
            [['id_os_ga_vehicle_parameter', 'id_wo', 'vehicle', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_by', 'created_date', 'status_listing'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['plate_number', 'stdk_number'], 'string', 'max' => 50],
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
            'id_wo' => 'Id Wo',
            'vehicle' => 'Vehicle',
            'plate_number' => 'Plate Number',
            'stdk_number' => 'Stdk Number',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
        ];
    }
	
	public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_wo']);
    }
	
	public function getIdOspWo()
    {
        return $this->hasOne(OspWorkOrder::className(), ['id' => 'id_wo']);
    }
	
	public function getIdVendorRegistVendor()
    {
        return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'vendor_name']);
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
