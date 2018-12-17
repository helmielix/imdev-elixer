<?php
namespace oci\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\CaIomAndCity;
use app\models\City;
use app\models\Subdistrict;
use app\models\District;
use linslin\yii2\curl;

use common\models\MkmPrToRr;
use common\models\OrafinViewMkmPrToPay;
use common\models\PoRequisitionsForo;

/**
 * Site controller
 */
class ApiorafinController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'common\models\OrafinViewMkmPrToPay';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','getcity', 'getregion', 'getdistrict', 'getsubdistrict','getcityapproved','getiombycity','getdistrictbyiom','test','getmkmprtopay', 'insertpo', 'gopost', 'insertinv', 'getinvamount', 'insertrr', 'getmkmmasteritem'],
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
                    'insertpo' => ['post'],
                    'insertinv' => ['post'],
                    'insertrr' => ['post'],
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
		ini_set('memory_limit', '200M');
        // echo var_dump(OrafinViewMkmPrToPay :: find()->select(['distinct(po_no) as po_no', 'pr_no'])->orderBy('po_no asc')->asArray()->all());
		echo var_dump(Yii::$app->dborafin->createCommand('SELECT 
			PO_NUM as po_num,
            PR_NUM as pr_num,
            CREATION_DATE as creation_date ,
            ITEM_DESCRIPTION as item_description,
            UOM as uom,
            QUANTITY as quantity,
            PR_DESC as pr_desc,
            CURRENCY_AMOUNT as currency_amount
			FROM MKM_PR_TO_PAY
			
			-- PO_NO as po_no,
            -- PR_NO as pr_no,
            -- CREATION_DATE_PO as creation_date_po ,
            -- ITEM_DESCRIPTION_PR as item_description_pr,
            -- UOM as uom,
            -- QUANTITY_PO as quantity_po,
            -- COMMENTS as comments,
            -- LINE_AMOUNT as line_amount
			-- FROM MKM_PR_TO_RR
			
			'
			)->queryAll());
        // return $this->redirect(['dashboard-os/index']);
    }
	
	public function actionGetmkmmasteritem(){
		$data = Yii::$app->dborafin->createCommand("
			SELECT
			 ITEM_CODE as item_code
			,ITEM_DESC as item_desc
			,NEW_COST as new_cost
			,ITEM_UOM_CODE as item_uom_code
			,ITEM_UOM_DESC as item_uom_desc
			,INVENTORY_ITEM_FLAG as inventory_item_flag
			,LOCATION_ID as location_id
			,LOCATION_CODE as location_code
			,LOCATION as location
			,ORGANIZATION_ID as organization_id
			,SOURCE_CODE as source_code
			,DISTRIBUTION_ACCOUNT_ID as distribution_account_id
			,TRANSACTION_COST as transaction_cost
			,PRIOR_COST as prior_cost
			,EXPENSE_ACCOUNT as expense_account
			,SEGMENT1 as segment1
			,SEGMENT2 as segment2
			,SEGMENT3 as segment3
			,SEGMENT4 as segment4
			,SEGMENT5 as segment5
			,SEGMENT6 as segment6
			from MKM_MASTER_ITEM 
			order by ITEM_CODE");
		$orafindata = $data->queryAll();
			
		Yii::$app->db->createCommand()->batchInsert('temp_mkm_master_item', [
                'item_code'
				,'item_desc'
				,'new_cost'
				,'item_uom_code'
				,'item_uom_desc'
				,'inventory_item_flag'
				,'location_id'
				,'location_code'
				,'location'
				,'organization_id'
				,'source_code'
				,'distribution_account_id'
				,'transaction_cost'
				,'prior_cost'
				,'expense_account'
				,'segment1'
				,'segment2'
				,'segment3'
				,'segment4'
				,'segment5'
				,'segment6'
            ] , $orafindata)->execute();
			
		$command = Yii::$app->db->createCommand("select _upsert_mkm_master_item();")->query();
	}
	
	public function actionGetfullmkmprtopay(){
		$data = Yii::$app->dborafin->createCommand("SELECT 
			 DISTINCT(PR_ITEM_CODE) as item_code
			,PO_PRICE as po_price
			from MKM_PR_TO_PAY
			where PO_PRICE IS NOT NULL
			order by PR_ITEM_CODE");
		$orafindata = $data->queryAll();
		
		Yii::$app->db->createCommand()->batchInsert('temp_mkm_pr_to_pay', [
                'item_code',
				'po_price',
            ] , $orafindata)->execute();
			
		$command = Yii::$app->db->createCommand("select _upsert_mkm_master_item_price();")->query();
	}

    public function actionGetmkmprtopay()
    {
		ini_set('memory_limit', '500M');
        $data = Yii::$app->dborafin->createCommand("SELECT PO_NUM as po_num,
            PR_NUM as pr_num,
            PR_CREATION_DATE as pr_creation_date ,
            PR_ITEM_DESCRIPTION as pr_item_description,
            PR_ITEM_CODE as pr_item_code,
            ITEM_ID as item_id,
            PO_UOM as po_uom,
            PO_PRICE as po_price,
			PO_SUPPLIER as po_supplier,
			PO_HEADER_ID as po_header_id,
			PO_LINE_ID as po_line_id,
			PO_LINE_LOCATION_ID as po_line_location_id,
			PO_DISTRIBUTION_ID as po_distribution_id,
			-- PO_RELEASE_ID as po_release_id,
            PR_QUANTITY as pr_quantity,
			PR_PRICE as pr_price,
            PR_DESC as pr_desc,
			PO_DATE as po_date,
            PO_AMOUNT as po_amount,
			PR_STATUS as pr_status,
			PO_STATUS as po_status,
			PO_ITEM_DESCRIPTION as po_item_description,
			PO_LINE_NUM as po_line_num,
			PO_QUANTITY_ORDERED as po_quantity_ordered,
			PR_CURRENCY_AMOUNT as pr_currency_amount,
			ACCRUAL_ACCOUNT as accrual_account,
			SHIP_TO_LOCATION_ID as ship_to_location_id,
			PO_VENDOR_SITE_CODE as po_vendor_site_code,
			RCV_NO as rcv_no,
			RCV_QUANTITY_RECEIVED as rcv_quantity_received,
			RCV_TRANSACTION_ID as rcv_transaction_id,
			RCV_SHIPMENT_LINE_ID as rcv_shipment_line_id,
			RCV_DATE as rcv_date,
			RCV_RECEIVER as rcv_receiver,
			INV_NO as inv_no,
			INV_AMOUNT as inv_amount,
			INV_DATE as inv_date,
			INV_QUANTITY as inv_quantity,
			PAYMENT_AMOUNT as payment_amount,
			PAYMENT_DATE as payment_date,
			PAYMENT_NUMBER as payment_number,
			PAYMENT_RATE as payment_rate,
			PAYMENT_STATUS as payment_status
            FROM MKM_PR_TO_PAY WHERE PR_DESC LIKE 'PLANNING%'");
		$orafindata = $data->queryAll();

        // OrafinViewMkmPrToPay::deleteAll(); // delete on foro, sync with orafin view
		Yii::$app->db->createCommand('truncate orafin_view_mkm_pr_to_pay')->execute();
		// orafin_view_mkm_pr_to_rr_id_seq
		Yii::$app->db->createCommand('ALTER SEQUENCE orafin_view_mkm_pr_to_rr_id_seq RESTART WITH 1')->execute();
        Yii::$app->db->createCommand()->batchInsert('orafin_view_mkm_pr_to_pay', [
                'po_num' ,
                'pr_num' ,
                'pr_creation_date' ,
                'pr_item_description' ,
				'pr_item_code',
				'item_id',
                'po_uom' ,
				'po_price',
				'po_supplier',
				'po_header_id',
				'po_line_id',
				'po_line_location_id',
				'po_distribution_id',
				// 'po_release_id',
                'pr_quantity' ,
				'pr_price',
                'pr_desc',
				'po_date',
                'po_amount',
				'pr_status',
				'po_status',
				'po_item_description',
				'po_line_num',
				'po_quantity_ordered',
				'pr_currency_amount',
				'accrual_account',
				'ship_to_location_id',
				'po_vendor_site_code',
				'rcv_no',
				'rcv_quantity_received',
				'rcv_transaction_id',
				'rcv_shipment_line_id',
				'rcv_date',
				'rcv_receiver',
				'inv_no',
				'inv_amount',
				'inv_date',
				'inv_quantity',
				'payment_amount',
				'payment_date',
				'payment_number',
				'payment_rate',
				'payment_status',
            ] , $orafindata)->execute();

    }	
	
	public function actionGetinvamount($po,$rr, $inv = false){
		
		$command = (new \yii\db\Query())
                // ->select(['SUM(PO_AMOUNT) AS PO_AMOUNT'])
				->select ([
					new \yii\db\Expression('sum(po_price * rcv_quantity_received) as PO_AMOUNT'),
				])
                ->from('MKM_PR_TO_PAY')
				->andWhere(['PO_NUM' => $po])
				->andWhere(['RCV_NO' => $rr])
				
				;
				
		if ($inv){
			$command = $command->andWhere(['is not', 'INV_AMOUNT', null]);
		}
		
        $command = $command->groupBy('PR_NUM, PO_NUM, RCV_NO, INV_NO, PAYMENT_NUMBER')
			->createCommand();
		// return 'stop'.var_dump($command->createCommand());
		$masterInv = Yii::$app->dborafin->createCommand($command->sql, $command->params)
			->queryOne();
		echo $masterInv['PO_AMOUNT'];
	}
	
	public function actionInsertinv(){
		$params = Yii::$app->getRequest()->getBodyParams();
		
		// PREPAYMENT == DP
		$arrInvTypeLookupCode = ['STANDARD', 'PREPAYMENT'];
		$invTypeLookupCode	= $arrInvTypeLookupCode[$params['invTypeLookupCode']];
		$invNum				= $params['invNum'];
		$invDate			= $params['invDate'];
		$invDueDate			= $params['invDueDate']; //(TERMS DATE)
		$invAmount			= $params['invAmount']; // sudah hasil perhitungan jika ada percentage
		$invPoNum			= $params['invPoNum'];
		$invPercentage		= $params['invPercentage']; // jika tidak ada percentage maka nilai default 200
		$lines				= isset($params['lines']) ? $params['lines'] : [];
		
		// $masterInvId = Yii::$app->dborafin->createCommand("select distinct (INVOICE_ID) from AP_INVOICES_IFACE_X order by invoice_id desc")
		// $masterInvId = Yii::$app->dborafin->createCommand("select (INVOICE_ID) from AP_INVOICES_IFACE_X where invoice_id = ".date('Ymd').sprintf("%03d", 1))
		#testing
		$masterInvId = Yii::$app->dborafin->createCommand("select (INVOICE_ID) from AP_INVOICES_IFACE_X where invoice_id like '".date('Ymd')."%' order by invoice_id desc")
			->queryOne();
		$invid = $masterInvId['INVOICE_ID'];
		// $invid = null;
		#testing
		if($invid == null){
			$invid = date('Ymd').sprintf("%03d", 1);
		}else{
			$invid = substr($invid, -3);
			$invid = $invid + 1;
			$invid = date('Ymd').sprintf("%03d", $invid);
		}
		
		// $masterMkmPay = Yii::$app->dborafin->createCommand("SELECT PO_SUPPLIER FROM MKM_PR_TO_PAY
			// WHERE PR_DESC LIKE 'PLANNING%'
			// AND PO_NUM = '{$lines[0]['poNum']}'
			// AND RCV_NO = '{$lines[0]['rcvNum']}'
			// AND ROWNUM = 1")
			// ->queryOne();
		// $vendorName = $masterMkmPay['PO_SUPPLIER'];
		
		$masterMkmPay = OrafinViewMkmPrToPay::find()
				->select([
					'po_supplier',
					'po_vendor_site_code',
				])
				->andWhere(['po_num' => $invPoNum])
				// ->andWhere(['rcv_no' => $lines[0]['rcvNum']])
				->one();
		$vendorName = $masterMkmPay->po_supplier;
		$vendorSiteCode = $masterMkmPay->po_vendor_site_code;
		
		
		$allColumnHeader = [
				'INVOICE_ID',
                'INVOICE_TYPE_LOOKUP_CODE', // v25 (STANDARD / PREPAYMENT [dp])
                'VENDOR_NAME', //v240
                'VENDOR_SITE_CODE', //v15 (JAKARTA)
                'INVOICE_NUM', //v50
                'INVOICE_DATE', //date
                'ACCTS_PAY_CODE_CONCATENATED', //v250
                'INVOICE_RECEIVED_DATE', //date
                'GOODS_RECEIVED_DATE', //date
                'GL_DATE', //date
                'TERMS_NAME', //v50 (NET30)
                'TERMS_DATE', //date
                'INVOICE_CURRENCY_CODE', //v15 (IDR)
                'EXCHANGE_RATE_TYPE', //v30 (diisi dengan CORPORATE jika currency bukan  IDR)
                'EXCHANGE_DATE', //date
                'EXCHANGE_RATE', //int (1)
                'INVOICE_AMOUNT', //bigint
                'DESCRIPTION', //v240
                'PAYMENT_METHOD_CODE', //v30 (CHECK)
                'SOURCE', //v80 (FORO)
                'OPERATING_UNIT', //v240 (MKM Operating Unit)
                'ORG_ID', //int (141)
        ];
		
		if ($params['invTypeLookupCode'] == 1) { // PREPAYMENT
			$accts_pay_code_concatenated = '21101.2121901.000.0000.000.000';
		}else{
			$accts_pay_code_concatenated = '21101.2121199.000.0000.000.000';
		}
		
		$allDataHeader = [
				$invid, // INVOICE_ID
                $invTypeLookupCode, // INVOICE_TYPE_LOOKUP_CODE
                $vendorName, // VENDOR_NAME
                $vendorSiteCode, // VENDOR_SITE_CODE (MASIH DUMMY)
                $invNum, // INVOICE_NUM
				$invDate, // INVOICE_DATE
                $accts_pay_code_concatenated, // ACCTS_PAY_CODE_CONCATENATED
                $invDate, // INVOICE_RECEIVED_DATE
                $invDate, // GOODS_RECEIVED_DATE
                $invDate, // GL_DATE
                '30 Days', // TERMS_NAME (HARDCODE)
                $invDueDate, // TERMS_DATE
                'IDR', // INVOICE_CURRENCY_CODE
                '', // EXCHANGE_RATE_TYPE
                '', // EXCHANGE_DATE
                1, // EXCHANGE_RATE
                $invAmount, // INVOICE_AMOUNT
                'PO #'.implode(', PO #',$invPoNum), // DESCRIPTION
                'CHECK', // PAYMENT_METHOD_CODE
                'FORO', // SOURCE
                'MKM Operating Unit', // OPERATING_UNIT
                141, // ORG_ID
        ];
		
		$allColumnLines = [
                'INVOICE_ID', // int (dari tabel header)
                'INVOICE_LINE_ID', //int  running number
                'LINE_TYPE_LOOKUP_CODE', //v25 (ITEM)
                'ACCOUNTING_DATE', //date (GL DATE dari tabel header)
                'LINE_NUMBER', //int (base on data)
                'PO_NUMBER',  //v20
                'INVENTORY_ITEM_ID', //int
                'DESCRIPTION', //v240 (PO_ITEM_DESCRIPTION)
				'ITEM_DESCRIPTION', //(PO_ITEM_DESCRIPTION)
                'AMOUNT', //bigint
                'QUANTITY_INVOICED', //int
				'UNIT_PRICE', //int request Orafin, di isi PO_PRICE
                'DIST_CODE_CONCATENATED', //v250
                'ASSETS_TRACKING_FLAG', //v1 (N)
                'ORG_ID', //int (141)
				'MATCH_OPTION', // HARDCODE (R)
				'PO_HEADER_ID',
				'PO_LINE_ID',
				// 'PO_RELEASE_ID',
				'PO_LINE_LOCATION_ID',
				'PO_DISTRIBUTION_ID',
				'RCV_TRANSACTION_ID',
				'SHIP_TO_LOCATION_ID',
				// 'RCV_SHIPMENT_LINE_ID',
				'TAX_CLASSIFICATION_CODE', //(MKM_PPN10)
				'RECEIPT_NUMBER', 
				'PO_LINE_NUMBER', 
        ];				

		#testing
		// insert to header , AP_INVOICES_IFACE_X
		Yii::$app->dborafin->createCommand('ALTER SESSION SET NLS_DATE_FORMAT=\'YYYY-MM-DD\'')->execute(); // clear date formatting
		$g = Yii::$app->dborafin->createCommand()->batchInsert('AP_INVOICES_IFACE_X', $allColumnHeader, [$allDataHeader]);
		#testing
		
		// insert to line, AP_INVOICE_LINES_IFACE_X
		$rownum = 1;
		// jika STANDARD (bukan PREPAYMENT) memiliki data $lines
		$out = '';
		foreach($lines as $key => $value){
			// $arrpo_num[] = "'".$value['poNum']."'";
			// $arrrr_num[] = "'".$value['rcvNum']."'";
			$orafinview = OrafinViewMkmPrToPay::find()
				->select([
					'pr_item_code', 
					'rcv_quantity_received', 
					new \yii\db\Expression('(po_price * rcv_quantity_received) as inv_amount'),
					new \yii\db\Expression('rcv_quantity_received - sum(inv_quantity) as rem_rcv_quantity_received'),
					'po_price',
					'po_header_id',
					'po_line_id',
					'po_line_location_id',
					'po_distribution_id',
					'ship_to_location_id',
					'accrual_account',
					'rcv_no',
					'rcv_transaction_id',
					'rcv_shipment_line_id',
					'item_id',
					'po_item_description',
					'po_line_num',
				])
				->andWhere(['po_num' => $value['poNum']])
				->andWhere(['rcv_no' => $value['rcvNum']])
				->groupBy('rcv_quantity_received ,pr_item_code ,po_price ,po_header_id ,po_line_id ,po_line_location_id ,po_distribution_id ,ship_to_location_id ,accrual_account ,rcv_no, rcv_transaction_id, rcv_shipment_line_id, item_id, po_item_description, po_line_num')
				->all();
			foreach($orafinview as $index => $data){
				
				$dist_code_concatenated = '';
				$po_item_desc = $data['po_item_description'];

				if ($invPercentage == 200){
					$qtyInvoiced = $data['rcv_quantity_received'];
					$lineAmount = $data['inv_amount'];
				}else{
					$qtyInvoiced = $data['rem_rcv_quantity_received'] * ($invPercentage / 100);
					// $lineAmount = round( $data['inv_amount'] * ($invPercentage / 100) );
					$lineAmount = round( ($data['po_price'] * $data['rem_rcv_quantity_received']) * ($invPercentage / 100) );
				}
				
				#output testing
				// $out .= $value['poNum'].' '.$value['rcvNum'].' '.$data['rcv_quantity_received'].' '.$data['rem_rcv_quantity_received'].' '.$data['pr_item_code']
					// .',qtyInvoiced = '.$qtyInvoiced." , lineAmount1 = {$data['inv_amount']}, lineAmount2 = {$lineAmount}, po_price = {$data['po_price']}".'<br>';
				// continue;
				#output testing
				
				$allDataLines[] = [
					$invid, // INVOICE_ID
					$invid.sprintf("%03d", $rownum), // INVOICE_LINE_ID
					'ITEM', // LINE_TYPE_LOOKUP_CODE
					$invDate, // ACCOUNTING_DATE
					$rownum, // LINE_NUMBER
					$value['poNum'],  // PO_NUMBER
					$data['item_id'], // INVENTORY_ITEM_ID
					$po_item_desc, // (DESCRIPTION)
					$po_item_desc, // (ITEM_DESCRIPTION)
					$lineAmount, // AMOUNT
					$qtyInvoiced, // QUANTITY_INVOICED
					$data['po_price'], // UNIT_PRICE
					$dist_code_concatenated, // DIST_CODE_CONCATENATED
					'N', // ASSETS_TRACKING_FLAG
					'141', // ORG_ID
					'R', // MATCH_OPTION
					$data['po_header_id'], // PO_HEADER_ID
					$data['po_line_id'], // PO_LINE_ID
					// 'PO_RELEASE_ID', // PO_RELEASE_ID
					$data['po_line_location_id'], // PO_LINE_LOCATION_ID
					$data['po_distribution_id'], // PO_DISTRIBUTION_ID
					$data['rcv_transaction_id'], // RCV_TRANSACTION_ID
					$data['ship_to_location_id'], // SHIP_TO_LOCATION_ID
					// $data['rcv_shipment_line_id'], // RCV_SHIPMENT_LINE_ID
					'MKM_PPN10', // TAX_CLASSIFICATION_CODE
					$data['rcv_no'], // RECEIPT_NUMBER
					$data['po_line_num'], // PO_LINE_NUMBER
				];
				
				$rownum++;
			}
		}
		#output testing
		// return $out;
		#output testing
		
		// jika PREPAYMENT SESUAIKAN DIST_CODE_CONCATENATED
		if ($params['invTypeLookupCode'] == 1) { // PREPAYMENT
			// $dist_code_concatenated = '2121901';
			$dist_code_concatenated = '1181299';
			$po_item_desc = '';
			
			$dist_code_concatenated = '';
			$allDataLines[] = [
				$invid, // INVOICE_ID
				$invid.sprintf("%03d", $rownum), // INVOICE_LINE_ID
				'ITEM', // LINE_TYPE_LOOKUP_CODE
				$invDate, // ACCOUNTING_DATE
				$rownum, // LINE_NUMBER
				'',  // PO_NUMBER
				'', // INVENTORY_ITEM_ID
				// $invPoNum, // (DESCRIPTION)
				'PO #'.implode(', PO #',$invPoNum), // DESCRIPTION
				'', // (ITEM_DESCRIPTION)
				$invAmount, // AMOUNT
				'1', // QUANTITY_INVOICED
				'1', // UNIT_PRICE
				$dist_code_concatenated, // DIST_CODE_CONCATENATED
				'N', // ASSETS_TRACKING_FLAG
				'141', // ORG_ID
				'', // MATCH_OPTION
				'', // PO_HEADER_ID
				'', // PO_LINE_ID
				// 'PO_RELEASE_ID', // PO_RELEASE_ID
				'', // PO_LINE_LOCATION_ID
				'', // PO_DISTRIBUTION_ID
				'', // RCV_TRANSACTION_ID
				'', // SHIP_TO_LOCATION_ID
				// $data['rcv_shipment_line_id'], // RCV_SHIPMENT_LINE_ID
				'', // TAX_CLASSIFICATION_CODE
				'', // RECEIPT_NUMBER
				'', // PO_LINE_NUMBER
			];
		}		
		
		#testing
		$gL = Yii::$app->dborafin->createCommand()->batchInsert('AP_INVOICE_LINES_IFACE_X', $allColumnLines, $allDataLines);
		#testing
		
		// return json_encode(['status' => 'failed', 'reason' => 'digagalkan']);
		
		try{
			#testing
			$g->execute();
			$gL->execute();
			#testing
			
			return json_encode(['status' => 'Success', 'reason' => 'Success']);
		}catch(\yii\db\Exception $e){
			return json_encode(['reason' => 'DB error: '.$e->getMessage(), 'status' => 'failed']);
		}catch(\Exception $e){
			return json_encode(['reason' => 'Exception: '.$e->getMessage(), 'status' => 'failed']);
		}
		// return $g->getRawSql();
		// return explode('VALUES',$g->getRawSql())[0];
	}
	
	public function actionInsertrr(){
		// return json_encode(['reason' => '$e->getMessage()', 'status' => 'failed']);
        $params = Yii::$app->getRequest()->getBodyParams();
		$noPo = $params['po_num'];
		$items = $params['items'];
		$orgid = '141';
		
		// $masterRrId = Yii::$app->dborafin->createCommand("select (HEADER_INTERFACE_ID) from RCV_HEADERS_INTERFACE where HEADER_INTERFACE_ID like '".date('Ymd')."%' order by HEADER_INTERFACE_ID desc")
			// ->queryOne();
		// $rrid = $masterRrId['HEADER_INTERFACE_ID'];
		// if($rrid == null){
			// $rrid = date('Ymd').sprintf("%03d", 1);
		// }else{
			// $rrid = substr($rrid, -3);
			// $rrid = $rrid + 1;
			// $rrid = date('Ymd').sprintf("%03d", $rrid);
		// }
		
		// $queryOracle = "DECLARE p_group_id NUMBER; BEGIN ";
		// $queryOracle = "DECLARE BEGIN ";
		$queryOracle = "BEGIN IFACE_PO_RCV_H ('$noPo', $orgid); END;";
		
		$procedurePoRcv = Yii::$app->dborafin->createCommand($queryOracle);
		try{
			$procedurePoRcv->execute();
			// return $queryOracle;
			
			// LANJUT KE PROCEDURE ITEM
		}catch (\yii\db\Exception $e){
			return json_encode(['reason' => $e->getMessage(), 'status' => 'failed']);
		}
		
		$queryOracle = "BEGIN ";
		
		$masterRcv = Yii::$app->dborafin->createCommand("select HEADER_INTERFACE_ID, GROUP_ID from RCV_HEADERS_IFACE_X where COMMENTS = '$noPo'")->queryOne();
		$rrid = $masterRcv['HEADER_INTERFACE_ID'];
		$rrTrans = $masterRcv['GROUP_ID'];
		
		$line = 1;
		$err = '';
		$data = '';
		foreach($items as $item){
			$poLineNum 	= $item['item_po_line_num'];
			$rrQty		= $item['item_vol'];
			$rrItemInfo	= $item['item_info'];
			$rrItemName	= $item['item_name'];
			$rrItemId	= $item['item_id'];
			// $rrTrans	= $rrid.sprintf("%03d", $line);
			
			// check quantity
			$command = (new \yii\db\Query())
					->select(['po_quantity_ordered', new \yii\db\Expression('sum(rcv_quantity_received) as totalqtyrr'),])
					->from('orafin_view_mkm_pr_to_pay')
					->andWhere(['po_num' => $noPo])
					->andWhere(['po_line_num' => $poLineNum])
					->groupBy('po_quantity_ordered')
					->createCommand();
			$masterQty = Yii::$app->db->createCommand($command->sql, $command->params)
				->queryOne();
			$remainingQty = $masterQty['po_quantity_ordered'] - $masterQty['totalqtyrr'];
			
			if ($rrQty > $remainingQty && $rrItemInfo == 'nowarning'){
				// stok sisa qty PO tidak memadai untuk dibuat RR
				$err .= "item {$rrItemName} quantity is more than the PO quantity\nBefore continue to the next step, PR additional in oracle must created;\n";
				$data .= $rrItemId.'-'.$remainingQty.';';
			}elseif ($remainingQty > 1 && $rrItemInfo == 'warning'){
				$queryOracle .= "BEGIN IFACE_PO_RCV_L ('$noPo', $orgid, $poLineNum, $remainingQty, $rrid, $rrTrans); END;";
			}elseif ($rrQty <= $remainingQty && $rrItemInfo == 'nowarning'){				
				$queryOracle .= "BEGIN IFACE_PO_RCV_L ('$noPo', $orgid, $poLineNum, $rrQty, $rrid, $rrTrans); END;";
			}
			
			$line++;
		}
		
		if ($err != ''){
			return json_encode(['status' => 'overqty', 'reason' => $data.'@'.$err]);
		}
		
		$queryOracle .= " END;";
		
		$procedurePoRcv = Yii::$app->dborafin->createCommand($queryOracle);
		
		try{
			$procedurePoRcv->execute();
			// return $queryOracle;
			
			return json_encode(['status' => 'Success', 'reason' => $queryOracle]);
		}catch (\yii\db\Exception $e){
			return json_encode(['reason' => $e->getMessage(), 'status' => 'failed']);
		}
	}
	

    public function actionInsertpo()
    {
        // $this->layout = 'blank';
        $params = Yii::$app->getRequest()->getBodyParams();
        $data = [];
        $countItem = count($params['list_item']);
		$firstData = true;
        $idx = 0;
		$boq_plan = substr($params['boq_number'], 9); //(POTONG "PLANNING/" KARENA KETERBATASAN LENGTH DI KOLOM PADA TABEL DI ORAFIN)
		$isCipro = strpos($boq_plan, 'CIPRO');		
		
		// cek data pada PoRequisitionsForo
		$cek = PoRequisitionsForo::find()->andWhere(['interface_source_code' => $boq_plan]);
		if ($cek->one() !== null){
			// punya 1 data permit/material
			$cekcount = $cek->count();
			$countItem = $cekcount + $countItem; // for multiple input
			$firstData = false; // for multiple input
			$permitInput = $cek->andWhere(['item_segment1' => 'WE119-08.100'])->count();
			
			// STOP jika sudah pernah input data sebelumnya
			// kecuali jika kirim permit dan belum pernah input permit, lanjutkan
			if ( $permitInput == 1 ){
				// sudah ada permit, cek kirim permit
				if ( array_search( 'WE119-08.100', array_column($params['list_item'], 'item_code') ) !== false ){
					return json_encode(['status' => 'notfirstdata', 'reason' => 'Has already sent permit before.']);
				}else{
					// bukan kirim permit
					// cek apakah sudah ada material selain permit
					if ( $cek->count() > 1 ){
						return json_encode(['status' => 'notfirstdata', 'reason' => 'Has already sent data before.']);
					}
				}
			}else{
				// belum ada permit (kondisi CIPRO)
				// cek apakah sudah ada material dan bukan kirim permit
				if ( $cek->count() > 0 && ( array_search( 'WE119-08.100', array_column($params['list_item'], 'item_code') ) === false ) ){
					return json_encode(['status' => 'notfirstdata', 'reason' => 'Has already sent data before.']);
				}
			}		
			
			// if ($cekcount > 1 && $isCipro === false){
				// return json_encode(['status' => 'notfirstdata', 'reason' => 'Has already sent data before.']);
			// }else {
				// if ($countItem > 1){
					// // bukan kirim permit
					// return json_encode(['status' => 'notfirstdata', 'reason' => 'Has already sent data before..'. $cekcount]);
				// }else{
					// $cek = $cek->andWhere(['item_segment1' => 'WE119-08.100']);
					// if ($cek->one() !== null){
						// return json_encode(['status' => 'notfirstdata', 'reason' => 'Has already sent permit before.']);
					// }
					
				// }
			// }
		}
		
		// return json_encode(['status' => 'Success']);
		// return json_encode(['reason' => 'sukses oyyy', 'status' => 'asda']);
		
		// CEK EMAIL USER PADA MKM_EMPLOYEE
		$command = (new \yii\db\Query())
                ->select(['USER_NAME', 'PERSON_ID'])
                ->from('MKM_EMPLOYEE')
				->andWhere(['USER_NAME' => strtoupper($params['email'])])
                ->createCommand();
		$masterEmail = Yii::$app->dborafin->createCommand($command->sql, $command->params)
			->queryOne();
		$email 	   = isset($masterEmail['USER_NAME']) ? $masterEmail['USER_NAME'] : '';
		$person_id = isset($masterEmail['PERSON_ID']) ? $masterEmail['PERSON_ID'] : '';
		if ($email == ''){
			$email = 'SITI.FATIMAH@MNCGROUP.COM';
			$person_id = '17039';
		}
		$email_employee = $email;
		
		// DATA HEADER ATTRIBUTE 2 (APPROVAL HIERARCHY)
		// $command = (new \yii\db\Query())
                // ->select(['APPROVAL_HIERARCHY'])
                // ->from('MKM_APPROVAL_HIERARCHY')
				// ->andWhere([''])
                // ->createCommand();
		// $masterApp = Yii::$app->dborafin->createCommand($command->sql, $command->params)
			// ->queryOne();
		// $approval_hierarchy = $masterApp['APPROVAL_HIERARCHY'];
		$approval_hierarchy = 'MKM - PR PROJECT';
		
		
		$tableOrafin = 'PO_REQUISITIONS_INTERFACE_ALL';
		$tableForoOrafin = 'po_requisitions';

        foreach ($params['list_item'] as $key => $value) {
            // GET LOCATION CODE
            // and price (NEW_COST)
			$locationwhere = 'karta';
			$locationwhere = null;
			if($value['item_code'] == 'WE119-08.100'){
				$locationwhere = 'General'; // get MKM General
				$locationwhere = ['like', 'LOCATION', $locationwhere];
				
			}
            $command = (new \yii\db\Query())
                ->select([
					'LOCATION_CODE', 'LOCATION_ID', 
					'NEW_COST', 
					'ITEM_UOM_CODE', 
					'SEGMENT1', 'SEGMENT2', 'SEGMENT3', 
					'SEGMENT4', 'SEGMENT5', 'SEGMENT6',
					'ITEM_DESC',
					'INVENTORY_ITEM_FLAG'
				])
                ->from('MKM_MASTER_ITEM')
				->andWhere(['NOT LIKE', 'LOCATION_CODE', 'Z00'])
                ->andWhere(['ITEM_CODE' => $value['item_code']]);
			if ($locationwhere !== null){
				$command = $command
				->andWhere($locationwhere)
                ->createCommand();
			}else{
				$command = $command->createCommand();
			}
				
            $masterItem = Yii::$app->dborafin->createCommand($command->sql, $command->params)
                ->queryOne();
            $location   = substr($masterItem['LOCATION_CODE'], 0, 3);
            $locationID = $masterItem['LOCATION_ID'];
			$price      = isset($masterItem['NEW_COST'])?$masterItem['NEW_COST']:'';
			if ($price == '')
				$price = 1;
			else
				$price = round($price);
			
			if ($masterItem['INVENTORY_ITEM_FLAG'] == 'N'){
				$destType = 'EXPENSE';
			}else{
				$destType = 'INVENTORY';
			}
			
			$segment1   = $masterItem['SEGMENT1'];			
			$segment2   = $masterItem['SEGMENT2'];			
			$segment3   = $masterItem['SEGMENT3'];
			$segment4   = $masterItem['SEGMENT4'];
			$segment5   = $masterItem['SEGMENT5'];
			$segment6   = $masterItem['SEGMENT6'];
			$uom 	    = substr($masterItem['ITEM_UOM_CODE'], 0, 2);
			// $item_desc  = substr($value['item_note'], 0, 240);
			$item_desc  = $masterItem['ITEM_DESC'];
			$lineatr2   = substr($value['item_note'], 0, 150);

            $data[] = [
                $boq_plan, //'INTERFACE_SOURCE_CODE', // BOQ NUMBER
                'VENDOR', //'SOURCE_TYPE_CODE', //"VENDOR", // HARDCODE
                'PURCHASE', //'REQUISITION_TYPE', //"PURCHASE", // HARDCODE
                $destType, //'DESTINATION_TYPE_CODE',
                $item_desc, //'ITEM_DESCRIPTION', // Note BOQP
                $value['item_vol'], //'QUANTITY',  // VOL MASING-MASING BOQP DETAIL
                $price, // AVG PRICE DI MASTER ITEM ORAFIN
                'INCOMPLETE', //'AUTHORIZATION_STATUS', //"INCOMPLETE", // HARDCODE
                $boq_plan, //'GROUP_CODE', // SAMA DENGAN INTERFACE_SOURCE_CODE
                $person_id, //'PREPARER_ID', // USER ID (Table MKM_EMPLOYEE dari ORAFIN)
                $params['header_description'], //'HEADER_DESCRIPTION', // BOQ NUMBER#REGION#CITY#DIST#SUBDISCT#IDAREA#DIVISI
                '141', //'HEADER_ATTRIBUTE_CATEGORY', //"141", // HARDCODE
                $approval_hierarchy,//'HEADER_ATTRIBUTE2', // Dari tabel ORAFIN (diisi hierarki khusus untuk FORO)
                $email_employee, //'HEADER_ATTRIBUTE5', // EMAIL USER FORO jika tidak ada gunakan DEFAULT (USER_NAME)
                $value['item_code'], //'ITEM_SEGMENT1', //ITEM CODE
                $segment1  , //'CHARGE_ACCOUNT_SEGMENT1', //  dari tabel view master barang ORAFIN
                $segment2  , //'CHARGE_ACCOUNT_SEGMENT2', //  dari tabel view master barang ORAFIN
                $segment3  , //'CHARGE_ACCOUNT_SEGMENT3', //  dari tabel view master barang ORAFIN
                $segment4  , //'CHARGE_ACCOUNT_SEGMENT4', // kosongkan saja
                $segment5  , //'CHARGE_ACCOUNT_SEGMENT5', // TBA
                $segment6  , //'CHARGE_ACCOUNT_SEGMENT6', // TBA
                $uom, //'UOM_CODE', // DARI MASTER ITEM ORAFIN
                $location, //'DESTINATION_ORGANIZATION_CODE', // DARI MASTER ITEM ORAFIN
                $locationID, //'DELIVER_TO_LOCATION_ID', // HARDCODE (TBA :: INFO DARI PAK DWI) (MASIH DUMMY)
                $person_id, //'DELIVER_TO_REQUESTOR_ID', // DARI TABEL MKM_EMPLOYEE SAMA DENGAN KOLOM PREPARER_ID
                'MKM',//'LINE_ATTRIBUTE_CATEGORY', // HARDCODE
                $lineatr2, //'LINE_ATTRIBUTE2', // INFORMASI TAMBAHAN UNTUK ITEM FROM BOQP DETAIL NOTE
                $value['item_code'], //'LINE_ATTRIBUTE3', //ITEM CODE
                $price, // AVG PRICE DARI MASTER ITEM ORAFIN
                'IDR', //'LINE_ATTRIBUTE5', //"IDR", // HARDCODE
                $value['item_vol'], //'LINE_ATTRIBUTE10',  // VOL MASING-MASING BOQP DETAIL
                $params['need_by_date'], //'NEED_BY_DATE', // CREATED DATE
                $params['need_by_date'], //'GL_DATE', // CREATED DATE
                'IDR', //'CURRENCY_CODE', //"IDR", // HARDCODE
                $price, // AVG PRICE FROM MASTER ITEM
                '1', //'RATE', //"1", // HARDCODE
                '141', //'ORG_ID', //"141", // HARDCODE
            ];

        }

        $allColumn = [ 
                'INTERFACE_SOURCE_CODE', // BOQ NUMBER
                'SOURCE_TYPE_CODE', //"VENDOR", // HARDCODE
                'REQUISITION_TYPE', //"VENDOR", // HARDCODE
                'DESTINATION_TYPE_CODE', //"EXPENSE", // HARDCODE
                'ITEM_DESCRIPTION', // NOTE BOQP
                'QUANTITY',  // JUMLAH BOQP DETAIL YANG DIKIRIM
                'UNIT_PRICE', // AVG PRICE DI MASTER ITEM ORAFIN
                'AUTHORIZATION_STATUS', //"INCOMPLETE", // HARDCODE
                'GROUP_CODE', // SAMA DENGAN INTERFACE_SOURCE_CODE
                'PREPARER_ID', // USER ID
                'HEADER_DESCRIPTION', // BOQ NUMBER#REGION#CITY#DIST#SUBDISCT#IDAREA#DIVISI
                'HEADER_ATTRIBUTE_CATEGORY', //"141", // HARDCODE
                'HEADER_ATTRIBUTE2', // DARI TABEL ORAFIN
                'HEADER_ATTRIBUTE5', //YII::$APP->USER->IDENTITY->EMAIL, // EMAIL USER FORO
                'ITEM_SEGMENT1', //ITEM CODE
                'CHARGE_ACCOUNT_SEGMENT1', // TBA
                'CHARGE_ACCOUNT_SEGMENT2', // TBA
                'CHARGE_ACCOUNT_SEGMENT3', // TBA 
                'CHARGE_ACCOUNT_SEGMENT4', // TBA 
                'CHARGE_ACCOUNT_SEGMENT5', // TBA
                'CHARGE_ACCOUNT_SEGMENT6', // TBA
                'UOM_CODE', // DARI MASTER ITEM ORAFIN
                'DESTINATION_ORGANIZATION_CODE', // DARI MASTER ITEM ORAFIN
                'DELIVER_TO_LOCATION_ID', // DARI MASTER ITEM ORAFIN
                'DELIVER_TO_REQUESTOR_ID', // DARI USER BY EMAIL
                'LINE_ATTRIBUTE_CATEGORY', // TBA
                'LINE_ATTRIBUTE2', // INFORMASI TAMBAHAN UNTUK ITEM FROM BOQP DETAIL NOTE
                'LINE_ATTRIBUTE3', //ITEM CODE
                'LINE_ATTRIBUTE4', // AVG PRICE DARI MASTER ITEM ORAFIN
                'LINE_ATTRIBUTE5', //"IDR", // HARDCODE
                'LINE_ATTRIBUTE10',  // JUMLAH ITEM BOQP
                'NEED_BY_DATE', // CREATED DATE
                'GL_DATE', // CREATED DATE
                'CURRENCY_CODE', //"IDR", // HARDCODE
                'CURRENCY_UNIT_PRICE', // AVG PRICE FROM MASTER ITEM
                'RATE', //"1", // HARDCODE
                'ORG_ID', //"141", // HARDCODE
            ];
		
		// return json_encode(['reason' => 'Test: ready to send', 'status' => 'asda']);

        Yii::$app->dborafin->createCommand()->batchInsert($tableOrafin, $allColumn, $data)->execute(); // PROD TO ORAFIN (ALL COLUMN MUST UPPER CASE)
        $allColumn = array_map('strtolower', $allColumn);
		// return json_encode(['reason' => 'Test: ready to send', 'status' => 'asda']);
        Yii::$app->db->createCommand()->batchInsert($tableForoOrafin, $allColumn, $data)->execute();
		Yii::$app->db->createCommand()->update($tableForoOrafin, ['created_date' => date('Y-m-d H:i:s.u'), 'created_by' => $params['userid']], ['interface_source_code' => $boq_plan])
				->execute();
		
		
		// NOT EXECUTED (CAN NOT SEND MULTIPLE TIMES)
		// if(!$firstData){
			// Yii::$app->dborafin->createCommand()->update($tableOrafin, ['LINE_ATTRIBUTE10' => $countItem], ['INTERFACE_SOURCE_CODE' => $boq_plan])
				// ->execute();
			// Yii::$app->db->createCommand()->update($tableForoOrafin, ['line_attribute10' => $countItem], ['interface_source_code' => $boq_plan])
				// ->execute();
		// }
		// NOT EXECUTED (CAN NOT SEND MULTIPLE TIMES)
        return json_encode(['status' => 'Success']);

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

	public function actionUpdateGrf($idGrf){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		
    	$model = GrfOthers::findOne($idGrf);


        if (Yii::$app->request->post()) {
        	$request = Yii::$app->request->post();
        	
        	
        	$model->status_return = $request['status_return'];			
			
			if (!$model->save()){
				return $model->getErrors();
			}else{
				return 'masuk';
			}
			
			
        } else{
        	return array('status'=>'failed');
        }
    }
}
