<?php

namespace usermanagement\controllers;

use Yii;
use app\models\AuthItem;
use app\models\AuthItemChild;
use app\models\SearchAuthItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Auth_itemController implements the CRUD actions for AuthItem model.
 */
class Auth_itemController extends Controller
{
    /**
     * @inheritdoc
     */
	private $arrAccessMap = array(

		//----- User Management var declaration -----
		// User management
		'um_create' => array('/admin/user/index','/admin/user/before','/admin/user/after','/admin/user/view','/admin/user/delete','/admin/user/login','/admin/user/logout','/admin/user/signup','/admin/user/update','/admin/user/requestpasswordreset','/admin/user/resetpassword','/admin/user/changepassword','/admin/user/activate','/admin/user/suspend'),
		'um_role'  => array('/auth_item/index','/auth_item/view','/auth_item/save_array','/auth_item/create','/auth_item/update','/auth_item/delete'),
		'um_users'  => array('/admin/user/before','/admin/user/after','/admin/user/index','/admin/user/view','/admin/user/delete','/admin/user/login','/admin/user/logout','/admin/user/signup','/admin/user/update','/admin/user/requestpasswordreset','/admin/user/resetpassword','/admin/user/changepassword','/admin/user/activate','/admin/user/suspend'),
		'um_branch_setting'  => array('/branch/index','/branch/view','/branch/create','/branch/update','/branch/delete'),
		'um_labor_setting'  => array('/labor/index','/labor/view','/labor/create','/labor/update','/labor/delete','/labor/downloadfile'),
		'um_email_parameter_setting'  => array('/email-parameter/index'),
		'um_manage_warehouse'  => array('/warehouse/index','/warehouse/view','/warehouse/update','/warehouse/create','/warehouse/delete'),

		//----- GOVREL var declaration -----
		//govrel dashboard
		'govrel_dashboard_view' => array('/dashboard-govrel/index','/dashboard-govrel/getchartbyregion','/dashboard-govrel/map','/map/getareaextent', 'govrel-olt-placement/downloadfileplanningospmanageolt', 'govrel-olt-placement/downloadfileupload1', 'govrel-olt-placement/downloadfileupload2', 'govrel-olt-placement/downloadfileupload3', 'govrel-olt-placement/downloadfileupload4', 'govrel-olt-placement/downloadfileupload5', 'govrel-olt-placement/downloadfileplanningospmanageoltview', 'govrel-olt-placement/downloadfileplanningospmanageoltform', 'govrel-ba-distribution/downloadfilecaview', 'govrel-ba-distribution/downloadfileplanningikoboqpview', 'govrel-ba-distribution/downloadfilecabasurveyview', 'govrel-ba-distribution/downloadfilecaiomareaexpview'),

		//govrel internal coordination
		'govrel_ic_input' => array('/govrel-internal-coordination/index','/govrel-internal-coordination/view','/govrel-internal-coordination/create','/govrel-internal-coordination/update','/govrel-internal-coordination/delete','/govrel-internal-coordination/downloadfile','/govrel-internal-coordination/downloadfileplanningospboqp','/govrel-internal-coordination/rejectplanning'),
		'govrel_ic_verifikasi' => array('/govrel-internal-coordination/indexverify','/govrel-internal-coordination/viewverify','/govrel-internal-coordination/verify','/govrel-internal-coordination/revise','/govrel-internal-coordination/reject','/govrel-internal-coordination/downloadfile'),
		'govrel_ic_approve' => array('/govrel-internal-coordination/indexapprove','/govrel-internal-coordination/viewapprove','/govrel-internal-coordination/approve','/govrel-internal-coordination/revise','/govrel-internal-coordination/reject','/govrel-internal-coordination/downloadfile','/govrel-internal-coordination/exportpdf'),
		'govrel_ic_overview' => array('/govrel-internal-coordination/indexoverview','/govrel-internal-coordination/viewoverview','/govrel-internal-coordination/downloadfile','/govrel-internal-coordination/viewplanningospboqp','/govrel-internal-coordination/exportpdf','/govrel-internal-coordination/downloadfileplanningospboqp'),
		'govrel_ic_historical' => array('/log-govrel-internal-coordination/index','/log-govrel-internal-coordination/view','/log-govrel-internal-coordination/create','/log-govrel-internal-coordination/update','/log-govrel-internal-coordination/delete','/log-govrel-internal-coordination/downloadfile'),

		//govrel backbone feeder
		'govrel_bfp_input' => array('/govrel-bbfeed-permit/index','/govrel-bbfeed-permit/view','/govrel-bbfeed-permit/create','/govrel-bbfeed-permit/update','/govrel-bbfeed-permit/delete','/govrel-bbfeed-permit/repermit','/govrel-bbfeed-permit/downloadfile','/govrel-bbfeed-permit/viewinternalcoordination'),
		'govrel_bfp_verifikasi' => array('/govrel-bbfeed-permit/indexverify','/govrel-bbfeed-permit/viewverify','/govrel-bbfeed-permit/verify','/govrel-bbfeed-permit/revise','/govrel-bbfeed-permit/reject','/govrel-bbfeed-permit/downloadfile','/govrel-bbfeed-permit/viewinternalcoordination'),
		'govrel_bfp_approve' => array('/govrel-bbfeed-permit/indexapprove','/govrel-bbfeed-permit/viewapprove','/govrel-bbfeed-permit/approve','/govrel-bbfeed-permit/reject','/govrel-bbfeed-permit/revise','/govrel-bbfeed-permit/downloadfile','/govrel-bbfeed-permit/exportpdf','/govrel-bbfeed-permit/viewoverview'),
		'govrel_bfp_overview' => array('/govrel-bbfeed-permit/indexoverview','/govrel-bbfeed-permit/viewoverview','/govrel-bbfeed-permit/repermit','/govrel-bbfeed-permit/downloadfile','/govrel-bbfeed-permit/downloadfileplanningospboqp','/govrel-bbfeed-permit/viewinternalcoordination'),
		'govrel_bfp_historical' => array('/log-govrel-bbfeed-permit/index','/log-govrel-bbfeed-permit/view','/log-govrel-bbfeed-permit/downloadfile'),

		//govrel bank guarantee
		'govrel_bg_input' => array('/govrel-bg-permit/index','/govrel-bg-permit/view','/govrel-bg-permit/create','/govrel-bg-permit/update','/govrel-bg-permit/delete','/govrel-bg-permit/intervaltime','/govrel-bg-permit/downloadfile'),
		'govrel_bg_verifikasi' => array('/govrel-bg-permit/indexverify','/govrel-bg-permit/viewverify','/govrel-bg-permit/delete','/govrel-bg-permit/downloadfile','/govrel-bg-permit/intervaltime','/govrel-bg-permit/revise','/govrel-bg-permit/reject','/govrel-bg-permit/verify'),
		'govrel_bg_approve' => array('/govrel-bg-permit/indexapprove','/govrel-bg-permit/viewapprove','/govrel-bg-permit/delete','/govrel-bg-permit/downloadfile','/govrel-bg-permit/intervaltime','/govrel-bg-permit/revise','/govrel-bg-permit/reject','/govrel-bg-permit/approve','/govrel-bg-permit/exportpdf'),
		'govrel_bg_overview' => array('/govrel-bg-permit/indexoverview','/govrel-bg-permit/viewoverview','/govrel-bg-permit/intervaltime','/govrel-bg-permit/downloadfile'),
		'govrel_bg_historical' => array('/log-govrel-bg-permit/index','/log-govrel-bg-permit/view','/log-govrel-bg-permit/create','/log-govrel-bg-permit/update','/log-govrel-bg-permit/delete','/log-govrel-bg-permit/downloadfile'),

		//govrel olt placement
		'govrel_olt_input' => array('/govrel-olt-placement/index','/govrel-olt-placement/view','/govrel-olt-placement/create','/govrel-olt-placement/update','/govrel-olt-placement/delete','/govrel-olt-placement/indexoverview','/govrel-olt-placement/viewoverview','/govrel-olt-placement/viewtask','/govrel-olt-placement/repermit','/govrel-olt-placement/downloadfile','/govrel-olt-placement/viewospmanageolt','/govrel-olt-placement/downloadfileospmanageolt','/govrel-olt-placement/deactivate'),
		'govrel_olt_verifikasi' => array('/govrel-olt-placement/indexverify','/govrel-olt-placement/viewverify','/govrel-olt-placement/verify','/govrel-olt-placement/revise','/govrel-olt-placement/reject','/govrel-olt-placement/indexoverview','/govrel-olt-placement/viewoverview','/govrel-olt-placement/viewtask'),
		'govrel_olt_approve' => array('/govrel-olt-placement/indexapprove','/govrel-olt-placement/viewapprove','/govrel-olt-placement/approve','/govrel-olt-placement/revise','/govrel-olt-placement/reject','/govrel-olt-placement/update','/govrel-olt-placement/downloadfile','govrel-olt-placement/list','govrel-olt-placement/revise','govrel-olt-placement/reject','govrel-olt-placement/approve','/govrel-olt-placement/viewtask','/govrel-olt-placement/exportpdf'),
		'govrel_olt_overview' => array('/govrel-olt-placement/indexoverview','/govrel-olt-placement/viewoverview','/govrel-olt-placement/viewtask','/govrel-olt-placement/repermit','/govrel-olt-placement/downloadfile','/govrel-olt-placement/viewospmanageolt','/govrel-olt-placement/downloadfileospmanageolt'),
		'govrel_olt_historical' => array('/log-govrel-olt-placement/index','/log-govrel-olt-placement/view','/log-govrel-olt-placement/downloadfile','/govrel-olt-placement/downloadfileospmanageolt'),

		// govrel BAD - rollout
		'govrel_badRoll_input' => array('/govrel-ba-distribution/indexrollout','/govrel-ba-distribution/index','/govrel-ba-distribution/create','/govrel-ba-distribution/delete','/govrel-ba-distribution/exportexcel','/govrel-ba-distribution/viewrollout','/govrel-ba-distribution/updaterollout','/govrel-ba-distribution/viewplanningikoboqp','/govrel-ba-distribution/downloadfileplanningikoboqp'),
		'govrel_badRoll_verifikasi' => array('/govrel-ba-distribution/indexverifyrollout','/govrel-ba-distribution/indexverify','/govrel-ba-distribution/viewverifyrollout','/govrel-ba-distribution/verifyrollout','/govrel-ba-distribution/reviserollout','/govrel-ba-distribution/rejectrollout'),
		'govrel_badRoll_approve' => array('/govrel-ba-distribution/indexapproverollout','/govrel-ba-distribution/indexapprove','/govrel-ba-distribution/viewapproverollout','/govrel-ba-distribution/approverollout','/govrel-ba-distribution/approve','/govrel-ba-distribution/reviserollout','/govrel-ba-distribution/rejectrollout','/govrel-ba-distribution/exportpdf','/govrel-ba-distribution/viewplanningikoboqp', '/govrel-ba-distribution/repermit'),
		'govrel_badRoll_overview' => array('/govrel-ba-distribution/indexoverviewrollout','/govrel-ba-distribution/indexoverview','/govrel-ba-distribution/viewoverviewrollout','/govrel-ba-distribution/downloadfile','/govrel-ba-distribution/viewplanningikoboqp'),
		'govrel_badRoll_historical' => array('/log-govrel-ba-distribution/indexrollout','/log-govrel-ba-distribution/index','/log-govrel-ba-distribution/view','/log-govrel-ba-distribution/viewrollout','/log-govrel-ba-distribution/create','/log-govrel-ba-distribution/update','/log-govrel-ba-distribution/delete','/log-govrel-ba-distribution/downloadfile'),


		//govrel Problem IKO
		'govrel_problem_iko_input' => array('/govrel-iko-problem/index','/govrel-iko-problem/view','/govrel-iko-problem/create','/govrel-iko-problem/update','/govrel-iko-problem/delete','/govrel-iko-problem/viewtask'),
		'govrel_problem_iko_verifikasi' => array('/govrel-iko-problem/indexverify','/govrel-iko-problem/viewverify','/govrel-iko-problem/verify','/govrel-iko-problem/revise','/govrel-iko-problem/reject'),
		'govrel_problem_iko_approve' => array('/govrel-iko-problem/indexapprove','/govrel-iko-problem/viewapprove','/govrel-iko-problem/approve','/govrel-iko-problem/revise'),
		'govrel_problem_iko_overview' => array('/govrel-iko-problem/indexoverview','/govrel-iko-problem/viewoverview'),

		//govrel Problem OSP
		'govrel_problem_osp_input' => array('/govrel-osp-problem/index','/govrel-osp-problem/view','/govrel-osp-problem/create','/govrel-osp-problem/update','/govrel-osp-problem/delete','/govrel-osp-problem/indexoverview','/govrel-osp-problem/viewoverview','/govrel-osp-problem/viewtask'),
		'govrel_problem_osp_verifikasi' => array('/govrel-osp-problem/indexverify','/govrel-osp-problem/viewverify','/govrel-osp-problem/verify','/govrel-osp-problem/revise','/govrel-osp-problem/reject'),
		'govrel_problem_osp_approve' => array('/govrel-osp-problem/indexapprove','/govrel-osp-problem/viewapprove','/govrel-osp-problem/approve','/govrel-osp-problem/revise'),
		'govrel_problem_osp_overview' => array('/govrel-osp-problem/indexoverview','/govrel-osp-problem/viewoverview','/govrel-osp-problem/viewtask'),

		//govrel Parameter BB Feeder
		'govrel_parameter_bfp_input' => array('/govrel-par-bbfeed-permit/index','/govrel-par-bbfeed-permit/view','/govrel-par-bbfeed-permit/create','/govrel-par-bbfeed-permit/update','/govrel-par-bbfeed-permit/delete'),
		'govrel_parameter_bfp_approve' => array('/govrel-par-bbfeed-permit/indexapprove','/govrel-par-bbfeed-permit/viewapprove','/govrel-par-bbfeed-permit/create','/govrel-par-bbfeed-permit/update','/govrel-par-bbfeed-permit/delete','/govrel-par-bbfeed-permit/revise','/govrel-par-bbfeed-permit/reject','/govrel-par-bbfeed-permit/approve'),
		'govrel_parameter_bfp_overview' => array('/govrel-par-bbfeed-permit/indexoverview'),
		'govrel_parameter_bfp_verifikasi' => array('/govrel-par-bbfeed-permit/indexverify'),

		//govrel Parameter PIC Problem
		'govrel_parameter_problem_input' => array('/govrel-parameter-pic-problem/index','/govrel-parameter-pic-problem/view','/govrel-parameter-pic-problem/create','/govrel-parameter-pic-problem/update','/govrel-parameter-pic-problem/delete'),
		'govrel_parameter_problem_approve' => array('/govrel-parameter-pic-problem/indexapprove','/govrel-parameter-pic-problem/viewapprove','/govrel-parameter-pic-problem/delete','/govrel-parameter-pic-problem/revise','/govrel-parameter-pic-problem/reject','/govrel-parameter-pic-problem/approve','/govrel-parameter-pic-problem/delete'),
		'govrel_parameter_problem_overview' => array('/govrel-parameter-pic-problem/indexoverview'),
		'govrel_parameter_problem_verifikasi' => array('/govrel-parameter-pic-problem/indexverify'),

		//govrel Parameter Bank
		'govrel_parameter_bank_input' => array('/govrel-bank-publish/index','/govrel-bank-publish/view','/govrel-bank-publish/create','/govrel-bank-publish/update','/govrel-bank-publish/delete'),

        //govrel Parameter Reminder
		'govrel_parameter_reminder_input' => array('/govrel-parameter-reminder/index', '/govrel-parameter-reminder/view', '/govrel-parameter-reminder/create', '/govrel-parameter-reminder/update', '/govrel-parameter-reminder/delete'),

		//govrel ca ba survey
		'govrel_caBAS_view' => array('/govrel-ca-ba-survey/index','/govrel-ca-ba-survey/view','/govrel-ca-ba-survey/downloadfile'),

		//----- CA var declaration -----
		// ca dashboard
		'ca_dashboard_view' => array('/dashboard-ca/index','/dashboard-ca/map','/site/getdistrictbyiom','/site/getsubdistrict','/map/getareaextent','/dashboard-ca/get-dash-ca-hp-by-city'),

		//ca manage city
		'ca_manageCity_input' => array('/ca-iom-area-expansion/index','/ca-iom-area-expansion/view','/ca-iom-area-expansion/create','/ca-iom-area-expansion/update','/ca-iom-area-expansion/delete','/ca-iom-area-expansion/save','/ca-iom-area-expansion/indexcity','/ca-iom-area-expansion/createcity','/ca-iom-area-expansion/deletecity','/ca-iom-area-expansion/downloadfile'),
		'ca_manageCity_verifikasi' => array('/ca-iom-area-expansion/indexverify','/ca-iom-area-expansion/viewverify','/ca-iom-area-expansion/verify','/ca-iom-area-expansion/reviseverify','/ca-iom-area-expansion/rejectverify'),
		'ca_manageCity_approve' => array('/ca-iom-area-expansion/indexapprove','/ca-iom-area-expansion/viewapprove','/ca-iom-area-expansion/approve','/ca-iom-area-expansion/reviseapprove','/ca-iom-area-expansion/rejectapprove','/ca-iom-area-expansion/downloadfile'),
		'ca_manageCity_overview' => array('/ca-iom-area-expansion/indexoverview','/ca-iom-area-expansion/viewoverview','/ca-iom-area-expansion/downloadfile','/ca-iom-area-expansion/indexcitylog','/ca-iom-area-expansion/indexlog','/ca-iom-area-expansion/viewlog'),

		// ca manage area - pre bas
		'ca_preBas_input' => array('/ca-ba-survey/create_presurvey','/ca-ba-survey/index_presurvey','/ca-ba-survey/view','/ca-ba-survey/view_presurvey','/ca-ba-survey/view_potensial','/ca-ba-survey/create','/ca-ba-survey/update','/ca-ba-survey/update_presurvey','/ca-ba-survey/delete','/ca-ba-survey/downloadfile','/ca-ba-survey/exportxls', '/ca-ba-survey/createpolygon','/site/getcityapproved','/site/getiombycity','/ca-ba-survey/delete_potensial'),
		'ca_preBas_verifikasi' => array('/ca-ba-survey/indexverify_presurvey','/ca-ba-survey/indexverify_potensial','/ca-ba-survey/viewverify_presurvey','/ca-ba-survey/verify_presurvey','/ca-ba-survey/viewverify_potensial','/ca-ba-survey/verify_potensial','/ca-ba-survey/revise','/ca-ba-survey/revise_presurvey','/ca-ba-survey/revise_potensial','/ca-ba-survey/reject','/ca-ba-survey/reject_potensial','/ca-ba-survey/reject_presurvey','/ca-ba-survey/downloadfile','/map/getareaextent'),
		'ca_preBas_approve' => array('/ca-ba-survey/indexapprove_presurvey','/ca-ba-survey/indexapprove_potensial','/ca-ba-survey/index_potensial','/ca-ba-survey/viewapprove_presurvey','/ca-ba-survey/viewapprove_potensial','/ca-ba-survey/approve_presurvey','/ca-ba-survey/revise','/ca-ba-survey/revise_presurvey','/ca-ba-survey/revise_potensial','/ca-ba-survey/reject','/ca-ba-survey/reject_potensial','/ca-ba-survey/reject_presurvey','/ca-ba-survey/downloadfile','/map/getareaextent','/ca-ba-survey/approve_potensial'),
		'ca_preBas_overview' => array('/ca-ba-survey/indexoverview_presurvey','/ca-iom-area-expansion/viewoverview','/ca-ba-survey/viewoverview_presurvey','/ca-ba-survey/exportxls','/ca-ba-survey/downloadfile','/map/getareaextent','/ca-ba-survey/indexlog'),

		// ca manage area - bas
		'ca_bas_input' => array('/ca-ba-survey/index','/ca-ba-survey/view','/ca-ba-survey/create','/ca-ba-survey/update','/ca-ba-survey/delete','/ca-ba-survey/downloadfile','/ca-ba-survey/exportxls','/ca-ba-survey/createpolygon','/ca-ba-survey/repermit','/map/getareaextent'),
		'ca_bas_verifikasi' => array('/ca-ba-survey/indexverify','/ca-ba-survey/viewverify','/ca-ba-survey/verify','/ca-ba-survey/revise','/ca-ba-survey/reject','/ca-ba-survey/downloadfile','/ca-ba-survey/exportxls','/map/getareaextent'),
		'ca_bas_approve' => array('/ca-ba-survey/indexapprove','/ca-ba-survey/viewapprove','/ca-ba-survey/approve','/ca-ba-survey/revise','/ca-ba-survey/reject', '/ca-ba-survey/exportxls','/ca-ba-survey/downloadfile','/map/getareaextent'),

		// ca manage Area - Available To Roll out
		'ca_availableToRollout_input' => array('/ca-ba-survey/index_iom','/ca-ba-survey/view_iom','/ca-ba-survey/create_iom','/ca-ba-survey/update_iom','/ca-ba-survey/delete_iom',
			                                   '/ca-ba-survey/setting','/ca-ba-survey/submitsetting','/ca-ba-survey/getiom','/map/getareaextent','/ca-ba-survey/delete_iom'),
		'ca_availableToRollout_verifikasi' => array('/ca-ba-survey/indexverify_iom','/ca-ba-survey/viewverify_iom','/ca-ba-survey/verify_iom','/ca-ba-survey/revise_iom','/ca-ba-survey/reject_iom','/map/getareaextent'),
		'ca_availableToRollout_approve' => array('/ca-ba-survey/indexapprove_iom','/ca-ba-survey/viewapprove_iom','/ca-ba-survey/approve_iom','/ca-ba-survey/revise_iom','/ca-ba-survey/reject_iom','/map/getareaextent'),

		// ca manage area - bas Overview
		'ca_basOverview_overview' => array('/ca-ba-survey/indexoverview','/ca-ba-survey/viewoverview','/ca-ba-survey/exportxls','/ca-ba-survey/downloadfile','/map/getareaextent','/ca-ba-survey/indexlog','/ca-ba-survey/viewlog'),

		// ca manage area - HP Overview
		'ca_hpOverview_overview' => array('/homepass/index','/homepass/view','/homepass/create','/homepass/update','/homepass/delete','/homepass/submitsetting','/homepass/setting'),

		// ca area setting
		'ca_areaSetting_region' => array('/region/index','/region/create','/region/update','/region/delete'),
		'ca_areaSetting_city' => array('/city/index','/city/create','/city/update','/city/delete'),
		'ca_areaSetting_district' => array('/district/index','/district/view','/district/create','/district/update',
			'/district/delete','/district/getcity'),
		'ca_areaSetting_subdistrict' => array('/subdistrict/index','/subdistrict/create','/subdistrict/update','/subdistrict/delete','/subdistrict/getcity','/subdistrict/getdistrict'),

		// ca parameter setting
		'ca_parameterSet_setting' =>  array('/ca-reference/index','/ca-reference/view','/ca-reference/create','/ca-reference/update','/ca-reference/delete'),


		//----- IKO var declaration -----
		'iko_dashboard_view' => array('/dashboard-iko/index','/dashboard-iko/getdashikototalwo','/dashboard-iko/map','/map/getareaextent','/iko-planning-iko-boq-p/indexinvitation'),

		// iko iom rollout
		'iko_iomrollout_view' => array('/iko-planning-iko-boq-p/index','/iko-planning-iko-boq-p/view','/iko-planning-iko-boq-p/create','/iko-planning-iko-boq-p/update','/iko-planning-iko-boq-p/delete','/iko-planning-iko-boq-p/downloadfile','/iko-planning-iko-boq-p/exportxls'),

		// iko - executor decision
		'iko_executor_view' => array('/iko-planning-iko-boq-p/indexexecutor','/iko-planning-iko-boq-p/indexinvitation','/iko-planning-iko-boq-p/update','/iko-planning-iko-boq-p/setting','/iko-planning-iko-boq-p/submitsetting','/iko-planning-iko-boq-p/view','/iko-planning-iko-boq-p/viewexecutor','/iko-planning-iko-boq-p/delete','/iko-planning-iko-boq-p/deletedetail','/iko-planning-iko-boq-p/exportpdf','/iko-planning-iko-boq-p/unit','/iko-planning-iko-boq-p/downloadfile','/iko-planning-iko-boq-p/exportxls','/iko-planning-iko-boq-p/senddetailitem'),

		//iko inhouse - monthly
		'iko_itpMonthly_input' => array('/iko-itp-monthly/index','/iko-itp-monthly/view','/iko-itp-monthly/create','/iko-itp-monthly/update','/iko-itp-monthly/delete','/iko-itp-monthly/createarea','/iko-itp-monthly/deletearea','/iko-itp-monthly/indexarea','/iko-itp-monthly/setting','/iko-itp-monthly/submitsetting','/iko-itp-monthly/calculate','/iko-itp-monthly/getplanningikobasplan','/iko-itp-monthly/getplanningikoboqp','/iko-itp-monthly/getareabyregionitp'),
		'iko_itpMonthly_verifikasi' => array('/iko-itp-monthly/indexverify','/iko-itp-monthly/viewverify','/iko-itp-monthly/verify','/iko-itp-monthly/reviseverify','/iko-itp-monthly/rejectverify','/iko-itp-monthly/deleteverify'),
		'iko_itpMonthly_approve' => array('/iko-itp-monthly/indexapprove','/iko-itp-monthly/viewapprove','/iko-itp-monthly/approve','/iko-itp-monthly/reviseapprove','/iko-itp-monthly/rejectapprove'),
		'iko_itpMonthly_overview' => array('/iko-itp-monthly/indexoverview','/iko-itp-monthly/viewoverview','/iko-itp-monthly/indexlog','/iko-itp-monthly/viewlog'),

		//iko inhouse - weekly
		'iko_itpWeekly_input' => array('/iko-itp-weekly/index','/iko-itp-weekly/view','/iko-itp-weekly/create','/iko-itp-weekly/update','/iko-itp-weekly/delete','/iko-itp-weekly/createarea','/iko-itp-weekly/deletearea','/iko-itp-weekly/indexarea','/iko-itp-weekly/calculate','/iko-itp-weekly/getmonth','/iko-itp-weekly/getyear','/iko-itp-weekly/getplanningikobasplan','/iko-itp-weekly/getweek'),
		'iko_itpWeekly_verifikasi' => array('/iko-itp-weekly/indexverify','/iko-itp-weekly/viewverify','/iko-itp-weekly/verify','/iko-itp-weekly/reviseverify','/iko-itp-weekly/rejectverify','/iko-itp-weekly/reject','/iko-itp-weekly/revise','/iko-itp-weekly/deleteverify'),
		'iko_itpWeekly_approve' => array('/iko-itp-weekly/indexapprove','/iko-itp-weekly/viewapprove','/iko-itp-weekly/approve','/iko-itp-weekly/reviseapprove','/iko-itp-weekly/rejectapprove','/iko-itp-weekly/reject','/iko-itp-weekly/revise'),
		'iko_itpWeekly_overview' => array('/iko-itp-weekly/indexoverview','/iko-itp-weekly/viewoverview','/iko-itp-weekly/indexlog','/iko-itp-weekly/viewlog'),

		//iko inhouse - daily
		'iko_itpDaily_form' => array('/iko-itp-daily/index','/iko-itp-daily/view','/iko-itp-daily/create','/iko-itp-daily/update','/iko-itp-daily/delete','/iko-itp-daily/getmonth','/iko-itp-daily/getweek','/iko-itp-daily/getregion','/iko-itp-monthly/getyear','/iko-itp-daily/getplanningikobasplan','/iko-itp-monthly/get-area-by-region-itp','/iko-itp-monthly/getmonth','/iko-itp-monthly/getweek'),
		'iko_itpDaily_spcReq' => array('/iko-itp-daily/indexspc','/iko-itp-daily/indexapprovespc','/iko-itp-daily/indexverifyspc','/iko-itp-daily/viewspc','/iko-itp-daily/createspc','/iko-itp-daily/updatespc','/iko-itp-daily/approvespc','/iko-itp-daily/deletespc','/iko-itp-daily/verifyspc','/iko-itp-daily/viewapprovespc','/iko-itp-daily/viewverifyspc'),
		'iko_itpDaily_verifikasi' => array('/iko-itp-daily/indexverify','/iko-itp-daily/viewverify','/iko-itp-daily/verify','/iko-itp-daily/reviseverify','/iko-itp-daily/rejectverify','/iko-itp-daily/deleteverify'),
		'iko_itpDaily_approve' => array('/iko-itp-daily/indexapprove','/iko-itp-daily/viewapprove','/iko-itp-daily/approve','/iko-itp-daily/reviseapprove','/iko-itp-daily/rejectapprove'),
		'iko_itpDaily_overview' => array('/iko-itp-daily/indexoverview','/iko-itp-daily/viewoverview','/iko-itp-daily/indexlog','/iko-itp-daily/viewlog'),

		// inhouse - work order
		'iko_wo_input_manageTeam' => array('/iko-team/index','/iko-team/indexmember','/iko-team/view','/iko-team/viewmember','/iko-team/create','/iko-team/createmember','/iko-team/update','/iko-team/updatemember','/iko-team/delete','/iko-team/deletemember'),
		'iko_wo_input_workOrder' => array('/iko-work-order/index','/iko-work-order/view','/iko-work-order/viewbadistribution','/iko-work-order/create','/iko-work-order/update','/iko-work-order/delete','/iko-work-order/exportpdf','/iko-work-order/getwarehouse'),
		'iko_wo_input_ToolsNeeds' => array('/iko-tools-wo/index','/iko-tools-wo/indexwo','/iko-tools-wo/view','/iko-tools-wo/viewwo','/iko-tools-wo/create','/iko-tools-wo/update','/iko-tools-wo/deletetools','/iko-tools-wo/delete'),
		'iko_wo_input_materialNeeds' => array('/iko-material-wo/index','/iko-material-wo/indexgrfinput','/iko-material-wo/indexgrflog','/iko-material-wo/indexgrfoverview','/iko-material-wo/indexwo','/iko-material-wo/indexwoactual','/iko-material-wo/indexgrfdetail','/iko-material-wo/view','/iko-material-wo/viewwo','/iko-material-wo/indexviewgrfinput','/iko-material-wo/create','/iko-material-wo/update','/iko-material-wo/updategrf','/iko-material-wo/deletematerial','/iko-material-wo/deletegrf','/iko-material-wo/submitgrf','/iko-material-wo/exportpdf'),
		'iko_wo_input_transportNeeds' => array('/iko-transport-wo/index','/iko-transport-wo/indexwo','/iko-transport-wo/indexwoactual','/iko-transport-wo/view','/iko-transport-wo/viewwo','/iko-transport-wo/create','/iko-transport-wo/update','/iko-transport-wo/deletetransport','/iko-transport-wo/deletedetail','/iko-transport-wo/delete'),
		'iko_wo_verifikasi' => array('/iko-work-order/indexverify','/iko-work-order/viewverify','/iko-work-order/verify','/iko-work-order/reviseverify','/iko-work-order/rejectverify','/iko-work-order/exportpdf'),
		'iko_wo_approve' => array('/iko-work-order/indexapprove','/iko-work-order/viewapprove','/iko-work-order/approve','/iko-work-order/reviseapprove','/iko-work-order/rejectapprove','/iko-work-order/exportpdf'),
		'iko_wo_listWO' => array('/iko-work-order/indexoverview','/iko-work-order/viewoverview','/iko-work-order/indexlog','/iko-work-order/viewlog'),

		// inhouse - wo - grf
		'iko_grf_input' => array('/iko-material-wo/indexgrfinput','/iko-material-wo/indexgrfdetail','/iko-material-wo/indexviewgrfinput','/iko-material-wo/viewgrfinput','/iko-material-wo/create','/iko-material-wo/updategrf','/iko-material-wo/delete','/iko-material-wo/deletegrf','/iko-material-wo/submitgrf','/iko-material-wo/exportpdf','/iko-material-wo/upload'),
		'iko_grf_verifikasi' => array('/iko-material-wo/indexgrfverify','/iko-material-wo/viewgrfverify','/iko-material-wo/verifygrf','/iko-material-wo/revisegrf','/iko-material-wo/revisgrf','/iko-material-wo/rejectgrf'),
		'iko_grf_approve' => array('/iko-material-wo/indexgrfapprove','/iko-material-wo/viewgrfapprove','/iko-material-wo/indexgrfapprovegrf','/iko-material-wo/approvegrf','/iko-material-wo/approve','/iko-material-wo/revisegrf','/iko-material-wo/rejectgrf','/iko-material-wo/exportpdf'),


		// inhouse - problem
		'iko_problem_input' => array('/iko-problem/index','/iko-problem/view','/iko-problem/viewtask','/iko-problem/create','/iko-problem/update','/iko-problem/delete'),
		'iko_problem_verifikasi' => array('/iko-problem/indexverify','/iko-problem/viewverify','/iko-problem/verify','/iko-problem/reviseverify','/iko-problem/rejectverify'),
		'iko_problem_approve' => array('/iko-problem/indexapprove','/iko-problem/viewapprove','/iko-problem/approve','/iko-problem/reviseapprove','/iko-problem/rejectapprove'),
		'iko_problem_overview' => array('/iko-problem/indexoverview','/iko-problem/viewoverview','/iko-problem/indexlog','/iko-problem/viewlog'),

		//  inhouse - work order actual
		'iko_woActual_input_workOrder' => array('/iko-wo-actual/index','/iko-wo-actual/view','/iko-wo-actual/viewwoactual','/iko-wo-actual/viewbadistribution','/iko-wo-actual/viewworkorder','/iko-wo-actual/create','/iko-wo-actual/update','/iko-wo-actual/delete','/iko-wo-actual/exportpdf'),
		'iko_woActual_input_report' => array('/iko-team-wo-actual/indexwoactual','/iko-team-wo-actual/index','/iko-team-wo-actual/indexactual','/iko-team-wo-actual/view','/iko-team-wo-actual/viewwoactual','/iko-team-wo-actual/create','/iko-team-wo-actual/update','/iko-team-wo-actual/delete','/iko-team-wo-actual/deletedetail','/iko-team-wo-actual/submitteam'),
		'iko_woActual_input_ToolsUsage' => array('/iko-tools-usage/indexwoactual','/iko-tools-usage/index','/iko-tools-usage/viewwoactual','/iko-tools-usage/view','/iko-tools-usage/create','/iko-tools-usage/update','/iko-tools-usage/delete','/iko-tools-usage/submittools'),
		'iko_woActual_input_materialUsage' => array('/iko-material-usage/indexwoactual','/iko-material-usage/index','/iko-material-usage/viewwoactual','/iko-material-usage/view','/iko-material-usage/create','/iko-material-usage/update','/iko-material-usage/delete','/iko-material-usage/submitmaterial'),
		'iko_woActual_input_transportUsage' => array('/iko-transport-usage/indexwoactual','/iko-transport-usage/index','/iko-transport-usage/viewwoactual','/iko-transport-usage/view','/iko-transport-usage/create','/iko-transport-usage/update','/iko-transport-usage/delete','/iko-transport-usage/submittransport','/iko-transport-usage/deletedetail'),
		'iko_woActual_verifikasi' => array('/iko-wo-actual/indexverify','/iko-wo-actual/viewverify','/iko-wo-actual/create','/iko-wo-actual/update','/iko-wo-actual/verify','/iko-wo-actual/reviseverify','/iko-wo-actual/rejectverify','/iko-wo-actual/exportpdf'),
		'iko_woActual_approve' => array('/iko-wo-actual/indexapprove','/iko-wo-actual/viewapprove','/iko-wo-actual/create','/iko-wo-actual/update','/iko-wo-actual/approve','/iko-wo-actual/reviseapprove','/iko-wo-actual/rejectapprove','/iko-wo-actual/exportpdf'),
		'iko_woActual_overview' => array('/iko-wo-actual/indexoverview','/iko-wo-actual/viewoverview','/iko-wo-actual/viewworkorderoverview','/iko-wo-actual/downloadfile','iko-bas-implementation/downloadfile','/iko-bas-implementation/viewbasplan','/iko-wo-actual/indexwolog','/iko-wo-actual/viewlog'),

		// iko inhouse - rfr
		'iko_rfr_view' => array('/iko-rfa/indexrfr','/iko-rfa/viewrfr','/iko-rfa/downloadfile'),

		// iko inhouse - rfa
		'iko_rfa_input' => array('/iko-rfa/index','/iko-rfa/view','/iko-rfa/create','/iko-rfa/update','/iko-rfa/delete','/iko-rfa/viewboqp','/iko-rfa/uploadexcel'),
		'iko_rfa_verifikasi' => array('/iko-rfa/indexverify','/iko-rfa/viewverify','/iko-rfa/verify','/iko-rfa/reviseverify','/iko-rfa/rejectverify','/iko-rfa/downloadfile'),
		'iko_rfa_approve' => array('/iko-rfa/indexapprove','/iko-rfa/viewapprove','/iko-rfa/approve','/iko-rfa/reviseapprove','/iko-rfa/rejectapprove','/iko-rfa/downloadfile'),
		'iko_rfa_overview' => array('/iko-rfa/indexoverview','/iko-rfa/viewoverview','/iko-rfa/viewboqp','/iko-rfa/indexlog','/iko-rfa/viewlog'),

		// iko vendor - Daily Report Vendor
		'iko_dailyReportVendor_input' => array('/iko-daily-report/uploadreport','/iko-daily-report/index','/iko-daily-report/view','/iko-daily-report/create','/iko-daily-report/update','/iko-daily-report/delete','/iko-daily-report/indexlog','/iko-daily-report/viewlog', '/iko-daily-report/downloadfile'),
		'iko_dailyReportVendor_view' => array('/iko-daily-report/view','/iko-daily-report/delete','/iko-daily-report/index','/iko-daily-report/update','/iko-daily-report/indexlog','/iko-daily-report/viewlog'),

		//iko vendor - GRF Vendor
		'iko_grfVendor_input' => array('/iko-grf-vendor/index','/iko-grf-vendor/viewinput','/iko-grf-vendor/viewgrfvendor','/iko-grf-vendor/create','/iko-grf-vendor/getwarehouse','/iko-grf-vendor/createdetail','/iko-grf-vendor/update','/iko-grf-vendor/indexdetail','/iko-grf-vendor/delete','/iko-grf-vendor/deletedetail','/iko-grf-vendor/getikoboqp','/iko-grf-vendor/uploaddetail','/iko-grf-vendor/submitgrf', '/iko-grf-vendor/downloadfile', '/iko-grf-vendor/backdate'),
		'iko_grfVendor_verifikasi' => array('/iko-grf-vendor/indexverify','/iko-grf-vendor/viewverify','/iko-grf-vendor/verify','/iko-grf-vendor/reviseverify','/iko-grf-vendor/rejectverify'),
		'iko_grfVendor_approve' => array('/iko-grf-vendor/indexapprove','/iko-grf-vendor/viewapprove','/iko-grf-vendor/approve','/iko-grf-vendor/reviseapprove','/iko-grf-vendor/rejectapprove','/iko-grf-vendor/exportpdf','/iko-grf-vendor/exportpdfusage'),
		'iko_grfVendor_overview' => array('/iko-grf-vendor/indexoverview','/iko-grf-vendor/viewoverview','/iko-grf-vendor/uploaddetail','/iko-grf-vendor/exportpdf','/iko-grf-vendor/indexlog','/iko-grf-vendor/viewlog'),

		// iko vendor - material usage  vendor
		'iko_materialUsageVendor_input' => array('/iko-grf-vendor/indexusage','/iko-grf-vendor/viewusageinput','/iko-grf-vendor/viewgrfvendor','/iko-grf-vendor/create','/iko-grf-vendor/getwarehouse','/iko-grf-vendor/createdetail','/iko-grf-vendor/update','/iko-grf-vendor/updateusage','/iko-grf-vendor/indexdetail','/iko-grf-vendor/indexusagedetail','/iko-grf-vendor/delete','/iko-grf-vendor/deletedetail','/iko-grf-vendor/getikoboqp','/iko-grf-vendor/uploaddetail','/iko-grf-vendor/exportpdf','/iko-grf-vendor/exportpdfusage','/iko-grf-vendor/submitgrf'),
		'iko_materialUsageVendor_verifikasi' => array('/iko-grf-vendor/indexusageverify','/iko-grf-vendor/viewusageverify','/iko-grf-vendor/create','/iko-grf-vendor/update','/iko-grf-vendor/deleteverify','/iko-grf-vendor/verifyusage','/iko-grf-vendor/reviseusageverify','/iko-grf-vendor/rejectusageverify'),
		'iko_materialUsageVendor_approve' => array('/iko-grf-vendor/indexusageapprove','/iko-grf-vendor/viewusageapprove','/iko-grf-vendor/create','/iko-grf-vendor/createdetail','/iko-grf-vendor/updateusage','/iko-grf-vendor/approveusage','/iko-grf-vendor/reviseusageapprove','/iko-grf-vendor/rejectusageapprove','/iko-grf-vendor/deleteapprove'),
		'iko_materialUsageVendor_overview' => array('/iko-grf-vendor/indexusageoverview','/iko-grf-vendor/viewusageoverview','/iko-grf-vendor/downloadfile','/iko-grf-vendor/indexusagelog','/iko-grf-vendor/viewusagelog'),


		//----- OSP var declaration -----
		// osp dashboard
		'osp_dashboard_view' => array('/dashboard-osp/index','/dashboard-osp/map','/map/getareaextent','/osp-planning-boq-p/index_invitation_osp','/osp-planning-boq-p/index_invitation_iko','/dashboard-osp/getchartbyregion','/dashboard-osp/getchartbyregionvendor'),

		// osp ready to coordination
		'osp_readyToCoordination_input' => array('/osp-planning-osp-boq-p/indexinput','/osp-planning-osp-boq-p/viewinput','/osp-planning-osp-boq-p/create','/osp-planning-osp-boq-p/update','/osp-planning-osp-boq-p/delete','/osp-planning-osp-boq-p/getoltslotport','/osp-planning-osp-boq-p/unit','/osp-planning-osp-boq-p/exportpdf','/osp-planning-osp-boq-p/downloadfile'),
		'osp_readyToCoordination_verifikasi' => array('/osp-planning-osp-boq-p/indexverify','/osp-planning-osp-boq-p/viewverify','/osp-planning-osp-boq-p/verify','/osp-planning-osp-boq-p/revise','/osp-planning-osp-boq-p/reject','/osp-planning-osp-boq-p/exportpdf','/osp-planning-osp-boq-p/downloadfile'),
		'osp_readyToCoordination_approve' => array('/osp-planning-osp-boq-p/indexapprove','/osp-planning-osp-boq-p/viewapprove','/osp-planning-osp-boq-p/approve','/osp-planning-osp-boq-p/revise','/osp-planning-osp-boq-p/exportpdf','/osp-planning-osp-boq-p/downloadfile'),
		'osp_readyToCoordination_overview' => array('/osp-planning-osp-boq-p/indexoverview','/osp-planning-osp-boq-p/viewoverview','/osp-planning-osp-boq-p/exportpdf','/osp-planning-osp-boq-p/downloadfile','/osp-planning-osp-boq-p/indexlog','/osp-planning-osp-boq-p/viewlog'),

		//osp daily report vendor
		'osp_itp_report_input' => array('/osp-report-itp/index','/osp-report-itp/view','/osp-report-itp/create','/osp-report-itp/update','/osp-report-itp/delete','/osp-report-itp/downloadfile'),

		//osp ready to roll out
		'osp_readyToRollOut_view' => array('/osp-govrel-internal-coordination/index','/osp-govrel-internal-coordination/view','/osp-govrel-internal-coordination/create','/osp-govrel-internal-coordination/update','/osp-govrel-internal-coordination/delete','/osp-govrel-internal-coordination/downloadfile'),

		//osp Rollout Process - workorder
		'osp_wo_manageTeam' => array('/osp-team/index','/osp-team/indexmember','/osp-team/view','/osp-team/viewmember','/osp-team/create','/osp-team/createmember','/osp-team/update','/osp-team/updatemember','/osp-team/delete','/osp-team/deletemember'),
		'osp_wo_input_workOrder' => array('/osp-work-order/indexinput','/osp-work-order/indexall','/osp-work-order/viewinput','/osp-work-order/viewall','/osp-work-order/create','/osp-work-order/update','/osp-work-order/delete','/osp-work-order/getcity','/osp-work-order/getlocation','/osp-work-order/getidospboqp','/osp-work-order/exportpdf'),
		'osp_wo_input_toolsNeeds' => array('/osp-tools-wo/index','/osp-tools-wo/indexwo','/osp-tools-wo/view','/osp-tools-wo/viewwo','/osp-tools-wo/create','/osp-tools-wo/update','/osp-tools-wo/delete','/osp-tools-wo/deletedetail','/osp-tools-wo/uploaddetail', '/osp-tools-wo/downloadfile'),
		'osp_wo_input_materialNeeds' => array('/osp-material-wo/index','/osp-material-wo/indexwo','/osp-material-wo/indexwoactual','/osp-material-wo/indexgrfinput','/osp-material-wo/indexgrfdetail','/osp-material-wo/view','/osp-material-wo/viewwo','/osp-material-wo/viewgrfinput','/osp-material-wo/create','/osp-material-wo/update','/osp-material-wo/updategrf','/osp-material-wo/deletegrf','/osp-material-wo/delete','/osp-material-wo/deletedetail','/osp-material-wo/submitgrf','/osp-material-wo/uploaddetail','/osp-material-wo/exportpdf', '/osp-material-wo/downloadfile'),
		'osp_wo_input_transport' => array('/osp-transport-wo/index','/osp-transport-wo/indexwo','/osp-transport-wo/indexwoactual','/osp-transport-wo/view','/osp-transport-wo/viewwo','/osp-transport-wo/create','/osp-transport-wo/update','/osp-transport-wo/delete','/osp-transport-wo/deletedetail'),
		'osp_wo_verifikasi_workOrder' => array('/osp-work-order/indexverify','/osp-work-order/viewverify','/osp-work-order/verify','/osp-work-order/reviseverify','/osp-work-order/rejectverify'),
		'osp_wo_approve_workOrder' => array('/osp-work-order/indexapprove','/osp-work-order/viewapprove','/osp-work-order/approve','/osp-work-order/reviseapprove','/osp-work-order/rejectapprove'),
		'osp_wo_listWo' => array('/osp-work-order/indexall','/osp-work-order/viewall','/osp-work-order/indexalllog','/osp-work-order/viewlog'),

		// osp rollout Process - wo - grf
		'osp_wo_grf_input' => array('/osp-material-wo/indexwoactual','/osp-material-wo/indexgrfinput','/osp-material-wo/indexgrfdetail','/osp-material-wo/viewgrfinput','/osp-material-wo/create','/osp-material-wo/updategrf','/osp-material-wo/deletegrf','/osp-material-wo/delete','/osp-material-wo/uploaddetail','/osp-material-wo/deletedetail','/osp-material-wo/submitgrf','/osp-material-wo/uploaddetail','/osp-material-wo/exportpdf'),
		'osp_wo_grf_verifikasi' => array('/osp-material-wo/indexgrfverify','/osp-material-wo/viewgrfverify','/osp-material-wo/verifygrf','/osp-material-wo/revisegrf','/osp-material-wo/rejectgrf'),
		'osp_wo_grf_approve' => array('/osp-material-wo/indexgrfapprove','/osp-material-wo/viewgrfapprove','/osp-material-wo/approvegrf','/osp-material-wo/revisegrf','/osp-material-wo/exportpdf'),
		'osp_wo_grf_overview' => array('/osp-material-wo/indexgrfoverview','/osp-material-wo/viewgrfoverview','/osp-material-wo/exportpdf','/osp-material-wo/indexgrflog','/osp-material-wo/viewgrflog'),

		// osp rollout Process - problem
		'osp_problem_input' => array('/osp-problem/index','/osp-problem/view','/osp-problem/create','/osp-problem/update','/osp-problem/delete'),
		'osp_problem_verifikasi' => array('/osp-problem/indexverify','/osp-problem/viewverify','/osp-problem/verify','/osp-problem/reviseverify','/osp-problem/rejectverify'),
		'osp_problem_approve' => array('/osp-problem/indexapprove','/osp-problem/viewapprove','/osp-problem/approve','/osp-problem/reviseapprove','/osp-problem/rejectapprove'),
		'osp_problem_overview' => array('/osp-problem/indexoverview','/osp-problem/viewoverview','/osp-problem/indexlog','/osp-problem/viewlog'),

		// osp rollout Process - Workorder Actual
		'osp_woActual_input_workOrder' => array('/osp-wo-actual/index','/osp-wo-actual/view','/osp-wo-actual/viewwo','/osp-wo-actual/create','/osp-wo-actual/update','/osp-wo-actual/delete','/osp-wo-actual/exportpdf'),
		'osp_woActual_teamReport' => array('/osp-team-wo-actual/index','/osp-team-wo-actual/indexwoactual','/osp-team-wo-actual/view','/osp-team-wo-actual/viewwoactual','/osp-team-wo-actual/create','/osp-team-wo-actual/update','/osp-team-wo-actual/delete','/osp-team-wo-actual/deletedetail','/osp-team-wo-actual/submitteam'),
		'osp_woActual_inputToolsUsage' => array('/osp-tools-usage/index','/osp-tools-usage/indexwoactual','/osp-tools-usage/view','/osp-tools-usage/viewwoactual','/osp-tools-usage/create','/osp-tools-usage/update','/osp-tools-usage/delete','/osp-tools-usage/submittools'),
		'osp_woActual_inputMaterialUsage' => array('/osp-material-usage/index','/osp-material-usage/indexwoactual','/osp-material-usage/view','/osp-material-usage/viewwoactual','/osp-material-usage/create','/osp-material-usage/update','/osp-material-usage/delete','/osp-material-usage/submitmaterial'),
		'osp_woActual_inputTransportUsage' => array('/osp-transport-usage/index','/osp-transport-usage/indexwoactual','/osp-transport-usage/view','/osp-transport-usage/viewwoactual','/osp-transport-usage/create','/osp-transport-usage/update','/osp-transport-usage/delete','/osp-transport-usage/deletedetail','/osp-transport-usage/submittransport'),
		'osp_woActual_verifikasi' => array('/osp-wo-actual/indexverify','/osp-wo-actual/viewverify','/osp-wo-actual/verify','/osp-wo-actual/reviseverify','/osp-wo-actual/rejectverify','/osp-wo-actual/deleteverify'),
		'osp_woActual_approve' => array('/osp-wo-actual/indexapprove','/osp-wo-actual/viewapprove','/osp-wo-actual/approve','/osp-wo-actual/deleteapprove','/osp-wo-actual/reviseverify','/osp-wo-actual/rejectverify'),
		'osp_woActual_overview' => array('/osp-wo-actual/indexoverview','/osp-wo-actual/viewoverview','/osp-wo-actual/viewwooverview','/osp-wo-actual/exportpdf','/osp-wo-actual/indexwolog','/osp-wo-actual/viewlog','/osp-wo-actual/downloadfile'),

		//osp rollout process - RFR
		'osp_rfr_view' => array('/osp-rfa/indexrfr','/osp-rfa/viewrfr'),

		//osp rollout process - RFA
		'osp_rfa_input' => array('/osp-rfa/index','/osp-rfa/view','/osp-rfa/viewboqp','/osp-rfa/create','/osp-rfa/update','/osp-rfa/delete','/osp-rfa/downloadfile'),
		'osp_rfa_verifikasi' => array('/osp-rfa/indexverify','/osp-rfa/viewverify','/osp-rfa/verify','/osp-rfa/reviseverify','/osp-rfa/rejectverify'),
		'osp_rfa_approve' => array('/osp-rfa/indexapprove','/osp-rfa/viewapprove','/osp-rfa/approve','/osp-rfa/reviseverify','/osp-rfa/rejectverify'),
		'osp_rfa_overview' => array('/osp-rfa/indexoverview','/osp-rfa/viewoverview','/osp-rfa/viewboqpoverview','/osp-rfa/indexlog','/osp-rfa/viewlog','/osp-rfa/downloadfile'),

		// Vendor ITP Report Vendor
		'osp_itpReportVendor_view' => array('/osp-govrel-internal-coordination/indexvendor','/osp-govrel-internal-coordination/view','/osp-govrel-internal-coordination/create','/osp-govrel-internal-coordination/update','/osp-govrel-internal-coordination/delete','/osp-govrel-internal-coordination/downloadfile'),

		// Vendor Ready To Rollout Vendor
		'osp_readyToRollOutVendor_view' => array('/osp-report-itp/indexvendor','/osp-report-itp/view','/osp-report-itp/create','/osp-report-itp/update','/osp-report-itp/delete','/osp-report-itp/downloadfile'),

		// vendor - Daily Report
		'osp_reportVendor_report' => array('/osp-daily-report/index','/osp-daily-report/view','/osp-daily-report/create','/osp-daily-report/update','/osp-daily-report/delete','/osp-daily-report/indexlog','/osp-daily-report/viewlog'),

		// Vendor - GRF Vendor
		'osp_grfVendor_input' => array('/osp-grf-vendor/index','/osp-grf-vendor/view','/osp-grf-vendor/create','/osp-grf-vendor/update','/osp-grf-vendor/delete','/osp-grf-vendor/indexdetail','/osp-grf-vendor/uploaddetail','/osp-grf-vendor/getplanningospboqp','/osp-grf-vendor/getcity','/osp-grf-vendor/getlocation','/osp-grf-vendor/getidplanningospboqp','/osp-grf-vendor/exportpdf', '/osp-grf-vendor/downloadfile'),
		'osp_grfVendor_verifikasi' => array('/osp-grf-vendor/indexverify','/osp-grf-vendor/viewverify','/osp-grf-vendor/verify','/osp-grf-vendor/reviseverify','/osp-grf-vendor/rejectverify'),
		'osp_grfVendor_approve' => array('/osp-grf-vendor/indexapprove','/osp-grf-vendor/viewapprove','/osp-grf-vendor/approve','/osp-grf-vendor/reviseapprove','/osp-grf-vendor/rejectapprove'),
		'osp_grfVendor_overview' => array('/osp-grf-vendor/indexoverview','/osp-grf-vendor/viewoverview','/osp-grf-vendor/exportpdf','/osp-grf-vendor/indexlog','/osp-grf-vendor/viewlog'),

		// Vendor - Material Usage Vendor
		'osp_materialUsageVendor_input' => array('/osp-grf-vendor/indexusage','/osp-grf-vendor/viewusage','/osp-grf-vendor/updateusage','/osp-grf-vendor/indexusagedetail','/osp-grf-vendor/createdetail','/osp-grf-vendor/deletedetail','/osp-grf-vendor/exportpdfusage'),
		'osp_materialUsageVendor_verifikasi' => array('/osp-grf-vendor/indexusageverify','/osp-grf-vendor/viewusageverify','/osp-grf-vendor/verifyusage','/osp-grf-vendor/reviseusageverify','/osp-grf-vendor/rejectusageverify'),
		'osp_materialUsageVendor_approve' => array('/osp-grf-vendor/indexusageapprove','/osp-grf-vendor/viewusageapprove','/osp-grf-vendor/approveusage','/osp-grf-vendor/reviseusageapprove','/osp-grf-vendor/rejectusageapprove','/osp-grf-vendor/exportpdfusage'),
		'osp_materialUsageVendor_overview' => array('/osp-grf-vendor/indexusageoverview','/osp-grf-vendor/viewusageoverview','/osp-grf-vendor/indexusagedetail','/osp-grf-vendor/exportpdfusage','/osp-grf-vendor/indexusagelog','/osp-grf-vendor/viewlog'),

		// osp vendor - RFR
		'osp_VendorRFR_view' => array('/osp-rfa/indexvendorrfr','/osp-rfa/viewrfr'),

		//osp vendor - RFA
		'osp_VendorRFA_input' => array('/osp-rfa/indexvendor','/osp-rfa/view','/osp-rfa/viewboqp','/osp-rfa/create','/osp-rfa/update','/osp-rfa/delete','/osp-rfa/downloadfile'),
		'osp_VendorRFA_verifikasi' => array('/osp-rfa/indexvendorverify','/osp-rfa/viewverify','/osp-rfa/verify','/osp-rfa/reviseverify','/osp-rfa/rejectverify','/osp-rfa/downloadfile'),
		'osp_VendorRFA_approve' => array('/osp-rfa/indexvendorapprove','/osp-rfa/viewapprove','/osp-rfa/approve','/osp-rfa/reviseverify','/osp-rfa/rejectverify','/osp-rfa/downloadfile'),
		'osp_VendorRFA_overview' => array('/osp-rfa/indexvendoroverview','/osp-rfa/viewoverview','/osp-rfa/viewboqpoverview','/osp-rfa/indexlog','/osp-rfa/indexvendorlog','/osp-rfa/viewlog','/osp-rfa/downloadfile'),

		// osp manage OLT
		'osp_manageOLT_input' => array('/osp-manage-olt/index','/osp-manage-olt/view','/osp-manage-olt/create','/osp-manage-olt/update','/osp-manage-olt/delete','/osp-manage-olt/getcity','/osp-manage-olt/getdistrict','/osp-manage-olt/getsubdistrict','/osp-manage-olt/downloadfile'),
		'osp_manageOLT_verifikasi' => array('/osp-manage-olt/indexverify','/osp-manage-olt/viewverify','/osp-manage-olt/verify','/osp-manage-olt/reviseverify','/osp-manage-olt/rejectverify','/osp-manage-olt/downloadfilegovrel'),
		'osp_manageOLT_approve' => array('/osp-manage-olt/indexapprove','/osp-manage-olt/viewapprove','/osp-manage-olt/approve','/osp-manage-olt/reviseverify','/osp-manage-olt/rejectverify','/osp-manage-olt/downloadfilegovrel'),
		'osp_manageOLT_overview' => array('/osp-manage-olt/indexoverview','/osp-manage-olt/viewoverview','/osp-manage-olt/downloadfile','/osp-manage-olt/downloadfilegovrel','/osp-manage-olt/indexlog','/osp-manage-olt/viewlog','/osp-manage-olt/downloadfile'),


		//----- PLANNING var declaration -----
		// planning dashboard
		'planning_dashboard_view' => array('/dashboard-planning/index','/dashboard-planning/map','/dashboard-planning/getchartbycity','/planning-osp-bas/indexinvitation','/planning-iko-bas-plan/indexinvitation','/map/getareaextent'),

		// planning iko basp
		'planning_ikoBASP_input' => array('/planning-iko-bas-plan/index','/planning-iko-bas-plan/view','/planning-iko-bas-plan/create','/planning-iko-bas-plan/update','/planning-iko-bas-plan/delete','/planning-iko-bas-plan/setting','/planning-iko-bas-plan/submitsetting','/planning-iko-bas-plan/viewbadistribution','/planning-iko-bas-plan/exportpdf','/planning-iko-bas-plan/downloadfile','/planning-iko-bas-plan/viewcabasurvey'),
		'planning_ikoBASP_verifikasi' => array('/planning-iko-bas-plan/indexverify','/planning-iko-bas-plan/viewverify','/planning-iko-bas-plan/verify','/planning-iko-bas-plan/reviseverify','/planning-iko-bas-plan/rejectverify','/planning-iko-bas-plan/deleteverify','/planning-iko-bas-plan/exportpdf','/planning-iko-bas-plan/downloadfile'),
		'planning_ikoBASP_approve' => array('/planning-iko-bas-plan/indexapprove','/planning-iko-bas-plan/viewapprove','/planning-iko-bas-plan/approve','/planning-iko-bas-plan/deleteapprove','/planning-iko-bas-plan/exportpdf','/planning-iko-bas-plan/downloadfile','/planning-iko-bas-plan/reviseverify','/planning-iko-bas-plan/rejectverify'),
		'planning_ikoBASP_overview' => array('/planning-iko-bas-plan/indexoverview','/planning-iko-bas-plan/viewoverview','/planning-iko-bas-plan/downloadfile','/planning-iko-bas-plan/exportpdf','/planning-iko-bas-plan/indexlog','/planning-iko-bas-plan/viewlog','/planning-iko-bas-plan/viewcabasurvey'),

		// planning iko boqp
		'planning_ikoBOQP_input' => array('/planning-iko-boq-p/index','/planning-iko-boq-p/indexdetail','/planning-iko-boq-p/view','/planning-iko-boq-p/viewbasplan','/planning-iko-boq-p/create','/planning-iko-boq-p/update','/planning-iko-boq-p/delete','/planning-iko-boq-p/deletedetail','/planning-iko-boq-p/createdetail','/planning-iko-boq-p/updatedetail','/planning-iko-boq-p/setting','/planning-iko-boq-p/submitsetting','/planning-iko-boq-p/viewbasplan','/planning-iko-boq-p/uploaddetail','/planning-iko-boq-p/unit','/planning-iko-boq-p/exportpdf','/planning-iko-boq-p/exportxls','/planning-iko-boq-p/downloadfile'),
		'planning_ikoBOQP_verifikasi' => array('/planning-iko-boq-p/indexverify','/planning-iko-boq-p/viewverify','/planning-iko-boq-p/verify','/planning-iko-boq-p/reviseverify','/planning-iko-boq-p/rejectverify','/planning-iko-boq-p/exportpdf','/planning-iko-boq-p/exportxls','/planning-iko-boq-p/downloadfile'),
		'planning_ikoBOQP_approve' => array('/planning-iko-boq-p/indexapprove','/planning-iko-boq-p/viewapprove','/planning-iko-boq-p/approve','/planning-iko-boq-p/exportpdf','/planning-iko-boq-p/exportxls','/planning-iko-boq-p/reviseverify','/planning-iko-boq-p/rejectverify','/planning-iko-boq-p/downloadfile'),
		'planning_ikoBOQP_overview' => array('/planning-iko-boq-p/indexoverview','/planning-iko-boq-p/viewoverview','/planning-iko-boq-p/exportpdf','/planning-iko-boq-p/exportxls','/planning-iko-boq-p/downloadfile','/planning-iko-boq-p/indexlog','/planning-iko-boq-p/viewlog'),

		// planning iko boqb
		'planning_ikoBOQB_input' => array('/planning-iko-boq-b/index','/planning-iko-boq-b/view','/planning-iko-boq-b/viewikorfa','/planning-iko-boq-b/viewpplikobaut','/planning-iko-boq-b/viewikorfa','/planning-iko-boq-b/create','/planning-iko-boq-b/update','/planning-iko-boq-b/delete','/planning-iko-boq-b/updatedetail','/planning-iko-boq-b/indexdetail','/planning-iko-boq-b/createdetail','/planning-iko-boq-b/deletedetail','/planning-iko-boq-b/uploaddetail','/planning-iko-boq-b/unit','/planning-iko-boq-b/exportpdf'),
		'planning_ikoBOQB_verifikasi' => array('/planning-iko-boq-b/indexverify','/planning-iko-boq-b/viewverify','/planning-iko-boq-b/verify','/planning-iko-boq-b/reviseverify','/planning-iko-boq-b/rejectverify','/planning-iko-boq-b/exportpdf'),
		'planning_ikoBOQB_approve' => array('/planning-iko-boq-b/indexapprove','/planning-iko-boq-b/viewapprove','/planning-iko-boq-b/approve','/planning-iko-boq-b/reviseverify','/planning-iko-boq-b/rejectverify','/planning-iko-boq-b/exportpdf','/planning-iko-boq-b/downloadfile'),
		'planning_ikoBOQB_overview' => array('/planning-iko-boq-b/indexoverview','/planning-iko-boq-b/viewoverview','/planning-iko-boq-b/viewikorfaoverview','/planning-iko-boq-b/viewpplikobautoverview','/planning-iko-boq-b/exportpdf','/planning-iko-boq-b/downloadfile','/planning-iko-boq-b/indexlog','/planning-iko-boq-b/viewlog'),

		// planning ca presurvey overview
		'planning_caPresurvey_view' => array('/planning-osp-bas/indexpresurveyoverview','/planning-osp-bas/view_presurvey','/planning-osp-bas/previewsurveyoverview','/planning-osp-bas/downloadfile'),

		// planning osp basp
		'planning_ospBASP_input' => array('/planning-osp-bas/indexinput','/planning-osp-bas/viewinput','/planning-osp-bas/create','/planning-osp-bas/update','/planning-osp-bas/delete','/planning-osp-bas/getcity','/planning-osp-bas/getarea','/planning-osp-bas/upload','/planning-osp-bas/exportpdf','/planning-osp-bas/downloadfile'),
		'planning_ospBASP_verifikasi' => array('/planning-osp-bas/indexverify','/planning-osp-bas/viewverify','/planning-osp-bas/verify','/planning-osp-bas/revise','/planning-osp-bas/reject','/planning-osp-bas/exportpdf','/planning-osp-bas/downloadfile'),
		'planning_ospBASP_approve' => array('/planning-osp-bas/indexapprove','/planning-osp-bas/viewapprove','/planning-osp-bas/approve','/planning-osp-bas/revise','/planning-osp-bas/reject','/planning-osp-bas/exportpdf','/planning-osp-bas/downloadfile'),
		'planning_ospBASP_overview' => array('/planning-osp-bas/indexoverview','/planning-osp-bas/viewoverview','/planning-osp-bas/exportpdf','/planning-osp-bas/downloadfile','/planning-osp-bas/indexlog','/planning-osp-bas/viewlog'),

		// planning osp boqp
		'planning_ospBOQP_input' => array('/planning-osp-boq-p/indexinput','/planning-osp-boq-p/viewinput','/planning-osp-boq-p/create','/planning-osp-boq-p/update','/planning-osp-boq-p/delete','/planning-osp-boq-p/createdetail','/planning-osp-boq-p/updatedetail','/planning-osp-boq-p/deletedetail','/planning-osp-boq-p/indexdetail','/planning-osp-boq-p/viewbas','/planning-osp-boq-p/uploaddetail','/planning-osp-boq-p/unit','/planning-osp-boq-p/getoltslotport','/planning-osp-boq-p/exportpdf','/planning-osp-boq-p/downloadfile'),
		'planning_ospBOQP_verifikasi' => array('/planning-osp-boq-p/indexverify','/planning-osp-boq-p/viewverify','/planning-osp-boq-p/verify','/planning-osp-boq-p/revise','/planning-osp-boq-p/reject','/planning-osp-boq-p/exportpdf','/planning-osp-boq-p/downloadfile'),
		'planning_ospBOQP_approve' => array('/planning-osp-boq-p/indexapprove','/planning-osp-boq-p/viewapprove','/planning-osp-boq-p/approve','/planning-osp-boq-p/revise','/planning-osp-boq-p/reject','/planning-osp-boq-p/exportpdf','/planning-osp-boq-p/downloadfile'),
		'planning_ospBOQP_overview' => array('/planning-osp-boq-p/indexoverview','/planning-osp-boq-p/viewoverview','/planning-osp-boq-p/viewbasoverview','/planning-osp-boq-p/exportpdf','/planning-osp-boq-p/downloadfile','/planning-osp-boq-p/indexlog','/planning-osp-boq-p/viewlog'),

		// planning osp boqb
		'planning_ospBOQB_input' => array('/planning-osp-boq-b/index','/planning-osp-boq-b/view','/planning-osp-boq-b/viewosprfa','/planning-osp-boq-b/viewpplospatp','/planning-osp-boq-b/create','/planning-osp-boq-b/update','/planning-osp-boq-b/indexdetail','/planning-osp-boq-b/createdetail','/planning-osp-boq-b/delete','/planning-osp-boq-b/deletedetail','/planning-osp-boq-b/updatedetail','/planning-osp-boq-b/uploaddetail','/planning-osp-boq-b/unit','/planning-osp-boq-b/exportpdf','/planning-osp-boq-b/downloadfile'),
		'planning_ospBOQB_verifikasi' => array('/planning-osp-boq-b/indexverify','/planning-osp-boq-b/viewverify','/planning-osp-boq-b/verify','/planning-osp-boq-b/deleteverify','/planning-osp-boq-b/reviseverify','/planning-osp-boq-b/rejectverify','/planning-osp-boq-b/exportpdf','/planning-osp-boq-b/downloadfile'),
		'planning_ospBOQB_approve' => array('/planning-osp-boq-b/indexapprove','/planning-osp-boq-b/viewapprove','/planning-osp-boq-b/approve','/planning-osp-boq-b/exportpdf','/planning-osp-boq-b/downloadfile','/planning-osp-boq-b/reviseverify','/planning-osp-boq-b/rejectverify'),
		'planning_ospBOQB_overview' => array('/planning-osp-boq-b/indexoverview','/planning-osp-boq-b/viewoverview','/planning-osp-boq-b/viewosprfaoverview','/planning-osp-boq-b/viewpplospatpoverview','/planning-osp-boq-b/exportpdf','/planning-osp-boq-b/downloadfile','/planning-osp-boq-b/indexlog','/planning-osp-boq-b/viewlog'),

		//planning osp manage olt
		'planning_manageOLT_input' => array('/planning-osp-manage-olt/index','/planning-osp-manage-olt/view','/planning-osp-manage-olt/create','/planning-osp-manage-olt/update','/planning-osp-manage-olt/getcity','/planning-osp-manage-olt/getdistrict','/planning-osp-manage-olt/getsubdistrict','/planning-osp-manage-olt/delete','/planning-osp-manage-olt/genoltname','/planning-osp-manage-olt/downloadfile','/planning-osp-manage-olt/uploadrelationolt'),
		'planning_manageOLT_verifikasi' => array('/planning-osp-manage-olt/indexverify','/planning-osp-manage-olt/viewverify','/planning-osp-manage-olt/verify','/planning-osp-manage-olt/reviseverify','/planning-osp-manage-olt/rejectverify','/planning-osp-manage-olt/downloadfile'),
		'planning_manageOLT_approve' => array('/planning-osp-manage-olt/indexapprove','/planning-osp-manage-olt/viewapprove','/planning-osp-manage-olt/approve','/planning-osp-manage-olt/downloadfile'),
		'planning_manageOLT_overview' => array('/planning-osp-manage-olt/indexoverview','/planning-osp-manage-olt/viewoverview','/planning-osp-manage-olt/downloadfile','/planning-osp-manage-olt/indexlog','/planning-osp-manage-olt/viewlog'),


		//----- PPL var declaration -----
		//ppl dashboard
		'ppl_dashboard_view' => array('/dashboard-ppl/index','/dashboard-ppl/map','/map/getareaextent'),
		//ppl schedule
		'ppl_schedule_input' => array('/ppl-iko-atp/indexschedule','/ppl-iko-atp/viewschedule','/ppl-iko-atp/createschedule','/ppl-iko-atp/updateschedule'),
		'ppl_schedule_overview' => array('/ppl-iko-atp/indexoverviewschedule','/ppl-iko-atp/viewoverviewschedule','/ppl-iko-atp/indexschedulelog','/ppl-iko-atp/viewboqblog','/ppl-iko-atp/viewschedulelog'),

		// ppl iko atp
		'ppl_ikoATP_input' => array('/ppl-iko-atp/index','/ppl-iko-atp/view','/ppl-iko-atp/create','/ppl-iko-atp/update','/ppl-iko-atp/delete','/ppl-iko-atp/delete-atp','/ppl-iko-atp/viewboqb','/ppl-iko-atp/downloadfile','/ppl-iko-atp/uploadexcel'),
		'ppl_ikoATP_verifikasi' => array('/ppl-iko-atp/indexverify','/ppl-iko-atp/viewverify','/ppl-iko-atp/verify','/ppl-iko-atp/rejectverify','/ppl-iko-atp/revise','/ppl-iko-atp/downloadfile','/ppl-iko-atp/uploadexcel'),
		'ppl_ikoATP_approve' => array('/ppl-iko-atp/indexapprove','/ppl-iko-atp/viewapprove','/ppl-iko-atp/approve','/ppl-iko-atp/revise','/ppl-iko-atp/rejectverify','/ppl-iko-atp/exportpdf','/ppl-iko-atp/downloadfile','/ppl-iko-atp/uploadexcel'),
		'ppl_ikoATP_overview' => array('/ppl-iko-atp/indexoverview','/ppl-iko-atp/viewoverview','/ppl-iko-atp/downloadfile','/ppl-iko-atp/uploadexcel','/ppl-iko-atp/indexlog','/ppl-iko-atp/viewlog'),

		//ppl osp schedule
		'ppl_ospSchedule_input' => array('/ppl-osp-atp/indexschedule','/ppl-osp-atp/viewschedule','/ppl-osp-atp/createschedule','/ppl-osp-atp/updateschedule'),
		'ppl_ospSchedule_overview' => array('/ppl-osp-atp/indexoverviewschedule','/ppl-osp-atp/viewoverviewschedule','/ppl-osp-atp/indexschedulelog','/ppl-osp-atp/viewboqblog','/ppl-osp-atp/viewschedulelog'),

		// ppl osp atp
		'ppl_ospATP_input' => array('/ppl-osp-atp/index','/ppl-osp-atp/view','/ppl-osp-atp/create','/ppl-osp-atp/update','/ppl-osp-atp/delete','/ppl-osp-atp/delete-atp','/ppl-osp-atp/viewboqb','/ppl-osp-atp/uploadexcel','/ppl-osp-atp/downloadfile'),
		'ppl_ospATP_verifikasi' => array('/ppl-osp-atp/indexverify','/ppl-osp-atp/viewverify','/ppl-osp-atp/verify','/ppl-osp-atp/revise','/ppl-osp-atp/rejectverify','/ppl-osp-atp/uploadexcel','/ppl-osp-atp/downloadfile'),
		'ppl_ospATP_approve' => array('/ppl-osp-atp/indexapprove','/ppl-osp-atp/viewapprove','/ppl-osp-atp/approve','/ppl-osp-atp/revise','/ppl-osp-atp/rejectverify','/ppl-osp-atp/uploadexcel','/ppl-osp-atp/exportpdf','/ppl-osp-atp/downloadfile'),
		'ppl_ospATP_overview' => array('/ppl-osp-atp/indexoverview','/ppl-osp-atp/viewoverview','/ppl-osp-atp/uploadexcel','/ppl-osp-atp/downloadfile','/ppl-osp-atp/indexlog','/ppl-osp-atp/viewlog'),

		// ppl iko closing baut
		'ppl_ikoClosingBAUT_input' => array('/ppl-iko-baut/index','/ppl-iko-baut/view','/ppl-iko-baut/create','/ppl-iko-baut/update','/ppl-iko-baut/delete','/ppl-iko-baut/viewboqbf','/ppl-iko-baut/viewatp','/ppl-iko-baut/downloadfile'),
		'ppl_ikoClosingBAUT_verifikasi' => array('/ppl-iko-baut/indexverify','/ppl-iko-baut/viewverify','/ppl-iko-baut/verify','/ppl-iko-baut/reviseverify','/ppl-iko-baut/rejectverify','/ppl-iko-baut/downloadfile'),
		'ppl_ikoClosingBAUT_approve' => array('/ppl-iko-baut/indexapprove','/ppl-iko-baut/viewapprove','/ppl-iko-baut/approve','/ppl-iko-baut/reviseverify','/ppl-iko-baut/rejectverify','/ppl-iko-baut/downloadfile'),
		'ppl_ikoClosingBAUT_overview' => array('/ppl-iko-baut/indexoverview','/ppl-iko-baut/viewoverview','/ppl-iko-baut/viewatpoverview','/ppl-iko-baut/downloadfile','/ppl-iko-baut/indexlog','/ppl-iko-baut/viewatplog','/ppl-iko-baut/viewlog'),

		// ppl iko closing bast work
		'ppl_ikoClosingBAST_input' => array('/ppl-iko-bast-work/index','/ppl-iko-bast-work/view','/ppl-iko-bast-work/create','/ppl-iko-bast-work/update','/ppl-iko-bast-work/delete','/ppl-iko-bast-work/viewbaut','/ppl-iko-bast-work/getdatefinish','/ppl-iko-bast-work/downloadfile'),
		'ppl_ikoClosingBAST_verifikasi' => array('/ppl-iko-bast-work/indexverify','/ppl-iko-bast-work/viewverify','/ppl-iko-bast-work/verify','/ppl-iko-bast-work/reviseverify','/ppl-iko-bast-work/rejectverify','/ppl-iko-bast-work/downloadfile'),
		'ppl_ikoClosingBAST_approve' => array('/ppl-iko-bast-work/indexapprove','/ppl-iko-bast-work/viewapprove','/ppl-iko-bast-work/approve','/ppl-iko-bast-work/reviseverify','/ppl-iko-bast-work/rejectverify','/ppl-iko-bast-work/downloadfile'),
		'ppl_ikoClosingBAST_overview' => array('/ppl-iko-bast-work/indexoverview','/ppl-iko-bast-work/viewoverview','/ppl-iko-bast-work/viewbautoverview','/ppl-iko-bast-work/downloadfile','/ppl-iko-bast-work/indexlog','/ppl-iko-bast-work/viewlog'),

		// ppl iko closing bast retention
		'ppl_ikoClosingBASTRetention_input' => array('/ppl-iko-bast-retention/index','/ppl-iko-bast-retention/view','/ppl-iko-bast-retention/create','/ppl-iko-bast-retention/update','/ppl-iko-bast-retention/delete','/ppl-iko-bast-retention/viewbastwork','/ppl-iko-bast-retention/downloadfile'),
		'ppl_ikoClosingBASTRetention_verifikasi' => array('/ppl-iko-bast-retention/indexverify','/ppl-iko-bast-retention/viewverify','/ppl-iko-bast-retention/verify','/ppl-iko-bast-retention/reviseverify','/ppl-iko-bast-retention/rejectverify','/ppl-iko-bast-retention/downloadfile'),
		'ppl_ikoClosingBASTRetention_approve' => array('/ppl-iko-bast-retention/indexapprove','/ppl-iko-bast-retention/viewapprove','/ppl-iko-bast-retention/approve','/ppl-iko-bast-retention/reviseverify','/ppl-iko-bast-retention/rejectverify','/ppl-iko-bast-retention/downloadfile'),
		'ppl_ikoClosingBASTRetention_overview' => array('/ppl-iko-bast-retention/indexoverview','/ppl-iko-bast-retention/viewoverview','/ppl-iko-bast-retention/viewbastworkoverview','/ppl-iko-bast-retention/downloadfile','/ppl-iko-bast-retention/indexlog','/ppl-iko-bast-retention/viewlog'),

		// ppl osp closing baut
		'ppl_ospClosingBAUT_input' => array('/ppl-osp-baut/indexinput','/ppl-osp-baut/view','/ppl-osp-baut/viewatp','/ppl-osp-baut/create','/ppl-osp-baut/update','/ppl-osp-baut/delete','/ppl-osp-baut/downloadfile'),
		'ppl_ospClosingBAUT_verifikasi' => array('/ppl-osp-baut/indexverify','/ppl-osp-baut/viewverify','/ppl-osp-baut/verify','/ppl-osp-baut/reviseverify','/ppl-osp-baut/rejectverify','/ppl-osp-baut/downloadfile'),
		'ppl_ospClosingBAUT_approve' => array('/ppl-osp-baut/indexapprove','/ppl-osp-baut/viewapprove','/ppl-osp-baut/approve','/ppl-osp-baut/reviseverify','/ppl-osp-baut/rejectverify','/ppl-osp-baut/downloadfile'),
		'ppl_ospClosingBAUT_overview' => array('/ppl-osp-baut/indexoverview','/ppl-osp-baut/viewoverview','/ppl-osp-baut/downloadfile','/ppl-osp-baut/indexlog','/ppl-osp-baut/viewlog'),

		// ppl - osp closing bast work
		'ppl_ospClosingBASTWork_input' => array('/ppl-osp-bast-work/index','/ppl-osp-bast-work/view','/ppl-osp-bast-work/viewbaut','/ppl-osp-bast-work/create','/ppl-osp-bast-work/update','/ppl-osp-bast-work/delete','/ppl-osp-bast-work/getdatefinish','/ppl-osp-bast-work/downloadfile'),
		'ppl_ospClosingBASTWork_verifikasi' => array('/ppl-osp-bast-work/indexverify','/ppl-osp-bast-work/viewverify','/ppl-osp-bast-work/verify','/ppl-osp-bast-work/reviseverify','/ppl-osp-bast-work/rejectverify','/ppl-osp-bast-work/downloadfile'),
		'ppl_ospClosingBASTWork_approve' => array('/ppl-osp-bast-work/indexapprove','/ppl-osp-bast-work/viewapprove','/ppl-osp-bast-work/approve','/ppl-osp-bast-work/reviseverify','/ppl-osp-bast-work/rejectverify','/ppl-osp-bast-work/downloadfile'),
		'ppl_ospClosingBASTWork_overview' => array('/ppl-osp-bast-work/indexoverview','/ppl-osp-bast-work/viewoverview','/ppl-osp-bast-work/downloadfile','/ppl-osp-bast-work/indexlog','/ppl-osp-bast-work/viewlog'),

		// ppl - osp closing bast retention
		'ppl_ospClosingBASTRetention_input' => array('/ppl-osp-bast-retention/index','/ppl-osp-bast-retention/view','/ppl-osp-bast-retention/viewbastwork','/ppl-osp-bast-retention/create','/ppl-osp-bast-retention/update','/ppl-osp-bast-retention/delete','/ppl-osp-bast-retention/downloadfile'),
		'ppl_ospClosingBASTRetention_verifikasi' => array('/ppl-osp-bast-retention/indexverify','/ppl-osp-bast-retention/viewverify','/ppl-osp-bast-retention/verify','/ppl-osp-bast-retention/reviseverify','/ppl-osp-bast-retention/rejectverify','/ppl-osp-bast-retention/downloadfile'),
		'ppl_ospClosingBASTRetention_approve' => array('/ppl-osp-bast-retention/indexapprove','/ppl-osp-bast-retention/viewapprove','/ppl-osp-bast-retention/approve','/ppl-osp-bast-retention/reviseverify','/ppl-osp-bast-retention/rejectverify','/ppl-osp-bast-retention/downloadfile'),
		'ppl_ospClosingBASTRetention_overview' => array('/ppl-osp-bast-retention/indexoverview','/ppl-osp-bast-retention/viewoverview','/ppl-osp-bast-retention/viewbastworkoverview','/ppl-osp-bast-retention/downloadfile','/ppl-osp-bast-retention/indexlog','/ppl-osp-bast-retention/viewlog'),

		// ppl - iko atp invitation
		'ppl_iko_invited' => array('/ppl-iko-atp/indexinvitation','/ppl-iko-atp/viewinvitation','/ppl-iko-atp/create-invitation','/ppl-iko-atp/downloadfile'),

		// ppl - osp atp invitation
		'ppl_osp_invited' => array('/ppl-osp-atp/indexinvitation','/ppl-osp-atp/viewinvitation','/ppl-osp-atp/create-invitation','/ppl-osp-atp/downloadfile'),

		//ppl - ikr
		'ppl_ikr_invited' => array('/ppl-iko-atp/indexinvitationikr'),

		//ppl - pc
		'ppl_pc_invited' => array('/ppl-osp-atp/indexinvitationpc','/ppl-iko-atp/indexinvitationpc'),

		////ppl - ospm
		'ppl_ospm_invited' => array('/ppl-osp-atp/indexinvitationospm','/ppl-iko-atp/indexinvitationospm','/ppl-cipro-atp/viewinvitation'),

		//ppl - cdm
		'ppl_cdm_invited' => array('/ppl-cipro-atp/indexinvitation','/ppl-cipro-atp/viewinvitation','/ppl-cipro-atp/create-invitation','/ppl-cipro-atp/downloadfile'),

		//ppl - cipro
		'ppl_cipro_invited' => array('/ppl-cipro-atp/viewinvitation','/ppl-cipro-atp/indexinvitation','/ppl-cipro-atp/create-invitation','/ppl-cipro-atp/downloadfile'),

		////ppl - busdev
		'ppl_busdev_invited' => array('/ppl-cipro-atp/indexinvitation','/ppl-cipro-atp/viewinvitation','/ppl-cipro-atp/create-invitation','/ppl-cipro-atp/downloadfile'),

		//ppl - planning corp
		'ppl_planning_corp_invited' => array('/ppl-cipro-atp/indexinvitation','/ppl-cipro-atp/viewinvitation','/ppl-cipro-atp/create-invitation','/ppl-cipro-atp/downloadfile'),

		//ppl - pc_corp
		'ppl_pc_corp_invited' => array('/ppl-cipro-atp/indexinvitationpccorp','/ppl-cipro-atp/indexinvitation','/ppl-cipro-atp/viewinvitation','/ppl-cipro-atp/create-invitation','/ppl-cipro-atp/downloadfile'),



		//----- NetPro var declaration -----
		// netpro - dashboard
		'netpro_dashboard_view' => array('/dashboard-netpro/index','/dashboard-netpro/map','/dashboard-netpro/get-dash-netpro-grf','/dashboard-netpro/get-dash-netpro-wo-monthly'),

		//netpro - problem
		'netpro_problem_input' => array('/netpro-problem/index','/netpro-problem/view','/netpro-problem/create','/netpro-problem/update','/netpro-problem/delete'),
		'netpro_problem_verifikasi' => array('/netpro-problem/indexverify','/netpro-problem/viewverify','/netpro-problem/verify','/netpro-problem/reviseverify','/netpro-problem/rejectverify'),
		'netpro_problem_approve' => array('/netpro-problem/indexapprove','/netpro-problem/viewapprove','/netpro-problem/approve','/netpro-problem/reviseapprove','/netpro-problem/rejectapprove'),
		'netpro_problem_overview' => array('/netpro-problem/indexoverview','/netpro-problem/viewoverview'),

		//netpro - service report
		'netpro_sr_input' => array('/netpro-service-report/index','/netpro-service-report/view','/netpro-service-report/create','/netpro-service-report/update','/netpro-service-report/delete','/netpro-service-report/getcity','/netpro-service-report/exportpdf'),
		'netpro_sr_verifikasi' => array('/netpro-service-report/indexverify','/netpro-service-report/verify','/netpro-service-report/reviseverify','/netpro-service-report/rejectverify','/netpro-service-report/exportpdf'),
		'netpro_sr_approve' => array('/netpro-service-report/indexapprove','/netpro-service-report/viewapprove','/netpro-service-report/approve','/netpro-service-report/reviseapprove','/netpro-service-report/rejectapprove','/netpro-service-report/exportpdf'),
		'netpro_sr_overview' => array('/netpro-service-report/indexoverview','/netpro-service-report/viewoverview','/netpro-service-report/exportpdf'),

		//netpro - ba
		'netpro_ba_input' => array('/netpro-ba/index','/netpro-ba/view','/netpro-ba/create','/netpro-ba/update','/netpro-ba/delete'),
		'netpro_ba_verifikasi' => array('/netpro-ba/indexverify','/netpro-ba/verify','/netpro-ba/reviseverify','/netpro-ba/rejectverify'),
		'netpro_ba_approve' => array('/netpro-ba/indexapprove','/netpro-ba/viewapprove','/netpro-ba/approve','/netpro-ba/reviseapprove','/netpro-ba/rejectapprove'),
		'netpro_ba_overview' => array('/netpro-ba/indexoverview','/netpro-ba/viewoverview'),

		//netpro - workorder
		'netpro_wo_input' => array('/netpro-wo/index','/netpro-wo/view','/netpro-wo/create','/netpro-wo/update','/netpro-wo/delete','/netpro-wo/downloadfile'),
		'netpro_wo_verifikasi' => array('/netpro-wo/indexverify','/netpro-wo/verify','/netpro-wo/reviseverify','/netpro-wo/rejectverify','/netpro-wo/downloadfile','/netpro-wo/viewverify'),
		'netpro_wo_approve' => array('/netpro-wo/indexapprove','/netpro-wo/viewapprove','/netpro-wo/approve','/netpro-wo/reviseapprove','/netpro-wo/rejectapprove','/netpro-wo/downloadfile'),
		'netpro_wo_overview' => array('/netpro-wo/indexoverview','/netpro-wo/downloadfile'),

		//netpro - grf
		'netpro_grfv_input' => array('/netpro-grf/index','/netpro-grf/indexdetail','/netpro-grf/indexbs','/netpro-grf/view','/netpro-grf/create','/netpro-grf/createdetail','/netpro-grf/update','/netpro-grf/delete','/netpro-grf/deletedetail','/netpro-grf/submit','/netpro-grf/downloadfile','/netpro-grf/exportpdf','/netpro-grf/uom','/netpro-grf/uploaddetail','/netpro-grf/updatedetail','/netpro-grf/getcity','/netpro-grf/exportxls', '/netpro-grf/cancel'),
		'netpro_grfv_verifikasi' => array('/netpro-grf/indexverify','/netpro-grf/viewverify','/netpro-grf/verify','/netpro-grf/reviseverify','/netpro-grf/rejectverify','/netpro-grf/downloadfile','/netpro-grf/exportpdf','/netpro-grf/uom','/netpro-grf/getcity','/netpro-grf/exportxls'),
		'netpro_grfv_approve' => array('/netpro-grf/indexapprove','/netpro-grf/viewapprove','/netpro-grf/approve','/netpro-grf/reviseapprove','/netpro-grf/rejectapprove','/netpro-grf/downloadfile','/netpro-grf/exportpdf','/netpro-grf/uom','/netpro-grf/getcity','/netpro-grf/exportxls'),
		'netpro_grfv_overview' => array('/netpro-grf/indexoverview','/netpro-grf/viewoverview','/netpro-grf/downloadfile','/netpro-grf/exportpdf','/netpro-grf/indexlog','/netpro-grf/viewlog','/netpro-grf/uom','/netpro-grf/getcity','/netpro-grf/exportxls'),

		//netpro - Material usage
		'netpro_mu_input' => array('/netpro-grf/indexusage','/netpro-grf/indexbsusage','/netpro-grf/indexdetail','/netpro-grf/viewusage','/netpro-grf/create','/netpro-grf/createdetail','/netpro-grf/updateusage','/netpro-grf/updateusagedetail','/netpro-grf/delete','/netpro-grf/deletedetail','/netpro-grf/deleteusage','/netpro-grf/submit','/netpro-grf/submitusage','/netpro-grf/indexusagedetail'),
		'netpro_mu_verifikasi' => array('/netpro-grf/indexusageverify','/netpro-grf/viewusageverify','/netpro-grf/verifyusage','/netpro-grf/reviseusageverify','/netpro-grf/rejectusageverify'),
		'netpro_mu_approve' => array('/netpro-grf/indexusageapprove','/netpro-grf/viewusageapprove','/netpro-grf/approveusage','/netpro-grf/reviseusageapprove','/netpro-grf/rejectusageapprove'),
		'netpro_mu_overview' => array('/netpro-grf/indexusageoverview','/netpro-grf/viewusageoverview','/netpro-grf/indexusagelog','/netpro-grf/viewusagelog'),

		//netpro - grf bs
		'netpro_grf_bs_input' => array('/netpro-grf-bs/index','/netpro-grf-bs/indexdetail','/netpro-grf-bs/view','/netpro-grf-bs/create','/netpro-grf-bs/createdetail','/netpro-grf-bs/update','/netpro-grf-bs/delete','/netpro-grf-bs/deletedetail','/netpro-grf-bs/submit','/netpro-grf-bs/submitusage','/netpro-grf-bs/getcity','/netpro-grf-bs/getneeded','/netpro-grf-bs/readytoverify','/netpro-grf-bs/notreadytoverify','/netpro-grf-bs/updatedetail','/netpro-grf-bs/uom','/netpro-grf-bs/exportpdf','/netpro-grf-bs/viewwo','/netpro-grf-bs/updatemudetail','/netpro-grf-bs/deletemudetail','/netpro-grf-bs/uploaddetail','/netpro-grf-bs/exportxls','/netpro-grf-bs/cancel','/netpro-grf-bs/downloadfile'),
		'netpro_grf_bs_verifikasi' => array('/netpro-grf-bs/indexverify','/netpro-grf-bs/viewverify','/netpro-grf-bs/verify','/netpro-grf-bs/reviseverify','/netpro-grf-bs/rejectverify','/netpro-grf-bs/exportpdf','/netpro-grf-bs/exportxls'),
		'netpro_grf_bs_approve' => array('/netpro-grf-bs/indexapprove','/netpro-grf-bs/viewapprove','/netpro-grf-bs/approve','/netpro-grf-bs/reviseverify','/netpro-grf-bs/rejectverify','/netpro-grf-bs/exportpdf','/netpro-grf-bs/exportxls'),
		'netpro_grf_bs_overview' => array('/netpro-grf-bs/indexoverview','/netpro-grf-bs/viewoverview','/netpro-grf-bs/indexlog','/netpro-grf-bs/viewlog','/netpro-grf-bs/exportpdf','/netpro-grf-bs/viewwo','/netpro-grf-bs/exportxls'),

		//netpro - Material usage bs
		'netpro_mu_bs_input' => array('/netpro-grf-bs/indexusage','/netpro-grf-bs/indexdetail','/netpro-grf-bs/viewusage','/netpro-grf-bs/createmuwo','/netpro-grf-bs/createmudetail','/netpro-grf-bs/updateusage','/netpro-grf-bs/deleteusage','/netpro-grf-bs/deletemuusage','/netpro-grf-bs/submit','/netpro-grf-bs/getcity','/netpro-grf-bs/getneeded','/netpro-grf-bs/readytoverify','/netpro-grf-bs/uom'),
		'netpro_mu_bs_verifikasi' => array('/netpro-grf-bs/indexusageverify','/netpro-grf-bs/viewusageverify','/netpro-grf-bs/verifyusage','/netpro-grf-bs/reviseusageverify','/netpro-grf-bs/rejectusageverify'),
		'netpro_mu_bs_approve' => array('/netpro-grf-bs/indexusageapprove','/netpro-grf-bs/viewusageapprove','/netpro-grf-bs/approveusage','/netpro-grf-bs/reviseusageverify','/netpro-grf-bs/rejectusageverify'),
		'netpro_mu_bs_overview' => array('/netpro-grf-bs/indexusageoverview','/netpro-grf-bs/viewusageoverview','/netpro-grf-bs/indexusagelog','/netpro-grf-bs/viewusagelog','/netpro-grf-bs/viewwolog'),

		// List Stock Buffer
		'netpro_lsb_view' => array('/netpro-list-stock-buffer/index','/netpro-list-stock-buffer/indexdetail','/netpro-list-stock-buffer/view','/netpro-list-stock-buffer/create','/netpro-list-stock-buffer/createdetail','/netpro-list-stock-buffer/update','/netpro-list-stock-buffer/delete','/netpro-list-stock-buffer/getcity','/netpro-grf-bs/indexstockbuffer'),



		//----- ospm var declaration -----
		// ospm - dashboard
		'ospm_dashboard_view' => array('/dashboard-ospm/index','/dashboard-ospm/map','/dashboard-ospm/get-dash-ospm-grf','/dashboard-ospm/get-dash-ospm-crm','/dashboard-ospm/get-dash-ospm-im'),

		// ospm - grf
		'ospm_grf_input' => array('/ospm-grf/index','/ospm-grf/view','/ospm-grf/create','/ospm-grf/update','/ospm-grf/delete','/ospm-grf/indexdetail','/ospm-grf/createdetail','/ospm-grf/updatedetail','/ospm-grf/deletedetail','/ospm-grf/uploaddetail','/ospm-grf/getcity', '/ospm-grf/downloadfile','/ospm-grf/submit', '/ospm-grf/cancel'),
		'ospm_grf_verifikasi' => array('/ospm-grf/indexverify','/ospm-grf/viewverify','/ospm-grf/verify','/ospm-grf/reviseverify','/ospm-grf/rejectverify'),
		'ospm_grf_approve' => array('/ospm-grf/indexapprove','/ospm-grf/viewapprove','/ospm-grf/approve','/ospm-grf/reviseverify','/ospm-grf/rejectverify'),
		'ospm_grf_overview' => array('/ospm-grf/indexoverview','/ospm-grf/viewoverview','/ospm-grf/indexlog','/ospm-grf/viewlog','/ospm-grf/exportpdf','/ospm-grf/exportxls'),

		//ospm - Material usage
		'ospm_mu_input' => array('/ospm-grf/indexusage','/ospm-grf/indexusagedetail','/ospm-grf/viewusage','/ospm-grf/createdetail','/ospm-grf/updateusage','/ospm-grf/updateusagedetail','/ospm-grf/deleteusage','/ospm-grf/deletedetail','/ospm-grf/submitusage'),
		'ospm_mu_verifikasi' => array('/ospm-grf/indexusageverify','/ospm-grf/viewusageverify','/ospm-grf/verifyusage','/ospm-grf/reviseusageverify','/ospm-grf/rejectusageverify'),
		'ospm_mu_approve' => array('/ospm-grf/indexusageapprove','/ospm-grf/viewusageapprove','/ospm-grf/approveusage','/ospm-grf/reviseusageapprove','/ospm-grf/rejectusageapprove'),
		'ospm_mu_overview' => array('/ospm-grf/indexusageoverview','/ospm-grf/viewusageoverview','/ospm-grf/indexusagelog','/ospm-grf/viewusagelog','/ospm-grf/exportpdf','/ospm-grf/exportxls', '/ospm-grf/exportxlsmu'),

		// ospm - obstacle
		'ospm_obstacle_input' => array('/ospm-obstacle/index','/ospm-obstacle/view','/ospm-obstacle/create','/ospm-obstacle/update','/ospm-obstacle/delete'),
		'ospm_obstacle_verifikasi' => array('/ospm-obstacle/indexverify'),
		'ospm_obstacle_approve' => array('/ospm-obstacle/indexapprove'),
		'ospm_obstacle_overview' => array('/ospm-obstacle/indexoverview'),

		// ospm - ticket trouble
		'ospm_tt_input' => array('/ospm-ticket-trouble/index','/ospm-ticket-trouble/view','/ospm-ticket-trouble/create','/ospm-ticket-trouble/update','/ospm-ticket-trouble/delete','/ospm-ticket-trouble/indexcrm','/ospm-ticket-trouble/viewcrm'),
		'ospm_tt_verifikasi' => array('/ospm-ticket-trouble/indexverify'),
		'ospm_tt_approve' => array('/ospm-ticket-trouble/indexapprove'),
		'ospm_tt_overview' => array('/ospm-ticket-trouble/indexoverview'),

		//ospm - grf bs
		'ospm_grf_bs_input' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/index','/ospm-grf-bs/indexdetail','/ospm-grf-bs/view','/ospm-grf-bs/create','/ospm-grf-bs/createdetail','/ospm-grf-bs/update','/ospm-grf-bs/delete','/ospm-grf-bs/deletedetail','/ospm-grf-bs/submit','/ospm-grf-bs/getcity','/ospm-grf-bs/getneeded','/ospm-grf-bs/readytoverify','/ospm-grf-bs/notreadytoverify', '/ospm-grf-bs/cancel'),
		'ospm_grf_bs_verifikasi' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexverify','/ospm-grf-bs/viewverify','/ospm-grf-bs/verify','/ospm-grf-bs/reviseverify','/ospm-grf-bs/rejectverify'),
		'ospm_grf_bs_approve' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexapprove','/ospm-grf-bs/viewapprove','/ospm-grf-bs/approve','/ospm-grf-bs/reviseapprove','/ospm-grf-bs/rejectapprove'),
		'ospm_grf_bs_overview' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexoverview','/ospm-grf-bs/viewoverview','/ospm-grf-bs/indexlog','/ospm-grf-bs/viewlog','/ospm-grf-bs/exportpdf','/ospm-grf-bs/exportxls','/ospm-grf-bs/downloadfile'),

		//ospm - Material usage bs
		'ospm_mu_bs_input' => array('/ospm-grf-bs/indexusage','/ospm-grf-bs/indexdetail','/ospm-grf-bs/viewusage','/ospm-grf-bs/create','/ospm-grf-bs/createdetail','/ospm-grf-bs/updatemudetail','/ospm-grf-bs/deleteusage','/ospm-grf-bs/deletemuusage','/ospm-grf-bs/deletedetail','/ospm-grf-bs/submit','/ospm-grf-bs/getcity','/ospm-grf-bs/getneeded','/ospm-grf-bs/readytoverify','/ospm-grf-bs/updatedetail','/ospm-grf-bs/uploaddetail','/ospm-grf-bs/createmudetail','/ospm-grf-bs/createmuwo','/ospm-grf-bs/deletemudetail'),
		'ospm_mu_bs_verifikasi' => array('/ospm-grf-bs/indexusageverify','/ospm-grf-bs/viewusageverify','/ospm-grf-bs/verifyusage','/ospm-grf-bs/reviseusageverify','/ospm-grf-bs/rejectusageverify'),
		'ospm_mu_bs_approve' => array('/ospm-grf-bs/indexusageapprove','/ospm-grf-bs/viewusageapprove','/ospm-grf-bs/approveusage','/ospm-grf-bs/reviseusageverify','/ospm-grf-bs/rejectusageverify'),
		'ospm_mu_bs_overview' => array('/ospm-grf-bs/indexusageoverview','/ospm-grf-bs/viewusageoverview','/ospm-grf-bs/indexusagelog','/ospm-grf-bs/viewusagelog','/ospm-grf-bs/exportpdf','/ospm-grf-bs/exportxls','/ospm-grf-bs/exportxlsmu','/ospm-grf-bs/downloadfile'),

		//ospm - grf bs vendor
		'ospm_grf_bs_input_vendor' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexvendor','/ospm-grf-bs/indexdetail','/ospm-grf-bs/view','/ospm-grf-bs/createvendor','/ospm-grf-bs/createdetail','/ospm-grf-bs/update','/ospm-grf-bs/delete','/ospm-grf-bs/deletedetail','/ospm-grf-bs/submit','/ospm-grf-bs/getcity','/ospm-grf-bs/getneeded','/ospm-grf-bs/readytoverify', '/ospm-grf-bs/cancel'),
		'ospm_grf_bs_verifikasi_vendor' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexverifyvendor','/ospm-grf-bs/viewverify','/ospm-grf-bs/verify','/ospm-grf-bs/reviseverify','/ospm-grf-bs/rejectverify'),
		'ospm_grf_bs_approve_vendor' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexapprovevendor','/ospm-grf-bs/viewapprove','/ospm-grf-bs/approve','/ospm-grf-bs/reviseapprove','/ospm-grf-bs/rejectapprove'),
		'ospm_grf_bs_overview_vendor' => array('/ospm-grf-bs/viewwo','/ospm-grf-bs/indexoverviewvendor','/ospm-grf-bs/viewoverview','/ospm-grf-bs/indexlogvendor','/ospm-grf-bs/viewlog','/ospm-grf-bs/exportpdf','/ospm-grf-bs/exportxls','/ospm-grf-bs/downloadfile'),

		//ospm - Material usage bs Vendor
		'ospm_mu_bs_input_vendor' => array('/ospm-grf-bs/indexusagevendor','/ospm-grf-bs/indexdetail','/ospm-grf-bs/viewusage','/ospm-grf-bs/create','/ospm-grf-bs/createdetail','/ospm-grf-bs/updatemudetail','/ospm-grf-bs/deletemuusage','/ospm-grf-bs/deleteusage','/ospm-grf-bs/deletedetail','/ospm-grf-bs/submit','/ospm-grf-bs/getcity','/ospm-grf-bs/getneeded','/ospm-grf-bs/readytoverify','/ospm-grf-bs/createmudetail','/ospm-grf-bs/createmuwo'),
		'ospm_mu_bs_verifikasi_vendor' => array('/ospm-grf-bs/indexusageverifyvendor','/ospm-grf-bs/viewusageverify','/ospm-grf-bs/verifyusage','/ospm-grf-bs/reviseusageverify','/ospm-grf-bs/rejectusageverify'),
		'ospm_mu_bs_approve_vendor' => array('/ospm-grf-bs/indexusageapprovevendor','/ospm-grf-bs/viewusageapprove','/ospm-grf-bs/approveusage','/ospm-grf-bs/reviseusageverify','/ospm-grf-bs/rejectusageverify'),
		'ospm_mu_bs_overview_vendor' => array('/ospm-grf-bs/indexusageoverviewvendor','/ospm-grf-bs/viewusageoverview','/ospm-grf-bs/indexusagelogvendor','/ospm-grf-bs/viewusagelog','/ospm-grf-bs/exportpdf','/ospm-grf-bs/exportxls','/ospm-grf-bs/exportxlsmu','/ospm-grf-bs/downloadfile'),

		// ospm - list stock buffer
		'ospm_list_stock_buffer_input' => array('/ospm-grf-bs/indexstockbuffer','/ospm-list-stock-buffer/index','/ospm-list-stock-buffer/view','/ospm-list-stock-buffer/create','/ospm-list-stock-buffer/update','/ospm-list-stock-buffer/delete'),

		// ospm - list stock buffer vendor
		'ospm_list_stock_buffer_input_vendor' => array('/ospm-grf-bs/indexstockbuffervendor','/ospm-list-stock-buffer/indexvendor','/ospm-list-stock-buffer/view','/ospm-list-stock-buffer/create','/ospm-list-stock-buffer/update','/ospm-list-stock-buffer/delete'),



		// // ap - invoice
		// 'ap_finance_invoice_input' => array('/finance-invoice/index','/finance-invoice/indexbast','/finance-invoice/getlaborposition','/finance-invoice/view','/finance-invoice/create','/finance-invoice/createbast','/finance-invoice/update','/finance-invoice/delete','/finance-invoice/getbast','/finance-invoice/downloadfile'),
		// 'ap_finance_invoice_verifikasi' => array('/finance-invoice/indexverify','/finance-invoice/viewverify','/finance-invoice/verify','/finance-invoice/revise','/finance-invoice/reject','/finance-invoice/downloadfile'),
		// 'ap_finance_invoice_approve' => array('/finance-invoice/indexapprove','/finance-invoice/viewapprove','/finance-invoice/approve','/finance-invoice/downloadfile'),
		// 'ap_finance_invoice_overview' => array('/finance-invoice/indexoverview','/finance-invoice/viewoverview','/finance-invoice/downloadfile'),
		// //ap report
		// 'ap_finance_report' => array('/finance-report/indexreport','/finance-report/viewoverview','/finance-report/downloadfile'),


		// // ap - invoice document
		// 'ap_finance_invoice_doc_verify' => array('/finance-invoice/indexdocverify', '/finance-invoice/verifydoc'),
		// 'ap_finance_invoice_doc_approve' => array('/finance-invoice/indexdocapprove', '/finance-invoice/approvedoc'),

		// // ap - rfp
		// 'ap_finance_rfp_input' => array('/finance-rfp/index','/finance-rfp/view','/finance-rfp/create','/finance-rfp/update','/finance-rfp/delete'),
		// 'ap_finance_rfp_verifikasi' => array('/finance-rfp/indexverify','/finance-rfp/viewverify'),
		// 'ap_finance_rfp_approve' => array('/finance-rfp/indexapprove','/finance-rfp/viewapprove'),
		// 'ap_finance_rfp_overview' => array('/finance-rfp/indexoverview','/finance-rfp/viewoverview'),

		//----- os var declaration -----
		// os -  dashboard
		'os_dashboard_view' => array('/dashboard-os/index','/dashboard-os/map','/dashboard-os/get-dash-chart-os-ga', '/dashboard-os/get-dash-chart-os-personel'),

		// os - outsource personil
		'os_personil_input' => array('/os-outsource-personil/upload','/os-outsource-personil/index','/os-outsource-personil/view','/os-outsource-personil/create','/os-outsource-personil/update','/os-outsource-personil/delete','/os-outsource-personil/getdivision','/os-outsource-personil/exportpdf','/os-outsource-personil/downloadfile','/os-outsource-personil/notactive'),
		'os_personil_verifikasi' => array('/os-outsource-personil/indexverify','/os-outsource-personil/viewverify','/os-outsource-personil/verify','/os-outsource-personil/revise','/os-outsource-personil/reject','/os-outsource-personil/exportpdf','/os-outsource-personil/downloadfile'),
		'os_personil_approve' => array('/os-outsource-personil/indexapprove','/os-outsource-personil/viewapprove','/os-outsource-personil/approve','/os-outsource-personil/revise','/os-outsource-personil/reject','/os-outsource-personil/exportpdf','/os-outsource-personil/downloadfile'),
		'os_personil_overview' => array('/os-outsource-personil/indexoverview','/os-outsource-personil/viewoverview','/os-outsource-personil/exportpdf','/os-outsource-personil/downloadfile','/os-outsource-personil/indexlog','/os-outsource-personil/viewlog'),

		// os - outsource salary
		'os_salary_input' => array('/os-outsource-salary/savesalarydetail','/os-outsource-salary/countsalarytampil','/os-outsource-salary/index','/os-outsource-salary/view','/os-outsource-salary/create','/os-outsource-salary/update','/os-outsource-salary/delete','/os-outsource-salary/list','/os-outsource-salary/countsalary','/os-outsource-salary/countsalarydetail','/os-outsource-salary/salarydetail','/os-outsource-salary/exportpdf','/os-outsource-salary/downloadfile', '/os-outsource-salary/detailsalary'),
		'os_salary_verifikasi' => array('/os-outsource-salary/indexverify','/os-outsource-salary/viewverify','/os-outsource-salary/verify','/os-outsource-salary/revise','/os-outsource-salary/reject','/os-outsource-salary/exportpdf','/os-outsource-salary/downloadfile', '/os-outsource-salary/detailsalary'),
		'os_salary_approve' => array('/os-outsource-salary/indexapprove','/os-outsource-salary/viewapprove','/os-outsource-salary/approve','/os-outsource-salary/revise','/os-outsource-salary/reject','/os-outsource-salary/exportpdf','/os-outsource-salary/downloadfile', '/os-outsource-salary/detailsalary'),
		'os_salary_overview' => array('/os-outsource-salary/indexoverview','/os-outsource-salary/viewoverview','/os-outsource-salary/exportpdf','/os-outsource-salary/downloadfile','/os-outsource-salary/indexlog','/os-outsource-salary/viewlog', '/os-outsource-salary/detailsalary'),

		// os - outsource parameter
		'os_outsource_input' => array('/os-outsource-parameter/index','/os-outsource-parameter/view','/os-outsource-parameter/create','/os-outsource-parameter/update','/os-outsource-parameter/delete','/os-outsource-parameter/exportpdf'),
		'os_outsource_verifikasi' => array('/os-outsource-parameter/indexverify','/os-outsource-parameter/viewverify','/os-outsource-parameter/verify','/os-outsource-parameter/revise','/os-outsource-parameter/reject','/os-outsource-parameter/exportpdf'),
		'os_outsource_approve' => array('/os-outsource-parameter/indexapprove','/os-outsource-parameter/viewapprove','/os-outsource-parameter/approve','/os-outsource-parameter/revise','/os-outsource-parameter/reject','/os-outsource-parameter/exportpdf'),
		'os_outsource_overview' => array('/os-outsource-parameter/indexoverview','/os-outsource-parameter/viewoverview','/os-outsource-parameter/exportpdf'),

        // os - ga biaya jalan
		'os_ga_biaya_jalan_input' => array('/os-ga-biaya-jalan/index','/os-ga-biaya-jalan/view','/os-ga-biaya-jalan/create','/os-ga-biaya-jalan/update','/os-ga-biaya-jalan/delete'),
		'os_ga_biaya_jalan_verifikasi' => array('/os-ga-biaya-jalan/indexverify','/os-ga-biaya-jalan/viewverify','/os-ga-biaya-jalan/revise','/os-ga-biaya-jalan/reject'),
		'os_ga_biaya_jalan_approve' => array('/os-ga-biaya-jalan/indexapprove','/os-ga-biaya-jalan/viewapprove','/os-ga-biaya-jalan/revise','/os-ga-biaya-jalan/reject'),
		'os_ga_biaya_jalan_overview' => array('/os-ga-biaya-jalan/indexoverview','/os-ga-biaya-jalan/viewoverview'),

        // os - ga biaya jalan iko
		'os_ga_biaya_jalan_iko_input' => array('/os-ga-biaya-jalan-iko/indexdetail','/os-ga-biaya-jalan-iko/index','/os-ga-biaya-jalan-iko/view','/os-ga-biaya-jalan-iko/create','/os-ga-biaya-jalan-iko/update','/os-ga-biaya-jalan-iko/delete','/os-ga-biaya-jalan-iko/viewosgavehicleiko','/os-ga-biaya-jalan-iko/exportpdf'),
		'os_ga_biaya_jalan_iko_verifikasi' => array('/os-ga-biaya-jalan-iko/indexverify','/os-ga-biaya-jalan-iko/viewverify','/os-ga-biaya-jalan-iko/revise','/os-ga-biaya-jalan-iko/reject','/os-ga-biaya-jalan-iko/verify','/os-ga-biaya-jalan-iko/exportpdf'),
		'os_ga_biaya_jalan_iko_approve' => array('/os-ga-biaya-jalan-iko/indexapprove','/os-ga-biaya-jalan-iko/viewapprove','/os-ga-biaya-jalan-iko/revise','/os-ga-biaya-jalan-iko/reject','/os-ga-biaya-jalan-iko/approve','/os-ga-biaya-jalan-iko/exportpdf'),
		'os_ga_biaya_jalan_iko_overview' => array('/os-ga-biaya-jalan-iko/indexoverview','/os-ga-biaya-jalan-iko/viewoverview','/os-ga-biaya-jalan-iko/indexlog','/os-ga-biaya-jalan-iko/viewlog','/os-ga-biaya-jalan-iko/viewosgavehicleiko','/os-ga-biaya-jalan-iko/exportpdf','/os-ga-biaya-jalan-iko/exportxls','/os-ga-biaya-jalan-iko/downloadfile'),

        // os - ga biaya jalan osp
		'os_ga_biaya_jalan_osp_input' => array('/os-ga-biaya-jalan-osp/indexdetail','/os-ga-biaya-jalan-osp/index','/os-ga-biaya-jalan-osp/view','/os-ga-biaya-jalan-osp/create','/os-ga-biaya-jalan-osp/update','/os-ga-biaya-jalan-osp/delete','/os-ga-biaya-jalan-osp/viewosgavehicleosp','/os-ga-biaya-jalan-osp/exportpdf'),
		'os_ga_biaya_jalan_osp_verifikasi' => array('/os-ga-biaya-jalan-osp/indexverify','/os-ga-biaya-jalan-osp/viewverify','/os-ga-biaya-jalan-osp/revise','/os-ga-biaya-jalan-osp/reject','/os-ga-biaya-jalan-osp/verify','/os-ga-biaya-jalan-osp/exportpdf'),
		'os_ga_biaya_jalan_osp_approve' => array('/os-ga-biaya-jalan-osp/indexapprove','/os-ga-biaya-jalan-osp/viewapprove','/os-ga-biaya-jalan-osp/revise','/os-ga-biaya-jalan-osp/reject','/os-ga-biaya-jalan-osp/approve','/os-ga-biaya-jalan-osp/exportpdf'),
		'os_ga_biaya_jalan_osp_overview' => array('/os-ga-biaya-jalan-osp/indexoverview','/os-ga-biaya-jalan-osp/viewoverview','/os-ga-biaya-jalan-osp/indexlog','/os-ga-biaya-jalan-osp/viewlog','/os-ga-biaya-jalan-osp/viewosgavehicleosp','/os-ga-biaya-jalan-osp/exportpdf','/os-ga-biaya-jalan-osp/exportxls', '/os-ga-biaya-jalan-osp/downloadfile'),

        // os - ga vehicle iko
		'os_ga_vehicle_iko_input' => array('/os-ga-vehicle-iko/index','/os-ga-vehicle-iko/view','/os-ga-vehicle-iko/create','/os-ga-vehicle-iko/update','/os-ga-vehicle-iko/delete','/os-ga-vehicle-iko/createdetail','/os-ga-vehicle-iko/create','/os-ga-vehicle-iko/indexdetail','/os-ga-vehicle-iko/getplatenumber','/os-ga-vehicle-iko/viewwo','/os-ga-vehicle-iko/viewikoworkorder','/os-ga-vehicle-iko/exportpdf','/os-ga-vehicle-iko/updatedetail','/os-ga-vehicle-iko/deletedetail'),
		'os_ga_vehicle_iko_verifikasi' => array('/os-ga-vehicle-iko/indexverify','/os-ga-vehicle-iko/viewverify','/os-ga-vehicle-iko/revise','/os-ga-vehicle-iko/reject','/os-ga-vehicle-iko/verify','/os-ga-vehicle-iko/exportpdf'),
		'os_ga_vehicle_iko_approve' => array('/os-ga-vehicle-iko/indexapprove','/os-ga-vehicle-iko/viewapprove','/os-ga-vehicle-iko/revise','/os-ga-vehicle-iko/reject','/os-ga-vehicle-iko/approve','/os-ga-vehicle-iko/exportpdf'),
		'os_ga_vehicle_iko_overview' => array('/os-ga-vehicle-iko/indexoverview','/os-ga-vehicle-iko/viewoverview','/os-ga-vehicle-iko/exportpdf','/os-ga-vehicle-iko/indexlog','/os-ga-vehicle-iko/viewlog'),
		'os_ga_vehicle_iko_listwo' => array('/os-ga-vehicle-iko/indexwo','/os-ga-vehicle-iko/viewwo','/os-ga-vehicle-iko/viewikoworkorder','/os-ga-vehicle-iko/exportpdf'),

        // os - ga vehicle osp
		'os_ga_vehicle_osp_input' => array('/os-ga-vehicle-osp/index','/os-ga-vehicle-osp/view','/os-ga-vehicle-osp/create','/os-ga-vehicle-osp/update','/os-ga-vehicle-osp/delete', '/os-ga-vehicle-osp/createdetail','/os-ga-vehicle-osp/create','/os-ga-vehicle-osp/indexdetail','/os-ga-vehicle-osp/getplatenumber','/os-ga-vehicle-osp/viewwo','/os-ga-vehicle-osp/viewospworkorder','/os-ga-vehicle-osp/exportpdf','/os-ga-vehicle-osp/updatedetail','/os-ga-vehicle-osp/deletedetail'),
		'os_ga_vehicle_osp_verifikasi' => array('/os-ga-vehicle-osp/indexverify','/os-ga-vehicle-osp/verify','/os-ga-vehicle-osp/viewverify','/os-ga-vehicle-osp/revise','/os-ga-vehicle-osp/reject','/os-ga-vehicle-osp/exportpdf'),
		'os_ga_vehicle_osp_approve' => array('/os-ga-vehicle-osp/indexapprove','/os-ga-vehicle-osp/approve','/os-ga-vehicle-osp/viewapprove','/os-ga-vehicle-osp/revise','/os-ga-vehicle-osp/reject','/os-ga-vehicle-osp/exportpdf'),
		'os_ga_vehicle_osp_overview' => array('/os-ga-vehicle-osp/indexoverview','/os-ga-vehicle-osp/viewoverview','/os-ga-vehicle-osp/exportpdf','/os-ga-vehicle-osp/indexlog','/os-ga-vehicle-osp/viewlog'),
		'os_ga_vehicle_osp_listwo' => array('/os-ga-vehicle-osp/indexwo','/os-ga-vehicle-osp/viewwo','/os-ga-vehicle-osp/viewospworkorder','/os-ga-vehicle-osp/exportpdf'),

        // os - ga vehilce parameter
		'os_ga_vehicle_parameter_input' => array('/os-ga-vehicle-parameter/index','/os-ga-vehicle-parameter/view','/os-ga-vehicle-parameter/create','/os-ga-vehicle-parameter/update','/os-ga-vehicle-parameter/delete'),
		'os_ga_vehicle_parameter_verifikasi' => array('/os-ga-vehicle-parameter/indexverify','/os-ga-vehicle-parameter/viewverify','/os-ga-vehicle-parameter/revise','/os-ga-vehicle-parameter/reject'),
		'os_ga_vehicle_parameter_approve' => array('/os-ga-vehicle-parameter/indexapprove','/os-ga-vehicle-parameter/viewapprove','/os-ga-vehicle-parameter/revise','/os-ga-vehicle-parameter/reject','/os-ga-vehicle-parameter/approve'),
		'os_ga_vehicle_parameter_overview' => array('/os-ga-vehicle-parameter/indexoverview','/os-ga-vehicle-parameter/viewoverview'),

		// os - vendor regist vendor
		'os_vendor_regist_vendor_input' => array('/os-vendor-regist-vendor/index','/os-vendor-regist-vendor/view','/os-vendor-regist-vendor/create','/os-vendor-regist-vendor/update','/os-vendor-regist-vendor/delete','/os-vendor-regist-vendor/updateoverview'),
		'os_vendor_regist_vendor_verifikasi' => array('/os-vendor-regist-vendor/indexverify','/os-vendor-regist-vendor/viewverify','/os-vendor-regist-vendor/revise','/os-vendor-regist-vendor/reject','/os-vendor-regist-vendor/verify'),
		'os_vendor_regist_vendor_approve' => array('/os-vendor-regist-vendor/indexapprove','/os-vendor-regist-vendor/viewapprove','/os-vendor-regist-vendor/revise','/os-vendor-regist-vendor/reject','/os-vendor-regist-vendor/approve'),
		'os_vendor_regist_vendor_overview' => array('/os-vendor-regist-vendor/indexoverview','/os-vendor-regist-vendor/viewoverview','/os-vendor-regist-vendor/indexlog','/os-vendor-regist-vendor/viewlog','/os-vendor-regist-vendor/exportpdf','/os-vendor-regist-vendor/downloadfile'),

		// os - vendor pob
		'os_vendor_pob_input' => array('/os-vendor-pob/index','/os-vendor-pob/view','/os-vendor-pob/create','/os-vendor-pob/update','/os-vendor-pob/delete','/os-vendor-pob/list'),
		'os_vendor_pob_verifikasi' => array('/os-vendor-pob/indexverify','/os-vendor-pob/viewverify','/os-vendor-pob/revise','/os-vendor-pob/reject', '/os-vendor-pob/verify'),
		'os_vendor_pob_approve' => array('/os-vendor-pob/indexapprove','/os-vendor-pob/viewapprove','/os-vendor-pob/revise','/os-vendor-pob/reject','/os-vendor-pob/approve'),
		'os_vendor_pob_overview' => array('/os-vendor-pob/indexoverview','/os-vendor-pob/viewoverview','/os-vendor-pob/indexlog','/os-vendor-pob/viewlog','/os-vendor-pob/exportpdf', '/os-vendor-pob/exportpo'),

		// os - vendor pob detail
		'os_vendor_pob_detail_input' => array('/os-vendor-pob-detail/index','/os-vendor-pob-detail/view','/os-vendor-pob-detail/create','/os-vendor-pob-detail/update','/os-vendor-pob-detail/delete','/os-vendor-pob-detail/deletedetail'),
		'os_vendor_pob_detail_verifikasi' => array('/os-vendor-pob-detail/indexverify','/os-vendor-pob-detail/viewverify','/os-vendor-pob-detail/revise','/os-vendor-pob-detail/reject'),
		'os_vendor_pob_detail_approve' => array('/os-vendor-pob-detail/indexapprove','/os-vendor-pob-detail/viewapprove','/os-vendor-pob-detail/revise','/os-vendor-pob-detail/reject'),
		'os_vendor_pob_detail_overview' => array('/os-vendor-pob-detail/indexoverview','/os-vendor-pob-detail/viewoverview'),

		// os - vendor term sheet
		'os_vendor_term_sheet_input' => array('/os-vendor-term-sheet/index','/os-vendor-term-sheet/view','/os-vendor-term-sheet/create','/os-vendor-term-sheet/update','/os-vendor-term-sheet/delete','/os-vendor-term-sheet/viewosvendorregist','/os-vendor-term-sheet/updatepks'),
		'os_vendor_term_sheet_verifikasi' => array('/os-vendor-term-sheet/indexverify','/os-vendor-term-sheet/viewverify','/os-vendor-term-sheet/revise','/os-vendor-term-sheet/reject','/os-vendor-term-sheet/verify'),
		'os_vendor_term_sheet_approve' => array('/os-vendor-term-sheet/indexapprove','/os-vendor-term-sheet/viewapprove','/os-vendor-term-sheet/revise','/os-vendor-term-sheet/reject','/os-vendor-term-sheet/approve'),
		'os_vendor_term_sheet_overview' => array('/os-vendor-term-sheet/indexoverview','/os-vendor-term-sheet/viewoverview','/os-vendor-term-sheet/indexlog','/os-vendor-term-sheet/viewlog','/os-vendor-term-sheet/viewosvendorregist', '/os-vendor-term-sheet/exportpdf','/os-vendor-term-sheet/downloadfile'),

		// os - ga driver parameter
		'os_ga_driver_parameter_input' => array('/os-ga-driver-parameter/index','/os-ga-driver-parameter/view','/os-ga-driver-parameter/create','/os-ga-driver-parameter/update','/os-ga-driver-parameter/delete'),
		'os_ga_driver_parameter_verifikasi' => array('/os-ga-driver-parameter/indexverify','/os-ga-driver-parameter/viewverify','/os-ga-driver-parameter/revise','/os-ga-driver-parameter/reject'),
		'os_ga_driver_parameter_approve' => array('/os-ga-driver-parameter/indexapprove','/os-ga-driver-parameter/viewapprove','/os-ga-driver-parameter/revise','/os-ga-driver-parameter/reject','/os-ga-driver-parameter/approve'),
		'os_ga_driver_parameter_overview' => array('/os-ga-driver-parameter/indexoverview','/os-ga-driver-parameter/viewoverview'),

		//os - project parameter
		'os_vendor_project_parameter_input' => array('/os-vendor-project-parameter/index','/os-vendor-project-parameter/view','/os-vendor-project-parameter/create','/os-vendor-project-parameter/update','/os-vendor-project-parameter/delete'),
		'os_vendor_project_parameter_verifikasi' => array('/os-vendor-project-parameter/indexverify','/os-vendor-project-parameter/viewverify','/os-vendor-project-parameter/revise','/os-vendor-project-parameter/reject','/os-vendor-project-parameter/verify'),
		'os_vendor_project_parameter_approve' => array('/os-vendor-project-parameter/indexapprove','/os-vendor-project-parameter/viewapprove','/os-vendor-project-parameter/revise','/os-vendor-project-parameter/reject','/os-vendor-project-parameter/approve'),
		'os_vendor_project_parameter_overview' => array('/os-vendor-project-parameter/indexoverview','/os-vendor-project-parameter/viewoverview'),
//=================================================
				//----- os var declaration -----
		// cipro -  dashboard
		'corporate_dashboard_view' => array('/dashboard-corporate/index','/dashboard-corporate/map','/dashboard-corporate/get-dash-corporate'),

		// planning cipro basp
		'planning_ciproBASP_input' => array('/planning-cipro-bas-plan/index','/planning-cipro-bas-plan/view','/planning-cipro-bas-plan/create','/planning-cipro-bas-plan/update','/planning-cipro-bas-plan/delete','/planning-cipro-bas-plan/setting','/planning-cipro-bas-plan/submitsetting','/planning-cipro-bas-plan/viewbadistribution','/planning-cipro-bas-plan/exportpdf','/planning-cipro-bas-plan/downloadfile','/planning-cipro-bas-plan/viewcdm'),
		'planning_ciproBASP_verifikasi' => array('/planning-cipro-bas-plan/indexverify','/planning-cipro-bas-plan/viewverify','/planning-cipro-bas-plan/verify','/planning-cipro-bas-plan/revise','/planning-cipro-bas-plan/reject','/planning-cipro-bas-plan/deleteverify','/planning-cipro-bas-plan/exportpdf','/planning-cipro-bas-plan/downloadfile'),
		'planning_ciproBASP_approve' => array('/planning-cipro-bas-plan/indexapprove','/planning-cipro-bas-plan/viewapprove','/planning-cipro-bas-plan/approve','/planning-cipro-bas-plan/deleteapprove','/planning-cipro-bas-plan/exportpdf','/planning-cipro-bas-plan/downloadfile','/planning-cipro-bas-plan/revise','/planning-cipro-bas-plan/reject'),
		'planning_ciproBASP_input' => array('/planning-cipro-bas-plan/index','/planning-cipro-bas-plan/view','/planning-cipro-bas-plan/create','/planning-cipro-bas-plan/update','/planning-cipro-bas-plan/delete','/planning-cipro-bas-plan/setting','/planning-cipro-bas-plan/submitsetting','/planning-cipro-bas-plan/viewbadistribution','/planning-cipro-bas-plan/exportpdf','/planning-cipro-bas-plan/downloadfile','/planning-cipro-bas-plan/viewcdm'),
		'planning_ciproBASP_overview' => array('/planning-cipro-bas-plan/indexoverview','/planning-cipro-bas-plan/viewoverview','/planning-cipro-bas-plan/downloadfile','/planning-cipro-bas-plan/exportpdf','/planning-cipro-bas-plan/indexlog','/planning-cipro-bas-plan/viewlog','/planning-cipro-bas-plan/viewcdm','/map/getareaextent'),

		// planning cipro boqp
		'planning_ciproBOQP_input' => array('/planning-cipro-boq-p/index','/planning-cipro-boq-p/indexdetail','/planning-cipro-boq-p/view','/planning-cipro-boq-p/viewbasplan','/planning-cipro-boq-p/create','/planning-cipro-boq-p/update','/planning-cipro-boq-p/delete','/planning-cipro-boq-p/deletedetail','/planning-cipro-boq-p/createdetail','/planning-cipro-boq-p/updatedetail','/planning-cipro-boq-p/setting','/planning-cipro-boq-p/submitsetting','/planning-cipro-boq-p/viewbasplan','/planning-cipro-boq-p/uploaddetail','/planning-cipro-boq-p/unit','/planning-cipro-boq-p/exportpdf','/planning-cipro-boq-p/exportxls','/planning-cipro-boq-p/downloadfile','/planning-cipro-boq-p/cancel','/planning-cipro-boq-p/submit'),
		'planning_ciproBOQP_verifikasi' => array('/planning-cipro-boq-p/indexverify','/planning-cipro-boq-p/viewverify','/planning-cipro-boq-p/verify','/planning-cipro-boq-p/revise','/planning-cipro-boq-p/reject','/planning-cipro-boq-p/exportpdf','/planning-cipro-boq-p/exportxls','/planning-cipro-boq-p/downloadfile','/planning-cipro-boq-p/reviseverify','/planning-cipro-boq-p/rejectverify'),
		'planning_ciproBOQP_approve' => array('/planning-cipro-boq-p/indexapprove','/planning-cipro-boq-p/viewapprove','/planning-cipro-boq-p/approve','/planning-cipro-boq-p/exportpdf','/planning-cipro-boq-p/exportxls','/planning-cipro-boq-p/revise','/planning-cipro-boq-p/reviseapprove','/planning-cipro-boq-p/reject','/planning-cipro-boq-p/downloadfile','/planning-cipro-boq-p/rejectapprove'),
		'planning_ciproBOQP_overview' => array('/planning-cipro-boq-p/indexoverview','/planning-cipro-boq-p/viewoverview','/planning-cipro-boq-p/exportpdf','/planning-cipro-boq-p/exportxls','/planning-cipro-boq-p/downloadfile','/planning-cipro-boq-p/indexlog','/planning-cipro-boq-p/viewlog'),

		// cipro - executor decision
		'cipro_executor_view' => array('/cipro-planning-cipro-boq-p/indexexecutor','/cipro-planning-cipro-boq-p/indexinvitation','/cipro-planning-cipro-boq-p/update','/cipro-planning-cipro-boq-p/setting','/cipro-planning-cipro-boq-p/submitsetting','/cipro-planning-cipro-boq-p/view','/cipro-planning-cipro-boq-p/viewexecutor','/cipro-planning-cipro-boq-p/delete','/cipro-planning-cipro-boq-p/deletedetail','/cipro-planning-cipro-boq-p/exportpdf','/cipro-planning-cipro-boq-p/unit','/cipro-planning-cipro-boq-p/downloadfile','/cipro-planning-cipro-boq-p/exportxls'),

		// planning cipro boqb
		'planning_ciproBOQB_input' => array('/planning-cipro-boq-b/index','/planning-cipro-boq-b/view','/planning-cipro-boq-b/viewciprorfa','/planning-cipro-boq-b/viewpplciprobaut','/planning-cipro-boq-b/viewciprorfa','/planning-cipro-boq-b/create','/planning-cipro-boq-b/update','/planning-cipro-boq-b/delete','/planning-cipro-boq-b/updatedetail','/planning-cipro-boq-b/indexdetail','/planning-cipro-boq-b/createdetail','/planning-cipro-boq-b/deletedetail','/planning-cipro-boq-b/uploaddetail','/planning-cipro-boq-b/unit','/planning-cipro-boq-b/exportpdf','/planning-cipro-boq-b/submit','/planning-cipro-boq-b/cancel'),
		'planning_ciproBOQB_verifikasi' => array('/planning-cipro-boq-b/indexverify','/planning-cipro-boq-b/viewverify','/planning-cipro-boq-b/verify','/planning-cipro-boq-b/reviseverify','/planning-cipro-boq-b/rejectverify','/planning-cipro-boq-b/exportpdf'),
		'planning_ciproBOQB_approve' => array('/planning-cipro-boq-b/indexapprove','/planning-cipro-boq-b/viewapprove','/planning-cipro-boq-b/approve','/planning-cipro-boq-b/reviseverify','/planning-cipro-boq-b/rejectverify','/planning-cipro-boq-b/exportpdf','/planning-cipro-boq-b/downloadfile'),
		'planning_ciproBOQB_overview' => array('/planning-cipro-boq-b/indexoverview','/planning-cipro-boq-b/viewoverview','/planning-cipro-boq-b/viewciprorfaoverview','/planning-cipro-boq-b/viewpplciprobautoverview','/planning-cipro-boq-b/exportpdf','/planning-cipro-boq-b/downloadfile','/planning-cipro-boq-b/indexlog','/planning-cipro-boq-b/viewlog'),

		// inhouse - work order
		'cipro_wo_input_manageTeam' => array('/cipro-team/index','/cipro-team/indexmember','/cipro-team/view','/cipro-team/viewmember','/cipro-team/create','/cipro-team/createmember','/cipro-team/update','/cipro-team/updatemember','/cipro-team/delete','/cipro-team/deletemember'),
		'cipro_wo_input_workOrder' => array('/cipro-work-order/index','/cipro-work-order/view','/cipro-work-order/create','/cipro-work-order/update','/cipro-work-order/delete','/cipro-work-order/exportpdf','/cipro-work-order/getregion','/cipro-work-order/getcity','/cipro-work-order/getdistrict','/cipro-work-order/getsubdistrict'),
		'cipro_wo_input_ToolsNeeds' => array('/cipro-tools-wo/index','/cipro-tools-wo/indexwo','/cipro-tools-wo/view','/cipro-tools-wo/viewwo','/cipro-tools-wo/create','/cipro-tools-wo/update','/cipro-tools-wo/deletetools'),
		'cipro_wo_input_materialNeeds' => array('/cipro-material-wo/index','/cipro-material-wo/indexgrfinput','/cipro-material-wo/indexwo','/cipro-material-wo/indexwoactual','/cipro-material-wo/indexgrfdetail','/cipro-material-wo/view','/cipro-material-wo/viewwo','/cipro-material-wo/indexviewgrfinput','/cipro-material-wo/create','/cipro-material-wo/update','/cipro-material-wo/updategrf','/cipro-material-wo/deletematerial','/cipro-material-wo/submitgrf','/cipro-material-wo/exportpdf','/cipro-material-wo/uom'),
		'cipro_wo_input_transportNeeds' => array('/cipro-transport-wo/index','/cipro-transport-wo/indexwo','/cipro-transport-wo/indexwoactual','/cipro-transport-wo/view','/cipro-transport-wo/viewwo','/cipro-transport-wo/create','/cipro-transport-wo/update','/cipro-transport-wo/deletetransport','/cipro-transport-wo/deletedetail'),
		'cipro_wo_verifikasi' => array('/cipro-work-order/indexverify','/cipro-work-order/viewverify','/cipro-work-order/verify','/cipro-work-order/reviseverify','/cipro-work-order/rejectverify','/cipro-work-order/exportpdf'),
		'cipro_wo_approve' => array('/cipro-work-order/indexapprove','/cipro-work-order/viewapprove','/cipro-work-order/approve','/cipro-work-order/reviseapprove','/cipro-work-order/rejectapprove','/cipro-work-order/exportpdf'),
		'cipro_wo_listWO' => array('/cipro-work-order/indexoverview','/cipro-work-order/viewoverview','/cipro-work-order/indexlog','/cipro-work-order/viewlog','/cipro-work-order/exportxls'),

		// inhouse - wo - grf
		'cipro_grf_input' => array('/cipro-material-wo/indexgrfinput','/cipro-material-wo/indexgrfdetail','/cipro-material-wo/indexviewgrfinput','/cipro-material-wo/viewgrfinput','/cipro-material-wo/create','/cipro-material-wo/updategrf','/cipro-material-wo/delete','/cipro-material-wo/submitgrf','/cipro-material-wo/exportpdf'),
		'cipro_grf_verifikasi' => array('/cipro-material-wo/indexgrfverify','/cipro-material-wo/viewgrfverify','/cipro-material-wo/verifygrf','/cipro-material-wo/revisegrf','/cipro-material-wo/rejectgrf'),
		'cipro_grf_approve' => array('/cipro-material-wo/indexgrfapprove','/cipro-material-wo/viewgrfapprove','/cipro-material-wo/approvegrf','/cipro-material-wo/revisegrf','/cipro-material-wo/rejectgrf','/cipro-material-wo/exportpdf','/cipro-material-wo/exportxls'),


		// inhouse - problem
		'cipro_problem_input' => array('/cipro-problem/index','/cipro-problem/view','/cipro-problem/create','/cipro-problem/update','/cipro-problem/delete'),
		'cipro_problem_verifikasi' => array('/cipro-problem/indexverify','/cipro-problem/viewverify','/cipro-problem/verify','/cipro-problem/reviseverify','/cipro-problem/rejectverify'),
		'cipro_problem_approve' => array('/cipro-problem/indexapprove','/cipro-problem/viewapprove','/cipro-problem/approve','/cipro-problem/reviseapprove','/cipro-problem/rejectapprove'),
		'cipro_problem_overview' => array('/cipro-problem/indexoverview','/cipro-problem/viewoverview','/cipro-problem/indexlog','/cipro-problem/viewlog'),

		//  inhouse - work order actual
		'cipro_woActual_input_workOrder' => array('/cipro-wo-actual/index','/cipro-wo-actual/view','/cipro-wo-actual/viewworkorder','/cipro-wo-actual/create','/cipro-wo-actual/update','/cipro-wo-actual/delete','/cipro-wo-actual/exportpdf'),
		'cipro_woActual_input_report' => array('/cipro-team-wo-actual/indexwoactual','/cipro-team-wo-actual/index','/cipro-team-wo-actual/view','/cipro-team-wo-actual/viewwoactual','/cipro-team-wo-actual/create','/cipro-team-wo-actual/update','/cipro-team-wo-actual/delete','/cipro-team-wo-actual/deletedetail','/cipro-team-wo-actual/submitteam'),
		'cipro_woActual_input_ToolsUsage' => array('/cipro-tools-usage/indexwoactual','/cipro-tools-usage/index','/cipro-tools-usage/viewwoactual','/cipro-tools-usage/view','/cipro-tools-usage/create','/cipro-tools-usage/update','/cipro-tools-usage/delete','/cipro-tools-usage/submittools'),
		'cipro_woActual_input_materialUsage' => array('/cipro-material-usage/indexwoactual','/cipro-material-usage/index','/cipro-material-usage/viewwoactual','/cipro-material-usage/view','/cipro-material-usage/create','/cipro-material-usage/update','/cipro-material-usage/delete','/cipro-material-usage/submitmaterial'),
		'cipro_woActual_input_transportUsage' => array('/cipro-transport-usage/indexwoactual','/cipro-transport-usage/index','/cipro-transport-usage/viewwoactual','/cipro-transport-usage/view','/cipro-transport-usage/create','/cipro-transport-usage/update','/cipro-transport-usage/delete','/cipro-transport-usage/submittransport','/cipro-transport-usage/deletedetail'),
		'cipro_woActual_verifikasi' => array('/cipro-wo-actual/indexverify','/cipro-wo-actual/viewverify','/cipro-wo-actual/create','/cipro-wo-actual/update','/cipro-wo-actual/verify','/cipro-wo-actual/reviseverify','/cipro-wo-actual/rejectverify','/cipro-wo-actual/exportpdf'),
		'cipro_woActual_approve' => array('/cipro-wo-actual/indexapprove','/cipro-wo-actual/viewapprove','/cipro-wo-actual/create','/cipro-wo-actual/update','/cipro-wo-actual/approve','/cipro-wo-actual/reviseapprove','/cipro-wo-actual/rejectapprove','/cipro-wo-actual/exportpdf'),
		'cipro_woActual_overview' => array('/cipro-wo-actual/indexoverview','/cipro-wo-actual/viewoverview','/cipro-wo-actual/viewworkorderoverview','cipro-bas-implementation/downloadfile','/cipro-bas-implementation/viewbasplan','/cipro-wo-actual/indexwolog','/cipro-wo-actual/viewlog'),

		// cipro inhouse - rfr
		'cipro_rfr_view' => array('/cipro-rfa/indexrfr','/cipro-rfa/viewrfr','/cipro-rfa/downloadfile'),

		// cipro inhouse - rfa
		'cipro_rfa_input' => array('/cipro-rfa/index','/cipro-rfa/view','/cipro-rfa/create','/cipro-rfa/update','/cipro-rfa/delete','/cipro-rfa/viewboqp','/cipro-rfa/uploadexcel'),
		'cipro_rfa_verifikasi' => array('/cipro-rfa/indexverify','/cipro-rfa/viewverify','/cipro-rfa/verify','/cipro-rfa/reviseverify','/cipro-rfa/rejectverify','/cipro-rfa/downloadfile'),
		'cipro_rfa_approve' => array('/cipro-rfa/indexapprove','/cipro-rfa/viewapprove','/cipro-rfa/approve','/cipro-rfa/reviseapprove','/cipro-rfa/rejectapprove','/cipro-rfa/downloadfile'),
		'cipro_rfa_overview' => array('/cipro-rfa/indexoverview','/cipro-rfa/viewoverview','/cipro-rfa/viewboqp','/cipro-rfa/indexlog','/cipro-rfa/viewlog'),

		// cipro vendor - Daily Report Vendor
		'cipro_dailyReportVendor_input' => array('/cipro-daily-report/uploadreport','/cipro-daily-report/index','/cipro-daily-report/view','/cipro-daily-report/create','/cipro-daily-report/update','/cipro-daily-report/delete','/cipro-daily-report/indexlog','/cipro-daily-report/viewlog', '/cipro-daily-report/downloadfile','/cipro-daily-report/getwodate'),
		'cipro_dailyReportVendor_view' => array('/cipro-daily-report/view','/cipro-daily-report/delete','/cipro-daily-report/index','/cipro-daily-report/update','/cipro-daily-report/indexlog','/cipro-daily-report/viewlog'),

		//cipro vendor - GRF Vendor
		'cipro_grfVendor_input' => array('/cipro-grf-vendor/index','/cipro-grf-vendor/viewinput','/cipro-grf-vendor/viewgrfvendor','/cipro-grf-vendor/create','/cipro-grf-vendor/createdetail','/cipro-grf-vendor/update','/cipro-grf-vendor/indexdetail','/cipro-grf-vendor/delete','/cipro-grf-vendor/deletedetail','/cipro-grf-vendor/getciproboqp','/cipro-grf-vendor/uploaddetail','/cipro-grf-vendor/submitgrf', '/cipro-grf-vendor/downloadfile', '/cipro-grf-vendor/backdate','/cipro-grf-vendor/uom'),
		'cipro_grfVendor_verifikasi' => array('/cipro-grf-vendor/indexverify','/cipro-grf-vendor/viewverify','/cipro-grf-vendor/verify','/cipro-grf-vendor/reviseverify','/cipro-grf-vendor/rejectverify','/cipro-grf-vendor/uom'),
		'cipro_grfVendor_approve' => array('/cipro-grf-vendor/indexapprove','/cipro-grf-vendor/viewapprove','/cipro-grf-vendor/approve','/cipro-grf-vendor/reviseapprove','/cipro-grf-vendor/rejectapprove','/cipro-grf-vendor/exportpdf','/cipro-grf-vendor/exportpdfusage','/cipro-grf-vendor/uom','/cipro-grf-vendor/exportxls'),
		'cipro_grfVendor_overview' => array('/cipro-grf-vendor/indexoverview','/cipro-grf-vendor/viewoverview','/cipro-grf-vendor/uploaddetail','/cipro-grf-vendor/exportpdf','/cipro-grf-vendor/indexlog','/cipro-grf-vendor/viewlog','/cipro-grf-vendor/uom','/map/getareaextent','/cipro-grf-vendor/exportxls'),

		// cipro vendor - material usage  vendor
		'cipro_materialUsageVendor_input' => array('/cipro-grf-vendor/indexusage','/cipro-grf-vendor/viewusageinput','/cipro-grf-vendor/viewgrfvendor','/cipro-grf-vendor/create','/cipro-grf-vendor/createdetail','/cipro-grf-vendor/update','/cipro-grf-vendor/updateusage','/cipro-grf-vendor/indexdetail','/cipro-grf-vendor/indexusagedetail','/cipro-grf-vendor/delete','/cipro-grf-vendor/deletedetail','/cipro-grf-vendor/getciproboqp','/cipro-grf-vendor/uploaddetail','/cipro-grf-vendor/exportpdf','/cipro-grf-vendor/exportpdfusage','/cipro-grf-vendor/submitgrf'),
		'cipro_materialUsageVendor_verifikasi' => array('/cipro-grf-vendor/indexusageverify','/cipro-grf-vendor/viewusageverify','/cipro-grf-vendor/create','/cipro-grf-vendor/update','/cipro-grf-vendor/deleteverify','/cipro-grf-vendor/verifyusage','/cipro-grf-vendor/reviseusageverify','/cipro-grf-vendor/rejectusageverify'),
		'cipro_materialUsageVendor_approve' => array('/cipro-grf-vendor/indexusageapprove','/cipro-grf-vendor/viewusageapprove','/cipro-grf-vendor/create','/cipro-grf-vendor/createdetail','/cipro-grf-vendor/updateusage','/cipro-grf-vendor/approveusage','/cipro-grf-vendor/reviseusageapprove','/cipro-grf-vendor/rejectusageapprove','/cipro-grf-vendor/deleteapprove'),
		'cipro_materialUsageVendor_overview' => array('/cipro-grf-vendor/indexusageoverview','/cipro-grf-vendor/viewusageoverview','/cipro-grf-vendor/downloadfile','/cipro-grf-vendor/indexusagelog','/cipro-grf-vendor/viewusagelog'),

		// ppl cipro atp
		'ppl_ciproATP_input' => array('/ppl-cipro-atp/create','/ppl-cipro-atp/index','/ppl-cipro-atp/view','/ppl-cipro-atp/create','/ppl-cipro-atp/update','/ppl-cipro-atp/delete','/ppl-cipro-atp/delete-atp','/ppl-cipro-atp/viewboqb','/ppl-cipro-atp/downloadfile','/ppl-cipro-atp/uploadexcel'),
		'ppl_ciproATP_verifikasi' => array('/ppl-cipro-atp/indexverify','/ppl-cipro-atp/viewverify','/ppl-cipro-atp/verify','/ppl-cipro-atp/rejectverify','/ppl-cipro-atp/revise','/ppl-cipro-atp/downloadfile','/ppl-cipro-atp/uploadexcel'),
		'ppl_ciproATP_approve' => array('/ppl-cipro-atp/indexapprove','/ppl-cipro-atp/viewapprove','/ppl-cipro-atp/approve','/ppl-cipro-atp/revise','/ppl-cipro-atp/rejectverify','/ppl-cipro-atp/exportpdf','/ppl-cipro-atp/downloadfile','/ppl-cipro-atp/uploadexcel'),
		'ppl_ciproATP_overview' => array('/ppl-cipro-atp/indexoverview','/ppl-cipro-atp/viewoverview','/ppl-cipro-atp/downloadfile','/ppl-cipro-atp/uploadexcel','/ppl-cipro-atp/indexlog','/ppl-cipro-atp/viewlog'),

		//ppl cipro schedule
		'ppl_ciproSchedule_input' => array('/ppl-cipro-atp/indexschedule','/ppl-cipro-atp/viewschedule','/ppl-cipro-atp/createschedule','/ppl-cipro-atp/updateschedule','/ppl-cipro-atp/indexinvitation','/ppl-cipro-atp/viewinvitation'),
		'ppl_ciproSchedule_overview' => array('/ppl-cipro-atp/indexoverviewschedule','/ppl-cipro-atp/viewoverviewschedule','/ppl-cipro-atp/indexschedulelog','/ppl-cipro-atp/viewboqblog','/ppl-cipro-atp/viewschedulelog','/ppl-cipro-atp/exportpdf'),

		// ppl cipro closing baut
		'ppl_ciproClosingBAUT_input' => array('/ppl-cipro-baut/index','/ppl-cipro-baut/view','/ppl-cipro-baut/create','/ppl-cipro-baut/update','/ppl-cipro-baut/delete','/ppl-cipro-baut/viewboqbf','/ppl-cipro-baut/viewatp','/ppl-cipro-baut/downloadfile'),
		'ppl_ciproClosingBAUT_verifikasi' => array('/ppl-cipro-baut/indexverify','/ppl-cipro-baut/viewverify','/ppl-cipro-baut/verify','/ppl-cipro-baut/reviseverify','/ppl-cipro-baut/rejectverify','/ppl-cipro-baut/downloadfile'),
		'ppl_ciproClosingBAUT_approve' => array('/ppl-cipro-baut/indexapprove','/ppl-cipro-baut/viewapprove','/ppl-cipro-baut/approve','/ppl-cipro-baut/reviseverify','/ppl-cipro-baut/rejectverify','/ppl-cipro-baut/downloadfile'),
		'ppl_ciproClosingBAUT_overview' => array('/ppl-cipro-baut/indexoverview','/ppl-cipro-baut/viewoverview','/ppl-cipro-baut/viewatpoverview','/ppl-cipro-baut/downloadfile','/ppl-cipro-baut/indexlog','/ppl-cipro-baut/viewatplog','/ppl-cipro-baut/viewlog','/ppl-cipro-baut/exportpdf'),

		// ppl cipro closing bast work
		'ppl_ciproClosingBASTWork_input' => array('/ppl-cipro-bast-work/index','/ppl-cipro-bast-work/view','/ppl-cipro-bast-work/create','/ppl-cipro-bast-work/update','/ppl-cipro-bast-work/delete','/ppl-cipro-bast-work/viewbaut','/ppl-cipro-bast-work/getdatefinish','/ppl-cipro-bast-work/downloadfile'),
		'ppl_ciproClosingBASTWork_verifikasi' => array('/ppl-cipro-bast-work/indexverify','/ppl-cipro-bast-work/viewverify','/ppl-cipro-bast-work/verify','/ppl-cipro-bast-work/reviseverify','/ppl-cipro-bast-work/rejectverify','/ppl-cipro-bast-work/downloadfile'),
		'ppl_ciproClosingBASTWork_approve' => array('/ppl-cipro-bast-work/indexapprove','/ppl-cipro-bast-work/viewapprove','/ppl-cipro-bast-work/approve','/ppl-cipro-bast-work/reviseverify','/ppl-cipro-bast-work/rejectverify','/ppl-cipro-bast-work/downloadfile'),
		'ppl_ciproClosingBASTWork_overview' => array('/ppl-cipro-bast-work/indexoverview','/ppl-cipro-bast-work/viewoverview','/ppl-cipro-bast-work/viewbautoverview','/ppl-cipro-bast-work/downloadfile','/ppl-cipro-bast-work/indexlog','/ppl-cipro-bast-work/viewlog','/ppl-cipro-bast-work/exportpdf'),

		// ppl cipro closing bast retention
		'ppl_ciproClosingBASTRetention_input' => array('/ppl-cipro-bast-retention/index','/ppl-cipro-bast-retention/view','/ppl-cipro-bast-retention/create','/ppl-cipro-bast-retention/update','/ppl-cipro-bast-retention/delete','/ppl-cipro-bast-retention/viewbastwork','/ppl-cipro-bast-retention/downloadfile'),
		'ppl_ciproClosingBASTRetention_verifikasi' => array('/ppl-cipro-bast-retention/indexverify','/ppl-cipro-bast-retention/viewverify','/ppl-cipro-bast-retention/verify','/ppl-cipro-bast-retention/reviseverify','/ppl-cipro-bast-retention/rejectverify','/ppl-cipro-bast-retention/downloadfile'),
		'ppl_ciproClosingBASTRetention_approve' => array('/ppl-cipro-bast-retention/indexapprove','/ppl-cipro-bast-retention/viewapprove','/ppl-cipro-bast-retention/approve','/ppl-cipro-bast-retention/reviseverify','/ppl-cipro-bast-retention/rejectverify','/ppl-cipro-bast-retention/downloadfile'),
		'ppl_ciproClosingBASTRetention_overview' => array('/ppl-cipro-bast-retention/indexoverview','/ppl-cipro-bast-retention/viewoverview','/ppl-cipro-bast-retention/viewbastworkoverview','/ppl-cipro-bast-retention/downloadfile','/ppl-cipro-bast-retention/indexlog','/ppl-cipro-bast-retention/viewlog','/ppl-cipro-bast-retention/exportpdf'),


		// busdev_baSurvey
		'busdev_baSurvey_input' => array('/busdev-ba-survey/index','/busdev-ba-survey/view','/busdev-ba-survey/create','/busdev-ba-survey/update','/busdev-ba-survey/delete','/busdev-ba-survey/createpolygon','/map/getareaextent','/busdev-ba-survey/downloadfile'),
		'busdev_baSurvey_verifikasi' => array('/busdev-ba-survey/indexverify','/busdev-ba-survey/viewverify','/busdev-ba-survey/verify','/busdev-ba-survey/reviseverify','/busdev-ba-survey/revise','/busdev-ba-survey/rejectverify','/busdev-ba-survey/reject','/map/getareaextent','/busdev-ba-survey/downloadfile'),
		'busdev_baSurvey_approve' => array('/busdev-ba-survey/indexapprove','/busdev-ba-survey/viewapprove','/busdev-ba-survey/approve','/busdev-ba-survey/reviseapprove','/busdev-ba-survey/revise','/busdev-ba-survey/rejectapprove','/busdev-ba-survey/reject','/map/getareaextent','/busdev-ba-survey/downloadfile'),
		'busdev_baSurvey_overview' => array('/busdev-ba-survey/indexoverview','/busdev-ba-survey/viewoverview','/busdev-ba-survey/indexlog','/busdev-ba-survey/viewlog','/map/getareaextent','/busdev-ba-survey/downloadfile','/busdev-ba-survey/exportpdf'),

		// busdev_pks
		'busdev_pks_input' => array('/busdev-pks/downloadfile','/busdev-pks/index','/busdev-pks/view','/busdev-pks/create','/busdev-pks/update','/busdev-pks/delete','/busdev-pks/rejectpnl', '/busdev-pks/viewpnl'),
		'busdev_pks_verifikasi' => array('/busdev-pks/downloadfile','/busdev-pks/indexverify','/busdev-pks/viewverify','/busdev-pks/verify','/busdev-pks/revise','/busdev-pks/reject','/busdev-pks/rejectverify','/busdev-pks/reviseverify'),
		'busdev_pks_approve' => array('/busdev-pks/downloadfile','/busdev-pks/indexapprove','/busdev-pks/viewapprove','/busdev-pks/approve','/busdev-pks/revise','/busdev-pks/reject','/busdev-pks/rejectapprove','/busdev-pks/reviseapprove'),
		'busdev_pks_overview' => array('/busdev-pks/downloadfile','/busdev-pks/indexoverview','/busdev-pks/viewoverview','/busdev-pks/indexlog','/busdev-pks/viewlog','/busdev-pks/exportpdf'),

		// cdm_baso
		'cdm_baso_input' => array('/cdm-baso/index','/cdm-baso/view','/cdm-baso/create','/cdm-baso/update','/cdm-baso/delete','/cdm-baso/viewbaut','/busdev-pks/viewpnl'),
		'cdm_baso_verifikasi' => array('/cdm-baso/indexverify','/cdm-baso/viewverify','/cdm-baso/verify','/cdm-baso/revise','/cdm-baso/reject','/cdm-baso/rejectverify','/cdm-baso/reviseverify'),
		'cdm_baso_approve' => array('/cdm-baso/indexapprove','/cdm-baso/viewapprove','/cdm-baso/approve','/cdm-baso/revise','/cdm-baso/reject','/cdm-baso/rejectapprove','/cdm-baso/reviseapprove'),
		'cdm_baso_overview' => array('/cdm-baso/indexoverview','/cdm-baso/viewoverview','/cdm-baso/indexlog','/cdm-baso/viewlog','/cdm-baso/downloadfile','/cdm-baso/exportpdf'),

		// cdm_pnl
		'cdm_pnl_input' => array('/cdm-pnl/index','/cdm-pnl/view','/cdm-pnl/create','/cdm-pnl/update','/cdm-pnl/delete','/cdm-pnl/viewboqp','/cdm-pnl/downloadfile','/cdm-pnl/exportpdf'),
		'cdm_pnl_verifikasi' => array('/cdm-pnl/indexverify','/cdm-pnl/viewverify','/cdm-pnl/verify','/cdm-pnl/reviseverify','/cdm-pnl/rejectverify','/cdm-pnl/downloadfile'),
		'cdm_pnl_approve' => array('/cdm-pnl/indexapprove','/cdm-pnl/viewapprove','/cdm-pnl/approve','/cdm-pnl/reviseapprove','/cdm-pnl/rejectapprove','/cdm-pnl/downloadfile'),
		'cdm_pnl_overview' => array('/cdm-pnl/indexoverview','/cdm-pnl/viewoverview','/cdm-pnl/indexlog','/cdm-pnl/viewlog','/cdm-pnl/viewboqp','/cdm-pnl/downloadfile'),

		// cdm_woSurvey
		'cdm_woSurvey_input' => array('/cdm-wo-survey/index','/cdm-wo-survey/view','/cdm-wo-survey/create','/cdm-wo-survey/update','/cdm-wo-survey/delete','/cdm-wo-survey/viewbusdevbasurvey','/cdm-wo-survey/downloadfile'),
		'cdm_woSurvey_verifikasi' => array('/cdm-wo-survey/indexverify','/cdm-wo-survey/viewverify','/cdm-wo-survey/verify','/cdm-wo-survey/revise','/cdm-wo-survey/reject','/cdm-wo-survey/rejectverify','/cdm-wo-survey/reviseverify','/cdm-wo-survey/downloadfile'),
		'cdm_woSurvey_approve' => array('/cdm-wo-survey/indexapprove','/cdm-wo-survey/viewapprove','/cdm-wo-survey/approve','/cdm-wo-survey/revise','/cdm-wo-survey/reject','/cdm-wo-survey/rejectapprove','/cdm-wo-survey/reviseapprove','/cdm-wo-survey/downloadfile'),
		'cdm_woSurvey_overview' => array('/cdm-wo-survey/indexoverview','/cdm-wo-survey/viewoverview','/cdm-wo-survey/indexlog','/cdm-wo-survey/viewlog','/cdm-wo-survey/viewbusdevbasurvey','/cdm-wo-survey/downloadfile','/map/getareaextent','/cdm-wo-survey/exportpdf'),

		// cdm_woRollout
		'cdm_woRollout_input' => array('/cdm-wo-rollout/index','/cdm-wo-rollout/view','/cdm-wo-rollout/create','/cdm-wo-rollout/update','/cdm-wo-rollout/delete','/cdm-wo-rollout/downloadfile','/cdm-wo-rollout/viewboqp'),
		'cdm_woRollout_verifikasi' => array('/cdm-wo-rollout/indexverify','/cdm-wo-rollout/viewverify','/cdm-wo-rollout/verify','/cdm-wo-rollout/revise','/cdm-wo-rollout/reject','/cdm-wo-rollout/rejectverify','/cdm-wo-rollout/reviseverify','/cdm-wo-rollout/downloadfile'),
		'cdm_woRollout_approve' => array('/cdm-wo-rollout/indexapprove','/cdm-wo-rollout/viewapprove','/cdm-wo-rollout/approve','/cdm-wo-rollout/revise','/cdm-wo-rollout/reject','/cdm-wo-rollout/rejectapprove','/cdm-wo-rollout/reviseapprove','/cdm-wo-rollout/downloadfile'),
		'cdm_woRollout_overview' => array('/cdm-wo-rollout/indexoverview','/cdm-wo-rollout/viewoverview','/cdm-wo-rollout/indexlog','/cdm-wo-rollout/viewlog','/cdm-wo-rollout/downloadfile','/cdm-wo-rollout/exportpdf'),

		// govrel_ciproProblem
		'govrel_ciproProblem_input' => array('/govrel-cipro-problem/index','/govrel-cipro-problem/view','/govrel-cipro-problem/create','/govrel-cipro-problem/update','/govrel-cipro-problem/delete'),

		'govrel_ciproProblem_verifikasi' => array('/govrel-cipro-problem/indexverify','/govrel-cipro-problem/viewverify','/govrel-cipro-problem/verify','/govrel-cipro-problem/revise','/govrel-cipro-problem/reject'),

		'govrel_ciproProblem_approve' => array('/govrel-cipro-problem/indexapprove','/govrel-cipro-problem/viewapprove','/govrel-cipro-problem/approve','/govrel-cipro-problem/revise','/govrel-cipro-problem/reject'),

		'govrel_ciproProblem_overview' => array('/govrel-cipro-problem/indexoverview','/govrel-cipro-problem/viewoverview','/govrel-cipro-problem/indexlog','/govrel-cipro-problem/viewlog','/govrel-cipro-problem/viewtask'),

		// govrel_baCorporate
		'govrel_baCorporate_input' => array('/govrel-ba-coorporate/repermit','/govrel-ba-coorporate/index','/govrel-ba-coorporate/view','/govrel-ba-coorporate/create','/govrel-ba-coorporate/update','/govrel-ba-coorporate/delete','/govrel-ba-coorporate/uploadexcel', '/govrel-ba-coorporate/downloadfile', '/govrel-ba-coorporate/exportpdf','/govrel-ba-coorporate/viewplanning'),
		'govrel_baCorporate_verifikasi' => array('/govrel-ba-coorporate/indexverify','/govrel-ba-coorporate/viewverify','/govrel-ba-coorporate/verify','/govrel-ba-coorporate/reviseverify','/govrel-ba-coorporate/rejectverify','/govrel-ba-coorporate/downloadfile','/govrel-ba-coorporate/exportpdf','/govrel-ba-coorporate/viewplanning'),
		'govrel_baCorporate_approve' => array('/govrel-ba-coorporate/indexapprove','/govrel-ba-coorporate/viewapprove','/govrel-ba-coorporate/approve','/govrel-ba-coorporate/reviseapprove','/govrel-ba-coorporate/rejectapprove','/govrel-ba-coorporate/downloadfile','/govrel-ba-coorporate/exportpdf','/govrel-ba-coorporate/viewplanning'),
		'govrel_baCorporate_overview' => array('/govrel-ba-coorporate/indexoverview','/govrel-ba-coorporate/viewoverview','/govrel-ba-coorporate/indexlog','/govrel-ba-coorporate/viewlog','/govrel-ba-coorporate/downloadfile','/govrel-ba-coorporate/viewplanning'),


		//----- ap var declaration -----
		// ap - dashboard
		'ap_dashboard_view' => array('/dashboard-ap/index','/dashboard-ap/get-dash-chart-ap'),

		// Ap finance_invoice
		'finace_invoice_input' => array('/finance-invoice/index','/finance-invoice/view','/finance-invoice/create','/finance-invoice/createrr','/finance-invoice/createdoc','/finance-invoice/createbast','/finance-invoice/update','/finance-invoice/delete','/finance-invoice/downloadfile','/finance-invoice/indexrr','/finance-invoice/indexdoc','/finance-invoice/viewrr','/finance-invoice/getpobnominal','/finance-invoice/getbast','/finance-invoice/getlaborposition'),
		'finace_invoice_verifikasi' => array('/finance-invoice/indexverify','/finance-invoice/viewverify','/finance-invoice/verify','/finance-invoice/revise','/finance-invoice/reject','/finance-invoice/downloadfile'),
		'finace_invoice_approve' => array('/finance-invoice/indexapprove','/finance-invoice/viewapprove','/finance-invoice/approve','/finance-invoice/revise','/finance-invoice/reject','/finance-invoice/downloadfile','/finance-invoice/downloadfile'),
		'finace_invoice_overview' => array('/finance-invoice/indexoverview','/finance-invoice/viewoverview','/finance-invoice/downloadfile','/finance-invoice/indexlog','/finance-invoice/viewlog'),

		//Ap document_verification
		'finace_invoice_document_verification' => array('/finance-invoice/indexdocverify','/finance-invoice/viewdocverify','/finance-invoice/downloadfile','/finance-invoice/verifydoc'),

		// Ap finance_costing_osp
		'finace_costing_osp_input' => array('/finance-costing/indexosp','/finance-costing/viewosp','/finance-costing/create','/finance-costing/update','/finance-costing/delete','/finance-costing/downloadfile'),

		// Ap finance_costing_cipro
		'finace_costing_cipro_input' => array('/finance-costing/indexcipro','/finance-costing/viewcipro','/finance-costing/create','/finance-costing/update','/finance-costing/delete','/finance-costing/downloadfile'),

		// Ap finance_costing_ospm
		'finace_costing_ospm_input' => array('/finance-costing/indexospm','/finance-costing/viewospm','/finance-costing/create','/finance-costing/update','/finance-costing/delete','/finance-costing/downloadfile'),

		// Ap finance_costing_netpro
		'finace_costing_netpro_input' => array('/finance-costing/indexnetpro','/finance-costing/viewnetpro','/finance-costing/create','/finance-costing/update','/finance-costing/delete','/finance-costing/downloadfile'),

		// Ap finance_costing_homepass
		'finace_costing_homepass_input' => array('/finance-costing/indexhomepass','/finance-costing/viewhomepass','/finance-costing/create','/finance-costing/update','/finance-costing/delete','/finance-costing/downloadfile'),

		// Ap finance_invoice_document_approval
		'finace_invoice_document_approval_input' => array('/finance-invoice/indexdocapprove','/finance-invoice/viewdocapprove','/finance-invoice/create','/finance-invoice/update','/finance-invoice/delete','/finance-invoice/downloadfile'),

		// Ap finance_report
		'finace_report_input' => array('/finance-report/indexreport','/finance-report/view','/finance-report/create','/finance-report/update','/finance-report/delete','/finance-report/downloadfile'),

		// Ap finance_project_progress_iko
		'finace_project_progress_iko_input' => array('/finance-project-progress/indexiko','/finance-project-progress/viewiko','/finance-project-progress/create','/finance-project-progress/update','/finance-project-progress/delete','/finance-project-progress/downloadfile'),

		// Ap finance_project_progress_osp
		'finace_project_progress_osp_input' => array('/finance-project-progress/indexosp','/finance-project-progress/viewosp','/finance-project-progress/create','/finance-project-progress/update','/finance-project-progress/delete','/finance-project-progress/downloadfile'),

	);

