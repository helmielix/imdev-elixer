<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $access;
    public  $um_create, // User management
			$um_role,
			$um_users,
			$um_branch_setting,
			$um_labor_setting,
			$um_email_parameter_setting,
			$um_manage_warehouse,

			$govrel_dashboard_view, // Dashboard

			$govrel_ic_input, //internal coordination
            $govrel_ic_verifikasi,
            $govrel_ic_approve,
            $govrel_ic_overview,
			$govrel_ic_historical,

            $govrel_bfp_input, //backbone feeder permit
            $govrel_bfp_verifikasi,
            $govrel_bfp_approve,
            $govrel_bfp_overview,
			$govrel_bfp_historical,

            $govrel_bg_input, //bank guarantee
            $govrel_bg_verifikasi,
            $govrel_bg_approve,
            $govrel_bg_overview,
			$govrel_bg_historical,

            $govrel_olt_input, //olt placement
            $govrel_olt_verifikasi,
            $govrel_olt_approve,
            $govrel_olt_overview,
			$govrel_olt_historical,

			$govrel_badRoll_input,  // berita acara distribution rollout
			$govrel_badRoll_verifikasi,
			$govrel_badRoll_approve,
			$govrel_badRoll_overview,
			$govrel_badRoll_historical,

            $govrel_problem_iko_input, //problem iko
            $govrel_problem_iko_verifikasi,
            $govrel_problem_iko_approve,
            $govrel_problem_iko_overview,

            $govrel_problem_osp_input, //problem osp
            $govrel_problem_osp_verifikasi,
            $govrel_problem_osp_approve,
            $govrel_problem_osp_overview,

            $govrel_parameter_bfp_input, //PIC Backbone feeder
            $govrel_parameter_bfp_approve,
			$govrel_parameter_bfp_overview,
			$govrel_parameter_bfp_verifikasi,

            $govrel_parameter_problem_input,
            $govrel_parameter_problem_approve,
            $govrel_parameter_problem_overview,
            $govrel_parameter_problem_verifikasi,

            $govrel_parameter_bank_input,

            $govrel_parameter_reminder_input,

			$govrel_caBAS_view, // govrel ca ba survey
//======================================================================================================
			$ca_dashboard_view, // Dashboard

			$ca_manageCity_input, // Manage City
			$ca_manageCity_verifikasi,
			$ca_manageCity_approve,
			$ca_manageCity_overview,

			$ca_preBas_input, // Manage Area - pre bas
			$ca_preBas_verifikasi,
			$ca_preBas_approve,
			$ca_preBas_overview,

			$ca_bas_input, // Manage area - bas
			$ca_bas_verifikasi,
			$ca_bas_approve,

			$ca_availableToRollout_input, // Manage Area - Available To Roll out
			$ca_availableToRollout_verifikasi,
			$ca_availableToRollout_approve,

			$ca_basOverview_overview,  // Manage Area - BAS Overview

			$ca_hpOverview_overview,   // Manage Area - HP Overview

			$ca_areaSetting_region, // Area Setting
			$ca_areaSetting_city,
			$ca_areaSetting_district,
			$ca_areaSetting_subdistrict,

			$ca_parameterSet_setting,  // Parameter Setting

//======================================================================================================
			$iko_dashboard_view, // iko - dashboard

			$iko_iomrollout_view, // iko - iom rollout

			$iko_executor_view, // iko - executor decision

			$iko_itpMonthly_input, // inhouse - monthly
			$iko_itpMonthly_verifikasi,
			$iko_itpMonthly_approve,
			$iko_itpMonthly_overview,

			$iko_itpWeekly_input, // inhouse - weekly
			$iko_itpWeekly_verifikasi,
			$iko_itpWeekly_approve,
			$iko_itpWeekly_overview,

			$iko_itpDaily_form,  // inhouse - daily
			$iko_itpDaily_spcReq,
			$iko_itpDaily_verifikasi,
			$iko_itpDaily_approve,
			$iko_itpDaily_overview,

			$iko_wo_input_manageTeam, // inhouse - work order
			$iko_wo_input_workOrder,
			$iko_wo_input_ToolsNeeds,
			$iko_wo_input_materialNeeds,
			$iko_wo_input_transportNeeds,
			$iko_wo_verifikasi,
			$iko_wo_approve,
			$iko_wo_listWO,

			$iko_grf_input, // inhouse - wo - grf
			$iko_grf_verifikasi,
			$iko_grf_approve,

			$iko_problem_input, // inhouse - problem
			$iko_problem_verifikasi,
			$iko_problem_approve,
			$iko_problem_overview,

			$iko_woActual_input_workOrder,  //  inhouse - work order actual
			$iko_woActual_input_report,
			$iko_woActual_input_ToolsUsage,
			$iko_woActual_input_materialUsage,
			$iko_woActual_input_transportUsage,
			$iko_woActual_verifikasi,
			$iko_woActual_approve,
			$iko_woActual_overview,

			$iko_rfr_view,   // inhouse - rfr

			$iko_rfa_input,   // inhouse - rfa
			$iko_rfa_verifikasi,
			$iko_rfa_approve,
			$iko_rfa_overview,

			$iko_dailyReportVendor_input, // vendor - Daily Report Vendor
			$iko_dailyReportVendor_view,


			$iko_grfVendor_input,  // Vendor - GRF Vendor
			$iko_grfVendor_verifikasi,
			$iko_grfVendor_approve,
			$iko_grfVendor_overview,

			$iko_materialUsageVendor_input, // vendor - material usage  vendor
			$iko_materialUsageVendor_verifikasi,
			$iko_materialUsageVendor_approve,
			$iko_materialUsageVendor_overview,

