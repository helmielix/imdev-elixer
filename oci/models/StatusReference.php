<?php

namespace app\models;

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
 * @property CaBaSurvey[] $caBaSurveys0
 * @property CaBaSurvey[] $caBaSurveys1
 * @property FinanceInvoice[] $financeInvoices
 * @property FinanceRfp[] $financeRfps
 * @property FinanceRr[] $financeRrs
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property GovrelBaDistribution[] $govrelBaDistributions0
 * @property GovrelBankPublish[] $govrelBankPublishes
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits0
 * @property GovrelBgPermit[] $govrelBgPermits
 * @property GovrelInternalCoordination[] $govrelInternalCoordinations
 * @property GovrelOltPlacement[] $govrelOltPlacements
 * @property GovrelParBbfeedPermit[] $govrelParBbfeedPermits
 * @property GovrelParameterPicProblem[] $govrelParameterPicProblems
 * @property IkoGrfVendor[] $ikoGrfVendors
 * @property IkoGrfVendor[] $ikoGrfVendors0
 * @property IkoGrfVendor[] $ikoGrfVendors1
 * @property IkoGrfVendorDetail[] $ikoGrfVendorDetails
 * @property IkoItpDaily[] $ikoItpDailies
 * @property IkoItpMonthly[] $ikoItpMonthlies
 * @property IkoItpWeekly[] $ikoItpWeeklies
 * @property IkoProblem[] $ikoProblems
 * @property IkoProblem[] $ikoProblems0
 * @property IkoRfa[] $ikoRfas
 * @property IkoRfa[] $ikoRfas0
 * @property IkoTeamWo[] $ikoTeamWos
 * @property IkoWoActual[] $ikoWoActuals
 * @property IkoWoActual[] $ikoWoActuals0
 * @property IkoWoActual[] $ikoWoActuals1
 * @property IkoWoActual[] $ikoWoActuals2
 * @property IkoWoActual[] $ikoWoActuals3
 * @property IkoWoActual[] $ikoWoActuals4
 * @property IkoWoActual[] $ikoWoActuals5
 * @property IkoWorkOrder[] $ikoWorkOrders
 * @property IkoWorkOrder[] $ikoWorkOrders0
 * @property IkoWorkOrder[] $ikoWorkOrders1
 * @property IkoWorkOrder[] $ikoWorkOrders2
 * @property IkoWorkOrder[] $ikoWorkOrders3
 * @property IkoWorkOrder[] $ikoWorkOrders4
 * @property IkoWorkOrder[] $ikoWorkOrders5
 * @property IkoWorkOrder[] $ikoWorkOrders6
 * @property NetproGrfVendor[] $netproGrfVendors
 * @property NetproGrfVendor[] $netproGrfVendors0
 * @property NetproGrfVendor[] $netproGrfVendors1
 * @property NetproGrfVendorDetail[] $netproGrfVendorDetails
 * @property NetproObstacle[] $netproObstacles
 * @property NetproWo[] $netproWos
 * @property OsOutsourceParameter[] $osOutsourceParameters
 * @property OspGrfVendor[] $ospGrfVendors
 * @property OspGrfVendor[] $ospGrfVendors0
 * @property OspGrfVendor[] $ospGrfVendors1
 * @property OspGrfVendorDetail[] $ospGrfVendorDetails
 * @property OspManageOlt[] $ospManageOlts
 * @property OspManageOlt[] $ospManageOlts0
 * @property OspProblem[] $ospProblems
 * @property OspProblem[] $ospProblems0
 * @property OspRfa[] $ospRfas
 * @property OspRfa[] $ospRfas0
 * @property OspTeam[] $ospTeams
 * @property OspWoActual[] $ospWoActuals
 * @property OspWoActual[] $ospWoActuals0
 * @property OspWoActual[] $ospWoActuals1
 * @property OspWoActual[] $ospWoActuals2
 * @property OspWoActual[] $ospWoActuals3
 * @property OspWoActual[] $ospWoActuals4
 * @property OspWoActual[] $ospWoActuals5
 * @property OspWoTeamMember[] $ospWoTeamMembers
 * @property OspWorkOrder[] $ospWorkOrders
 * @property OspWorkOrder[] $ospWorkOrders0
 * @property OspWorkOrder[] $ospWorkOrders1
 * @property OspWorkOrder[] $ospWorkOrders2
 * @property OspWorkOrder[] $ospWorkOrders3
 * @property OspWorkOrder[] $ospWorkOrders4
 * @property OspWorkOrder[] $ospWorkOrders5
 * @property OspmGrf[] $ospmGrves
 * @property OspmGrfDetail[] $ospmGrfDetails
 * @property OspmObstacle[] $ospmObstacles
 * @property OspmTicketTrouble[] $ospmTicketTroubles
 * @property OspmTicketTrouble[] $ospmTicketTroubles0
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningIkoBoqB[] $planningIkoBoqBs
 * @property PlanningIkoBoqB[] $planningIkoBoqBs0
 * @property PlanningIkoBoqB[] $planningIkoBoqBs1
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningIkoBoqP[] $planningIkoBoqPs0
 * @property PlanningIkoBoqP[] $planningIkoBoqPs1
 * @property PlanningOspBas[] $planningOspBas
 * @property PlanningOspBoqB[] $planningOspBoqBs
 * @property PlanningOspBoqB[] $planningOspBoqBs0
 * @property PlanningOspBoqB[] $planningOspBoqBs1
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PlanningOspBoqP[] $planningOspBoqPs0
 * @property PlanningOspBoqP[] $planningOspBoqPs1
 * @property PlanningOspBoqP[] $planningOspBoqPs2
 * @property PplIkoAtp[] $pplIkoAtps
 * @property PplIkoAtp[] $pplIkoAtps0
 * @property PplIkoBastRetention[] $pplIkoBastRetentions
 * @property PplIkoBastWork[] $pplIkoBastWorks
 * @property PplIkoBaut[] $pplIkoBauts
 * @property PplOspAtp[] $pplOspAtps
 * @property PplOspAtp[] $pplOspAtps0
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
    public function rules()
    {
        return [
            [['status_listing', 'status_color'], 'required'],
            [['status_listing'], 'string', 'max' => 30],
            [['status_color'], 'string', 'max' => 15],
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
    public function getCaBaSurveys0()
    {
        return $this->hasMany(CaBaSurvey::className(), ['status_iom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys1()
    {
        return $this->hasMany(CaBaSurvey::className(), ['status_presurvey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasMany(FinanceInvoice::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRfps()
    {
        return $this->hasMany(FinanceRfp::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRrs()
    {
        return $this->hasMany(FinanceRr::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions()
    {
        return $this->hasMany(GovrelBaDistribution::className(), ['permit_result' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaDistributions0()
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
        return $this->hasMany(GovrelBbfeedPermit::className(), ['result_permit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBbfeedPermits0()
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
    public function getIkoGrfVendors()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors0()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['status_iko_grf_vendor_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors1()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['status_listing_usage' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendorDetails()
    {
        return $this->hasMany(IkoGrfVendorDetail::className(), ['status_usage' => 'id']);
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
    public function getIkoProblems0()
    {
        return $this->hasMany(IkoProblem::className(), ['status_listing_govrel' => 'id']);
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
    public function getIkoRfas0()
    {
        return $this->hasMany(IkoRfa::className(), ['status_rfr' => 'id']);
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
    public function getIkoWoActuals0()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_team' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals1()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals2()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_material_used' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals3()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_transport' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals4()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_material_need' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWoActuals5()
    {
        return $this->hasMany(IkoWoActual::className(), ['status_grf' => 'id']);
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
    public function getIkoWorkOrders0()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_team' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders1()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders2()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_material_used' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders3()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_transport' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders4()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_material_need' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders5()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_grf' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders6()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['status_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfVendors()
    {
        return $this->hasMany(NetproGrfVendor::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfVendors0()
    {
        return $this->hasMany(NetproGrfVendor::className(), ['status_netpro_grf_vendor_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfVendors1()
    {
        return $this->hasMany(NetproGrfVendor::className(), ['status_listing_usage' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproGrfVendorDetails()
    {
        return $this->hasMany(NetproGrfVendorDetail::className(), ['status_usage' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproObstacles()
    {
        return $this->hasMany(NetproObstacle::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproWos()
    {
        return $this->hasMany(NetproWo::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceParameters()
    {
        return $this->hasMany(OsOutsourceParameter::className(), ['status_listing' => 'id']);
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
    public function getOspGrfVendors0()
    {
        return $this->hasMany(OspGrfVendor::className(), ['status_osp_grf_vendor_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendors1()
    {
        return $this->hasMany(OspGrfVendor::className(), ['status_listing_usage' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspGrfVendorDetails()
    {
        return $this->hasMany(OspGrfVendorDetail::className(), ['status_usage' => 'id']);
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
    public function getOspManageOlts0()
    {
        return $this->hasMany(OspManageOlt::className(), ['status_planning' => 'id']);
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
    public function getOspProblems0()
    {
        return $this->hasMany(OspProblem::className(), ['status_listing_govrel' => 'id']);
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
    public function getOspRfas0()
    {
        return $this->hasMany(OspRfa::className(), ['status_rfr' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams()
    {
        return $this->hasMany(OspTeam::className(), ['status_team' => 'id']);
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
    public function getOspWoActuals0()
    {
        return $this->hasMany(OspWoActual::className(), ['status_team' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals1()
    {
        return $this->hasMany(OspWoActual::className(), ['status_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals2()
    {
        return $this->hasMany(OspWoActual::className(), ['status_material_used' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals3()
    {
        return $this->hasMany(OspWoActual::className(), ['status_transport' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals4()
    {
        return $this->hasMany(OspWoActual::className(), ['status_material_need' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWoActuals5()
    {
        return $this->hasMany(OspWoActual::className(), ['status_grf' => 'id']);
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
    public function getOspWorkOrders0()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_material_need' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders1()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_transport' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders2()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_team' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders3()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders4()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_material_used' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders5()
    {
        return $this->hasMany(OspWorkOrder::className(), ['status_grf' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmGrves()
    {
        return $this->hasMany(OspmGrf::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmGrfDetails()
    {
        return $this->hasMany(OspmGrfDetail::className(), ['status_usage' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmObstacles()
    {
        return $this->hasMany(OspmObstacle::className(), ['status_listing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmTicketTroubles()
    {
        return $this->hasMany(OspmTicketTrouble::className(), ['status_trouble' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmTicketTroubles0()
    {
        return $this->hasMany(OspmTicketTrouble::className(), ['status_listing' => 'id']);
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
    public function getPlanningIkoBoqBs0()
    {
        return $this->hasMany(PlanningIkoBoqB::className(), ['status_boq_b_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBs1()
    {
        return $this->hasMany(PlanningIkoBoqB::className(), ['status_final' => 'id']);
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
    public function getPlanningIkoBoqPs0()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['status_boq_p_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs1()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['status_final' => 'id']);
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
    public function getPlanningOspBoqBs0()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['status_boq_b_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBs1()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['status_final' => 'id']);
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
    public function getPlanningOspBoqPs0()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['status_boq_p_detail' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs1()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['status_final' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs2()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['status_coordination' => 'id']);
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
    public function getPplIkoAtps0()
    {
        return $this->hasMany(PplIkoAtp::className(), ['status_schedule' => 'id']);
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
    public function getPplOspAtps0()
    {
        return $this->hasMany(PplOspAtp::className(), ['status_schedule' => 'id']);
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
