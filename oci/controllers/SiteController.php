<?php
namespace oci\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\CaIomAndCity;
use app\models\City;
use app\models\Subdistrict;
use app\models\District;
use linslin\yii2\curl;

use common\models\MkmPrToRr;
use common\models\OrafinViewMkmPrToRr;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','getcity', 'getregion', 'getdistrict', 'getsubdistrict','getcityapproved','getiombycity','getdistrictbyiom','test','getmkmprtorr', 'insertpo', 'gopost'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    // 'insertpo' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // echo var_dump(OrafinViewMkmPrToRr :: find()->select(['distinct(po_no) as po_no', 'pr_no'])->orderBy('po_no asc')->asArray()->all());
        return $this->redirect(['dashboard-os/index']);
    }        

    public function actionInsertpo()
    {
        // $this->layout = 'blank';
        // $request = Yii::$app->request;
        // $params = $request->bodyParams;
        // return var_dump($params);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return 'STOP';
        Yii::$app->dborafin->createCommand()->insert('PO_REQUISITIONS_INTERFACE_ALL',
            [
                // "TRANSACTION_ID" => "",
            	// "PROCESS_FLAG" => "",
            	// "REQUEST_ID" => "",
            	// "PROGRAM_ID" => "",
            	// "PROGRAM_APPLICATION_ID" => "",
            	// "PROGRAM_UPDATE_DATE" => "",
            	// "LAST_UPDATED_BY" => "",
            	// "LAST_UPDATE_DATE" => "",
            	// "LAST_UPDATE_LOGIN" => "",
            	// "CREATION_DATE" => "",
            	// "CREATED_BY" => "",
            	"INTERFACE_SOURCE_CODE" => "PRF-001062", // BOQ NUMBER
            	// "INTERFACE_SOURCE_LINE_ID" => "",
                "SOURCE_TYPE_CODE" => "VENDOR", // HARDCODE
                "REQUISITION_TYPE" => "VENDOR", // HARDCODE
                "DESTINATION_TYPE_CODE" => "EXPENSE", // HARDCODE
            	// "REQUISITION_HEADER_ID" => "",
            	// "REQUISITION_LINE_ID" => "",
            	// "REQ_DISTRIBUTION_ID" => "",
            	"ITEM_DESCRIPTION" => "", // Note BOQP
            	"QUANTITY" => "1", // JUMLAH BOQP DETAIL YANG DIKIRIM
            	"UNIT_PRICE" => "", // AVG PRICE DI MASTER ITEM ORAFIN
            	"AUTHORIZATION_STATUS" => "INCOMPLETE", // HARDCODE
            	// "BATCH_ID" => "",
            	"GROUP_CODE" => "", // SAMA DENGAN INTERFACE_SOURCE_CODE
            	// "DELETE_ENABLED_FLAG" => "",
            	// "UPDATE_ENABLED_FLAG" => "",
            	// "APPROVER_ID" => "",
            	// "APPROVER_NAME" => "",
            	// "APPROVAL_PATH_ID" => "",
            	// "NOTE_TO_APPROVER" => "",
            	"PREPARER_ID" => "", // USER ID
            	// "AUTOSOURCE_FLAG" => "",
            	// "REQ_NUMBER_SEGMENT1" => "",
            	// "REQ_NUMBER_SEGMENT2" => "",
            	// "REQ_NUMBER_SEGMENT3" => "",
            	// "REQ_NUMBER_SEGMENT4" => "",
            	// "REQ_NUMBER_SEGMENT5" => "",
            	"HEADER_DESCRIPTION" => "", // BOQ NUMBER#REGION#CITY#DIST#SUBDISCT#IDAREA#DIVISI
            	"HEADER_ATTRIBUTE_CATEGORY" => "141", // HARDCODE
            	// "HEADER_ATTRIBUTE1" => "",
            	"HEADER_ATTRIBUTE2" => "", // Dari tabel ORAFIN
            	// "HEADER_ATTRIBUTE3" => "",
            	// "HEADER_ATTRIBUTE4" => "",
            	"HEADER_ATTRIBUTE5" => Yii::$app->user->identity->email, // EMAIL USER FORO
            	// "HEADER_ATTRIBUTE6" => "",
            	// "HEADER_ATTRIBUTE7" => "",
            	// "HEADER_ATTRIBUTE8" => "",
            	// "HEADER_ATTRIBUTE9" => "",
            	// "HEADER_ATTRIBUTE10" => "",
            	// "HEADER_ATTRIBUTE11" => "",
            	// "HEADER_ATTRIBUTE12" => "",
            	// "HEADER_ATTRIBUTE13" => "",
            	// "HEADER_ATTRIBUTE14" => "",
            	// "URGENT_FLAG" => "",
            	// "HEADER_ATTRIBUTE15" => "",
            	// "RFQ_REQUIRED_FLAG" => "",
            	// "JUSTIFICATION" => "",
            	// "NOTE_TO_BUYER" => "",
            	// "NOTE_TO_RECEIVER" => "",
            	// "ITEM_ID" => "",
            	"ITEM_SEGMENT1" => "PC101-01.002", // ITEM
            	// "ITEM_SEGMENT2" => "",
            	// "ITEM_SEGMENT3" => "",
            	// "ITEM_SEGMENT4" => "",
            	// "ITEM_SEGMENT5" => "",
            	// "ITEM_SEGMENT6" => "",
            	// "ITEM_SEGMENT7" => "",
            	// "ITEM_SEGMENT8" => "",
            	// "ITEM_SEGMENT9" => "",
            	// "ITEM_SEGMENT10" => "",
            	// "ITEM_SEGMENT11" => "",
            	// "ITEM_SEGMENT12" => "",
            	// "ITEM_SEGMENT13" => "",
            	// "ITEM_SEGMENT14" => "",
            	// "ITEM_SEGMENT15" => "",
            	// "ITEM_SEGMENT16" => "",
            	// "ITEM_SEGMENT17" => "",
            	// "ITEM_SEGMENT18" => "",
            	// "ITEM_SEGMENT19" => "",
            	// "ITEM_SEGMENT20" => "",
            	// "ITEM_REVISION" => "",
            	// "CHARGE_ACCOUNT_ID" => "",
            	"CHARGE_ACCOUNT_SEGMENT1" => "", // TBA
            	"CHARGE_ACCOUNT_SEGMENT2" => "", // TBA
            	"CHARGE_ACCOUNT_SEGMENT3" => "", // TBA
            	"CHARGE_ACCOUNT_SEGMENT4" => "", // TBA
            	"CHARGE_ACCOUNT_SEGMENT5" => "", // TBA
            	"CHARGE_ACCOUNT_SEGMENT6" => "", // TBA
            	// "CHARGE_ACCOUNT_SEGMENT7" => "",
            	// "CHARGE_ACCOUNT_SEGMENT8" => "",
            	// "CHARGE_ACCOUNT_SEGMENT9" => "",
            	// "CHARGE_ACCOUNT_SEGMENT10" => "",
            	// "CHARGE_ACCOUNT_SEGMENT11" => "",
            	// "CHARGE_ACCOUNT_SEGMENT12" => "",
            	// "CHARGE_ACCOUNT_SEGMENT13" => "",
            	// "CHARGE_ACCOUNT_SEGMENT14" => "",
            	// "CHARGE_ACCOUNT_SEGMENT15" => "",
            	// "CHARGE_ACCOUNT_SEGMENT16" => "",
            	// "CHARGE_ACCOUNT_SEGMENT17" => "",
            	// "CHARGE_ACCOUNT_SEGMENT18" => "",
            	// "CHARGE_ACCOUNT_SEGMENT19" => "",
            	// "CHARGE_ACCOUNT_SEGMENT20" => "",
            	// "CHARGE_ACCOUNT_SEGMENT21" => "",
            	// "CHARGE_ACCOUNT_SEGMENT22" => "",
            	// "CHARGE_ACCOUNT_SEGMENT23" => "",
            	// "CHARGE_ACCOUNT_SEGMENT24" => "",
            	// "CHARGE_ACCOUNT_SEGMENT25" => "",
            	// "CHARGE_ACCOUNT_SEGMENT26" => "",
            	// "CHARGE_ACCOUNT_SEGMENT27" => "",
            	// "CHARGE_ACCOUNT_SEGMENT28" => "",
            	// "CHARGE_ACCOUNT_SEGMENT29" => "",
            	// "CHARGE_ACCOUNT_SEGMENT30" => "",
            	// "CATEGORY_ID" => "",
            	// "CATEGORY_SEGMENT1" => "",
            	// "CATEGORY_SEGMENT2" => "",
            	// "CATEGORY_SEGMENT3" => "",
            	// "CATEGORY_SEGMENT4" => "",
            	// "CATEGORY_SEGMENT5" => "",
            	// "CATEGORY_SEGMENT6" => "",
            	// "CATEGORY_SEGMENT7" => "",
            	// "CATEGORY_SEGMENT8" => "",
            	// "CATEGORY_SEGMENT9" => "",
            	// "CATEGORY_SEGMENT10" => "",
            	// "CATEGORY_SEGMENT11" => "",
            	// "CATEGORY_SEGMENT12" => "",
            	// "CATEGORY_SEGMENT13" => "",
            	// "CATEGORY_SEGMENT14" => "",
            	// "CATEGORY_SEGMENT15" => "",
            	// "CATEGORY_SEGMENT16" => "",
            	// "CATEGORY_SEGMENT17" => "",
            	// "CATEGORY_SEGMENT18" => "",
            	// "CATEGORY_SEGMENT19" => "",
            	// "CATEGORY_SEGMENT20" => "",
            	// "UNIT_OF_MEASURE" => "",
            	"UOM_CODE" => "", // MASTER ITEM ORAFIN
            	// "LINE_TYPE_ID" => "",
            	// "LINE_TYPE" => "",
            	// "UN_NUMBER_ID" => "",
            	// "UN_NUMBER" => "",
            	// "HAZARD_CLASS_ID" => "",
            	// "HAZARD_CLASS" => "",
            	// "MUST_USE_SUGG_VENDOR_FLAG" => "",
            	// "REFERENCE_NUM" => "",
            	// "WIP_ENTITY_ID" => "",
            	// "WIP_LINE_ID" => "",
            	// "WIP_OPERATION_SEQ_NUM" => "",
            	// "WIP_RESOURCE_SEQ_NUM" => "",
            	// "WIP_REPETITIVE_SCHEDULE_ID" => "",
            	// "PROJECT_NUM" => "",
            	// "TASK_NUM" => "",
            	// "EXPENDITURE_TYPE" => "",
            	// "SOURCE_ORGANIZATION_ID" => "",
            	// "SOURCE_ORGANIZATION_CODE" => "",
            	// "SOURCE_SUBINVENTORY" => "",
            	// "DESTINATION_ORGANIZATION_ID" => "",
            	"DESTINATION_ORGANIZATION_CODE" => "Z40",  // DARI MASTER ITEM ORAFIN
            	// "DESTINATION_SUBINVENTORY" => "",
            	"DELIVER_TO_LOCATION_ID" => "", // DARI MASTER ITEM ORAFIN
            	// "DELIVER_TO_LOCATION_CODE" => "",
            	"DELIVER_TO_REQUESTOR_ID" => "", // DARI USER BY EMAIL
            	// "DELIVER_TO_REQUESTOR_NAME" => "",
            	// "SUGGESTED_BUYER_ID" => "",
            	// "SUGGESTED_BUYER_NAME" => "",
            	// "SUGGESTED_VENDOR_NAME" => "",
            	// "SUGGESTED_VENDOR_ID" => "",
            	// "SUGGESTED_VENDOR_SITE" => "",
            	// "SUGGESTED_VENDOR_SITE_ID" => "",
            	// "SUGGESTED_VENDOR_CONTACT" => "",
            	// "SUGGESTED_VENDOR_CONTACT_ID" => "",
            	// "SUGGESTED_VENDOR_PHONE" => "",
            	// "SUGGESTED_VENDOR_ITEM_NUM" => "",
            	"LINE_ATTRIBUTE_CATEGORY" => "", // TBA
            	// "LINE_ATTRIBUTE1" => "",
            	"LINE_ATTRIBUTE2" => "100038 - Pembayaran Allowance teknisi PPD#Allowance Driver#Testing FORO", // INFORMASI TAMBAHAN UNTUK ITEM
            	"LINE_ATTRIBUTE3" => "PC101-01.002", // EXCEL
            	"LINE_ATTRIBUTE4" => "", // AVG PRICE DARI MASTER ITEM ORAFIN
            	"LINE_ATTRIBUTE5" => "IDR", // HARDCODE
            	// "LINE_ATTRIBUTE6" => "",
            	// "LINE_ATTRIBUTE7" => "",
            	// "LINE_ATTRIBUTE8" => "",
            	// "LINE_ATTRIBUTE9" => "",
            	"LINE_ATTRIBUTE10" => "", // JUMLAH ITEM BOQP
            	// "LINE_ATTRIBUTE11" => "",
            	// "LINE_ATTRIBUTE12" => "",
            	// "LINE_ATTRIBUTE13" => "",
            	// "LINE_ATTRIBUTE14" => "",
            	// "LINE_ATTRIBUTE15" => "",
            	"NEED_BY_DATE" => "", // CREATED DATE
            	// "NOTE1_ID" => "",
            	// "NOTE2_ID" => "",
            	// "NOTE3_ID" => "",
            	// "NOTE4_ID" => "",
            	// "NOTE5_ID" => "",
            	// "NOTE6_ID" => "",
            	// "NOTE7_ID" => "",
            	// "NOTE8_ID" => "",
            	// "NOTE9_ID" => "",
            	// "NOTE10_ID" => "",
            	// "NOTE1_TITLE" => "",
            	// "NOTE2_TITLE" => "",
            	// "NOTE3_TITLE" => "",
            	// "NOTE4_TITLE" => "",
            	// "NOTE5_TITLE" => "",
            	// "NOTE6_TITLE" => "",
            	// "NOTE7_TITLE" => "",
            	// "NOTE8_TITLE" => "",
            	// "NOTE9_TITLE" => "",
            	// "NOTE10_TITLE" => "",
            	"GL_DATE" => "", // CREATED DATE
            	// "DIST_ATTRIBUTE_CATEGORY" => "",
            	// "DISTRIBUTION_ATTRIBUTE1" => "",
            	// "DISTRIBUTION_ATTRIBUTE2" => "",
            	// "DISTRIBUTION_ATTRIBUTE3" => "",
            	// "DISTRIBUTION_ATTRIBUTE4" => "",
            	// "DISTRIBUTION_ATTRIBUTE5" => "",
            	// "DISTRIBUTION_ATTRIBUTE6" => "",
            	// "DISTRIBUTION_ATTRIBUTE7" => "",
            	// "DISTRIBUTION_ATTRIBUTE8" => "",
            	// "DISTRIBUTION_ATTRIBUTE9" => "",
            	// "DISTRIBUTION_ATTRIBUTE10" => "",
            	// "DISTRIBUTION_ATTRIBUTE11" => "",
            	// "DISTRIBUTION_ATTRIBUTE12" => "",
            	// "DISTRIBUTION_ATTRIBUTE13" => "",
            	// "DISTRIBUTION_ATTRIBUTE14" => "",
            	// "DISTRIBUTION_ATTRIBUTE15" => "",
            	// "PREPARER_NAME" => "",
            	// "BOM_RESOURCE_ID" => "",
            	// "ACCRUAL_ACCOUNT_ID" => "",
            	// "VARIANCE_ACCOUNT_ID" => "",
            	// "BUDGET_ACCOUNT_ID" => "",
            	// "USSGL_TRANSACTION_CODE" => "",
            	// "GOVERNMENT_CONTEXT" => "",
            	"CURRENCY_CODE" => "IDR", // HARDCODE
            	"CURRENCY_UNIT_PRICE" => "", // AVG PRICE FROM MASTER ITEM
            	"RATE" => "1", // HARDCODE
            	// "RATE_DATE" => "",
            	// "RATE_TYPE" => "",
            	// "PREVENT_ENCUMBRANCE_FLAG" => "",
            	// "AUTOSOURCE_DOC_HEADER_ID" => "",
            	// "AUTOSOURCE_DOC_LINE_NUM" => "",
            	// "PROJECT_ACCOUNTING_CONTEXT" => "",
            	// "EXPENDITURE_ORGANIZATION_ID" => "",
            	// "PROJECT_ID" => "",
            	// "TASK_ID" => "",
            	// "END_ITEM_UNIT_NUMBER" => "",
            	// "EXPENDITURE_ITEM_DATE" => "",
            	// "DOCUMENT_TYPE_CODE" => "",
            	"ORG_ID" => "141", // HARDCODE
            	// "TRANSACTION_REASON_CODE" => "",
            	// "ALLOCATION_TYPE" => "",
            	// "ALLOCATION_VALUE" => "",
            	// "MULTI_DISTRIBUTIONS" => "",
            	// "REQ_DIST_SEQUENCE_ID" => "",
            	// "KANBAN_CARD_ID" => "",
            	// "EMERGENCY_PO_NUM" => "",
            	// "AWARD_ID" => "",
            	// "TAX_CODE_ID" => "",
            	// "OKE_CONTRACT_HEADER_ID" => "",
            	// "OKE_CONTRACT_NUM" => "",
            	// "OKE_CONTRACT_VERSION_ID" => "",
            	// "OKE_CONTRACT_LINE_ID" => "",
            	// "OKE_CONTRACT_LINE_NUM" => "",
            	// "OKE_CONTRACT_DELIVERABLE_ID" => "",
            	// "OKE_CONTRACT_DELIVERABLE_NUM" => "",
            	// "SECONDARY_UNIT_OF_MEASURE" => "",
            	// "SECONDARY_UOM_CODE" => "",
            	// "SECONDARY_QUANTITY" => "",
            	// "PREFERRED_GRADE" => "",
            	// "VMI_FLAG" => "",
            	// "TAX_USER_OVERRIDE_FLAG" => "",
            	// "AMOUNT" => "",
            	// "CURRENCY_AMOUNT" => "",
            	// "SHIP_METHOD" => "",
            	// "ESTIMATED_PICKUP_DATE" => "",
            	// "BASE_UNIT_PRICE" => "",
            	// "NEGOTIATED_BY_PREPARER_FLAG" => "",
            	// "TAX_NAME" => ""
            ]
        )
        // ->execute()
		;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {$this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	public function actionGetregion() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$cities = City::find()->where(['id_province' => $cat_id])->all();

				$ids = [];
				$j = 0;
				for($i = 0; $i < count($cities); $i++) {
					if(!in_array($cities[$i]->idRegion->id,$ids)) {
						array_push($ids, $cities[$i]->idRegion->id);
						$out[$j]['id'] = $cities[$i]->idRegion->id;
						$out[$j]['name'] = $cities[$i]->idRegion->name;
						$j++;
					}
				}

				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

    public function actionGetcity() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id_region = $parents[0];
				$id_province = $parents[1];
				$out = City::find()->where(['id_region' => $id_region])->andWhere(['id_province'=> $id_province])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetcityapproved() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id_region = $parents[0];
				$out = CaIomAndCity::find()->joinWith(['idCity'],false)->joinWith(['idIom'],false)
					->where(['city.id_region' => $id_region])->andWhere(['ca_iom_area_expansion.status'=> 'approved'])->select('city.id as id, city.name as name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetdistrict() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$out = District::find($cat_id)->where(['id_city' => $cat_id])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetsubdistrict() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$out = Subdistrict::find($cat_id)->where(['id_district' => $cat_id])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetiombycity() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$datas = CaIomAndCity::find($cat_id)->where(['id_city' => $cat_id])->orderBy(['id'=>SORT_DESC])->all();
				for($i=0;$i<count($datas);$i++) {
					if($datas[$i]->idIom->status == 'approved') {
						$out[$i]['id'] = $datas[$i]->id;
						$out[$i]['name'] = $datas[$i]->idIom->no_iom_area_exp;
					}
				}
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetdistrictbyiom() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$city = CaIomAndCity::findOne($cat_id)->idCity->id;
				$out = District::find()->where(['id_city' => $city])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
}