//======================================================================================================
			$osp_dashboard_view,    // osp dashboard

			$osp_readyToCoordination_input, // osp ready to coordination
			$osp_readyToCoordination_verifikasi,
			$osp_readyToCoordination_approve,
			$osp_readyToCoordination_overview,

            $osp_itp_report_input,  // overall itp report

			$osp_readyToRollOut_view, // ready to roll out

			$osp_wo_manageTeam, //Rollout Process - workorder
			$osp_wo_input_workOrder,
			$osp_wo_input_toolsNeeds,
			$osp_wo_input_materialNeeds,
			$osp_wo_input_transport,
			$osp_wo_verifikasi_workOrder,
			$osp_wo_approve_workOrder,
			$osp_wo_listWo,

			$osp_wo_grf_input, // Rollout Process - wo - grf
			$osp_wo_grf_verifikasi,
			$osp_wo_grf_approve,
			$osp_wo_grf_overview,

			$osp_problem_input, // Rollout Process - problem
			$osp_problem_verifikasi,
			$osp_problem_approve,
			$osp_problem_overview,

			$osp_woActual_input_workOrder, //Rollout Process - Workorder Actual
			$osp_woActual_teamReport,
			$osp_woActual_inputToolsUsage,
			$osp_woActual_inputMaterialUsage,
			$osp_woActual_inputTransportUsage,
			$osp_woActual_verifikasi,
			$osp_woActual_approve,
			$osp_woActual_overview,

			$osp_rfr_view, // Rollout process - RFR

			$osp_rfa_input,   // Rollout Process - RFA
			$osp_rfa_verifikasi,
			$osp_rfa_approve,
			$osp_rfa_overview,

			$osp_itpReportVendor_view, // ITP Report Vendor

			$osp_readyToRollOutVendor_view, // Ready To Rollout Vendor

			$osp_reportVendor_report,// vendor - Daily Report

			$osp_grfVendor_input, // Vendor - GRF Vendor
			$osp_grfVendor_verifikasi,
			$osp_grfVendor_approve,
			$osp_grfVendor_overview,

			$osp_materialUsageVendor_input, // Vendor - Material Usage Vendor
			$osp_materialUsageVendor_verifikasi,
			$osp_materialUsageVendor_approve,
			$osp_materialUsageVendor_overview,

			$osp_VendorRFR_view, // Vendor - RFR

			$osp_VendorRFA_input, // Vendor - RFA
			$osp_VendorRFA_verifikasi,
			$osp_VendorRFA_approve,
			$osp_VendorRFA_overview,

			$osp_manageOLT_input, // Manage OLT
			$osp_manageOLT_verifikasi,
			$osp_manageOLT_approve,
			$osp_manageOLT_overview,
//======================================================================================================
			$planning_dashboard_view,   // dashboard

			$planning_ikoBASP_input, // iko basp
			$planning_ikoBASP_verifikasi,
			$planning_ikoBASP_approve,
			$planning_ikoBASP_overview,

			$planning_ikoBOQP_input, // iko boqp
			$planning_ikoBOQP_verifikasi,
			$planning_ikoBOQP_approve,
			$planning_ikoBOQP_overview,

			$planning_ikoBOQB_input, // iko boqb
			$planning_ikoBOQB_verifikasi,
			$planning_ikoBOQB_approve,
			$planning_ikoBOQB_overview,

			$planning_caPresurvey_view, // ca presurvey overview

			$planning_ospBASP_input, // osp basp
			$planning_ospBASP_verifikasi,
			$planning_ospBASP_approve,
			$planning_ospBASP_overview,

			$planning_ospBOQP_input, // osp boqp
			$planning_ospBOQP_verifikasi,
			$planning_ospBOQP_approve,
			$planning_ospBOQP_overview,

			$planning_ospBOQB_input, // osp boqb
			$planning_ospBOQB_verifikasi,
			$planning_ospBOQB_approve,
			$planning_ospBOQB_overview,

			$planning_manageOLT_input,  //osp manage olt
			$planning_manageOLT_verifikasi,
			$planning_manageOLT_approve,
			$planning_manageOLT_overview,
//======================================================================================================
			$ppl_dashboard_view, // ppl dashboard

			$ppl_schedule_input,  // ppl iko schedule
			$ppl_schedule_overview,

			$ppl_ikoATP_input,   // iko atp
			$ppl_ikoATP_verifikasi,
			$ppl_ikoATP_approve,
			$ppl_ikoATP_overview,

			$ppl_ospSchedule_input,  // ppl osp schedule
			$ppl_ospSchedule_overview,

			$ppl_ospATP_input, // osp atp
			$ppl_ospATP_verifikasi,
			$ppl_ospATP_approve,
			$ppl_ospATP_overview,

			$ppl_ikoClosingBAUT_input, //iko closing baut
			$ppl_ikoClosingBAUT_verifikasi,
			$ppl_ikoClosingBAUT_approve,
			$ppl_ikoClosingBAUT_overview,

			$ppl_ikoClosingBAST_input, //iko closing bast
			$ppl_ikoClosingBAST_verifikasi,
			$ppl_ikoClosingBAST_approve,
			$ppl_ikoClosingBAST_overview,

			$ppl_ikoClosingBASTRetention_input, // iko closing bast retention
			$ppl_ikoClosingBASTRetention_verifikasi,
			$ppl_ikoClosingBASTRetention_approve,
			$ppl_ikoClosingBASTRetention_overview,

			$ppl_ospClosingBAUT_input,  //ppl osp closing baut
			$ppl_ospClosingBAUT_verifikasi,
			$ppl_ospClosingBAUT_approve,
			$ppl_ospClosingBAUT_overview,

			$ppl_ospClosingBASTWork_input, // ppl - osp closing bast work
			$ppl_ospClosingBASTWork_verifikasi,
			$ppl_ospClosingBASTWork_approve,
			$ppl_ospClosingBASTWork_overview,

			$ppl_ospClosingBASTRetention_input, //ppl - osp closing bast retention
			$ppl_ospClosingBASTRetention_verifikasi,
			$ppl_ospClosingBASTRetention_approve,
			$ppl_ospClosingBASTRetention_overview,

			// ppl invitation
			$ppl_iko_invited,
			$ppl_osp_invited,
			$ppl_ikr_invited,
			$ppl_pc_invited,
			$ppl_ospm_invited,
			$ppl_cdm_invited,
			$ppl_cipro_invited,
			$ppl_busdev_invited,
			$ppl_planning_corp_invited,
			$ppl_pc_corp_invited,


