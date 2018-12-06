<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reference".
 *
 * @property integer $id
 * @property string $description
 * @property string $table_relation
 *
 * @property CaBaSurvey[] $caBaSurveys
 * @property CiproProblem[] $ciproProblems
 * @property CiproProblem[] $ciproProblems0
 * @property CiproRfa[] $ciproRfas
 * @property CiproWoActual[] $ciproWoActuals
 * @property CiproWorkOrder[] $ciproWorkOrders
 * @property EmailParameter[] $emailParameters
 * @property FinanceInvoice[] $financeInvoices
 * @property GovrelBaCoorporate[] $govrelBaCoorporates
 * @property GovrelBaCoorporate[] $govrelBaCoorporates0
 * @property GovrelBaCoorporate[] $govrelBaCoorporates1
 * @property GovrelBaDistribution[] $govrelBaDistributions
 * @property GovrelBaDistribution[] $govrelBaDistributions0
 * @property GovrelBaDistribution[] $govrelBaDistributions1
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits0
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits1
 * @property GovrelBbfeedPermit[] $govrelBbfeedPermits2
 * @property GovrelBgPermit[] $govrelBgPermits
 * @property GovrelBgPermit[] $govrelBgPermits0
 * @property GovrelOltPlacement[] $govrelOltPlacements
 * @property GovrelOltPlacement[] $govrelOltPlacements0
 * @property GovrelOltPlacement[] $govrelOltPlacements1
 * @property IkoProblem[] $ikoProblems
 * @property IkoProblem[] $ikoProblems0
 * @property IkoRfa[] $ikoRfas
 * @property IkoWoActual[] $ikoWoActuals
 * @property IkoWorkOrder[] $ikoWorkOrders
 * @property LogPplIkoBaut[] $logPplIkoBauts
 * @property NetproProblem[] $netproProblems
 * @property NetproProblem[] $netproProblems0
 * @property NetproServiceReport[] $netproServiceReports
 * @property NetproWo[] $netproWos
 * @property NetproWo[] $netproWos0
 * @property OsGaBiayaJalanIko[] $osGaBiayaJalanIkos
 * @property OsGaBiayaJalanOsp[] $osGaBiayaJalanOsps
 * @property OsGaVehicleParameter[] $osGaVehicleParameters
 * @property OsOutsourcePersonil[] $osOutsourcePersonils
 * @property OsOutsourcePersonil[] $osOutsourcePersonils0
 * @property OsOutsourcePersonil[] $osOutsourcePersonils1
 * @property OsOutsourcePersonil[] $osOutsourcePersonils2
 * @property OsOutsourcePersonil[] $osOutsourcePersonils3
 * @property OsOutsourceSalary[] $osOutsourceSalaries
 * @property OsOutsourceSalary[] $osOutsourceSalaries0
 * @property OsVendorLegalParameter[] $osVendorLegalParameters
 * @property OsVendorRegistVendor[] $osVendorRegistVendors
 * @property OsVendorSpk[] $osVendorSpks
 * @property OsVendorSpk[] $osVendorSpks0
 * @property OsVendorSpkDetail[] $osVendorSpkDetails
 * @property OsVendorSpkDetail[] $osVendorSpkDetails0
 * @property OsVendorSpkDetail[] $osVendorSpkDetails1
 * @property OspDailyReport[] $ospDailyReports
 * @property OspManageOlt[] $ospManageOlts
 * @property OspProblem[] $ospProblems
 * @property OspProblem[] $ospProblems0
 * @property OspRfa[] $ospRfas
 * @property OspWorkOrder[] $ospWorkOrders
 * @property OspWorkOrder[] $ospWorkOrders0
 * @property OspmObstacle[] $ospmObstacles
 * @property PlanningCiproBasPlan[] $planningCiproBasPlans
 * @property PlanningCiproBoqBDetail[] $planningCiproBoqBDetails
 * @property PlanningCiproBoqBDetail[] $planningCiproBoqBDetails0
 * @property PlanningCiproBoqBDetail[] $planningCiproBoqBDetails1
 * @property PlanningCiproBoqP[] $planningCiproBoqPs
 * @property PlanningCiproBoqPDetail[] $planningCiproBoqPDetails
 * @property PlanningCiproBoqPDetail[] $planningCiproBoqPDetails0
 * @property PlanningCiproBoqPDetail[] $planningCiproBoqPDetails1
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails
 * @property PlanningOspBas[] $planningOspBas
 * @property PlanningOspBoqB[] $planningOspBoqBs
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails
 * @property PplCiproBastRetention[] $pplCiproBastRetentions
 * @property PplCiproBastWork[] $pplCiproBastWorks
 * @property PplCiproBaut[] $pplCiproBauts
 * @property PplIkoBastRetention[] $pplIkoBastRetentions
 * @property PplIkoBastWork[] $pplIkoBastWorks
 * @property PplIkoBaut[] $pplIkoBauts
 * @property PplOspBastRetention[] $pplOspBastRetentions
 * @property PplOspBastWork[] $pplOspBastWorks
 * @property PplOspBaut[] $pplOspBauts
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
            [['table_relation'], 'string'],
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
            'table_relation' => 'Table Relation',
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
    public function getCiproProblems()
    {
        return $this->hasMany(CiproProblem::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiproProblems0()
    {
        return $this->hasMany(CiproProblem::className(), ['level_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiproRfas()
    {
        return $this->hasMany(CiproRfa::className(), ['executor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiproWoActuals()
    {
        return $this->hasMany(CiproWoActual::className(), ['reason' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiproWorkOrders()
    {
        return $this->hasMany(CiproWorkOrder::className(), ['work_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailParameters()
    {
        return $this->hasMany(EmailParameter::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasMany(FinanceInvoice::className(), ['invoice_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaCoorporates()
    {
        return $this->hasMany(GovrelBaCoorporate::className(), ['id_owner' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaCoorporates0()
    {
        return $this->hasMany(GovrelBaCoorporate::className(), ['free_mnc_play' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBaCoorporates1()
    {
        return $this->hasMany(GovrelBaCoorporate::className(), ['executor_type' => 'id']);
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
        return $this->hasMany(GovrelBgPermit::className(), ['id_govrel_bank_publish' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGovrelBgPermits0()
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
    public function getLogPplIkoBauts()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproProblems()
    {
        return $this->hasMany(NetproProblem::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproProblems0()
    {
        return $this->hasMany(NetproProblem::className(), ['level_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproServiceReports()
    {
        return $this->hasMany(NetproServiceReport::className(), ['type_customer' => 'id']);
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
    public function getOsGaBiayaJalanIkos()
    {
        return $this->hasMany(OsGaBiayaJalanIko::className(), ['mobil_rental' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaBiayaJalanOsps()
    {
        return $this->hasMany(OsGaBiayaJalanOsp::className(), ['mobil_rental' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsGaVehicleParameters()
    {
        return $this->hasMany(OsGaVehicleParameter::className(), ['vehicle_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['id_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils0()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['gender' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils1()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['religion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils2()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['marital_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils3()
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
    public function getOsVendorLegalParameters()
    {
        return $this->hasMany(OsVendorLegalParameter::className(), ['id_reference' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorRegistVendors()
    {
        return $this->hasMany(OsVendorRegistVendor::className(), ['contract_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorSpks()
    {
        return $this->hasMany(OsVendorSpk::className(), ['project_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorSpks0()
    {
        return $this->hasMany(OsVendorSpk::className(), ['currency' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorSpkDetails()
    {
        return $this->hasMany(OsVendorSpkDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorSpkDetails0()
    {
        return $this->hasMany(OsVendorSpkDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorSpkDetails1()
    {
        return $this->hasMany(OsVendorSpkDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspDailyReports()
    {
        return $this->hasMany(OspDailyReport::className(), ['work_type' => 'id']);
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
    public function getPlanningCiproBasPlans()
    {
        return $this->hasMany(PlanningCiproBasPlan::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqBDetails()
    {
        return $this->hasMany(PlanningCiproBoqBDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqBDetails0()
    {
        return $this->hasMany(PlanningCiproBoqBDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqBDetails1()
    {
        return $this->hasMany(PlanningCiproBoqBDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqPs()
    {
        return $this->hasMany(PlanningCiproBoqP::className(), ['last_executor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqPDetails()
    {
        return $this->hasMany(PlanningCiproBoqPDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqPDetails0()
    {
        return $this->hasMany(PlanningCiproBoqPDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningCiproBoqPDetails1()
    {
        return $this->hasMany(PlanningCiproBoqPDetail::className(), ['unit' => 'id']);
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
    public function getPplCiproBastRetentions()
    {
        return $this->hasMany(PplCiproBastRetention::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplCiproBastWorks()
    {
        return $this->hasMany(PplCiproBastWork::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplCiproBauts()
    {
        return $this->hasMany(PplCiproBaut::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastRetentions()
    {
        return $this->hasMany(PplIkoBastRetention::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastWorks()
    {
        return $this->hasMany(PplIkoBastWork::className(), ['attached_check' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts()
    {
        return $this->hasMany(PplIkoBaut::className(), ['attached_check' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts()
    {
        return $this->hasMany(PplOspBaut::className(), ['attached_check' => 'id']);
    }
}
