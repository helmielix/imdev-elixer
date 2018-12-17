<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_ga_biaya_jalan".
 *
 * @property integer $id
 * @property integer $mobil_rental
 * @property integer $id_division
 * @property integer $id_wo_actual
 * @property integer $car_rental_cost
 * @property integer $parking_cost
 * @property integer $toll_cost
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 */
class OsGaBiayaJalan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_ga_biaya_jalan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobil_rental', 'id_division', 'id_wo_actual', 'car_rental_cost', 'parking_cost', 'toll_cost', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_by', 'created_date', 'status_listing'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobil_rental' => 'Mobil Rental',
            'id_division' => 'Id Division',
            'id_wo_actual' => 'Id Wo Actual',
            'car_rental_cost' => 'Car Rental Cost',
            'parking_cost' => 'Parking Cost',
            'toll_cost' => 'Toll Cost',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
        ];
    }
	
	public function getIdIkoWoActual()
    {
        return $this->hasOne(IkoWoActual::className(), ['id_iko_wo' => 'id_wo_actual']);
    }
	
	public function getIdOspWoActual()
    {
        return $this->hasOne(OspWoActual::className(), ['id_osp_wo' => 'id_wo_actual']);
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
