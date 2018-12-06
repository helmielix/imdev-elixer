<?php

namespace app\models;

use Yii;

class IkoItpMonthly extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_itp_monthly';
    }

    public function rules()
    {
        return [
            [['no', 'holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arrangement_target', 'pvc_installation_target', 'pole_labeling_target', 'fatfdt_splicing_target', 'created_by', 'created_date', 'status_listing', 'itp_year', 'itp_month'], 'required'],
            [['holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arrangement_target', 'pvc_installation_target', 'pole_labeling_target', 'fatfdt_splicing_target', 'itp_year', 'itp_month'], 'integer'],
            [['mark', 'revision_remark'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['no', 'created_by', 'updated_by'], 'string', 'max' => 50],
            [['status_listing'], 'string', 'max' => 15],
            [['itp_year', 'itp_month'], 'unique', 'targetAttribute' => ['itp_year', 'itp_month'], 'message' => 'The combination of Itp Year and Itp Month has already been taken.'],
            [['no'], 'unique'],
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
            'itp_year' => 'ITP Year',
            'itp_month' => 'ITP Month',
        ];
    }

    public function getIkoItpWeeklies()
    {
        return $this->hasMany(IkoItpWeekly::className(), ['id_iko_itp_monthly' => 'id']);
    }
}
