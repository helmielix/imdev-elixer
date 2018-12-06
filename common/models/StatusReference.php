<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status_reference".
 *
 * @property integer $id
 * @property string $status_listing
 * @property string $status_color
 *
 * @property IkoDailyReport[] $ikoDailyReports
 * @property CaBaSurvey[] $caBaSurveys
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property GovrelBankPublish[] $govrelBankPublishes
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits
 * @property GovrelBgPermit[] $govrelBgPermits
 * @property GovrelInternalCoordination[] $govrelInternalCoordinations
 * @property GovrelOltPlacement[] $govrelOltPlacements
 * @property GovrelParBbfeedPermit[] $govrelParBbfeedPermits
 * @property GovrelParameterPicProblem[] $govrelParameterPicProblems
 * @property IkoDailyReport[] $ikoDailyReports0
 * @property IkoGrfVendor[] $ikoGrfVendors
 * @property IkoItpDaily[] $ikoItpDailies
 * @property IkoItpMonthly[] $ikoItpMonthlies
 * @property IkoItpWeekly[] $ikoItpWeeklies
 * @property IkoProblem[] $ikoProblems
 * @property IkoRfa[] $ikoRfas
 * @property IkoTeamWo[] $ikoTeamWos
 * @property IkoWoActual[] $ikoWoActuals
 * @property IkoWorkOrder[] $ikoWorkOrders
 * @property OspGrfVendor[] $ospGrfVendors
 * @property OspManageOlt[] $ospManageOlts
 * @property OspProblem[] $ospProblems
 * @property OspRfa[] $ospRfas
 * @property OspSchedulling[] $ospSchedullings
 * @property OspWoActual[] $ospWoActuals
 * @property OspWoTeamMember[] $ospWoTeamMembers
 * @property OspWorkOrder[] $ospWorkOrders
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningIkoBoqB[] $planningIkoBoqBs
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningOspBas[] $planningOspBas
 * @property PlanningOspBoqB[] $planningOspBoqBs
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PplIkoAtp[] $pplIkoAtps
 * @property PplIkoBastRetention[] $pplIkoBastRetentions
 * @property PplIkoBastWork[] $pplIkoBastWorks
 * @property PplIkoBaut[] $pplIkoBauts
 * @property PplOspAtp[] $pplOspAtps
 * @property PplOspBastRetention[] $pplOspBastRetentions
 * @property PplOspBastWork[] $pplOspBastWorks
 * @property PplOspBaut[] $pplOspBauts
 */
class StatusReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_reference';
    }

    /**
     * @inheritdoc
     */
    public $status_return;
    public function rules()
    {
        return [
            [['status_listing', 'status_color'], 'required'],
            [['status_listing', 'status_color'], 'string', 'max' => 15],
            [['status_listing'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_listing' => 'Status Listing',
            'status_color' => 'Status Color',
        ];
    }

    public function displayText()
    {
        return ucwords($this->status_listing);
    }

    public static function findText($id, $uc = false)
    {
        $status = static::find()
            ->andWhere(['id' => $id])
            ->one()->status_listing;
        if ($uc) {
            return ucwords($status);
        }
        return $status;
    }

    public static function findColor($id)
    {
        return static::find()->andWhere(['id' => $id])->one()->status_color;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoDailyReports()
    {
        return $this->hasMany(IkoDailyReport::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys()
    {
        return $this->hasMany(CaBaSurvey::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBankPublishes()
    {
        return $this->hasMany(GovrelBankPublish::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBgPermits()
    {
        return $this->hasMany(GovrelBgPermit::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelInternalCoordinations()
    {
        return $this->hasMany(GovrelInternalCoordination::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelOltPlacements()
    {
        return $this->hasMany(GovrelOltPlacement::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelParBbfeedPermits()
    {
        return $this->hasMany(GovrelParBbfeedPermit::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelParameterPicProblems()
    {
        return $this->hasMany(GovrelParameterPicProblem::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoDailyReports0()
    {
        return $this->hasMany(IkoDailyReport::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpDailies()
    {
        return $this->hasMany(IkoItpDaily::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpMonthlies()
    {
        return $this->hasMany(IkoItpMonthly::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpWeeklies()
    {
        return $this->hasMany(IkoItpWeekly::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems()
    {
        return $this->hasMany(IkoProblem::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoRfas()
    {
        return $this->hasMany(IkoRfa::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeamWos()
    {
        return $this->hasMany(IkoTeamWo::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendors()
    {
        return $this->hasMany(OspGrfVendor::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspManageOlts()
    {
        return $this->hasMany(OspManageOlt::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems()
    {
        return $this->hasMany(OspProblem::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspRfas()
    {
        return $this->hasMany(OspRfa::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspSchedullings()
    {
        return $this->hasMany(OspSchedulling::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals()
    {
        return $this->hasMany(OspWoActual::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoTeamMembers()
    {
        return $this->hasMany(OspWoTeamMember::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBs()
    {
        return $this->hasMany(PlanningIkoBoqB::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas()
    {
        return $this->hasMany(PlanningOspBas::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBs()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps()
    {
        return $this->hasMany(PplIkoAtp::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastRetentions()
    {
        return $this->hasMany(PplIkoBastRetention::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastWorks()
    {
        return $this->hasMany(PplIkoBastWork::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts()
    {
        return $this->hasMany(PplIkoBaut::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps()
    {
        return $this->hasMany(PplOspAtp::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks()
    {
        return $this->hasMany(PplOspBastWork::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts()
    {
        return $this->hasMany(PplOspBaut::className(), ['status_listing' => 'id']);
    }
}
