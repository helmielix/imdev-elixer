<?php

namespace divisisatu\controllers;

use Yii;
use common\models\InboundPo;
use common\models\LogInboundPo;
use common\models\SearchInboundPo;
use common\models\SearchLogInboundPo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;

use common\models\OrafinRr;
use common\models\SearchOrafinRr;
use common\models\OrafinViewMkmPrToPay;
use common\models\MasterItemIm;
use common\models\SearchMasterItemIm;
use common\models\UploadForm;

use common\models\InboundPoDetail;
use common\models\InboundPoDetailSn;
use common\models\SearchInboundPoDetailSn;
use common\models\SearchInboundPoDetail;

/**
 * InboundPoController implements the CRUD actions for InboundPo model.
 */
class InboundPoController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all InboundPo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionIndexlog()
    {
        $searchModel = new SearchLogInboundPo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexapprove()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexdetail()
    {
		$this->layout = 'blank';
		
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail', \Yii::$app->session->get('idInboundPo'));
		$model = $this->findModel(Yii::$app->session->get('idInboundPo'));
		
		//Yii::$app->session->set('rr_number', $model->rr_number);
		// $searchModel = new SearchOrafier();
		// $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,$idOrafinRr);
		
		// $modelOrafin = OrafinRr::find()->where(['=','id',$idOrafinRr])->one();

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			
        ]);
    }
	
	public function actionIndextagsn()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'tagsn');
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexdetailsn()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionGetItemIm() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parent_area = $_POST['depdrop_parents'];
			if ($parent_area != null) {
				$cat_id = $parent_area[0];

				$modelItem = MasterItemIm::find()
                    ->andWhere(['=', 'orafin_code', $cat_id])
                    ->all();

				for($i=0;$i<count($modelItem);$i++) {
					$out[$i]['id'] = $modelItem[$i]->id;
					$out[$i]['name'] = $modelItem[$i]->im_code;
				}

				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetrr() {

		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parent_area = $_POST['depdrop_parents'];
			if ($parent_area != null) {
				$cat_id = $parent_area[0];

				$modelItem = OrafinViewMkmPrToPay::find()
					->select(['distinct(rcv_no)'])
                    ->where(['=', 'po_num', $cat_id])
                    ->all();

				for($i=0;$i<count($modelItem);$i++) {
					$out[$i]['id'] = $modelItem[$i]->rcv_no;
					$out[$i]['name'] = $modelItem[$i]->rcv_no;
				}
				
				// $selected = self::getDefaultSubCat($cat_id);

				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetpr($rrNumber = NULL)
    {
    	// return print_r(Url::base());
		$model = OrafinViewMkmPrToPay::find()
			->where(['=', 'rcv_no', $rrNumber])
			->one();
		
		$arrResult = array(
			'pr_number' => $model->pr_num,
			'supplier' => $model->po_supplier,	
			'rr_date' => $model->rcv_date,
         );

		return json_encode($arrResult);
    }
    /**
     * Displays a single InboundPo model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewsn($id = NULL)
    {

		if($id == NULL){
			$id = \Yii::$app->session->get('idInboundPo');			
		}
		
		if (basename(Yii::$app->request->referrer) != 'indextagsn'){
			throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		}
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPo();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(),'detail_sn', $id);
		
		// if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
		// }
		$model = $this->findModelJoinOrafin($id);
		
		Yii::$app->session->set('idInboundPo',$id);
		
        return $this->render('viewsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionView($id = NULL)
    {
		if($id == NULL){
			$id = \Yii::$app->session->get('idInboundPo');			
		}
		
		// if (basename(Yii::$app->request->referrer) != 'index'){
			// throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPo();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
       $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(),'detail_sn', $id);
		
		// if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
		// }
		$model = $this->findModel($id);
		
		Yii::$app->session->set('idInboundPo',$id);
		
        return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewlog($id)
    {
		$this->layout = 'blank';
        return $this->render('viewlog', [
            'model' => LogInboundPo::find()->where(['idlog'=>$id])->one(),
        ]);
    }
	
	public function actionViewapprove($id = NULL)
    {
		if($id == NULL){
			$id = \Yii::$app->session->get('idInboundPo');			
		}
		
		// if (basename(Yii::$app->request->referrer) != 'index'){
			// throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPo();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
       $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(),'detail_sn', $id);
		
		// if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
		// }
		$model = $this->findModel($id);
		
		Yii::$app->session->set('idInboundPo',$id);
		
        return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewdetailsn($idInboundPoDetail = NULL)
    {
		if($idInboundPoDetail == NULL){
			$idInboundPoDetail = \Yii::$app->session->get('idInboundPoDetail');
			
		}
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPoDetailSn();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(), $idInboundPoDetail);
		
		
		$model = InboundPoDetail::findOne($idInboundPoDetail);
		
		Yii::$app->session->set('idInboundPoDetail',$idInboundPoDetail);
		
        return $this->render('viewdetailsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionApprove($id)
    {  
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if($model->status_listing == 1 ||  $model->status_listing == 2){
            $model->status_listing = 5;
            if ( $model->save()) {
               $this->createLog($model);
               

                    return 'success';
            } else {
                return print_r($model->getErrors());
            }
        }else{
            return 'Not valid for approve';
        }
    }
	
	public function actionRevise($id)
    {  
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
		if(!empty($_POST['InboundPo']['revision_remark'])) {
			if($model->status_listing == 1 || $model->status_listing == 2){
				$model->status_listing = 3;
				$model->revision_remark = $_POST['InboundPo']['revision_remark'];
				if ( $model->save()) {
					$this->createLog($model);
					return 'success';
				} else {
					return print_r($model->getErrors());
				}
			}else{
				return 'Not valid for approve';
			}
			
		}
        
    }
	
	public function actionResetsn($idInboundPoDetail)
    {  		
		$model = InboundPoDetail::findOne($idInboundPoDetail);
		
		$modelMasterItem = MasterItemIm::findOne($model->id_item_im);
		$modelMasterItem->stock_qty = $modelMasterItem->stock_qty - $model->qty;
		$modelMasterItem->save();
		
        InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.$idInboundPoDetail);
		
		
		$modelInbounPO = InboundPo::findOne($model->id_inbound_po);
		\Yii::$app->session->set('idInboundPo', $model->id_inbound_po);
        $model->status_listing = 999;
		$model->save();
		
		$modelInbounPO->status_listing = 5;
		$modelInbounPO->save();

		return 'success';
    }

    /**
     * Creates a new InboundPo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new InboundPo();
		$this->layout = 'blank';
        if ($model->load(Yii::$app->request->post())) {
			$model->rr_number = $_POST['InboundPo']['rr_number'];
			$model->po_number = $_POST['InboundPo']['po_number'];
			$model->tgl_sj = $_POST['InboundPo']['tgl_sj'];
			$model->no_sj = $_POST['InboundPo']['no_sj'];
			
			$modelOrafin = OrafinViewMkmPrToPay::find()
			->where(['=', 'rcv_no', $_POST['InboundPo']['rr_number']])
			->one();
			
			$model->pr_number = $modelOrafin->pr_num;
			$model->supplier = $modelOrafin->po_supplier;
						
			$model->waranty = $_POST['InboundPo']['waranty'];
			$model->id_modul = 1;
			$model->status_listing = 7;
			if($model->save()){
				Yii::$app->session->set('idInboundPo',$model->id);
				Yii::$app->session->set('rrNumber',$model->rr_number);
				$this->createLog($model);
				return 'success';
			}else{
				return print_r($model->getErrors());
			}
        } else {			
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionCreatedetail($orafinCode = NULL, $rrNumber = NULL, $maxQty = NULL)
    {
        $model = new InboundPoDetail();
		$this->layout = 'blank';
		$cek = 1;
		// print_r(\Yii::$app->session->get('orafinCode'));
        if ($model->load(Yii::$app->request->post())) {
        	// return print_r($maxQty);
			$quantities = $_POST['req_good_qty'];
			$imCodes = $_POST['im_code'];
			// $idItems = $_POST['id'];
			$sumQty = 0;
			// return print_r($imCodes);
			foreach($quantities as $key  => $data){
				// return print_r($quantities[$key]);
				$model = new InboundPoDetail();
				$model->id_inbound_po = \Yii::$app->session->get('idInboundPo');
				$model->orafin_code = $orafinCode;
				if($key == 0){
					$sumQty = $quantities[$key];
				}else{
					$sumQty = $sumQty + $quantities[$key];
				}
				
				if($quantities[$key] != NULL){
					$model->qty = $quantities[$key];
					if(!$model->validate()){
						print_r('Data is invalid');
						$cek = 0;
						break;
					}
					if($sumQty > $maxQty){
						print_r('Quantity must not be more than '.$maxQty);
						$cek = 0;
						break;
					}
					$modelItem = MasterItemIm::find()->where(['im_code'=>$imCodes[$key]])->one();
					
					$model->id_item_im = $modelItem->id;
					$model->status_listing = 999;
					if(!$model->save()){
						return print_r($model->getErrors());
					}
				}
			}
			
			$modelInboundOrafin = InboundPo::find()->select(['inbound_po.id as id_inbound_po','orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code'])->join('inner join', 'orafin_view_mkm_pr_to_pay', 'inbound_po.rr_number = orafin_view_mkm_pr_to_pay.rcv_no and inbound_po.po_number = orafin_view_mkm_pr_to_pay.po_num')->asArray()->all();
			$cekStatus = 1;
			foreach($modelInboundOrafin as $key => $value){
				if(!InboundPoDetail::find()->where(['and',['id_inbound_po'=>$value['id_inbound_po']],['orafin_code'=>$value['orafin_code']]])->exists() ){
					$cekStatus++;
				}
				
			}
			if($cekStatus == 1){
				$modelInbound = $this->findModel(\Yii::$app->session->get('idInboundPo'));
				$modelInbound->status_listing = 1;
				$modelInbound->save();
			}
				
			if($cek) return 'success';
		
        } else {
			$searchModel = new SearchMasterItemIm();
			$dataProvider = $searchModel->searchByOrafinCode(Yii::$app->request->post(), $orafinCode);
			$dataProvider->pagination=false;
			$dataProvider->sort=false;
			$modelOrafin = OrafinViewMkmPrToPay::find()->joinWith('orafinmaster')->select([
					'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
					'mkm_master_item.item_desc as orafin_name',
					'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
				])->where(['and',['orafin_view_mkm_pr_to_pay.pr_item_code'=>$orafinCode],['orafin_view_mkm_pr_to_pay.rcv_no'=>$rrNumber]])->one();
				
			$modelIm = MasterItemIm::find()->where(['orafin_code'=>$modelOrafin->orafin_code])->one();
			
            return $this->render('createdetail', [
                'model' => $model,
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'modelOrafin' => $modelOrafin,
				'modelIm' => $modelIm,
            ]);
        }
    }
	
	
	
	public function actionUpdatedetail($idDetail = NULL, $idInboundPo = NULL,$orafinCode = NULL, $rrNumber = NULL, $maxQty = NULL)
    {
        $model = new InboundPoDetail();
		$this->layout = 'blank';
		$cek = 1;
		if($idInboundPo==NULL)$idInboundPo = \Yii::$app->session->get('idInboundPo');
		// print_r(\Yii::$app->session->get('orafinCode'));
        if ($model->load(Yii::$app->request->post())) {
			// return 'stop ini post';
			$quantities = $_POST['req_good_qty'];
			$imCodes = $_POST['im_code'];
			$idItems = $_POST['id_item'];
			$sumQty = 0;
			// return print_r($idInboundPo);
			foreach($quantities as $key  => $data){
				$model = InboundPoDetail::find()->where(['and',['id_inbound_po'=>$idInboundPo],['id_item_im'=>$idItems[$key]]])->one();
				if(isset($model)){
					$model->delete();
				}
			}
			
			foreach($quantities as $key  => $data){
				// return print_r($quantities[$key]);
				$model = new InboundPoDetail();
				$model->id_inbound_po = \Yii::$app->session->get('idInboundPo');
				$model->orafin_code = $orafinCode;
				if($key == 0){
					$sumQty = $quantities[$key];
				}else{
					$sumQty = $sumQty + $quantities[$key];
				}
				
				
				if($quantities[$key] != NULL){
					$model->qty = $quantities[$key];
					if(!$model->validate()){
						print_r('Data is invalid');
						$cek = 0;
						break;
					}
					if($sumQty > $maxQty){
						print_r('Quantity must not be more than '.$maxQty);
						$cek = 0;
						break;
					}
					$modelItem = MasterItemIm::find()->where(['im_code'=>$imCodes[$key]])->one();
					
					$model->id_item_im = $modelItem->id;
					$model->status_listing = 999;
					if(!$model->save()){
						return print_r($model->getErrors());
					}
				}
				
			}
			$modelInboundOrafin = InboundPo::find()->select(['inbound_po.id as id_inbound_po','orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code'])->join('inner join', 'orafin_view_mkm_pr_to_pay', 'inbound_po.rr_number = orafin_view_mkm_pr_to_pay.rcv_no and inbound_po.po_number = orafin_view_mkm_pr_to_pay.po_num')->asArray()->all();
			$cekStatus = 1;
			foreach($modelInboundOrafin as $key => $value){
				if(!InboundPoDetail::find()->where(['and',['id_inbound_po'=>$value['id_inbound_po']],['orafin_code'=>$value['orafin_code']]])->exists() ){
					$cekStatus++;
				}
				
			}
			if($cekStatus == 1){
				$modelInbound = $this->findModel(\Yii::$app->session->get('idInboundPo'));
				$modelInbound->status_listing = 1;
				$modelInbound->save();
			}
			
			if($cek) return 'success';
		
        } else {
			$searchModel = new SearchMasterItemIm();
			$dataProvider = $searchModel->searchByOrafinCode(Yii::$app->request->post(), $orafinCode);
			$dataProvider->pagination=false;
			$dataProvider->sort=false;
			$modelOrafin = OrafinViewMkmPrToPay::find()->joinWith('orafinmaster')->select([
					'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
					'mkm_master_item.item_desc as orafin_name',
					'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
				])->where(['and',['orafin_view_mkm_pr_to_pay.pr_item_code'=>$orafinCode],['orafin_view_mkm_pr_to_pay.rcv_no'=>$rrNumber]])->one();
			
			$modelIm = MasterItemIm::find()->where(['orafin_code'=>$modelOrafin->orafin_code])->one();
				
			$idInboundPos = InboundPoDetail::find()->joinWith('itemIm')
			->select(['inbound_po_detail.qty','inbound_po_detail.id_item_im','master_item_im.im_code'])
			->where(['id_inbound_po'=>$idInboundPo])->asArray()->all();
			
			\Yii::$app->session->set('idInboundPo',$idInboundPo);
			
			$this->setSessionqtydetail($idInboundPos);
			
            return $this->render('createdetail', [
                'model' => $model,
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'modelOrafin' => $modelOrafin,
				'modelIm' => $modelIm,
            ]);
        }
    }
	
	protected function setSessionqtydetail($idInboundPos)
    {		 
        $aray = [];
        foreach ($idInboundPos as $data => $value) {  
		
			$reqQty = $value['qty'];
			$item = $value['id_item_im'];
			$imCode = $value['im_code'];
			
            // save to session
            $aray[$value['im_code']] = [
                $reqQty, $item
            ];
        }
        Yii::$app->session->set('countQty', $aray);
    }
	
	public function actionUploadsn($id = NULL, $idInboundPo = NULL, $qty = NULL) {
        $this->layout = 'blank';
        $model = new UploadForm();

        $model->scenario = 'xls';
		
		if($id != NULL){
			\Yii::$app->session->set('idInboundPoDetail', $id);
		}
		if($idInboundPo != NULL){
			\Yii::$app->session->set('idInboundPo', $idInboundPo);
		}
		if($qty != NULL){
			\Yii::$app->session->set('maxQty', $qty);
		}

        if (isset($_FILES['file']['size'])) {
            if($_FILES['file']['size'] != 0) {
                $filename=('Uploads/'.$_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], 'Uploads/'.basename( $_FILES['file']['name']));
                $datas = \moonland\phpexcel\Excel::import($filename, [
                    'setFirstRecordAsKeys' => true,
                    // 'setIndexSheetByName' => true,
                    // 'getOnlySheet' => 'Sheet1'
                ]);
                if(isset($datas[0][0])){
                    $datas = $datas[0];
                }
                //InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.Yii::$app->session->get('idInboundPoDetail'));
                $row = 2;
                $periksa = "\nplease check on row ";
                $reqCol = [
                	'SERIAL_NUMBER' => '',
                	'MAC_ADDRESS' => '',
                ];
				$maxQty = Yii::$app->session->get('maxQty');
				$cekStatus = 0;
				
                foreach ($datas as $key => $data) {
					if(($key+1) > $maxQty){
						return 'Quantity cannot be more than '. $maxQty;
					}
					
                    // periksa setiap kolom yang wajib ada, hanya di awal row
                    if ($row == 2) {
                    	$missCol = array_diff_key($reqCol,$data);
                    	if (count($missCol) > 0) {
                            InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.Yii::$app->session->get('idInboundPoDetail'));
                    		return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                    	}
                    }
                    $model = new InboundPoDetailSn();

                    $model->id_inbound_po_detail = Yii::$app->session->get('idInboundPoDetail');
                    $model->serial_number = (string)$data['SERIAL_NUMBER'];
                    $model->mac_address = $data['MAC_ADDRESS'];

                    if(!$model->save()) {
                        InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.Yii::$app->session->get('idInboundPoDetail'));
                        $error = $model->getErrors();
                        $error['line'] = [$periksa.$row];
                        return print_r($model->getErrors());
                    }
                    $row++;
					$cekStatus++;
                }
				$modelInboundPoDetail = InboundPoDetail::findOne(Yii::$app->session->get('idInboundPoDetail'));
				$model = InboundPoDetailSn::find()->where(['id_inbound_po_detail'=>Yii::$app->session->get('idInboundPoDetail')])->asArray()->all();
				
				//check max qty
				if($maxQty == count($model)){
					$modelInboundPoDetail->status_listing = 41;
					$modelInboundPoDetail->save();
					
					//Add new stock to master item im
					$modelMasterItem = MasterItemIm::findOne($modelInboundPoDetail->id_item_im);
					$modelMasterItem->stock_qty = $modelMasterItem->stock_qty + $maxQty;
					$modelMasterItem->save();
				}else{
					$modelInboundPoDetail->status_listing = 43;
					$modelInboundPoDetail->save();
				}
                
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				
				
				$modelInboundPoDetail = InboundPoDetail::find()->where(['id_inbound_po'=> Yii::$app->session->get('idInboundPo')])->asArray()->all();
				$cekStatus = 1;
				foreach($modelInboundPoDetail as $key => $value){
					// print_r($value['status_listing']);
					// break;
					if($value['status_listing'] != 41){
						$cekStatus++;
					}
				}
				
				if($cekStatus == 1){
					$modelInbound = $this->findModel(\Yii::$app->session->get('idInboundPo'));
					$modelInbound->status_listing = 42;
					$modelInbound->save();
				}
				
                return 'success';
            }
        }
		// print_r($id);
		
        return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InboundPo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($idInboundPo  = NULL)
    {
        $this->layout = 'blank';
        if($idInboundPo == NULL) $idInboundPo = \Yii::$app->session->get('idInboundPo');

        $model = $this->findModel($idInboundPo);
		
		\Yii::$app->session->set('rrNumber',$model->rr_number);
		\Yii::$app->session->set('idInboundPo',$model->id);
		
		$modelOrafin = OrafinViewMkmPrToPay::find()->where(['and',['po_num'=>$model->po_number],['rcv_no'=>$model->rr_number]])->one();

        if ($model->load(Yii::$app->request->post()) ) {
            if($model->status_listing==3 || $model->status_listing==2){
                $model->status_listing=2;
            }
            if($model->save()) {
                // \Yii::$app->session->set('idInboundPoDetail',$model->id);
				
                // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $this->createLog($model);
                
                return 'success';
            } else {
                return print_r($model->getErrors());
            }

        } else {
			
            
            return $this->render('update', [
                'model' => $model,
                'modelOrafin' => $modelOrafin,
            ]);
        }
    }
	
	

    /**
     * Deletes an existing InboundPo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDeletedetail($id)
    {
		$this->layout = 'blank';
		
        $model = InboundPoDetail::findOne($id)->delete();
		
		$searchModel = new SearchInboundPoDetail();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams, Yii::$app->session->get('idInboundPo'));

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the InboundPo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InboundPo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function createLog($model)
    {
        $modelLog = new LogInboundPo();
        $modelLog->setAttributes($model->attributes);
        // $modelLog->save();
		if(!$modelLog->save()){
			return print_r($modelLog->save());
		}
    }

    protected function findModel($id)
    {
        if (($model = InboundPo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelJoinOrafin($id)
    {
       $model = InboundPo::find()->select(['inbound_po.id as id_inbound_po',
											'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
											'inbound_po.rr_number',
											'inbound_po.po_number',
											'inbound_po.tgl_sj',
											'inbound_po.waranty',
											'orafin_view_mkm_pr_to_pay.pr_num as pr_number',
											'orafin_view_mkm_pr_to_pay.po_supplier as supplier',
											'orafin_view_mkm_pr_to_pay.rcv_date as rr_date',
										])
								->join('inner join', 'orafin_view_mkm_pr_to_pay', 'inbound_po.rr_number = orafin_view_mkm_pr_to_pay.rcv_no and inbound_po.po_number = orafin_view_mkm_pr_to_pay.po_num')->one();
		return $model;
    }
}
