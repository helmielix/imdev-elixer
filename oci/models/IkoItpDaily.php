<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class IkoItpDaily extends \yii\db\ActiveRecord
{

    public $itp_year;
    public $itp_month;
    public $itp_week;
    public $id_region;

    public static function tableName()
    {
        return 'iko_itp_daily';
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

    public function rules()
    {
        return [
            [['no', 'itp_date', 'holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arr_target', 'pvc_instalation_target', 'pole_painting_target', 'fatfdt_splicing_target', 'id_iko_itp_area', 'odc_splicing_target'], 'required'],
            [['itp_date', 'created_date', 'updated_date'], 'safe'],
            [['status_listing','holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arr_target', 'pvc_instalation_target', 'pole_painting_target', 'fatfdt_splicing_target', 'id_iko_itp_area', 'odc_splicing_target', 'created_by', 'updated_by'], 'integer'],
            [['mark', 'revision_remark'], 'string'],
            [['revision_remark'], 'required', 'on'=>['revise', 'reject']],
            [['no'], 'string', 'max' => 50],
            [['no'], 'unique'],
            [['id_iko_itp_area'], 'exist', 'skipOnError' => true, 'targetClass' => IkoItpArea::className(), 'targetAttribute' => ['id_iko_itp_area' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No',
            'itp_date' => 'ITP Date',
            'holes_digging_target' => 'Holes Digging Target',
            'poles_planting_target' => 'Poles Planting Target',
            'poles_foundry_target' => 'Poles Foundry Target',
            'cable_rollout_target' => 'Cable Rollout Target',
            'cable_arr_target' => 'Cable Arr Target',
            'pvc_instalation_target' => 'PVC Instalation Target',
            'pole_painting_target' => 'Pole Painting Target',
            'fatfdt_splicing_target' => 'FAT/ODP Splicing Target',
            'mark' => 'Mark',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'id_iko_itp_area' => 'ITP Area ID',
            'revision_remark' => 'Revision Remark',
			'odc_splicing_target' => 'ODC Splicing Target',
        ];
    }

    public function getIkoDailyReport()
    {
        return $this->hasOne(IkoDailyReport::className(), ['id_iko_itp_daily' => 'id']);
    }

    public function getIdIkoItpArea()
    {
        return $this->hasOne(IkoItpArea::className(), ['id' => 'id_iko_itp_area']);
    }

    public function getIkoResourceItpDailies()
    {
        return $this->hasMany(IkoResourceItpDaily::className(), ['id_iko_itp_daily' => 'id']);
    }

    public function getIkoWorkOrders()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['id_iko_itp_daily' => 'id']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
