<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "labor".
 *
 * @property string $nik
 * @property string $name
 * @property string $position
 * @property string $division
 *
 * @property CaBaSurvey[] $caBaSurveys
 * @property CaBaSurvey[] $caBaSurveys0
 * @property FinanceInvoice[] $financeInvoices
 * @property FinanceRfp[] $financeRfps
 * @property IkoGrfVendor[] $ikoGrfVendors
 * @property IkoTeam[] $ikoTeams
 * @property LogPplIkoBaut[] $logPplIkoBauts
 * @property LogPplIkoBaut[] $logPplIkoBauts0
 * @property LogPplIkoBaut[] $logPplIkoBauts1
 * @property LogPplIkoBaut[] $logPplIkoBauts2
 * @property LogPplIkoBaut[] $logPplIkoBauts3
 * @property LogPplIkoBaut[] $logPplIkoBauts4
 * @property LogPplIkoBaut[] $logPplIkoBauts5
 * @property NetproProblem[] $netproProblems
 * @property NetproServiceReport[] $netproServiceReports
 * @property OsOutsourcePersonil[] $osOutsourcePersonils
 * @property OsVendorTermSheet[] $osVendorTermSheets
 * @property OspRfa[] $ospRfas
 * @property OspTeam[] $ospTeams
 * @property OspTeam[] $ospTeams0
 * @property OspmGrf[] $ospmGrves
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningOspBas[] $planningOspBas
 * @property PplIkoAtp[] $pplIkoAtps
 * @property PplIkoAtp[] $pplIkoAtps0
 * @property PplIkoAtp[] $pplIkoAtps1
 * @property PplIkoAtp[] $pplIkoAtps2
 * @property PplIkoAtp[] $pplIkoAtps3
 * @property PplIkoAtp[] $pplIkoAtps4
 * @property PplIkoAtp[] $pplIkoAtps5
 * @property PplIkoBastRetention[] $pplIkoBastRetentions
 * @property PplIkoBaut[] $pplIkoBauts
 * @property PplIkoBaut[] $pplIkoBauts0
 * @property PplIkoBaut[] $pplIkoBauts1
 * @property PplIkoBaut[] $pplIkoBauts2
 * @property PplIkoBaut[] $pplIkoBauts3
 * @property PplIkoBaut[] $pplIkoBauts4
 * @property PplIkoBaut[] $pplIkoBauts5
 * @property PplOspAtp[] $pplOspAtps
 * @property PplOspAtp[] $pplOspAtps0
 * @property PplOspAtp[] $pplOspAtps1
 * @property PplOspAtp[] $pplOspAtps2
 * @property PplOspAtp[] $pplOspAtps3
 * @property PplOspBastRetention[] $pplOspBastRetentions
 * @property PplOspBastRetention[] $pplOspBastRetentions0
 * @property PplOspBastRetention[] $pplOspBastRetentions1
 * @property PplOspBastRetention[] $pplOspBastRetentions2
 * @property PplOspBastWork[] $pplOspBastWorks
 * @property PplOspBastWork[] $pplOspBastWorks0
 * @property PplOspBastWork[] $pplOspBastWorks1
 * @property PplOspBastWork[] $pplOspBastWorks2
 * @property PplOspBastWork[] $pplOspBastWorks3
 * @property PplOspBaut[] $pplOspBauts
 * @property PplOspBaut[] $pplOspBauts0
 * @property PplOspBaut[] $pplOspBauts1
 */
class Labor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	public $file;
	
    public static function tableName()
    {
        return 'labor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik'], 'required'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position'], 'string', 'max' => 50],
           // [['division'], 'string', 'max' => 10],
			[['file'],'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'name' => 'Name',
            'position' => 'Position',
            'division' => 'Division',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys()
    {
        return $this->hasMany(CaBaSurvey::className(), ['pic_survey' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys0()
    {
        return $this->hasMany(CaBaSurvey::className(), ['pic_iom_special' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasMany(FinanceInvoice::className(), ['pic_finance' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRfps()
    {
        return $this->hasMany(FinanceRfp::className(), ['pic_finance' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeams()
    {
        return $this->hasMany(IkoTeam::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_kadiv_ppl' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts0()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_ppl' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts1()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts2()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts3()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_pm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts4()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_projectcontrol' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogPplIkoBauts5()
    {
        return $this->hasMany(LogPplIkoBaut::className(), ['pic_ikr' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproProblems()
    {
        return $this->hasMany(NetproProblem::className(), ['reporter' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetproServiceReports()
    {
        return $this->hasMany(NetproServiceReport::className(), ['pic_technical' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorTermSheets()
    {
        return $this->hasMany(OsVendorTermSheet::className(), ['pic_mkm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspRfas()
    {
        return $this->hasMany(OspRfa::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams()
    {
        return $this->hasMany(OspTeam::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams0()
    {
        return $this->hasMany(OspTeam::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspmGrves()
    {
        return $this->hasMany(OspmGrf::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['pic1' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas()
    {
        return $this->hasMany(PlanningOspBas::className(), ['pic1' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps0()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps1()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps2()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_planning' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps3()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_project_control' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps4()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_ikr' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps5()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_ca' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastRetentions()
    {
        return $this->hasMany(PplIkoBastRetention::className(), ['kadiv_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_kadiv_ppl' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts0()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_ppl' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts1()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts2()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts3()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_pm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts4()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_projectcontrol' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts5()
    {
        return $this->hasMany(PplIkoBaut::className(), ['pic_ikr' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps0()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_planning' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps1()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps2()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_ca' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps3()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_project_control' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions0()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions1()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['pic_pmo' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions2()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['pic_ppl' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks()
    {
        return $this->hasMany(PplOspBastWork::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks0()
    {
        return $this->hasMany(PplOspBastWork::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks1()
    {
        return $this->hasMany(PplOspBastWork::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks2()
    {
        return $this->hasMany(PplOspBastWork::className(), ['pic_pmo' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks3()
    {
        return $this->hasMany(PplOspBastWork::className(), ['pic_ppl' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts()
    {
        return $this->hasMany(PplOspBaut::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts0()
    {
        return $this->hasMany(PplOspBaut::className(), ['pic_pm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts1()
    {
        return $this->hasMany(PplOspBaut::className(), ['pic_ppl' => 'nik']);
    }
}
