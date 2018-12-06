<?php

namespace app\models;

use Yii;

class IkoItpArea extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_itp_area';
    }

    public function rules()
    {
        return [
            [['id_planning_iko_bas_plan'], 'required'],
            [['id_ca_itp_weekly', 'id_planning_iko_bas_plan'], 'integer'],
            [['id_planning_iko_bas_plan'], 'exist', 'skipOnError' => true, 'targetClass' => IkoBasPlan::className(), 'targetAttribute' => ['id_planning_iko_bas_plan' => 'id']],
            [['id_ca_itp_weekly'], 'exist', 'skipOnError' => true, 'targetClass' => IkoItpWeekly::className(), 'targetAttribute' => ['id_ca_itp_weekly' => 'id']],
			[['id_ca_itp_weekly'], 'required', 'on'=>'create'],
			[['id_planning_iko_bas_plan', 'id_ca_itp_weekly'], 'unique', 'targetAttribute' => ['id_planning_iko_bas_plan', 'id_ca_itp_weekly'], 'message' => 'The IKO BAS Plan has been added to this list.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ca_itp_weekly' => 'Id Itp Weekly',
            'id_planning_iko_bas_plan' => 'Id Bas Iko',
        ];
    }

    public function getIdPlanningIkoBasPlan()
    {
        return $this->hasOne(PlanningIkoBasPlan::className(), ['id' => 'id_planning_iko_bas_plan']);
    }

    public function getIdIkoItpWeekly()
    {
        return $this->hasOne(IkoItpWeekly::className(), ['id' => 'id_ca_itp_weekly']);
    }

    public function getIkoItpDailies()
    {
        return $this->hasMany(IkoItpDaily::className(), ['id_iko_itp_area' => 'id']);
    }
}