//======================================================================================================
			$netpro_dashboard_view, // netpro - dashboard

			$netpro_problem_input, //netpro - problem
			$netpro_problem_verifikasi,
			$netpro_problem_approve,
			$netpro_problem_overview,

			$netpro_sr_input, //netpro - service report
			$netpro_sr_verifikasi,
			$netpro_sr_approve,
			$netpro_sr_overview,

			$netpro_ba_input, //netpro - ba
			$netpro_ba_verifikasi,
			$netpro_ba_approve,
			$netpro_ba_overview,

			$netpro_wo_input, //netpro - workorder
			$netpro_wo_verifikasi,
			$netpro_wo_approve,
			$netpro_wo_overview,

			$netpro_grfv_input, //netpro - grf
			$netpro_grfv_verifikasi,
			$netpro_grfv_approve,
			$netpro_grfv_overview,

            $netpro_mu_input, //netpro - grf usage
            $netpro_mu_verifikasi,
            $netpro_mu_approve,
            $netpro_mu_overview,

            $netpro_grf_bs_input, //netpro - grf bs
            $netpro_grf_bs_verifikasi,
            $netpro_grf_bs_approve,
            $netpro_grf_bs_overview,

			$netpro_mu_bs_input, //netpro - grf usage bs
			$netpro_mu_bs_verifikasi,
			$netpro_mu_bs_approve,
			$netpro_mu_bs_overview,

			$netpro_lsb_view, // List Stock Buffer
//======================================================================================================
			$ospm_dashboard_view, // ospm - dashboard

			$ospm_grf_input, // ospm - grf
			$ospm_grf_verifikasi,
			$ospm_grf_approve,
			$ospm_grf_overview,

            $ospm_mu_input, //ospm - grf usage
            $ospm_mu_verifikasi,
            $ospm_mu_approve,
            $ospm_mu_overview,

            $ospm_grf_bs_input, //ospm - grf bs
            $ospm_grf_bs_verifikasi,
            $ospm_grf_bs_approve,
            $ospm_grf_bs_overview,

            $ospm_mu_bs_input, //ospm - grf usage bs
			$ospm_mu_bs_verifikasi,
			$ospm_mu_bs_approve,
			$ospm_mu_bs_overview,
			
			$ospm_grf_bs_input_vendor, //ospm - grf bs
            $ospm_grf_bs_verifikasi_vendor,
            $ospm_grf_bs_approve_vendor,
            $ospm_grf_bs_overview_vendor,

            $ospm_mu_bs_input_vendor, //ospm - grf usage bs
			$ospm_mu_bs_verifikasi_vendor,
			$ospm_mu_bs_approve_vendor,
			$ospm_mu_bs_overview_vendor,

			$ospm_obstacle_input, // ospm - obstacle
			$ospm_obstacle_verifikasi,
			$ospm_obstacle_approve,
			$ospm_obstacle_overview,

			$ospm_tt_input, // ospm - ticket trouble
			$ospm_tt_verifikasi,
			$ospm_tt_approve,
			$ospm_tt_overview,

			$ospm_list_stock_buffer_input, // ospm - list stock buffer
			
			$ospm_list_stock_buffer_input_vendor, // ospm - list stock buffer vendor



			// $ap_finance_invoice_input,// ap - invoice
			// $ap_finance_invoice_verifikasi,
			// $ap_finance_invoice_approve,
			// $ap_finance_invoice_overview,

   //          $ap_finance_invoice_doc_verify,
   //          $ap_finance_invoice_doc_approve,

			// $ap_finance_rfp_input, // ap - rfp
			// $ap_finance_rfp_verifikasi,
			// $ap_finance_rfp_approve,
			// $ap_finance_rfp_overview,
