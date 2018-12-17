<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reference".
 *
 * @property integer $id
 * @property string $description
 *
 * @property CaBaSurvey[] $caBaSurveys
 * @property FinanceRfp[] $financeRfps
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property GovrelBaDistribution[] $govrelBaDistributions0
 * @property GovrelBaDistribution[] $govrelBaDistributions1
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits0
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits1
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits2
 * @property GovrelBgPermit[] $govrelBgPermits
 * @property GovrelOltPlacement[] $govrelOltPlacements
 * @property GovrelOltPlacement[] $govrelOltPlacements0
 * @property GovrelOltPlacement[] $govrelOltPlacements1
 * @property IkoProblem[] $ikoProblems
 * @property IkoProblem[] $ikoProblems0
 * @property IkoRfa[] $ikoRfas
 * @property IkoWoActual[] $ikoWoActuals
 * @property IkoWorkOrder[] $ikoWorkOrders
 * @property NetproObstacle[] $netproObstacles
 * @property NetproWo[] $netproWos
 * @property NetproWo[] $netproWos0
 * @property OsOutsourcePersonil[] $osOutsourcePersonils
 * @property OsOutsourcePersonil[] $osOutsourcePersonils0
 * @property OsOutsourceSalary[] $osOutsourceSalaries
 * @property OsOutsourceSalary[] $osOutsourceSalaries0
 * @property OspManageOlt[] $ospManageOlts
 * @property OspProblem[] $ospProblems
 * @property OspProblem[] $ospProblems0
 * @property OspRfa[] $ospRfas
 * @property OspWorkOrder[] $ospWorkOrders
 * @property OspWorkOrder[] $ospWorkOrders0
 * @property OspmObstacle[] $ospmObstacles
 * @property OspmTicketTrouble[] $ospmTicketTroubles
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails0
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails1
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails0
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails1
 * @property PlanningOspBas[] $planningOspBas
 * @property PlanningOspBoqB[] $planningOspBoqBs
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails0
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails1
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails0
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails1
 * @property PplOspBastRetention[] $pplOspBastRetentions
 * @property PplOspBastWork[] $pplOspBastWorks
 */
class Reference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys()
    {
        return $this->hasMany(CaBaSurvey::className(), ['iom_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRfps()
    {
        return $this->hasMany(FinanceRfp::className(), ['adjustment' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['owner' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions0()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['free_mnc_play' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions1()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['govrel_permit_level' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits0()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['govrel_permit_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits1()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['free_mnc_play' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits2()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBgPermits()
    {
        return $this->hasMany(GovrelBgPermit::className(), ['govrel_guarantee_work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelOltPlacements()
    {
        return $this->hasMany(GovrelOltPlacement::className(), ['govrel_status_place' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelOltPlacements0()
    {
        return $this->hasMany(GovrelOltPlacement::className(), ['receipt' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelOltPlacements1()
    {
        return $this->hasMany(GovrelOltPlacement::className(), ['pks' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems()
    {
        return $this->hasMany(IkoProblem::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems0()
    {
        return $this->hasMany(IkoProblem::className(), ['level_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoRfas()
    {
        return $this->hasMany(IkoRfa::className(), ['executor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals()
    {
        return $this->hasMany(IkoWoActual::className(), ['reason' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['work_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproObstacles()
    {
        return $this->hasMany(NetproObstacle::className(), ['type_obstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproWos()
    {
        return $this->hasMany(NetproWo::className(), ['type_work' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproWos0()
    {
        return $this->hasMany(NetproWo::className(), ['type_service' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['religion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils0()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['education' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceSalaries()
    {
        return $this->hasMany(OsOutsourceSalary::className(), ['month' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceSalaries0()
    {
        return $this->hasMany(OsOutsourceSalary::className(), ['year' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspManageOlts()
    {
        return $this->hasMany(OspManageOlt::className(), ['status_olt' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems()
    {
        return $this->hasMany(OspProblem::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems0()
    {
        return $this->hasMany(OspProblem::className(), ['level_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspRfas()
    {
        return $this->hasMany(OspRfa::className(), ['work_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders()
    {
        return $this->hasMany(OspWorkOrder::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders0()
    {
        return $this->hasMany(OspWorkOrder::className(), ['wo_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmObstacles()
    {
        return $this->hasMany(OspmObstacle::className(), ['type_obstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmTicketTroubles()
    {
        return $this->hasMany(OspmTicketTrouble::className(), ['category' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails0()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails1()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['last_executor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails0()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails1()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas()
    {
        return $this->hasMany(PlanningOspBas::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBs()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails0()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails1()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails0()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails1()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks()
    {
        return $this->hasMany(PplOspBastWork::className(), ['attached_check' => 'id']);
    }
}