    public $array, $parent;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAuthItem();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSave_array(array $array, $parent)
    {
        $child = $this->array;
        $parent_child = $this->parent;
        $datetime = new Expression('NOW()');
        $model = new AuthItem();
        $model_access = new AuthItemChild();
        foreach ($array as $index => $data )
        {
            $model_access = new AuthItemChild();
            $model = new AuthItem();
            $model_access->parent = $parent;
            $model_access->child = $data;
            $model_access->save();


        }
       // $query = (AuthItem::find()->where(['name'=>$model->role])->exists());
        foreach ($array as $index => $data )
        {
            $model = new AuthItem();
            $query = (AuthItem::find()->where(['name'=>$data])->exists());

            if(empty($query))
            {
                $cek = TRUE;
            }else{
                $cek = FALSE;
            }
            if($cek==TRUE){
                 $model->name = $data;
                $model->type = 1;
                //$model->created_at = $datetime;

                $model->save();

            }

        }


        $model->name = $parent;
        return $this->redirect(['view', 'id' => $model->name]);

    }



    public function actionCreate()
    {
        $model = new AuthItem();

		$model->type = 1;

        if ($model->load(Yii::$app->request->post()) ) {

            $newModel = new AuthItem();
            $newModel->name = $model->name;
            $newModel->type = 1;
            if($newModel->save()) {
				$arrNewChilds = [];
				foreach ($this->arrAccessMap as $k => $v) {
					if($model[$k] == 1) {
						foreach((array) $this->arrAccessMap[$k] as $value) {
							$arrNewChilds[$value] = 1;

						}
					}
				}

				foreach ($arrNewChilds as $k => $v) {
					$newModelChild = new AuthItemChild();
					$newModelChild->parent = $model->name;
					$newModelChild->child = $k;

					if(!$newModelChild->save()) return print_r($newModelChild->getErrors());
				}
                return $this->redirect(['index']);

            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

			AuthItemChild::deleteAll('parent = :parent', [':parent' => $model->name ]);
			$arrNewChilds = [];
			foreach ($this->arrAccessMap as $k => $v) {
				if($model[$k] == 1) {
					foreach((array) $this->arrAccessMap[$k] as $value) {
						$arrNewChilds[$value] = 1;

					}
				}
			}

			foreach ($arrNewChilds as $k => $v) {
				$newModelChild = new AuthItemChild();
				$newModelChild->parent = $model->name;
				$newModelChild->child = $k;

				if(!$newModelChild->save()) return print_r($newModelChild->getErrors());
			}

			return $this->redirect(['index']);

        } else {
            foreach ($this->arrAccessMap as $k => $v) {
				if (AuthItemChild::find()->where(['and', ['parent' => $model->name], ['child'=>$v[0]]])->exists()){
					$model[$k] = 1;
				}
			}

            return $this->render('update', [
                'model' => $model

            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