//======================================================================================================
			$os_dashboard_view, // os -  dashboard

			$os_outsource_input, // os - outsource parameter
			$os_outsource_verifikasi,
			$os_outsource_approve,
			$os_outsource_overview,

			$os_personil_input, // os - outsource personil
			$os_personil_verifikasi,
			$os_personil_approve,
			$os_personil_overview,

			$os_salary_input, // os - outsource salary
			$os_salary_verifikasi,
			$os_salary_approve,
			$os_salary_overview,

            $os_ga_biaya_jalan_input, // os - ga biaya jalan
            $os_ga_biaya_jalan_verifikasi,
            $os_ga_biaya_jalan_approve,
            $os_ga_biaya_jalan_overview,

            $os_ga_biaya_jalan_iko_input, // os - ga biaya jalan IKO
            $os_ga_biaya_jalan_iko_verifikasi,
            $os_ga_biaya_jalan_iko_approve,
            $os_ga_biaya_jalan_iko_overview,

            $os_ga_biaya_jalan_osp_input, // os - ga biaya jalan OSP
            $os_ga_biaya_jalan_osp_verifikasi,
            $os_ga_biaya_jalan_osp_approve,
            $os_ga_biaya_jalan_osp_overview,

            $os_ga_vehicle_iko_input, // os - ga vehicle iko
            $os_ga_vehicle_iko_verifikasi,
            $os_ga_vehicle_iko_approve,
            $os_ga_vehicle_iko_overview,
            $os_ga_vehicle_iko_listwo,

            $os_ga_vehicle_osp_input, // os - ga vehicle osp
            $os_ga_vehicle_osp_verifikasi,
            $os_ga_vehicle_osp_approve,
            $os_ga_vehicle_osp_overview,
            $os_ga_vehicle_osp_listwo,

            $os_ga_vehicle_parameter_input, // os - ga vehilce parameter
            $os_ga_vehicle_parameter_verifikasi,
            $os_ga_vehicle_parameter_approve,
            $os_ga_vehicle_parameter_overview,

            $os_vendor_regist_vendor_input, // os - vendor regist vendor
            $os_vendor_regist_vendor_verifikasi,
            $os_vendor_regist_vendor_approve,
            $os_vendor_regist_vendor_overview,

            $os_vendor_pob_input, // os - vendor spk
            $os_vendor_pob_verifikasi,
            $os_vendor_pob_approve,
            $os_vendor_pob_overview,

            $os_vendor_pob_detail_input, // os - vendor spk detail
            $os_vendor_pob_detail_verifikasi,
            $os_vendor_pob_detail_approve,
            $os_vendor_pob_detail_overview,

            $os_vendor_term_sheet_input, // os - vendor term sheet
            $os_vendor_term_sheet_verifikasi,
            $os_vendor_term_sheet_approve,
            $os_vendor_term_sheet_overview,

            $os_ga_driver_parameter_input, // os - ga driver parameter
            $os_ga_driver_parameter_verifikasi,
            $os_ga_driver_parameter_approve,
            $os_ga_driver_parameter_overview,

			$os_vendor_project_parameter_input, // os - ga vendor project param
            $os_vendor_project_parameter_verifikasi,
            $os_vendor_project_parameter_approve,
            $os_vendor_project_parameter_overview,
 //============================================================
            $corporate_dashboard_view,   // dashboard

			$planning_ciproBASP_input, // cipro basp
			$planning_ciproBASP_verifikasi,
			$planning_ciproBASP_approve,
			$planning_ciproBASP_overview,

			$planning_ciproBOQP_input, // cipro boqp
			$planning_ciproBOQP_verifikasi,
			$planning_ciproBOQP_approve,
			$planning_ciproBOQP_overview,

			$planning_ciproBOQB_input, // cipro boqb
			$planning_ciproBOQB_verifikasi,
			$planning_ciproBOQB_approve,
			$planning_ciproBOQB_overview,

			//$ppl_schedule_input,  // ppl cipro schedule
			//$ppl_schedule_overview,

			$ppl_ciproATP_input, // cipro atp
			$ppl_ciproATP_verifikasi,
			$ppl_ciproATP_approve,
			$ppl_ciproATP_overview,

			$ppl_ciproClosingBAUT_input, //cipro closing baut
			$ppl_ciproClosingBAUT_verifikasi,
			$ppl_ciproClosingBAUT_approve,
			$ppl_ciproClosingBAUT_overview,

			$ppl_ciproClosingBASTWork_input, //cipro closing bast
			$ppl_ciproClosingBASTWork_verifikasi,
			$ppl_ciproClosingBASTWork_approve,
			$ppl_ciproClosingBASTWork_overview,

			$ppl_ciproClosingBASTRetention_input, // cipro closing bast retention
			$ppl_ciproClosingBASTRetention_verifikasi,
			$ppl_ciproClosingBASTRetention_approve,
			$ppl_ciproClosingBASTRetention_overview,

			$cipro_executor_view, // cipro - executor decision

			$cipro_wo_input_manageTeam, // inhouse - work order
			$cipro_wo_input_workOrder,
			$cipro_wo_input_ToolsNeeds,
			$cipro_wo_input_materialNeeds,
			$cipro_wo_input_transportNeeds,
			$cipro_wo_verifikasi,
			$cipro_wo_approve,
			$cipro_wo_listWO,

			$cipro_grf_input, // inhouse - wo - grf
			$cipro_grf_verifikasi,
			$cipro_grf_approve,

			$cipro_problem_input, // inhouse - problem
			$cipro_problem_verifikasi,
			$cipro_problem_approve,
			$cipro_problem_overview,

			$cipro_woActual_input_workOrder,  //  inhouse - work order actual
			$cipro_woActual_input_report,
			$cipro_woActual_input_ToolsUsage,
			$cipro_woActual_input_materialUsage,
			$cipro_woActual_input_transportUsage,
			$cipro_woActual_verifikasi,
			$cipro_woActual_approve,
			$cipro_woActual_overview,

			$cipro_rfr_view,   // inhouse - rfr

			$cipro_rfa_input,   // inhouse - rfa
			$cipro_rfa_verifikasi,
			$cipro_rfa_approve,
			$cipro_rfa_overview,

			$cipro_dailyReportVendor_input, // vendor - Daily Report Vendor
			$cipro_dailyReportVendor_view,

            $ppl_ciproSchedule_input,
            $ppl_ciproSchedule_overview,



			$cipro_grfVendor_input,  // Vendor - GRF Vendor
			$cipro_grfVendor_verifikasi,
			$cipro_grfVendor_approve,
			$cipro_grfVendor_overview,

			$cipro_materialUsageVendor_input, // vendor - material usage  vendor
			$cipro_materialUsageVendor_verifikasi,
			$cipro_materialUsageVendor_approve,
			$cipro_materialUsageVendor_overview,

			$busdev_baSurvey_input, // busdev - ba survey
			$busdev_baSurvey_verifikasi,
			$busdev_baSurvey_approve,
			$busdev_baSurvey_overview,

			$busdev_pks_input, //busdev - pks
			$busdev_pks_verifikasi,
			$busdev_pks_approve,
			$busdev_pks_overview,

			$cdm_baso_input, // cdm - baso
			$cdm_baso_verifikasi,
			$cdm_baso_approve,
			$cdm_baso_overview,

			$cdm_pnl_input, // cdm -pnl
			$cdm_pnl_verifikasi,
			$cdm_pnl_approve,
			$cdm_pnl_overview,

			$cdm_woRollout_input, // cdm - wo rollout
			$cdm_woRollout_verifikasi,
			$cdm_woRollout_approve,
			$cdm_woRollout_overview,

			$cdm_woSurvey_input, // cdm - wo survey
			$cdm_woSurvey_verifikasi,
			$cdm_woSurvey_approve,
			$cdm_woSurvey_overview,

			$govrel_baCorporate_input, // govrel - ba corporate
			$govrel_baCorporate_verifikasi,
			$govrel_baCorporate_approve,
			$govrel_baCorporate_overview,

			$govrel_ciproProblem_input, // govrel - cipro problem
			$govrel_ciproProblem_verifikasi,
			$govrel_ciproProblem_approve,
			$govrel_ciproProblem_overview,

			//======================================================================================================
			$ap_dashboard_view, // ap - dashboard
			$finace_invoice_input, // finance_invoice
			$finace_invoice_verifikasi,
			$finace_invoice_approve,
			$finace_invoice_overview,

			$finace_invoice_document_verification,

			
			$finace_costing_osp_input, // Ap finance_costing_osp

			$finace_costing_cipro_input, // Ap finance_costing_cipro

			$finace_costing_ospm_input, // Ap finance_costing_ospm

			$finace_costing_netpro_input, // Ap finance_costing_nepro

			$finace_costing_homepass_input, // Ap finance_costing_homepass


			$finace_invoice_document_approval_input, // Ap finance_invoice_document_approval


			$finace_report_input, //finance_report


			$finace_project_progress_iko_input, // Ap finance_project_progress_iko
			
			$finace_project_progress_osp_input; // Ap finance_project_progress_osp

