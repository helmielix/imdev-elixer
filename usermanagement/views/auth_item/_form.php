<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">


    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-12">
			<h1>USER MANAGEMENT</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Menu User Management </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_create')->checkbox(['label' =>'Create User']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_role')->checkbox(['label' =>'Role']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_users')->checkbox(['label' =>'Users']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_branch_setting')->checkbox(['label' =>'Branch Setting']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_labor_setting')->checkbox(['label' =>'Labor Setting']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_email_parameter_setting')->checkbox(['label' =>'Email Parameter Setting']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'um_manage_warehouse')->checkbox(['label' =>'Manage Warehouse']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>GOVREL</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Dashboard </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_dashboard_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

    <div class="row">
        <div class="col-lg-12">
			<h4>Govrel Internal Coordination</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ic_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ic_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ic_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ic_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ic_historical')->checkbox(['label' =>'Historical']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Backbone Feeder Permit</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bfp_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bfp_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bfp_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bfp_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bfp_historical')->checkbox(['label' =>'Historical']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Work Guarantee</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bg_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bg_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bg_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bg_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_bg_historical')->checkbox(['label' =>'Historical ']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel OLT Placement</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_olt_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_olt_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_olt_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_olt_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_olt_historical')->checkbox(['label' =>'Historical']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel BA Distribution Rollout</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_badRoll_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_badRoll_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_badRoll_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_badRoll_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_badRoll_historical')->checkbox(['label' =>'Historical']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Problem IKO</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_iko_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_iko_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_iko_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_iko_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Problem OSP</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_osp_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_osp_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_osp_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_problem_osp_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Parameter PIC Backbone Feeder Permit</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_parameter_bfp_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_parameter_bfp_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Parameter PIC Problem</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_parameter_problem_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_parameter_problem_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Parameter Bank Publish</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_parameter_bank_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel Parameter Reminder</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_parameter_reminder_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel BA Survey</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_caBAS_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>


	<div class="row">
        <div class="col-lg-12">
			<h1>OSP</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSP Dashboard </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_dashboard_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSP Ready To Coordination </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_readyToCoordination_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_readyToCoordination_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_readyToCoordination_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_readyToCoordination_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - Overall ITP Report</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_itp_report_input')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - Ready to Roll Out</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_readyToRollOut_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>


	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - Work Order</h4>
		</div>
	</div>

	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_manageTeam')->checkbox(['label' =>'Manage Team']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_input_workOrder')->checkbox(['label' =>'Input Workorder']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_input_toolsNeeds')->checkbox(['label' =>'Input Tools Needs']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_input_materialNeeds')->checkbox(['label' =>'Input Material Needs']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>

	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_input_transport')->checkbox(['label' =>'Input Transport']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_verifikasi_workOrder')->checkbox(['label' =>'Verify Workorder']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_approve_workOrder')->checkbox(['label' =>'Approve Workorder']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_listWo')->checkbox(['label' =>'List WO']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - Workorder - GRF</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_grf_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_grf_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_grf_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_wo_grf_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>


	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - Problem</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_problem_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_problem_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_problem_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_problem_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - Workorder Actual</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_input_workOrder')->checkbox(['label' =>'Input Workorder']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_teamReport')->checkbox(['label' =>'Team Report']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_inputToolsUsage')->checkbox(['label' =>'Input Tools Usage']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_inputMaterialUsage')->checkbox(['label' =>'Input Material Usage']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_inputTransportUsage')->checkbox(['label' =>'Input Transport']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_woActual_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - RFR </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_rfr_view')->checkbox(['label' =>'View RFR']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Inhouse - RFA</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_rfa_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_rfa_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_rfa_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_rfa_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - Overall ITP Report</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_itpReportVendor_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - Ready to Roll Out</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_readyToRollOutVendor_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - Daily Report Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_reportVendor_report')->checkbox(['label' =>'Report']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - GRF Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_grfVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_grfVendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_grfVendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_grfVendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - Material Usage Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_materialUsageVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_materialUsageVendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_materialUsageVendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_materialUsageVendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - RFR </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_VendorRFR_view')->checkbox(['label' =>'View RFR']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Vendor - RFA</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_VendorRFA_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_VendorRFA_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_VendorRFA_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_VendorRFA_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>OSP Manage OLT</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_manageOLT_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_manageOLT_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_manageOLT_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'osp_manageOLT_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>


	<div class="row">
        <div class="col-lg-12">
			<h1>IKO</h1>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Dashboard</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_dashboard_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>IKO IOM Rollout</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_iomrollout_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Executor Decision</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_executor_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - ITP FORM - Monthly</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpMonthly_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpMonthly_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpMonthly_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpMonthly_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - ITP FORM - Weekly</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpWeekly_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpWeekly_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpWeekly_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpWeekly_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - ITP FORM - Daily</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpDaily_form')->checkbox(['label' =>'Form']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpDaily_spcReq')->checkbox(['label' =>'Spc. Request']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpDaily_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpDaily_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_itpDaily_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - Work Order</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'iko_wo_input_manageTeam')->checkbox(['label' =>'Input Manage Team']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_wo_input_workOrder')->checkbox(['label' =>'Input Work Order']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_wo_input_ToolsNeeds')->checkbox(['label' =>'Input Tools Needs']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_wo_input_materialNeeds')->checkbox(['label' =>'Input Material Needs']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'iko_wo_input_transportNeeds')->checkbox(['label' =>'Input Transport Needs ']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_wo_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_wo_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_wo_listWO')->checkbox(['label' =>'List WO']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - WO - Good Request Form</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grf_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grf_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grf_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - Problem</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_problem_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_problem_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_problem_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_problem_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - Work Order Actual</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'iko_woActual_input_workOrder')->checkbox(['label' =>'Input Work Order']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_woActual_input_report')->checkbox(['label' =>'Input Report']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_woActual_input_ToolsUsage')->checkbox(['label' =>'Input Tools Usage']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_woActual_input_materialUsage')->checkbox(['label' =>'Input Material Usage']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'iko_woActual_input_transportUsage')->checkbox(['label' =>'Input Transport Usage']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_woActual_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_woActual_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_woActual_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - RFR </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_rfr_view')->checkbox(['label' =>'View RFR']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Inhouse - RFA</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_rfa_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_rfa_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_rfa_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_rfa_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Vendor - Daily Report Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_dailyReportVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_dailyReportVendor_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Vendor - GRF Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grfVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grfVendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grfVendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_grfVendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>IKO Vendor - Material Usage Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_materialUsageVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_materialUsageVendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_materialUsageVendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'iko_materialUsageVendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>CA</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> Dashboard </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_dashboard_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Manage City</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_manageCity_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_manageCity_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_manageCity_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_manageCity_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Manage Area - Pre BA Survey</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_preBas_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_preBas_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_preBas_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_preBas_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Manage Area - BA Survey</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_bas_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_bas_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_bas_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Manage Area - Available To Roll Out</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_availableToRollout_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_availableToRollout_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_availableToRollout_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Manage Area - BA Survey Overview</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_basOverview_overview')->checkbox(['label' =>'BAS Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Manage Area - Homepass Overview</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'ca_hpOverview_overview')->checkbox(['label' =>'Homepass Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Area Setting</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_areaSetting_region')->checkbox(['label' =>'Region']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_areaSetting_city')->checkbox(['label' =>'City']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_areaSetting_district')->checkbox(['label' =>'District']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_areaSetting_subdistrict')->checkbox(['label' =>'Subdistrict']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CA Parameter Setting</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ca_parameterSet_setting')->checkbox(['label' =>'Setting']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>PLANNING</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> PLANNING DASHBOARD </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_dashboard_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING IKO BAS PLAN</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBASP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBASP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBASP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBASP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING IKO As Plan BOQ</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING IKO As Build BOQ </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQB_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQB_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQB_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ikoBOQB_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING CA Presurvey Overview</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_caPresurvey_view')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING OSP BAS PLAN</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBASP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBASP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBASP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBASP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING OSP As Plan BOQ </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING OSP As Build BOQ </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQB_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQB_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQB_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ospBOQB_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING OSP Manage OLT</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_manageOLT_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_manageOLT_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_manageOLT_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_manageOLT_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>


	<div class="row">
        <div class="col-lg-12">
			<h1>PPL</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL DASHBOARD </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_dashboard_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL IKO SCHEDULE </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_schedule_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_schedule_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL IKO ATP </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoATP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoATP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoATP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoATP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL OSP SCHEDULE </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospSchedule_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospSchedule_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL OSP ATP </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospATP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospATP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospATP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospATP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL IKO Closing - BAUT </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAUT_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAUT_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAUT_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAUT_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL IKO Closing - BAST Work </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAST_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAST_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAST_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBAST_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL IKO Closing - BAST Retention </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBASTRetention_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBASTRetention_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBASTRetention_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikoClosingBASTRetention_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL OSP Closing - BAUT </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBAUT_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBAUT_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBAUT_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBAUT_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL OSP Closing - BAST Work </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTWork_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTWork_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTWork_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTWork_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL OSP Closing - BAST Retention </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTRetention_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTRetention_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTRetention_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospClosingBASTRetention_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL Invitation </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_iko_invited')->checkbox(['label' =>'Viewed IKO']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_osp_invited')->checkbox(['label' =>'Viewed OSP']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ikr_invited')->checkbox(['label' =>'Viewed IKR ']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_pc_invited')->checkbox(['label' =>'Viewed PC ']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ospm_invited')->checkbox(['label' =>'Viewed OPSM ']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_cdm_invited')->checkbox(['label' =>'Viewed CDM']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_cipro_invited')->checkbox(['label' =>'Viewed CIPRO']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_busdev_invited')->checkbox(['label' =>'Viewed BUSDEV']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_planning_corp_invited')->checkbox(['label' =>'Viewed Planning Corporate ']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_pc_corp_invited')->checkbox(['label' =>'Viewed PC Corporate']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>NetPro</h1>
		</div>
	</div>


	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro Dashboard</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_dashboard_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro Problem</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_problem_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_problem_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_problem_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_problem_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro Service Report</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_sr_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_sr_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_sr_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_sr_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro BA</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_ba_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_ba_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_ba_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_ba_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro WorkOrder</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_wo_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_wo_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_wo_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_wo_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro GRF </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grfv_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grfv_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grfv_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grfv_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro Material Usage </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

    <div class="row">
        <div class="col-lg-12">
			<h4> NetPro GRF Buffer Stock</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grf_bs_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grf_bs_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grf_bs_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_grf_bs_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro Material Usage Buffer Stock</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_bs_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_bs_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_bs_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_mu_bs_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> NetPro List Stock Buffer </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'netpro_lsb_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>OSPM</h1>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - Dashboard</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_dashboard_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - GRF</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - Material Usage</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

    <div class="row">
        <div class="col-lg-12">
			<h4> OSPM - GRF Buffer Stock</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - Material Usage Buffer Stock</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - GRF Buffer Stock Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_input_vendor')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_verifikasi_vendor')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_approve_vendor')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_grf_bs_overview_vendor')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - Material Usage Buffer Stock Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_input_vendor')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_verifikasi_vendor')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_approve_vendor')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_mu_bs_overview_vendor')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - Obstacle</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_obstacle_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_obstacle_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_obstacle_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_obstacle_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - Ticket Trouble</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_tt_input')->checkbox(['label' =>'View']); ?>
		</div>
		<!-- <div class="col-lg-2">
			<?= $form->field($model, 'ospm_tt_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_tt_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_tt_overview')->checkbox(['label' =>'Overview']); ?>
		</div> -->
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - List Stock Buffer</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_list_stock_buffer_input')->checkbox(['label' =>'Input']); ?>
		</div>

		<!-- <div class="col-lg-2">
			<?= $form->field($model, 'ospm_tt_overview')->checkbox(['label' =>'Overview']); ?>
		</div> -->
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OSPM - List Stock Buffer Vendor</h4>
		</div>
	</div>
	<div>

		<div class="col-lg-2">
			<?= $form->field($model, 'ospm_list_stock_buffer_input_vendor')->checkbox(['label' =>'Input']); ?>
		</div>

	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>AP </h1>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Dashboard</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ap_dashboard_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Invoice</h4>
		</div>
	</div>

	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_invoice_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_invoice_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_invoice_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_invoice_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Document Verification</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_invoice_document_verification')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Costing</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_costing_osp_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_costing_cipro_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_costing_ospm_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_costing_netpro_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_costing_homepass_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Document Approval</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_invoice_document_approval_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Report Invoice</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_report_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> AP - Project Progress</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_project_progress_iko_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'finace_project_progress_osp_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	


	<div class="row">
        <div class="col-lg-12">
			<h1>OS </h1>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Dashboard</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_dashboard_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Outsource Parameter </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_outsource_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_outsource_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_outsource_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_outsource_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Outsource Personel </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_personil_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_personil_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_personil_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_personil_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Outsource Salary </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_salary_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_salary_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_salary_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_salary_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Biaya Jalan </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Biaya Jalan IKO</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_iko_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_iko_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_iko_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_iko_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Biaya Jalan OSP</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_osp_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_osp_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_osp_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_biaya_jalan_osp_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Vehicle IKO</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_iko_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_iko_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_iko_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_iko_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_iko_listwo')->checkbox(['label' =>'List WO']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Vehicle OSP</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_osp_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_osp_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_osp_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_osp_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_osp_listwo')->checkbox(['label' =>'List WO']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Vehicle Parameter</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_parameter_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_parameter_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_parameter_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_vehicle_parameter_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Vendor Registration Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_regist_vendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_regist_vendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_regist_vendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_regist_vendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Vendor SPK</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Vendor SPK Detail</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_detail_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_detail_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_detail_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_pob_detail_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Vendor Term Sheet</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_term_sheet_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_term_sheet_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_term_sheet_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_term_sheet_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - GA Driver Parameter</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_driver_parameter_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_driver_parameter_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_driver_parameter_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_ga_driver_parameter_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4> OS - Vendor Project Parameter</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_project_parameter_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_project_parameter_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_project_parameter_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'os_vendor_project_parameter_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h1>Corporate </h1>
		</div>
	</div>

	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4> Corporate - Dashboard</h4>
		</div>
	</div>

	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'corporate_dashboard_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING Cipro BAS PLAN</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBASP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBASP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBASP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBASP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING Cipro As Plan BOQ</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">
			<h4>PLANNING Cipro As Build BOQ </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQB_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQB_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQB_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'planning_ciproBOQB_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Executor Decision</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_executor_view')->checkbox(['label' =>'view']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Inhouse - Work Order</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'cipro_wo_input_manageTeam')->checkbox(['label' =>'Input Manage Team']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_wo_input_workOrder')->checkbox(['label' =>'Input Work Order']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_wo_input_ToolsNeeds')->checkbox(['label' =>'Input Tools Needs']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_wo_input_materialNeeds')->checkbox(['label' =>'Input Material Needs']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'cipro_wo_input_transportNeeds')->checkbox(['label' =>'Input Transport Needs ']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_wo_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_wo_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_wo_listWO')->checkbox(['label' =>'List WO']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Inhouse - WO - Good Request Form</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grf_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grf_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grf_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Inhouse - Problem</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_problem_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_problem_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_problem_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_problem_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Inhouse - Work Order Actual</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'cipro_woActual_input_workOrder')->checkbox(['label' =>'Input Work Order']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_woActual_input_report')->checkbox(['label' =>'Input Report']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_woActual_input_ToolsUsage')->checkbox(['label' =>'Input Tools Usage']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_woActual_input_materialUsage')->checkbox(['label' =>'Input Material Usage']); ?>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>
	<div>
		<div class="col-lg-3">
			<?= $form->field($model, 'cipro_woActual_input_transportUsage')->checkbox(['label' =>'Input Transport Usage']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_woActual_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_woActual_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_woActual_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Inhouse - RFR </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_rfr_view')->checkbox(['label' =>'View RFR']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Inhouse - RFA</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_rfa_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_rfa_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_rfa_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_rfa_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Vendor - Daily Report Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_dailyReportVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_dailyReportVendor_view')->checkbox(['label' =>'View']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Vendor - GRF Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grfVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grfVendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grfVendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_grfVendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Cipro Vendor - Material Usage Vendor</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_materialUsageVendor_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_materialUsageVendor_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_materialUsageVendor_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cipro_materialUsageVendor_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL Cipro SCHEDULE </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproSchedule_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproSchedule_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL Cipro ATP </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproATP_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproATP_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproATP_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproATP_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL Cipro Closing - BAUT </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBAUT_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBAUT_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBAUT_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBAUT_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL Cipro Closing - BAST Work </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTWork_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTWork_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTWork_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTWork_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>PPL Cipro Closing - BAST Retention </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTRetention_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTRetention_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTRetention_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'ppl_ciproClosingBASTRetention_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Busdev - Berita Acara Survey </h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_baSurvey_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_baSurvey_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_baSurvey_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_baSurvey_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Busdev - Perjanjian Kerja Sama</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_pks_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_pks_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_pks_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'busdev_pks_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CDM - Baso</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_baso_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_baso_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_baso_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_baso_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CDM - PNL</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_pnl_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_pnl_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_pnl_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_pnl_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CDM - WO Survey</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woSurvey_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woSurvey_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woSurvey_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woSurvey_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>CDM - WO Roll Out</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woRollout_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woRollout_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woRollout_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'cdm_woRollout_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel - BA Corporate</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_baCorporate_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_baCorporate_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_baCorporate_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_baCorporate_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>

	<div class="row">
        <div class="col-lg-12">
			<h4>Govrel - Cipro Problem</h4>
		</div>
	</div>
	<div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ciproProblem_input')->checkbox(['label' =>'Input']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ciproProblem_verifikasi')->checkbox(['label' =>'Verify']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ciproProblem_approve')->checkbox(['label' =>'Approve']); ?>
		</div>
		<div class="col-lg-2">
			<?= $form->field($model, 'govrel_ciproProblem_overview')->checkbox(['label' =>'Overview']); ?>
		</div>
	</div>





	</div>


	<div class="row">
        <div class="col-lg-12">

		</div>
	</div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
