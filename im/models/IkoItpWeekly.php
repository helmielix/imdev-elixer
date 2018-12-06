<?php

namespace app\models;

use Yii;

class IkoItpWeekly extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_itp_weekly';
    }

    public function rules()
    {
        return [
            [['no', 'holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arrangement_target', 'pvc_installation_target', 'pole_labeling_target', 'fatfdt_splicing_target', 'created_by', 'created_date', 'status_listing', 'id_iko_itp_monthly'], 'required'],
            [['holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arrangement_target', 'pvc_installation_target', 'pole_labeling_target', 'fatfdt_splicing_target', 'id_iko_itp_monthly', 'week'], 'integer'],
            [['mark', 'revision_remark'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['no', 'created_by', 'updated_by'], 'string', 'max' => 50],
            [['status_listing'], 'string', 'max' => 15],
            [['no'], 'unique'],
            [['id_iko_itp_monthly'], 'exist', 'skipOnError' => true, 'targetClass' => IkoItpMonthly::className(), 'targetAttribute' => ['id_iko_itp_monthly' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No',
            'holes_digging_target' => 'Holes Digging Target',
            'poles_planting_target' => 'Poles Planting Target',
            'poles_foundry_target' => 'Poles Foundry Target',
            'cable_rollout_target' => 'Cable Rollout Target',
            'cable_arrangement_target' => 'Cable Arrangement Target',
            'pvc_installation_target' => 'PVC Installation Target',
            'pole_labeling_target' => 'Pole Labeling Target',
            'fatfdt_splicing_target' => 'FAT/FDT Splicing Target',
            'mark' => 'Mark',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'id_iko_itp_monthly' => 'ITP Monthly ID',
            'week' => 'Week',
        ];
    }

    public function getIkoItpAreas()
    {
        return $this->hasMany(IkoItpArea::className(), ['id_iko_itp_weekly' => 'id']);
    }

    public function getIdIkoItpMonthly()
    {
        return $this->hasOne(IkoItpMonthly::className(), ['id' => 'id_iko_itp_monthly']);
    }
}