//==================================ap==================





    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data', 'access',


			'um_create', // User management
			'um_role',
			'um_users',
			'um_branch_setting',
			'um_labor_setting',
			'um_email_parameter_setting',
			'um_manage_warehouse',

			'govrel_dashboard_view', // Dashboard

			'govrel_ic_input', //internal coordination
            'govrel_ic_verifikasi',
            'govrel_ic_approve',
            'govrel_ic_overview',
			'govrel_ic_historical',

            'govrel_bfp_input', //backbone feeder permit
            'govrel_bfp_verifikasi',
            'govrel_bfp_approve',
            'govrel_bfp_overview',
			'govrel_bfp_historical',

            'govrel_bg_input', //bank guarantee
            'govrel_bg_verifikasi',
            'govrel_bg_approve',
            'govrel_bg_overview',
			'govrel_bg_historical',

            'govrel_olt_input', //olt placement
            'govrel_olt_verifikasi',
            'govrel_olt_approve',
            'govrel_olt_overview',
			'govrel_olt_historical',

			'govrel_badRoll_input',  // berita acara distribution rollout
			'govrel_badRoll_verifikasi',
			'govrel_badRoll_approve',
			'govrel_badRoll_overview',
			'govrel_badRoll_historical',

            'govrel_problem_iko_input', //problem iko
            'govrel_problem_iko_verifikasi',
            'govrel_problem_iko_approve',
            'govrel_problem_iko_overview',

            'govrel_problem_osp_input', //problem osp
            'govrel_problem_osp_verifikasi',
            'govrel_problem_osp_approve',
            'govrel_problem_osp_overview',

            'govrel_parameter_bfp_input',
            'govrel_parameter_bfp_approve',
			'govrel_parameter_bfp_overview',
			'govrel_parameter_bfp_verifikasi',

            'govrel_parameter_problem_input',
            'govrel_parameter_problem_approve',
            'govrel_parameter_problem_overview',
            'govrel_parameter_problem_verifikasi',

            'govrel_parameter_bank_input',

            'govrel_parameter_reminder_input',

			'govrel_caBAS_view', // govrel ca ba survey
//======================================================================================================
			'ca_dashboard_view', // Dashboard

			'ca_manageCity_input', // Manage City
			'ca_manageCity_verifikasi',
			'ca_manageCity_approve',
			'ca_manageCity_overview',

			'ca_preBas_input', // Manage Area - pre bas
			'ca_preBas_verifikasi',
			'ca_preBas_approve',
			'ca_preBas_overview',

			'ca_bas_input', // Manage area - bas
			'ca_bas_verifikasi',
			'ca_bas_approve',

			'ca_availableToRollout_input', // Manage Area - Available To Roll out
			'ca_availableToRollout_verifikasi',
			'ca_availableToRollout_approve',

			'ca_basOverview_overview',  // Manage Area - BAS Overview

			'ca_hpOverview_overview',   // Manage Area - HP Overview

			'ca_areaSetting_region', // Area Setting
			'ca_areaSetting_city',
			'ca_areaSetting_district',
			'ca_areaSetting_subdistrict',

			'ca_parameterSet_setting',  // Parameter Setting



//======================================================================================================
			'iko_dashboard_view', // iko - dashboard

			'iko_iomrollout_view', // iko - iom rollout

			'iko_executor_view', // iko - executor decision

			'iko_itpMonthly_input', // inhouse - monthly
			'iko_itpMonthly_verifikasi',
			'iko_itpMonthly_approve',
			'iko_itpMonthly_overview',

			'iko_itpWeekly_input', // inhouse - weekly
			'iko_itpWeekly_verifikasi',
			'iko_itpWeekly_approve',
			'iko_itpWeekly_overview',

			'iko_itpDaily_form',  // inhouse - daily
			'iko_itpDaily_spcReq',
			'iko_itpDaily_verifikasi',
			'iko_itpDaily_approve',
			'iko_itpDaily_overview',

			'iko_wo_input_manageTeam', // inhouse - work order
			'iko_wo_input_workOrder',
			'iko_wo_input_ToolsNeeds',
			'iko_wo_input_materialNeeds',
			'iko_wo_input_transportNeeds',
			'iko_wo_verifikasi',
			'iko_wo_approve',
			'iko_wo_listWO',

			'iko_grf_input', // inhouse - wo - grf
			'iko_grf_verifikasi',
			'iko_grf_approve',
			'osp_wo_grf_overview',

			'iko_problem_input', // inhouse - problem
			'iko_problem_verifikasi',
			'iko_problem_approve',
			'iko_problem_overview',

			'iko_woActual_input_workOrder',  //  inhouse - work order actual
			'iko_woActual_input_report',
			'iko_woActual_input_ToolsUsage',
			'iko_woActual_input_materialUsage',
			'iko_woActual_input_transportUsage',
			'iko_woActual_verifikasi',
			'iko_woActual_approve',
			'iko_woActual_overview',

			'iko_rfr_view', // inhouse - rfr

			'iko_rfa_input',   // inhouse - rfa
			'iko_rfa_verifikasi',
			'iko_rfa_approve',
			'iko_rfa_overview',

			'iko_dailyReportVendor_input', // vendor - Daily Report Vendor
			'iko_dailyReportVendor_view',

			'iko_grfVendor_input',  // Vendor - GRF Vendor
			'iko_grfVendor_verifikasi',
			'iko_grfVendor_approve',
			'iko_grfVendor_overview',

			'iko_materialUsageVendor_input', // vendor - material usage  vendor
			'iko_materialUsageVendor_verifikasi',
			'iko_materialUsageVendor_approve',
			'iko_materialUsageVendor_overview',

