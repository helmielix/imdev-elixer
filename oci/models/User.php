<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $blocked_at
 * @property string $auth_key
 * @property string $branch
 *
 * @property IkoDailyReport[] $ikoDailyReports
 * @property IkoDailyReport[] $ikoDailyReports0
 * @property Branch[] $branches
 * @property Branch[] $branches0
 * @property CaBaSurvey[] $caBaSurveys
 * @property CaBaSurvey[] $caBaSurveys0
 * @property CaIomAreaExpansion[] $caIomAreaExpansions
 * @property CaIomAreaExpansion[] $caIomAreaExpansions0
 * @property FinanceInvoice[] $financeInvoices
 * @property FinanceInvoice[] $financeInvoices0
 * @property FinanceRfp[] $financeRfps
 * @property FinanceRfp[] $financeRfps0
 * @property FinanceRr[] $financeRrs
 * @property FinanceRr[] $financeRrs0
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property GovrelBaDistribution[] $govrelBaDistributions0
 * @property GovrelBankPublish[] $govrelBankPublishes
 * @property GovrelBankPublish[] $govrelBankPublishes0
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits0
 * @property GovrelBgPermit[] $govrelBgPermits
 * @property GovrelBgPermit[] $govrelBgPermits0
 * @property GovrelInternalCoordination[] $govrelInternalCoordinations
 * @property GovrelInternalCoordination[] $govrelInternalCoordinations0
 * @property GovrelOltPlacement[] $govrelOltPlacements
 * @property GovrelOltPlacement[] $govrelOltPlacements0
 * @property GovrelParBbfeedPermit[] $govrelParBbfeedPermits
 * @property GovrelParBbfeedPermit[] $govrelParBbfeedPermits0
 * @property GovrelParameterPicProblem[] $govrelParameterPicProblems
 * @property GovrelParameterPicProblem[] $govrelParameterPicProblems0
 * @property IkoDailyReport[] $ikoDailyReports1
 * @property IkoDailyReport[] $ikoDailyReports2
 * @property IkoGrfVendor[] $ikoGrfVendors
 * @property IkoGrfVendor[] $ikoGrfVendors0
 * @property IkoItpDaily[] $ikoItpDailies
 * @property IkoItpDaily[] $ikoItpDailies0
 * @property IkoItpMonthly[] $ikoItpMonthlies
 * @property IkoItpMonthly[] $ikoItpMonthlies0
 * @property IkoItpWeekly[] $ikoItpWeeklies
 * @property IkoItpWeekly[] $ikoItpWeeklies0
 * @property IkoProblem[] $ikoProblems
 * @property IkoProblem[] $ikoProblems0
 * @property IkoRfa[] $ikoRfas
 * @property IkoRfa[] $ikoRfas0
 * @property IkoTeam[] $ikoTeams
 * @property IkoTeam[] $ikoTeams0
 * @property IkoTeamMember[] $ikoTeamMembers
 * @property IkoTeamMember[] $ikoTeamMembers0
 * @property IkoTeamWo[] $ikoTeamWos
 * @property IkoTeamWo[] $ikoTeamWos0
 * @property IkoWoActual[] $ikoWoActuals
 * @property IkoWoActual[] $ikoWoActuals0
 * @property IkoWorkOrder[] $ikoWorkOrders
 * @property IkoWorkOrder[] $ikoWorkOrders0
 * @property NetproGrfVendor[] $netproGrfVendors
 * @property NetproGrfVendor[] $netproGrfVendors0
 * @property NetproListStockBuffer[] $netproListStockBuffers
 * @property NetproListStockBuffer[] $netproListStockBuffers0
 * @property NetproObstacle[] $netproObstacles
 * @property NetproObstacle[] $netproObstacles0
 * @property NetproServiceReport[] $netproServiceReports
 * @property NetproServiceReport[] $netproServiceReports0
 * @property NetproWo[] $netproWos
 * @property NetproWo[] $netproWos0
 * @property OsOutsourceParameter[] $osOutsourceParameters
 * @property OsOutsourceParameter[] $osOutsourceParameters0
 * @property OspDailyReport[] $ospDailyReports
 * @property OspDailyReport[] $ospDailyReports0
 * @property OspGrfVendor[] $ospGrfVendors
 * @property OspGrfVendor[] $ospGrfVendors0
 * @property OspManageOlt[] $ospManageOlts
 * @property OspManageOlt[] $ospManageOlts0
 * @property OspProblem[] $ospProblems
 * @property OspProblem[] $ospProblems0
 * @property OspRfa[] $ospRfas
 * @property OspRfa[] $ospRfas0
 * @property OspTeam[] $ospTeams
 * @property OspTeam[] $ospTeams0
 * @property OspTeamMember[] $ospTeamMembers
 * @property OspTeamMember[] $ospTeamMembers0
 * @property OspWoActual[] $ospWoActuals
 * @property OspWoActual[] $ospWoActuals0
 * @property OspWoTeamMember[] $ospWoTeamMembers
 * @property OspWoTeamMember[] $ospWoTeamMembers0
 * @property OspWorkOrder[] $ospWorkOrders
 * @property OspWorkOrder[] $ospWorkOrders0
 * @property OspmGrf[] $ospmGrves
 * @property OspmGrf[] $ospmGrves0
 * @property OspmObstacle[] $ospmObstacles
 * @property OspmObstacle[] $ospmObstacles0
 * @property OspmTicketTrouble[] $ospmTicketTroubles
 * @property OspmTicketTrouble[] $ospmTicketTroubles0
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans0
 * @property PlanningIkoBoqB[] $planningIkoBoqBs
 * @property PlanningIkoBoqB[] $planningIkoBoqBs0
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails0
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningIkoBoqP[] $planningIkoBoqPs0
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails0
 * @property PlanningOspBas[] $planningOspBas
 * @property PlanningOspBas[] $planningOspBas0
 * @property PlanningOspBoqB[] $planningOspBoqBs
 * @property PlanningOspBoqB[] $planningOspBoqBs0
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails0
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PlanningOspBoqP[] $planningOspBoqPs0
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails0
 * @property PplIkoAtp[] $pplIkoAtps
 * @property PplIkoAtp[] $pplIkoAtps0
 * @property PplIkoBastRetention[] $pplIkoBastRetentions
 * @property PplIkoBastRetention[] $pplIkoBastRetentions0
 * @property PplIkoBastWork[] $pplIkoBastWorks
 * @property PplIkoBastWork[] $pplIkoBastWorks0
 * @property PplIkoBaut[] $pplIkoBauts
 * @property PplIkoBaut[] $pplIkoBauts0
 * @property PplOspAtp[] $pplOspAtps
 * @property PplOspAtp[] $pplOspAtps0
 * @property PplOspBastRetention[] $pplOspBastRetentions
 * @property PplOspBastRetention[] $pplOspBastRetentions0
 * @property PplOspBastWork[] $pplOspBastWorks
 * @property PplOspBastWork[] $pplOspBastWorks0
 * @property PplOspBaut[] $pplOspBauts
 * @property PplOspBaut[] $pplOspBauts0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'blocked_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'branch'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'blocked_at' => 'Blocked At',
            'auth_key' => 'Auth Key',
            'branch' => 'Branch',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoDailyReports()
    {
        return $this->hasMany(IkoDailyReport::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoDailyReports0()
    {
        return $this->hasMany(IkoDailyReport::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches0()
    {
        return $this->hasMany(Branch::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys()
    {
        return $this->hasMany(CaBaSurvey::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys0()
    {
        return $this->hasMany(CaBaSurvey::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaIomAreaExpansions()
    {
        return $this->hasMany(CaIomAreaExpansion::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaIomAreaExpansions0()
    {
        return $this->hasMany(CaIomAreaExpansion::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasMany(FinanceInvoice::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices0()
    {
        return $this->hasMany(FinanceInvoice::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRfps()
    {
        return $this->hasMany(FinanceRfp::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRfps0()
    {
        return $this->hasMany(FinanceRfp::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRrs()
    {
        return $this->hasMany(FinanceRr::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRrs0()
    {
        return $this->hasMany(FinanceRr::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions0()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBankPublishes()
    {
        return $this->hasMany(GovrelBankPublish::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBankPublishes0()
    {
        return $this->hasMany(GovrelBankPublish::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits0()
    {
        return $this->hasMany(GovrelBbfeedPermit::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBgPermits()
    {
        return $this->hasMany(GovrelBgPermit::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBgPermits0()
    {
        return $this->hasMany(GovrelBgPermit::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelInternalCoordinations()
    {
        return $this->hasMany(GovrelInternalCoordination::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelInternalCoordinations0()
    {
        return $this->hasMany(GovrelInternalCoordination::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelOltPlacements()
    {
        return $this->hasMany(GovrelOltPlacement::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelOltPlacements0()
    {
        return $this->hasMany(GovrelOltPlacement::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelParBbfeedPermits()
    {
        return $this->hasMany(GovrelParBbfeedPermit::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelParBbfeedPermits0()
    {
        return $this->hasMany(GovrelParBbfeedPermit::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelParameterPicProblems()
    {
        return $this->hasMany(GovrelParameterPicProblem::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelParameterPicProblems0()
    {
        return $this->hasMany(GovrelParameterPicProblem::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoDailyReports1()
    {
        return $this->hasMany(IkoDailyReport::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoDailyReports2()
    {
        return $this->hasMany(IkoDailyReport::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors0()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpDailies()
    {
        return $this->hasMany(IkoItpDaily::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpDailies0()
    {
        return $this->hasMany(IkoItpDaily::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpMonthlies()
    {
        return $this->hasMany(IkoItpMonthly::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpMonthlies0()
    {
        return $this->hasMany(IkoItpMonthly::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpWeeklies()
    {
        return $this->hasMany(IkoItpWeekly::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpWeeklies0()
    {
        return $this->hasMany(IkoItpWeekly::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems()
    {
        return $this->hasMany(IkoProblem::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems0()
    {
        return $this->hasMany(IkoProblem::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoRfas()
    {
        return $this->hasMany(IkoRfa::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoRfas0()
    {
        return $this->hasMany(IkoRfa::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeams()
    {
        return $this->hasMany(IkoTeam::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeams0()
    {
        return $this->hasMany(IkoTeam::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeamMembers()
    {
        return $this->hasMany(IkoTeamMember::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeamMembers0()
    {
        return $this->hasMany(IkoTeamMember::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeamWos()
    {
        return $this->hasMany(IkoTeamWo::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeamWos0()
    {
        return $this->hasMany(IkoTeamWo::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals()
    {
        return $this->hasMany(IkoWoActual::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals0()
    {
        return $this->hasMany(IkoWoActual::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders0()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfVendors()
    {
        return $this->hasMany(NetproGrfVendor::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfVendors0()
    {
        return $this->hasMany(NetproGrfVendor::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproListStockBuffers()
    {
        return $this->hasMany(NetproListStockBuffer::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproListStockBuffers0()
    {
        return $this->hasMany(NetproListStockBuffer::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproObstacles()
    {
        return $this->hasMany(NetproObstacle::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproObstacles0()
    {
        return $this->hasMany(NetproObstacle::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproServiceReports()
    {
        return $this->hasMany(NetproServiceReport::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproServiceReports0()
    {
        return $this->hasMany(NetproServiceReport::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproWos()
    {
        return $this->hasMany(NetproWo::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproWos0()
    {
        return $this->hasMany(NetproWo::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceParameters()
    {
        return $this->hasMany(OsOutsourceParameter::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceParameters0()
    {
        return $this->hasMany(OsOutsourceParameter::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspDailyReports()
    {
        return $this->hasMany(OspDailyReport::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspDailyReports0()
    {
        return $this->hasMany(OspDailyReport::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendors()
    {
        return $this->hasMany(OspGrfVendor::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendors0()
    {
        return $this->hasMany(OspGrfVendor::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspManageOlts()
    {
        return $this->hasMany(OspManageOlt::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspManageOlts0()
    {
        return $this->hasMany(OspManageOlt::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems()
    {
        return $this->hasMany(OspProblem::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems0()
    {
        return $this->hasMany(OspProblem::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspRfas()
    {
        return $this->hasMany(OspRfa::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspRfas0()
    {
        return $this->hasMany(OspRfa::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams()
    {
        return $this->hasMany(OspTeam::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams0()
    {
        return $this->hasMany(OspTeam::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeamMembers()
    {
        return $this->hasMany(OspTeamMember::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeamMembers0()
    {
        return $this->hasMany(OspTeamMember::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals()
    {
        return $this->hasMany(OspWoActual::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals0()
    {
        return $this->hasMany(OspWoActual::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoTeamMembers()
    {
        return $this->hasMany(OspWoTeamMember::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoTeamMembers0()
    {
        return $this->hasMany(OspWoTeamMember::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders()
    {
        return $this->hasMany(OspWorkOrder::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders0()
    {
        return $this->hasMany(OspWorkOrder::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmGrves()
    {
        return $this->hasMany(OspmGrf::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmGrves0()
    {
        return $this->hasMany(OspmGrf::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmObstacles()
    {
        return $this->hasMany(OspmObstacle::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmObstacles0()
    {
        return $this->hasMany(OspmObstacle::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmTicketTroubles()
    {
        return $this->hasMany(OspmTicketTrouble::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmTicketTroubles0()
    {
        return $this->hasMany(OspmTicketTrouble::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans0()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBs()
    {
        return $this->hasMany(PlanningIkoBoqB::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBs0()
    {
        return $this->hasMany(PlanningIkoBoqB::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails0()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs0()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails0()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas()
    {
        return $this->hasMany(PlanningOspBas::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas0()
    {
        return $this->hasMany(PlanningOspBas::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBs()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBs0()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails0()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs0()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails0()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps()
    {
        return $this->hasMany(PplIkoAtp::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps0()
    {
        return $this->hasMany(PplIkoAtp::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastRetentions()
    {
        return $this->hasMany(PplIkoBastRetention::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastRetentions0()
    {
        return $this->hasMany(PplIkoBastRetention::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastWorks()
    {
        return $this->hasMany(PplIkoBastWork::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastWorks0()
    {
        return $this->hasMany(PplIkoBastWork::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts()
    {
        return $this->hasMany(PplIkoBaut::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts0()
    {
        return $this->hasMany(PplIkoBaut::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps()
    {
        return $this->hasMany(PplOspAtp::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps0()
    {
        return $this->hasMany(PplOspAtp::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions0()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks()
    {
        return $this->hasMany(PplOspBastWork::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks0()
    {
        return $this->hasMany(PplOspBastWork::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts()
    {
        return $this->hasMany(PplOspBaut::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts0()
    {
        return $this->hasMany(PplOspBaut::className(), ['updated_by' => 'id']);
    }
}
