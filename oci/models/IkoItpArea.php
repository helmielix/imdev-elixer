<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class IkoItpArea extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_itp_area';
    }

    public function rules()
    {
        return [
            [['id_planning_iko_boq_p'], 'required'],
            [['id_iko_itp_weekly', 'id_planning_iko_boq_p'], 'integer'],
            [['id_planning_iko_boq_p'], 'exist', 'skipOnError' => true, 'targetClass' => PlanningIkoBoqP::className(), 'targetAttribute' => ['id_planning_iko_boq_p' => 'id_planning_iko_bas_plan']],
            [['id_iko_itp_weekly'], 'exist', 'skipOnError' => true, 'targetClass' => IkoItpWeekly::className(), 'targetAttribute' => ['id_iko_itp_weekly' => 'id']],
			[['id_iko_itp_weekly'], 'required', 'on'=>'create'],
			[['id_planning_iko_boq_p'], 'unique', 'targetAttribute' => ['id_planning_iko_boq_p', 'id_iko_itp_weekly'], 'message' => 'The IKO BAS Plan has been added to this list.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_iko_itp_weekly' => 'ID ITP Weekly',
            'id_planning_iko_boq_p' => 'ID as Plan BOQ IKO',
        ];
    }

    public function getIdPlanningIkoBoqP()
    {
        return $this->hasOne(PlanningIkoBoqP::className(), ['id_planning_iko_bas_plan' => 'id_planning_iko_boq_p']);
    }

    public function getIdIkoItpWeekly()
    {
        return $this->hasOne(IkoItpWeekly::className(), ['id' => 'id_iko_itp_weekly']);
    }

    public function getIkoItpDailies()
    {
        return $this->hasMany(IkoItpDaily::className(), ['id_iko_itp_area' => 'id']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