//======================================================================================================
			'osp_dashboard_view',  // dashboard

			'osp_readyToCoordination_input', // osp ready to coordination
			'osp_readyToCoordination_verifikasi',
			'osp_readyToCoordination_approve',
			'osp_readyToCoordination_overview',

			'osp_itp_report_input',  // itp report

			'osp_readyToRollOut_view', // ready to roll out

			'osp_wo_manageTeam', //Rollout Process Process-wo
			'osp_wo_input_workOrder',
			'osp_wo_input_toolsNeeds',
			'osp_wo_input_materialNeeds',
			'osp_wo_input_transport',
			'osp_wo_verifikasi_workOrder',
			'osp_wo_approve_workOrder',
			'osp_wo_listWo',

			'osp_wo_grf_input', // Rollout Process-wo-grf
			'osp_wo_grf_verifikasi',
			'osp_wo_grf_approve',

			'osp_problem_input', // Rollout Process - problem
			'osp_problem_verifikasi',
			'osp_problem_approve',
			'osp_problem_overview',

			'osp_woActual_input_workOrder', //Rollout Process - Workorder Actual
			'osp_woActual_teamReport',
			'osp_woActual_inputToolsUsage',
			'osp_woActual_inputMaterialUsage',
			'osp_woActual_inputTransportUsage',
			'osp_woActual_verifikasi',
			'osp_woActual_approve',
			'osp_woActual_overview',

			'osp_rfr_view', //Rollout Process - RFR

			'osp_rfa_input',   // Rollout Process - RFA
			'osp_rfa_verifikasi',
			'osp_rfa_approve',
			'osp_rfa_overview',

			'osp_itpReportVendor_view', // Vendor - ITP Report Vendor

			'osp_readyToRollOutVendor_view', // Vendor - Ready To Rollout Vendor

			'osp_reportVendor_report',// vendor - Daily Report

            'osp_grfVendor_input', // Vendor - GRF Vendor
			'osp_grfVendor_verifikasi',
			'osp_grfVendor_approve',
			'osp_grfVendor_overview',

			'osp_materialUsageVendor_input', // Vendor - Material Usage Vendor
			'osp_materialUsageVendor_verifikasi',
			'osp_materialUsageVendor_approve',
			'osp_materialUsageVendor_overview',

			'osp_VendorRFR_view', // Vendor - RFR

			'osp_VendorRFA_input', // Vendor - RFA
			'osp_VendorRFA_verifikasi',
			'osp_VendorRFA_approve',
			'osp_VendorRFA_overview',

			'osp_manageOLT_input', // Manage OLT
			'osp_manageOLT_verifikasi',
			'osp_manageOLT_approve',
			'osp_manageOLT_overview',
//======================================================================================================
			'planning_dashboard_view',   // dashboard

			'planning_ikoBASP_input', // iko basp
			'planning_ikoBASP_verifikasi',
			'planning_ikoBASP_approve',
			'planning_ikoBASP_overview',

			'planning_ikoBOQP_input', // iko boqp
			'planning_ikoBOQP_verifikasi',
			'planning_ikoBOQP_approve',
			'planning_ikoBOQP_overview',

			'planning_ikoBOQB_input', // iko boqb
			'planning_ikoBOQB_verifikasi',
			'planning_ikoBOQB_approve',
			'planning_ikoBOQB_overview',

			'planning_caPresurvey_view', //ca presurvey overview

			'planning_ospBASP_input', // osp basp
			'planning_ospBASP_verifikasi',
			'planning_ospBASP_approve',
			'planning_ospBASP_overview',

			'planning_ospBOQP_input', // osp boqp
			'planning_ospBOQP_verifikasi',
			'planning_ospBOQP_approve',
			'planning_ospBOQP_overview',

			'planning_ospBOQB_input', // osp boqb
			'planning_ospBOQB_verifikasi',
			'planning_ospBOQB_approve',
			'planning_ospBOQB_overview',

			'planning_manageOLT_input',  //osp manage olt
			'planning_manageOLT_verifikasi',
			'planning_manageOLT_approve',
			'planning_manageOLT_overview',

//======================================================================================================
			'ppl_dashboard_view', // ppl dashboard

			'ppl_schedule_input',  // ppl IKO schedule
			'ppl_schedule_overview',

			'ppl_ikoATP_input',   // iko atp
			'ppl_ikoATP_verifikasi',
			'ppl_ikoATP_approve',
			'ppl_ikoATP_overview',

			'ppl_ospSchedule_input',  // ppl OSP schedule
			'ppl_ospSchedule_overview',

			'ppl_ospATP_input', // osp atp
			'ppl_ospATP_verifikasi',
			'ppl_ospATP_approve',
			'ppl_ospATP_overview',

			'ppl_ikoClosingBAUT_input', //iko closing baut
			'ppl_ikoClosingBAUT_verifikasi',
			'ppl_ikoClosingBAUT_approve',
			'ppl_ikoClosingBAUT_overview',

			'ppl_ikoClosingBAST_input', //iko closing bast work
			'ppl_ikoClosingBAST_verifikasi',
			'ppl_ikoClosingBAST_approve',
			'ppl_ikoClosingBAST_overview',

			'ppl_ikoClosingBASTRetention_input', // iko closing bast retention
			'ppl_ikoClosingBASTRetention_verifikasi',
			'ppl_ikoClosingBASTRetention_approve',
			'ppl_ikoClosingBASTRetention_overview',

			'ppl_ospClosingBAUT_input',  //ppl osp closing baut
			'ppl_ospClosingBAUT_verifikasi',
			'ppl_ospClosingBAUT_approve',
			'ppl_ospClosingBAUT_overview',

			'ppl_ospClosingBASTWork_input', // ppl - osp closing bast work
			'ppl_ospClosingBASTWork_verifikasi',
			'ppl_ospClosingBASTWork_approve',
			'ppl_ospClosingBASTWork_overview',

			'ppl_ospClosingBASTRetention_input', //ppl - osp closing bast retention
			'ppl_ospClosingBASTRetention_verifikasi',
			'ppl_ospClosingBASTRetention_approve',
			'ppl_ospClosingBASTRetention_overview',

			// ppl invitation
			'ppl_iko_invited',
			'ppl_osp_invited',
			'ppl_ikr_invited',
			'ppl_pc_invited',
			'ppl_ospm_invited',
			'ppl_cdm_invited',
			'ppl_cipro_invited',
			'ppl_busdev_invited',
			'ppl_planning_corp_invited',
			'ppl_pc_corp_invited',


