<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_ga_vehicle_parameter".
 *
 * @property integer $id
 * @property string $vehicle_name
 * @property string $plate_number
 * @property string $vehicle_type
 * @property integer $toll_cost
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 */
class OsGaVehicleParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $description;
    public static function tableName()
    {
        return 'os_ga_vehicle_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_by', 'updated_by', 'status_listing', 'vehicle_type'], 'integer'],
            [['status_listing', 'plate_number', 'vehicle_type'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['vehicle_name'], 'string', 'max' => 50],
            [['plate_number'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_name' => 'Vehicle Name',
            'plate_number' => 'Plate Number',
            'vehicle_type' => 'Vehicle Type',
            'toll_cost' => 'Toll Cost',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
        ];
    }

	 public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
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

}
