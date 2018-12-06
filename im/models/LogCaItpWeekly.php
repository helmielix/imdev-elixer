<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ca_itp_weekly".
 *
 * @property integer $iglog
 * @property integer $id
 * @property string $no
 * @property integer $holes_digging_target
 * @property integer $poles_planting_target
 * @property integer $poles_foundry_target
 * @property integer $cable_rollout_target
 * @property integer $cable_arrangement_target
 * @property integer $pvc_installation_target
 * @property integer $pole_labeling_target
 * @property integer $fatfdt_splicing_target
 * @property string $mark
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 * @property string $status_listing
 * @property string $revision_remark
 * @property integer $id_ca_itp_monthly
 * @property integer $week
 */
class LogCaItpWeekly extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ca_itp_weekly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'holes_digging_target', 'poles_planting_target', 'poles_foundry_target', 'cable_rollout_target', 'cable_arrangement_target', 'pvc_installation_target', 'pole_labeling_target', 'fatfdt_splicing_target', 'id_ca_itp_monthly', 'week'], 'integer'],
            [['mark', 'revision_remark'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['no', 'created_by', 'updated_by'], 'string', 'max' => 50],
            [['status_listing'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iglog' => 'Iglog',
            'id' => 'ID',
            'no' => 'No',
            'holes_digging_target' => 'Holes Digging Target',
            'poles_planting_target' => 'Poles Planting Target',
            'poles_foundry_target' => 'Poles Foundry Target',
            'cable_rollout_target' => 'Cable Rollout Target',
            'cable_arrangement_target' => 'Cable Arrangement Target',
            'pvc_installation_target' => 'Pvc Installation Target',
            'pole_labeling_target' => 'Pole Labeling Target',
            'fatfdt_splicing_target' => 'Fatfdt Splicing Target',
            'mark' => 'Mark',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'id_ca_itp_monthly' => 'Id Ca Itp Monthly',
            'week' => 'Week',
        ];
    }
}