//======================================================================================================
			'netpro_dashboard_view', // netpro - dashboard

			'netpro_problem_input', //netpro - problem
			'netpro_problem_verifikasi',
			'netpro_problem_approve',
			'netpro_problem_overview',

			'netpro_sr_input', //netpro - service report
			'netpro_sr_verifikasi',
			'netpro_sr_approve',
			'netpro_sr_overview',

			'netpro_ba_input', //netpro - ba
			'netpro_ba_verifikasi',
			'netpro_ba_approve',
			'netpro_ba_overview',

			'netpro_wo_input', //netpro - workorder
			'netpro_wo_verifikasi',
			'netpro_wo_approve',
			'netpro_wo_overview',

			'netpro_grfv_input', //netpro - grf
			'netpro_grfv_verifikasi',
			'netpro_grfv_approve',
			'netpro_grfv_overview',

            'netpro_grf_bs_input', //netpro - grf bs
            'netpro_grf_bs_verifikasi',
            'netpro_grf_bs_approve',
            'netpro_grf_bs_overview',

			'netpro_mu_input', //netpro - grf usage
			'netpro_mu_verifikasi',
			'netpro_mu_approve',
			'netpro_mu_overview',

			'netpro_mu_bs_input', //netpro - grf usage bs
			'netpro_mu_bs_verifikasi',
			'netpro_mu_bs_approve',
			'netpro_mu_bs_overview',

			'netpro_lsb_view', // List Stock Buffer

//======================================================================================================
			'ospm_dashboard_view', // ospm - dashboard

			'ospm_grf_input', // ospm - grf
			'ospm_grf_verifikasi',
			'ospm_grf_approve',
			'ospm_grf_overview',

            'ospm_mu_input', //ospm - grf usage
            'ospm_mu_verifikasi',
            'ospm_mu_approve',
            'ospm_mu_overview',

            'ospm_grf_bs_input', //ospm - grf bs
            'ospm_grf_bs_verifikasi',
            'ospm_grf_bs_approve',
            'ospm_grf_bs_overview',

            'ospm_mu_bs_input', //ospm - grf usage bs
			'ospm_mu_bs_verifikasi',
			'ospm_mu_bs_approve',
			'ospm_mu_bs_overview',
			
			'ospm_grf_bs_input_vendor', //ospm - grf bs
            'ospm_grf_bs_verifikasi_vendor',
            'ospm_grf_bs_approve_vendor',
            'ospm_grf_bs_overview_vendor',

            'ospm_mu_bs_input_vendor', //ospm - grf usage bs
			'ospm_mu_bs_verifikasi_vendor',
			'ospm_mu_bs_approve_vendor',
			'ospm_mu_bs_overview_vendor',

			'ospm_obstacle_input', // ospm - obstacle
			'ospm_obstacle_verifikasi',
			'ospm_obstacle_approve',
			'ospm_obstacle_overview',

			'ospm_tt_input', // ospm - ticket trouble
			'ospm_tt_verifikasi',
			'ospm_tt_approve',
			'ospm_tt_overview',

			'ospm_list_stock_buffer_input', // ospm - list stock buffer
			
			'ospm_list_stock_buffer_input_vendor', // ospm - list stock buffer vendor
//======================================================================================================
			'ap_dashboard_view', // ap - dashboard

			'finace_invoice_input', // finance_invoice
			'finace_invoice_verifikasi',
			'finace_invoice_approve',
			'finace_invoice_overview',

			'finace_invoice_document_verification', 

			
			'finace_costing_osp_input', // Ap finance_costing_osp

			'finace_costing_cipro_input', // Ap finance_costing_cipro

			'finace_costing_ospm_input', // Ap finance_costing_ospm

			'finace_costing_netpro_input', // Ap finance_costing_nepro

			'finace_costing_homepass_input', // Ap finance_costing_homepass


			'finace_invoice_document_approval_input', // Ap finance_invoice_document_approval


			'finace_report_input', //finance_report
			

			'finace_project_progress_iko_input', // Ap finance_project_progress_iko
			
			'finace_project_progress_osp_input', // Ap finance_project_progress_osp
