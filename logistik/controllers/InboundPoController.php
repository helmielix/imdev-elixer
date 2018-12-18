<?php

namespace logistik\controllers;

use Yii;
use common\models\InboundPo;
use common\models\LogInboundPo;
use common\models\LogInboundPoDetail;
use common\models\SearchInboundPo;
use common\models\SearchLogInboundPo;
use common\models\SearchLogInboundPoDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\widgets\Email;
use common\widgets\Displayerror;

use common\models\OrafinRr;
use common\models\SearchOrafinRr;
use common\models\OrafinViewMkmPrToPay;
use common\models\MasterItemIm;
use common\models\MasterItemImDetail;
use common\models\SearchMasterItemIm;
use common\models\UploadForm;
use common\models\UserWarehouse;
use common\models\Warehouse;
use common\models\Reference;
use common\models\MasterSn;
use common\models\LogMasterSn;

use common\models\InboundPoDetail;
use common\models\InboundPoDetailSn;
use common\models\SearchInboundPoDetailSn;
use common\models\SearchInboundPoDetail;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Worksheet;

/**
 * InboundPoController implements the CRUD actions for InboundPo model.
 */
class InboundPoController extends Controller
{
	private $last_transaction = 'INBOUND PO';
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

    protected function getIdWarehouse(){
        $arrIdWarehouse = [];
    	if (Yii::$app->user->identity->wh_level == 1 || Yii::$app->user->identity->id == 5){
    		$modelUserWarehouse = Warehouse::find()->select('id as id_warehouse')->asArray()->all();
    	}else{
    		$modelUserWarehouse = UserWarehouse::find()->select('id_warehouse')->where(['id_user'=>Yii::$app->user->identity->id])->asArray()->all();
    	}

        foreach ($modelUserWarehouse as $key => $value) {
        	array_push($arrIdWarehouse, $value['id_warehouse']);
        }

        return $arrIdWarehouse;
    }

    

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
    	$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchLogInboundPo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$arrIdWarehouse);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexverify()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify',null);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexapprove()
    {
    	$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve',null,$arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexoverview()
    {
    	$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'overview',null,$arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexdetail()
    {
		$this->layout = 'blank';
		
        $searchModel = new SearchInboundPo();        
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'indexdetail', \Yii::$app->session->get('idInboundPo'));
		$model = $this->findModel(Yii::$app->session->get('idInboundPo'));
		
		//Yii::$app->session->set('rr_number', $model->rr_number);
		// $searchModel = new SearchOrafier();
		// $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,$idOrafinRr);
		
		// $modelOrafin = OrafinRr::find()->where(['=','id',$idOrafinRr])->one();

        return $this->render('indexdetail', [
        	'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			
        ]);
    }

	public function actionIndextagsn()
    {
    	$arrIdWarehouse = $this->getIdWarehouse();
        $arrSnWarehouse= ArrayHelper::getColumn(UserWarehouse::find()->select(['id_warehouse'])->where(['id_user'=>Yii::$app->user->identity->id])->all(),'id_warehouse');
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'tagsn',null,$arrSnWarehouse);


		
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

				// $modelInbound = InboundPo::find()->select('rr_number')->asArray()->all();	

				$arrInboundRr= ArrayHelper::getColumn( InboundPo::find()->select(['rr_number'])->where(['!=','status_listing',13])->distinct()->all(), 'rr_number');

				// return print_r(json_encode($modelInbound));

				$modelItem = OrafinViewMkmPrToPay::find()
					->select(['distinct(rcv_no)'])
                    ->where(['and',['=', 'po_num', $cat_id],['not in','rcv_no',$arrInboundRr]])
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
		
		// if (basename(Yii::$app->request->referrer) != 'indextagsn'){
		// 	throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPo();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
		
		// if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
		// }
		// return print_r($id);
		$model = $this->findModel($id);
		
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

		// if(Yii::$app->request->isPost){
		// 	return print_r(\Yii::$app->session->get('idInboundPo'));
		// }
		
		$searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(),'detail', $id);
		
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
  //   	if($id == NULL){
		// 	$id = \Yii::$app->session->get('idInboundPo');			
		// }
		
		// if (basename(Yii::$app->request->referrer) != 'index'){
			// throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchLogInboundPo();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
       $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(),'detail_sn', $id);
		
		// if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
		// }
		$model = LogInboundPo::findOne($id);
		
		// Yii::$app->session->set('idInboundPo',$id);
		
        return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,


		// $this->layout = 'blank';

  //       return $this->render('viewlog', [
  //           'model' => LogInboundPo::find()->where(['idlog'=>$id])->one(),
  //           'searchModel' => $searchModel,
  //           'dataProvider' => $dataProvider,
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
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(),'detail', $id);
		
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

    public function actionViewverify($id = NULL)
    {
		if($id == NULL){
			$id = \Yii::$app->session->get('idInboundPo');			
		}
		
		// if (basename(Yii::$app->request->referrer) != 'index'){
			// throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(),'detail', $id);
		
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

    public function actionViewoverview($id)
    {		
    	$id = \Yii::$app->session->get('idInboundPo');			
		// if (basename(Yii::$app->request->referrer) != 'index'){
			// throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(),'detail', $id);
		
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
	
	public function actionViewdetailsn($idInboundPoDetail)
    {
		// if($idInboundPoDetail == NULL){
		// 	$idInboundPoDetail = \Yii::$app->session->get('idInboundPoDetail');
			
		// }
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundPoDetailSn();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams, $idInboundPoDetail);
		
		
		$model = InboundPoDetail::findOne($idInboundPoDetail);
		
		Yii::$app->session->set('idInboundPoDetail',$idInboundPoDetail);
		
        return $this->render('viewdetailsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewqtycond($idInboundPoDetail = NULL)
    {
		if($idInboundPoDetail == NULL){
			$idInboundPoDetail = \Yii::$app->session->get('idInboundPoDetail');			
		}
		$model = InboundPoDetail::findOne($idInboundPoDetail);
		// if (basename(Yii::$app->request->referrer) != 'index'){
			// throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		$searchModel = new SearchInboundPoDetail();
		$dataProvider = $searchModel->searchById(Yii::$app->request->post(), $idInboundPoDetail);

		$idInboundPos = InboundPoDetail::find()->joinWith('itemIm')
		->select(['inbound_po_detail.qty','inbound_po_detail.qty_good','inbound_po_detail.qty_not_good','inbound_po_detail.qty_reject','inbound_po_detail.id_item_im','master_item_im.im_code'])
		->where(['inbound_po_detail.id'=>$idInboundPoDetail])->asArray()->all();
		
		$this->setSessionqtycond($idInboundPos);

        return $this->render('_formqtycond', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionVerify($id){
    	$model = $this->findModel($id);
        if($model->status_listing == 1 ||  $model->status_listing == 2){
        	$model->status_listing = 4;
        	$model->verified_by = Yii::$app->user->identity->id;
        	if($model->save()){

        		$this->createLog($model);
        			$arrAuth = ['/inbound-po/indexapprove'];
	                $header = 'Alert Approval INBOUND PO';
	                $subject = 'This document is waiting your approval. Please click this link document : '.Url::base(true).'/inbound-po/indexapprove#viewapprove?id='.$model->id.'&header=Detail_INBOUND_PO';
	                Email::sendEmail($arrAuth,$header,$subject,$model->id_warehouse);
                return 'success';
        	}
        }
    }
	
	public function actionApprove($id)
    {  
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if($model->status_listing == 4){
            $model->status_listing = 5;
            $model->approved_by = Yii::$app->user->identity->id;
            if ( $model->save()) {
               $this->createLog($model);

               // BELUM ADA SN BARU APPROVE SUMMARY DAN MATERIAL
             //   $modelInbound = InboundPoDetail::find()->joinWith('inboundPoDetailSns',  'RIGHT JOIN')
             //   											->select(['inbound_po_detail_sn.serial_number','inbound_po_detail.id','inbound_po_detail_sn.mac_address'])
             //   											->where(['inbound_po_detail.id_inbound_po'=>$model->id])->all();
             //   $arrayInbound = ArrayHelper::map($modelInbound, 'serial_number','mac_address');
               
           		// $modelInboundPo = InboundPo::findOne($model->id);
             //    foreach ($arrayInbound as $key => $value) {
             //    		// return print_r($value);
             //        	$modelMasterSn = new MasterSn();
             //        	if(MasterSn::find()->where(['serial_number'=>$value])->exists()){
             //        		$modelMasterSn = MasterSn::find()->where(['serial_number'=>$value])->one();
             //        	}

             //        	$modelMasterSn->serial_number = $value;
	            //         $modelMasterSn->mac_address = $data['MAC_ADDRESS'];
	            //         $modelMasterSn->condition = strtolower($data['CONDITION']);
	            //         $modelMasterSn->id_warehouse = $inboundPo->id_warehouse;
	            //         $modelMasterSn->last_transaction = 'TAG SN INBOUND PO'; 
	            //         $modelMasterSn->status = 27; 
	            //         $modelMasterSn->save();
	            //         $this->createLogsn($modelMasterSn);
             //    }
               // BELUM ADA SN BARU APPROVE SUMMARY DAN MATERIAL
               	// return print_r($arrayInbound);
				$arrAuth = ['/inbound-po/indextagsn'];
                $header = 'Tagging SN INBOUND PO';
                $subject = 'This document is ready for tagging SN. Please click this link document : '.Url::base(true).'/inbound-po/indextagsn#viewsn?id='.$model->id.'&header=Detail_Material_Inbound_PO';
                Email::sendEmail($arrAuth,$header,$subject,$model->id_warehouse);
         
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
					$arrAuth = ['/inbound-po/index'];
	                $header = 'Alert Need Revise INBOUND PO';
	                $subject = 'This document is waiting your Revise. Please click this link document : '.Url::base(true).'/inbound-po/index#view?id='.$model->id.'&header=Detail_INBOUND_PO';
	                Email::sendEmail($arrAuth,$header,$subject);
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
        $model->qty_good = 0;
        $model->qty_not_good = 0;
        $model->qty_reject = 0;
		$model->save();
		
		$modelInbounPO->status_listing = 5;
		$modelInbounPO->save();

		return 'success';
    }

    public function actionSubmit($id = NULL)
    {
    	if($id == NULL){
			$id = \Yii::$app->session->get('idInboundPo');			
		}

    	$modelInboundOrafin = InboundPo::find()->select(['inbound_po.id as id_inbound_po','orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code'])->join('inner join', 'orafin_view_mkm_pr_to_pay', 'inbound_po.rr_number = orafin_view_mkm_pr_to_pay.rcv_no and inbound_po.po_number = orafin_view_mkm_pr_to_pay.po_num')->where(['inbound_po.id'=>$id])->asArray()->all();
			$cekStatus = 0;
			foreach($modelInboundOrafin as $key => $value){
				// return print_r($value['id_inbound_po']);
				$modelInbound = InboundPoDetail::find()->select(['SUM(qty) as qty','qty_rr'])->where(['and',['id_inbound_po'=>$value['id_inbound_po']],['orafin_code'=>$value['orafin_code']]])->groupBy(['qty_rr']);
				if(!InboundPoDetail::find()->select(['SUM(qty) as qty','qty_rr'])->where(['and',['id_inbound_po'=>$value['id_inbound_po']],['orafin_code'=>$value['orafin_code']]])->groupBy(['qty_rr'])->exists() || $modelInbound->one()->qty != $modelInbound->one()->qty_rr){
					$cekStatus = 1;
				}

				if(!InboundPoDetail::find()->where(['id_inbound_po'=>$value['id_inbound_po']])->exists()){
					$cekStatus = 2;
				}
			}
			if($cekStatus == 0){
				$modelInbound = $this->findModel($id);
				$sendmail = false;
				if($modelInbound->status_listing == 3){
					$modelInbound->status_listing = 2;
					$sendmail = true;
				}else{
					$modelInbound->status_listing = 1;
					$sendmail = true;
				}
				$modelInbound->save();
				if ($sendmail) {
					//send email to verificator
					$arrAuth = ['/inbound-po/indexverify'];
	                $header = 'Alert Verify INBOUND PO';
	                $subject = 'This document is waiting your verify. Please click this link document : '.Url::base(true).'/inbound-po/indexverify#viewverify?id='.$modelInbound->id.'&header=Verify_INBOUND_PO';
	                Email::sendEmail($arrAuth,$header,$subject);
				}


				$this->createLog($modelInbound);
			}else if($cekStatus == 2){
				$modelInbound = $this->findModel($id);
				$modelInbound->status_listing = 7;
				$modelInbound->save();
				$this->createLog($modelInbound);
			}else{
				$modelInbound = $this->findModel($id);
				$modelInbound->status_listing = 43;
				$modelInbound->save();
				$this->createLog($modelInbound);
			}

			return 'success';
    }

    public function actionSubmitsn()
    {  		
		$model = InboundPoDetail::find()->where(['id_inbound_po'=>\Yii::$app->session->get('idInboundPo')])->asArray()->all();
		$cek = 1;
		$partial = 0;
		foreach ($model as $value) {		 
			$idWarehouse = InboundPo::findOne($value['id_inbound_po']);
			if(MasterItemImDetail::find()->where(['and',['id_master_item_im'=>$value['id_item_im']],['id_warehouse'=>$idWarehouse->id_warehouse]])->exists()){
				$modelMasterItemDetail = MasterItemImDetail::find()->where(['and',['id_master_item_im'=>$value['id_item_im']],['id_warehouse'=>$idWarehouse->id_warehouse]])->one();
			}else{
				$modelMasterItemDetail = new MasterItemImDetail();
			}
			$modelMasterItemDetail->id_master_item_im = $value['id_item_im'];
			$modelMasterItemDetail->id_warehouse = $idWarehouse->id_warehouse;
			$modelMasterItemDetail->s_good = $modelMasterItemDetail->s_good + $value['qty_good'];
			$modelMasterItemDetail->s_not_good = $modelMasterItemDetail->s_not_good + $value['qty_not_good'];
			$modelMasterItemDetail->s_reject = $modelMasterItemDetail->s_reject + $value['qty_reject'];
			if(!$modelMasterItemDetail->save()){
				return print_r($modelMasterItemDetail->getErrors());
			}

			if($value['status_listing'] != 41){
				$cek = 0;
			}

			// rubah status_stock menyatakan data sudah pernah merubah stock
			if ($value['qty_good'] + $value['qty_not_good'] + $value['qty_reject'] > 0) {
				$modelinboundpodetail = InboundPoDetail::findOne($value['id']);
				$modelinboundpodetail->status_stock = 1;
				$modelinboundpodetail->save(false);
				$partial = 1;
			}
		}

		$modelInbound = InboundPo::findOne(\Yii::$app->session->get('idInboundPo'));
		if($cek == 1){
			$modelInbound->status_listing = 42;
			$modelInbound->save();
			$this->createLog($modelInbound);
		}else{
			if ($partial == 1){
				$modelInbound->status_listing = 48; //partially uploaded
			}else{
				$modelInbound->status_listing = 5; //new inbound PO (qty semua detail 0)
			}

			$modelInbound->save();
			$this->createLog($modelInbound);
		}


		return 'success';
    }

    public function actionResetqtycond($idInboundPoDetail)
    {  		
		$model = InboundPoDetail::findOne($idInboundPoDetail);
		
		// $modelMasterItem = MasterItemIm::findOne($model->id_item_im);
		// $modelMasterItem->stock_qty = $modelMasterItem->stock_qty - $model->qty;
		// $modelMasterItem->save();
		
        // InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.$idInboundPoDetail);

		$modelMasterItemDetail = MasterItemImDetail::find();
        // menggunakan variable reference
        $where = ['and', ['id_warehouse' => $model->idInboundPo->id_warehouse], ['id_master_item_im' => &$id_item_im]];
        if ($model->status_stock == 1){
        	$id_item_im = $model->id_item_im;
			$modelstock = $modelMasterItemDetail->andWhere($where)->one();
			$modelstock->s_good	-= $model->qty_good;
			$modelstock->s_not_good	-= $model->qty_not_good;
			$modelstock->s_reject	-= $model->qty_reject;			

			$modelstock->save();
        }
		
		
		$modelInbounPO = InboundPo::findOne($model->id_inbound_po);
		\Yii::$app->session->set('idInboundPo', $model->id_inbound_po);
        $model->status_listing = 999;
        $model->status_stock = 0;
        $model->qty_good = 0;
        $model->qty_not_good = 0;
        $model->qty_reject = 0;
		$model->save();
		
		$modelInbounPO->status_listing = 5;
		$modelInbounPO->save();

		return 'success';
    }

    public function actionQtycond($id = NULL, $idInboundPo = NULL){
    	// return print_r(Yii::$app->request->post());
    	$model = InboundPoDetail::findOne($id);
    	// $modelDetail = InboundPoDetail::findOne($id);
    	$this->layout = 'blank';
    	if (Yii::$app->request->isPost){	
    		$qtyGood = $_POST['qty_good'];
    		$qtyNotGood = $_POST['qty_not_good'];
    		$qtyReject = $_POST['qty_reject'];
    		$qty = $_POST['qty'];

    		// return print_r($qty);

    		if(($qtyGood*1+$qtyNotGood*1+$qtyReject*1) > $qty*1){
    			return 'Quantity cannot be more than '.$qty;
    		}
    		
    		if(($qtyGood*1+$qtyNotGood*1+$qtyReject*1) < $qty*1){
    			$model->status_listing = 43;
    		}else{
    			$model->status_listing = 41;
    		}

    		$model->qty_good = $qtyGood;
    		$model->qty_not_good = $qtyNotGood;
    		$model->qty_reject = $qtyReject;
    		

			if(!$model->save()){
				return print_r($model->getErrors());
			}
			$modelInboundPoDetail = InboundPoDetail::findOne($id);

			$idWarehouse = InboundPo::findOne($modelInboundPoDetail->id_inbound_po);
			// $modelMasterItemDetail->save();

			$modelInboundPoDetail = InboundPoDetail::find()->where(['id_inbound_po'=> $idInboundPo])->asArray()->all();
			$cekStatus = 1;


			foreach($modelInboundPoDetail as $key => $value){
				if($value['status_listing'] != 41){
					$cekStatus++;
				}
			}

			if($cekStatus == 1){
				$modelInbound = $this->findModel($idInboundPo);
				$modelInbound->status_listing = 42;
				$modelInbound->save();
			}

			return 'success';
    	}else{
    		$searchModel = new SearchInboundPoDetail();
			$dataProvider = $searchModel->searchById(Yii::$app->request->post(), $id);
			// return print_r($id);
			$idInboundPos = InboundPoDetail::find()->joinWith('itemIm')
			->select(['inbound_po_detail.qty','inbound_po_detail.qty_good','inbound_po_detail.qty_not_good','inbound_po_detail.qty_reject','inbound_po_detail.id_item_im','master_item_im.im_code'])
			->where(['inbound_po_detail.id'=>$id])->asArray()->all();
			
			$this->setSessionqtycond($idInboundPos);

    		return $this->render('_formqtycond', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
    	}
    }

    protected function setSessionqtycond($idInboundPos)
    {		 
        $aray = [];
        foreach ($idInboundPos as $value) {  
			// print_r($value['qty_good']);
			// break;
			$reqQty = $value['qty'];
			$reqQtyGood = $value['qty_good'];
			$reqQtyNotGood = $value['qty_not_good'];
			$reqQtyReject = $value['qty_reject'];
			$item = $value['id_item_im'];
			$imCode = $value['im_code'];
			
            // save to session
            $aray[$value['im_code']] = [
                $reqQtyGood,$reqQtyNotGood,$reqQtyReject, $item
            ];
        }
        Yii::$app->session->set('countQtycond', $aray);

        // return print_r(json_encode($aray));
    }

    /**
     * Creates a new InboundPo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new InboundPo();
        $model->scenario = 'create';
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
			$model->id_warehouse = $_POST['InboundPo']['id_warehouse'];
			$model->id_modul = 1;
			$model->status_listing = 7;

			if (isset($_FILES['file'])) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$model->file = $_FILES['file'];
						$filename = $_FILES['file']['name'];
						$filepath = 'uploads/INDPO/';
					}
				}
			}
						

			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			$model->file_attachment = $filepath.$model->id.'/'.$filename;
			$model->save();
			
			Yii::$app->session->set('idInstWhTr', $model->id);
			
			if (!file_exists($filepath.$model->id.'/')) {
				mkdir($filepath.$model->id.'/', 0777, true);
			}
			move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);

			if($model->save()){
				Yii::$app->session->set('idInboundPo',$model->id);
				Yii::$app->session->set('rrNumber',$model->rr_number);
				// $this->createLog($model);
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

        // if ($model->load(Yii::$app->request->post())) {
        if (Yii::$app->request->isPost) {
        	// return print_r($maxQty);
        	
			$quantities = $_POST['req_good_qty'];
			$imCodes = $_POST['im_code'];
			// $idItems = $_POST['id'];
			$sumQty = 0;
			// return print_r($imCodes);
			foreach($quantities as $key  => $data){
				if($quantities[$key] == '' && $quantities[$key] == 0){
					continue;
				}
				

				// return print_r($quantities[$key]);
				$model = new InboundPoDetail();
				$model->id_inbound_po = \Yii::$app->session->get('idInboundPo');
				$model->orafin_code = $orafinCode;
				$model->qty_rr = $maxQty;
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
					$this->createLogDetail($model);
				}
			}
			 
				
			if($cek) return 'success';
			
		
        } else {
        	// return ($rrNumber.' rrNumber');

        	$modelInbound = InboundPo::findOne(\Yii::$app->session->get('idInboundPo'));

			$searchModel = new SearchMasterItemIm();
			$dataProvider = $searchModel->searchByOrafinCode(Yii::$app->request->queryParams, $orafinCode, $modelInbound->id_warehouse);
			$dataProvider->pagination=false;
			$dataProvider->sort=false;
			$modelOrafin = OrafinViewMkmPrToPay::find()->joinWith('orafinmaster')->select([
					'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
					'mkm_master_item.item_desc as orafin_name',
					'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
					'orafin_view_mkm_pr_to_pay.rcv_no as rr_number',
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
        if (Yii::$app->request->isPost) {
			// return 'stop ini post';
			$quantities = $_POST['req_good_qty'];
			$imCodes = $_POST['im_code'];
			$idItems = $_POST['id_item'];
			$sumQty = 0;
			// return print_r($idInboundPo);
			// foreach($quantities as $key  => $data){
			// 	$model = InboundPoDetail::find()->where(['and',['id_inbound_po'=>$idInboundPo],['id_item_im'=>$idItems[$key]]])->one();
			// 	if(isset($model)){
			// 		$model->delete();
			// 	}
			// }

			InboundPoDetail::deleteAll('id_inbound_po = :id_inbound_po AND orafin_code = :orafin_code', [':id_inbound_po' => $idInboundPo, ':orafin_code' => $orafinCode]);
			
			foreach($quantities as $key  => $data){
				if($key == '' && $key == 0){
					continue;
				}
				// return print_r($quantities[$key]);
				$model = new InboundPoDetail();
				$model->id_inbound_po = \Yii::$app->session->get('idInboundPo');
				$model->orafin_code = $orafinCode;
				$model->qty_rr = $maxQty;
				if($key == 0){
					$sumQty = '';
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
			// $this->createLog($modelInbound);
			
			if($cek) return 'success';
		
        } else {
        	$modelInbound = InboundPo::findOne(\Yii::$app->session->get('idInboundPo'));
			$searchModel = new SearchMasterItemIm();
			$dataProvider = $searchModel->searchByOrafinCode(Yii::$app->request->queryParams, $orafinCode, $modelInbound->id_warehouse);
			$dataProvider->pagination=false;
			$dataProvider->sort=false;
			$modelOrafin = OrafinViewMkmPrToPay::find()->joinWith('orafinmaster')->select([
					'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
					'mkm_master_item.item_desc as orafin_name',
					'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
					'orafin_view_mkm_pr_to_pay.rcv_no as rr_number',
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

    private function listView($idInboundPo = NULL,$orafinCode = NULL, $rrNumber = NULL)
    {
    	$model = new InboundPoDetail();
        $modelInbound = InboundPo::findOne(\Yii::$app->session->get('idInboundPo'));
		$searchModel = new SearchInboundPoDetail();
        $dataProvider = $searchModel->searchByIdInbound(Yii::$app->request->getQueryParams(),$idInboundPo, $orafinCode);

		$modelOrafin = OrafinViewMkmPrToPay::find()->joinWith('orafinmaster')->select([
				'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
				'mkm_master_item.item_desc as orafin_name',
				'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
			])->where(['and',['orafin_view_mkm_pr_to_pay.pr_item_code'=>$orafinCode],['orafin_view_mkm_pr_to_pay.rcv_no'=>$rrNumber]])->one();
		
		$modelIm = MasterItemIm::find()->where(['orafin_code'=>$modelOrafin->orafin_code])->one();

        return [
            'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'modelOrafin' => $modelOrafin,
			'modelIm' => $modelIm,
			'idInboundPo' => $idInboundPo,
    	];
    }

    public function actionViewdetail($idDetail = NULL, $idInboundPo = NULL,$orafinCode = NULL, $rrNumber = NULL, $maxQty = NULL)
    {

		$this->layout = 'blank';
		
		if($idInboundPo==NULL)$idInboundPo = \Yii::$app->session->get('idInboundPo');
		// print_r(\Yii::$app->session->get('idInboundPo'));
        return $this->render('viewdetail', $this->listView($idInboundPo,$orafinCode,$rrNumber));
            
        
    }

    public function actionViewdetailverify($idDetail = NULL, $idInboundPo = NULL,$orafinCode = NULL, $rrNumber = NULL, $maxQty = NULL)
    {

		$this->layout = 'blank';
		
		if($idInboundPo==NULL)$idInboundPo = \Yii::$app->session->get('idInboundPo');
		// print_r(\Yii::$app->session->get('idInboundPo'));
        return $this->render('viewdetail', $this->listView($idInboundPo,$orafinCode,$rrNumber));
            
        
    }

    public function actionViewdetailapprove($idDetail = NULL, $idInboundPo = NULL,$orafinCode = NULL, $rrNumber = NULL, $maxQty = NULL)
    {

		$this->layout = 'blank';
		
		if($idInboundPo==NULL)$idInboundPo = \Yii::$app->session->get('idInboundPo');
		// print_r(\Yii::$app->session->get('idInboundPo'));
        return $this->render('viewdetail', $this->listView($idInboundPo,$orafinCode,$rrNumber));
            
        
    }

    public function actionViewdetailoverview($idDetail = NULL, $idInboundPo = NULL,$orafinCode = NULL, $rrNumber = NULL, $maxQty = NULL)
    {

		$this->layout = 'blank';
		
		if($idInboundPo==NULL)$idInboundPo = \Yii::$app->session->get('idInboundPo');
		// print_r(\Yii::$app->session->get('idInboundPo'));
        return $this->render('viewdetail', $this->listView($idInboundPo,$orafinCode,$rrNumber));
            
        
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
                $filename=('uploads/'.$_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.basename( $_FILES['file']['name']));
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
                	'CONDITION' => '',
                ];
				$maxQty = Yii::$app->session->get('maxQty');
				$cekStatus = 0;

				$modelSn = InboundPoDetailSn::find()->andWhere(['id_inbound_po_detail' => $id]);
				$qtyGood 			= $modelSn->andWhere(['condition' => 'Good'])->count();
				$qtyNotGood 		= $modelSn->andWhere(['condition' => 'Not Good'])->count();
				$qtyReject 			= $modelSn->andWhere(['condition' => 'Reject'])->count();

				$modelInboundPoDetail = InboundPoDetail::findOne(Yii::$app->session->get('idInboundPoDetail'));
				
                foreach ($datas as $key => $data) {
					// if(($key+1) > $maxQty){
					// 	return 'Quantity cannot be more than '. $maxQty;
					// }
					
                    // periksa setiap kolom yang wajib ada, hanya di awal row
                    if ($row == 2) {
                    	$missCol = array_diff_key($reqCol,$data);
                    	if (count($missCol) > 0) {
                            InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.Yii::$app->session->get('idInboundPoDetail'));
                    		return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                    	}
                    }
                    if ($data['SERIAL_NUMBER'] == '' && $data['MAC_ADDRESS'] == '' && $data['CONDITION'] == '' ){
						continue;
					}
                    $model = new InboundPoDetailSn();

                    $model->id_inbound_po_detail = Yii::$app->session->get('idInboundPoDetail');
                    $model->serial_number = (string)$data['SERIAL_NUMBER'];
                    $model->mac_address = $data['MAC_ADDRESS'];
                    $model->condition = strtolower($data['CONDITION']);
                    // $model->last_transaction = 'TAG SN INBOUND PO';

                    switch($model->condition){
							case 'good':
								$qtyGood++;
							break;
							case 'not good':
								$qtyNotGood++;
							break;
							case 'reject':
								$qtyReject++;
							break;
						}

						$maxErr = '';
						if ($qtyGood > $maxQty){
							$maxErr = 'Quantity Good cannot be more than '. $maxQty;
						}
						
						if ($qtyNotGood > $maxQty){
							$maxErr = 'Quantity Not Good cannot be more than '. $maxQty;
						}
						
						if ($qtyReject > $maxQty){
							$maxErr = 'Quantity Reject cannot be more than '. $maxQty;
						}

						$idInboundPoDetail = Yii::$app->session->get('idInboundPoDetail');
						
						if ($maxErr != ''){
							InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.$idInboundPoDetail);
							return $maxErr;
						}

						

                    if(!$model->save()) {
                        InboundPoDetailSn::deleteAll('id_inbound_po_detail = '.$idInboundPoDetail);
                        $error = $model->getErrors();
                        $error['line'] = [$periksa.$row];
                        return Displayerror::pesan($model->getErrors());
                        return print_r($model->getErrors());
                    }else{
                    	$inboundPo = InboundPo::findOne($modelInboundPoDetail->id_inbound_po);

                    	$modelMasterSn = new MasterSn();
                    	if(MasterSn::find()->where(['serial_number'=>(string)$data['SERIAL_NUMBER']])->exists()){
                    		$modelMasterSn = MasterSn::find()->where(['serial_number'=>(string)$data['SERIAL_NUMBER']])->one();
                    	}

                    	$modelMasterSn->serial_number = (string)$data['SERIAL_NUMBER'];
	                    $modelMasterSn->mac_address = $data['MAC_ADDRESS'];
	                    $modelMasterSn->condition = strtolower($data['CONDITION']);
	                    $modelMasterSn->id_warehouse = $inboundPo->id_warehouse;
	                    $modelMasterSn->last_transaction = 'TAG SN INBOUND PO'; 
	                    $modelMasterSn->status = 27; 
	                    $modelMasterSn->save();
	                    $this->createLogsn($modelMasterSn);


                    }                    
                    $row++;
					// $cekStatus++;
                }

				
				$modelInboundPoDetail->qty_good = $qtyGood;
				$modelInboundPoDetail->qty_not_good = $qtyNotGood;
				$modelInboundPoDetail->qty_reject = $qtyReject;

				$model = InboundPoDetailSn::find()->where(['id_inbound_po_detail'=>$modelInboundPoDetail->id])->asArray()->all();
				//check max qty
				$idWarehouse = InboundPo::findOne($modelInboundPoDetail->id_inbound_po);

				// $modelMasterItem = MasterItemIm::findOne($modelInboundPoDetail->id_item_im);
				// if(MasterItemImDetail::find()->where(['and',['id_master_item_im'=>$modelMasterItem->id],['id_warehouse'=>$idWarehouse->id_warehouse]])->exists())
				// {
				// 	$modelMasterItemIm = MasterItemImDetail::find()->where(['and',['id_master_item_im'=>$modelMasterItem->id],['id_warehouse'=>$idWarehouse->id_warehouse]])->one();
					
				// }else{
				// 	$modelMasterItemIm = new MasterItemImDetail();
				// }

				// $modelMasterItemIm->id_item_im = $modelMasterItem->id;
				// $modelMasterItemIm->s_good = $modelMasterItemIm->s_good + $qtyGood;
				// $modelMasterItemIm->s_not_good = $modelMasterItemIm->s_not_good + $qtyNotGood;
				// $modelMasterItemIm->s_reject = $modelMasterItemIm->s_reject + $qtyReject;
				// $modelMasterItemIm->save();

				// return print_r(count($model));
				if($maxQty == count($model)){
					$modelInboundPoDetail->status_listing = 41;
					$modelInboundPoDetail->save();


					// $modelMasterItemDetail = '';
					// if(MasterItemImDetail::find()->where(['and',['id_master_item_im'=>$modelInboundPoDetail->id_item_im],['id_warehouse'=>$idWarehouse->id_warehouse]])->exists()){
					// 	// return print_r('expression');
					// 	$modelMasterItemDetail = MasterItemImDetail::find()->where(['and',['id_master_item_im'=>$modelInboundPoDetail->id_item_im],['id_warehouse'=>$idWarehouse->id_warehouse]])->one();
					// }else{
					// 	$modelMasterItemDetail = new MasterItemImDetail();
					// }
					
					//Add new stock to master item im
					
					// $modelMasterItemDetail->s_good = $modelMasterItemDetail->s_good + $qtyGood;
					// $modelMasterItemDetail->s_not_good = $modelMasterItemDetail->s_not_good + $qtyNotGood;
					// $modelMasterItemDetail->s_reject = $modelMasterItemDetail->s_reject + $qtyReject;
					// $modelMasterItemDetail->save();
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
		\Yii::$app->session->remove('idInboundPo');
		\Yii::$app->session->set('idInboundPo',$model->id);
		
		$modelOrafin = OrafinViewMkmPrToPay::find()->where(['and',['po_num'=>$model->po_number],['rcv_no'=>$model->rr_number]])->one();

        if ($model->load(Yii::$app->request->post()) ) {
            // if($model->status_listing==3 || $model->status_listing==2){
            //     $model->status_listing=2;
            // }
            if($model->save()) {
                // \Yii::$app->session->set('idInboundPo',$model->id);
				
                // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // $this->createLog($model);
					// $arrAuth = ['/inbound-po/indexverify'];
	    //             $header = 'Alert Verify INBOUND PO di update';
	    //             $subject = 'This document is waiting your verify. Please click this link document : '.Url::base(true).'/inbound-po/indexverify#viewverify?id='.$model->id.'&header=Verify_INBOUND_PO';
	    //             Email::sendEmail($arrAuth,$header,$subject);
                
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
        $model = $this->findModel($id);
        $model->status_listing = 13;
        if($model->save()){
        	$this->createLog($model);
        }

        return 'success';
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

    public function actionDownloadfile($id, $relation = ''){
		if ($id == 'template' || $id == 'templatemac'){
			$file = Yii::getAlias('@webroot') . '/uploads/TemplateInputSN.xlsx';
			$fileOut7 = Yii::getAlias('@webroot') . '/uploads/TemplateInputSN.xlsx';
			if (file_exists($file)) {
				// modify file before download
                $objPHPExcel = new \PHPExcel();
                $excel2 = \PHPExcel_IOFactory::createReader('Excel2007');
                $excel2 = $excel2->load($file);
				
				$excel2->setActiveSheetIndex(1);
                $modelCondition = Reference::find()->andWhere(['table_relation' => ['good_type', 'dismantle_type']])->orderBy('id_grouping asc')->all();
                if ($modelCondition !== null) {
                    $col = 1; //col B (index 0) (position)
                    $row = 2;
                    foreach ($modelCondition  as $key => $value) {
                        $excel2->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $modelCondition[$key]->description);
                        $rowpos = $row;
                        $row++;
                    }
                }
				
				$valRow = 2500;
				$excel2->setActiveSheetIndex(0);
				
				// hide mac address column
				if ($id == 'template'){
					$excel2->getActiveSheet()->getColumnDimension('B')->setVisible(false);
				}else{
					$excel2->getActiveSheet()->getColumnDimension('B')->setVisible(true);
				}
				
				// CONDITION
                $objValidation = $excel2->getActiveSheet()->getCell('C2')->getDataValidation();
                $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
                $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setFormula1('=Sheet2!$B$2:$B$'.$rowpos);
                for ($i=3; $i <= $valRow; $i++) {
                    $excel2->getActiveSheet()->getCell("C$i")->setDataValidation(clone $objValidation);
                }
                // CONDITION
				
				$excel2->getSheetByName('Sheet2')
                    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
					
				$objWriter = \PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
                $objWriter->save($fileOut7);
                return Yii::$app->response->sendFile($fileOut7);
			}else {
				// return $file;
                // throw new NotFoundHttpException('The requested page does not exist.');
            }
		}else if ($id == 'instruction'){
			$file = Yii::getAlias('@webroot') . '/uploads/TemplateInputSN.xlsx';
			
			if (file_exists($file)) {
				return Yii::$app->response->sendFile($file);
			}else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
		}
		
		$request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
		
		// if ($relation == 'instruction'){
			$model = InboundPo::findOne($id);
			$basepath = Yii::getAlias('@webroot') . '/';
			$path = ArrayHelper::getValue($model, $params['data'], 'Unknown');
		// }
		
		$file = $basepath.$path;
		
		if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
        // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        // $modelLog->id = $model->id;
        // $modelLog->id_modul = $model->id_modul;
        // $modelLog->rr_number = $model->rr_number;
        // $modelLog->no_sj = $model->no_sj;
        // $modelLog->tgl_sj = $model->tgl_sj;
        // $modelLog->waranty = $model->waranty;
        // $modelLog->no_sj = $model->tgl_sj;
        // $modelLog->po_number = $model->po_number;
        // $modelLog->supplier = $model->supplier;
        // $modelLog->pr_number = $model->pr_number;
        // $modelLog->revision_remark = $model->revision_remark;
        // $modelLog->save();
		if(!$modelLog->save()){
			return print_r($modelLog->save());
		}
    }

    public function createLogDetail($model)
    {
    	$modelLog = new LogInboundPoDetail();
        $modelLog->setAttributes($model->attributes);
        // $modelLog->idlog_inbound_po = $modelLog->id;
        // $modelLog->status = $model->status;
		if(!$modelLog->save()){
			return print_r($modelLog->save());
		}
    }

    public function createLogSn($model)
    {
    	$modelLog = new LogMasterSn();
        $modelLog->setAttributes($model->attributes);
        $modelLog->id = $model->id;
        $modelLog->status = $model->status;
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
											'inbound_po.no_sj',
											'inbound_po.waranty',
											'inbound_po.id_warehouse',
											'inbound_po.created_by',
											'inbound_po.verified_by',
											'inbound_po.approved_by',
											'orafin_view_mkm_pr_to_pay.pr_num as pr_number',
											'orafin_view_mkm_pr_to_pay.po_supplier as supplier',
											'orafin_view_mkm_pr_to_pay.rcv_date as rr_date',
										])
								->join('inner join', 'orafin_view_mkm_pr_to_pay', 'inbound_po.rr_number = orafin_view_mkm_pr_to_pay.rcv_no and inbound_po.po_number = orafin_view_mkm_pr_to_pay.po_num')->one();
		return $model;
    }
    private function createLogmastersn($model){
		$modelLog = new LogMasterSn();
        $modelLog->setAttributes($model->attributes);
		if(!$modelLog->save()){
			throw new NotFoundHttpException(Displayerror::pesan($modelLog->getErrors()));
			return Displayerror::pesan($modelLog->getErrors());
		}
		
	}
}