//======================================================================================================
			'os_dashboard_view', // os -  dashboard

			'os_outsource_input', // os - outsource parameter
			'os_outsource_verifikasi',
			'os_outsource_approve',
			'os_outsource_overview',

			'os_personil_input', // os - outsource personil
			'os_personil_verifikasi',
			'os_personil_approve',
			'os_personil_overview',

			'os_salary_input', // os - outsource salary
			'os_salary_verifikasi',
			'os_salary_approve',
			'os_salary_overview',

            'os_ga_biaya_jalan_input', // os - ga biaya jalan
            'os_ga_biaya_jalan_verifikasi',
            'os_ga_biaya_jalan_approve',
            'os_ga_biaya_jalan_overview',

            'os_ga_biaya_jalan_iko_input', // os - ga biaya jalan IKO
            'os_ga_biaya_jalan_iko_verifikasi',
            'os_ga_biaya_jalan_iko_approve',
            'os_ga_biaya_jalan_iko_overview',

            'os_ga_biaya_jalan_osp_input', // os - ga biaya jalan OSP
            'os_ga_biaya_jalan_osp_verifikasi',
            'os_ga_biaya_jalan_osp_approve',
            'os_ga_biaya_jalan_osp_overview',

            'os_ga_vehicle_iko_input', // os - ga vehicle iko
            'os_ga_vehicle_iko_verifikasi',
            'os_ga_vehicle_iko_approve',
            'os_ga_vehicle_iko_overview',
            'os_ga_vehicle_iko_listwo',

            'os_ga_vehicle_osp_input', // os - ga vehicle osp
            'os_ga_vehicle_osp_verifikasi',
            'os_ga_vehicle_osp_approve',
            'os_ga_vehicle_osp_overview',
            'os_ga_vehicle_osp_listwo',

            'os_ga_vehicle_parameter_input', // os - ga vehilce parameter
            'os_ga_vehicle_parameter_verifikasi',
            'os_ga_vehicle_parameter_approve',
            'os_ga_vehicle_parameter_overview',

            'os_vendor_regist_vendor_input', // os - vendor regist vendor
            'os_vendor_regist_vendor_verifikasi',
            'os_vendor_regist_vendor_approve',
            'os_vendor_regist_vendor_overview',

            'os_vendor_pob_input', // os - vendor spk
            'os_vendor_pob_verifikasi',
            'os_vendor_pob_approve',
            'os_vendor_pob_overview',

            'os_vendor_pob_detail_input', // os - vendor spk detail
            'os_vendor_pob_detail_verifikasi',
            'os_vendor_pob_detail_approve',
            'os_vendor_pob_detail_overview',

            'os_vendor_term_sheet_input', // os - vendor term sheet
            'os_vendor_term_sheet_verifikasi',
            'os_vendor_term_sheet_approve',
            'os_vendor_term_sheet_overview',

            'os_ga_driver_parameter_input', // os - ga driver parameter
            'os_ga_driver_parameter_verifikasi',
            'os_ga_driver_parameter_approve',
            'os_ga_driver_parameter_overview',

			'os_vendor_project_parameter_input', // os - ga project parameter
            'os_vendor_project_parameter_verifikasi',
            'os_vendor_project_parameter_approve',
            'os_vendor_project_parameter_overview',
  //-=========================================================================

            'corporate_dashboard_view',   // dashboard

			'planning_ciproBASP_input', // cipro basp
			'planning_ciproBASP_verifikasi',
			'planning_ciproBASP_approve',
			'planning_ciproBASP_overview',

			'planning_ciproBOQP_input', // cipro boqp
			'planning_ciproBOQP_verifikasi',
			'planning_ciproBOQP_approve',
			'planning_ciproBOQP_overview',

			'planning_ciproBOQB_input', // cipro boqb
			'planning_ciproBOQB_verifikasi',
			'planning_ciproBOQB_approve',
			'planning_ciproBOQB_overview',

			'cipro_executor_view', // cipro - executor decision

			'cipro_wo_input_manageTeam', // inhouse - work order
			'cipro_wo_input_workOrder',
			'cipro_wo_input_ToolsNeeds',
			'cipro_wo_input_materialNeeds',
			'cipro_wo_input_transportNeeds',
			'cipro_wo_verifikasi',
			'cipro_wo_approve',
			'cipro_wo_listWO',

			'cipro_grf_input', // inhouse - wo - grf
			'cipro_grf_verifikasi',
			'cipro_grf_approve',

			'cipro_problem_input', // inhouse - problem
			'cipro_problem_verifikasi',
			'cipro_problem_approve',
			'cipro_problem_overview',

			'cipro_woActual_input_workOrder',  //  inhouse - work order actual
			'cipro_woActual_input_report',
			'cipro_woActual_input_ToolsUsage',
			'cipro_woActual_input_materialUsage',
			'cipro_woActual_input_transportUsage',
			'cipro_woActual_verifikasi',
			'cipro_woActual_approve',
			'cipro_woActual_overview',

			'cipro_rfr_view',   // inhouse - rfr

			'cipro_rfa_input',   // inhouse - rfa
			'cipro_rfa_verifikasi',
			'cipro_rfa_approve',
			'cipro_rfa_overview',

			'cipro_dailyReportVendor_input', // vendor - Daily Report Vendor
			'cipro_dailyReportVendor_view',

            'ppl_ciproSchedule_input',
            'ppl_ciproSchedule_overview',

			'ppl_ciproClosingBAUT_input',  //ppl cipro closing baut
			'ppl_ciproClosingBAUT_verifikasi',
			'ppl_ciproClosingBAUT_approve',
			'ppl_ciproClosingBAUT_overview',

			'ppl_ciproClosingBASTWork_input', // ppl - cipro closing bast work
			'ppl_ciproClosingBASTWork_verifikasi',
			'ppl_ciproClosingBASTWork_approve',
			'ppl_ciproClosingBASTWork_overview',

			'ppl_ciproClosingBASTRetention_input', //ppl - cipro closing bast retention
			'ppl_ciproClosingBASTRetention_verifikasi',
			'ppl_ciproClosingBASTRetention_approve',
			'ppl_ciproClosingBASTRetention_overview',

			'ppl_ciproATP_input', // cipro atp
			'ppl_ciproATP_verifikasi',
			'ppl_ciproATP_approve',
			'ppl_ciproATP_overview',


			'cipro_grfVendor_input',  // Vendor - GRF Vendor
			'cipro_grfVendor_verifikasi',
			'cipro_grfVendor_approve',
			'cipro_grfVendor_overview',

			'cipro_materialUsageVendor_input', // vendor - material usage  vendor
			'cipro_materialUsageVendor_verifikasi',
			'cipro_materialUsageVendor_approve',
			'cipro_materialUsageVendor_overview',

			'busdev_baSurvey_input', // busdev - ba survey
			'busdev_baSurvey_verifikasi',
			'busdev_baSurvey_approve',
			'busdev_baSurvey_overview',

			'busdev_pks_input', //busdev -pks
			'busdev_pks_verifikasi',
			'busdev_pks_approve',
			'busdev_pks_overview',

			'cdm_baso_input', //cdm - basok
			'cdm_baso_verifikasi',
			'cdm_baso_approve',
			'cdm_baso_overview',

			'cdm_pnl_input', // cdm - pnl
			'cdm_pnl_verifikasi',
			'cdm_pnl_approve',
			'cdm_pnl_overview',

			'cdm_woRollout_input', //  cdm - wo rollout
			'cdm_woRollout_verifikasi',
			'cdm_woRollout_approve',
			'cdm_woRollout_overview',

			'cdm_woSurvey_input', // cdm - wo survey
			'cdm_woSurvey_verifikasi',
			'cdm_woSurvey_approve',
			'cdm_woSurvey_overview',

			'govrel_baCorporate_input', // govrel - ba corporate
			'govrel_baCorporate_verifikasi',
			'govrel_baCorporate_approve',
			'govrel_baCorporate_overview',

			'govrel_ciproProblem_input', // govrel - cipro problem
			'govrel_ciproProblem_verifikasi',
			'govrel_ciproProblem_approve',
			'govrel_ciproProblem_overview',

			// //--------ap-------
			// 'finance_invoice_input',  // finance_invoice
			// 'finance_invoice_verifikasi',
			// 'finance_invoice_approve',
			// 'finance_invoice_overview',

			// // 'ap_finance_report', // finance_report

			], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
           // [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'access' => 'Access',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    /**
     * @inheritdoc
     * @return AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemQuery(get_called_class());
    }
}
