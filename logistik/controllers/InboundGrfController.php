<?php

namespace logistik\controllers;

use Yii;
use common\models\Grf;
use common\models\InboundGrf;
use common\models\OutboundGrf;
use common\models\InboundGrfDetail;
use common\models\GrfDetail;
use common\models\SearchInboundGrf;
use common\models\SearchOutboundGrfDetail;
use common\models\SearchInboundGrfDetail;
use common\models\SearchInboundGrfDetailSn;
use common\models\SearchGrfDetail;
use common\models\SearchGrf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Displayerror;
use common\models\OrafinRr;
use common\models\SearchOrafinRr;
use common\models\OrafinViewMkmPrToPay;
use common\models\MasterItemIm;
use common\models\MasterItemImDetail;
use common\models\SearchMasterItemIm;
use yii\helpers\ArrayHelper;
use common\models\UserWarehouse;
use common\models\Warehouse;

/**
 * InboundGrfController implements the CRUD actions for InboundGrf model.
 */
class InboundGrfController extends Controller
{
    /**
     * @inheritdoc
     */
    private $id_modul = 1;
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
     * Lists all InboundGrf models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'ikr');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexreg()
    {
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'regikr');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexdetail(){

		$this->layout = 'blank';
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idInboundGrf'));

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    public function actionIndexgrfdetail(){

        $this->layout = 'blank';
        $searchModel = new SearchInboundGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idInboundGrf'));

        return $this->render('indexgrfdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexapprove(){
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexasset(){
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'asset');

        return $this->render('indexasset', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexsn(){
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'sn');

        return $this->render('indexsn', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
      public function actionIndexoverview(){
        // $arrIdWarehouse = $this->getIdWarehouse();
        $arrIdWarehouse = [];
        if (Yii::$app->user->identity->id == 5) {
            $arrIdWarehouse = ArrayHelper::getColumn(Warehouse::find()->all(),'id');
        }else{
            $modelUserWarehouse = UserWarehouse::find()->select('id_warehouse')->where(['id_user'=>Yii::$app->user->identity->id])->asArray()->all();
            foreach ($modelUserWarehouse as $key => $value) {
                array_push($arrIdWarehouse, $value['id_warehouse']);
            }
        }

        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'overview', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexregoverview(){
        // $arrIdWarehouse = $this->getIdWarehouse();
        $arrIdWarehouse = [];
        if (Yii::$app->user->identity->id == 5) {
            $arrIdWarehouse = ArrayHelper::getColumn(Warehouse::find()->all(),'id');
        }else{
            $modelUserWarehouse = UserWarehouse::find()->select('id_warehouse')->where(['id_user'=>Yii::$app->user->identity->id])->asArray()->all();
            foreach ($modelUserWarehouse as $key => $value) {
                array_push($arrIdWarehouse, $value['id_warehouse']);
            }
        }

        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'regoverview', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function detailView($id)
    {		
		$model = $this->findModel($id);
		
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		// Yii::$app->session->set('idGrf', $model->id);
		
        return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionViewsn($id )
    {

      
        $this->layout = 'blank';
        Yii::$app->session->set('idGrf', $id);
        return $this->render('viewsn', $this->detailView($id));
    }



    /**
     * Displays a single InboundGrf model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->layout = 'blank';
        Yii::$app->session->set('idGrf', $id);
        return $this->render('view', $this->detailView($id));
    }

    public function actionViewapprove($id){
		$this->layout = 'blank';
		return $this->render('viewapprove', $this->detailView($id));
	}

    public function actionViewoutbound($id){
        $this->layout = 'blank';
        $model = OutboundGrf::findOne($id);
        
        $searchModel = new SearchOutboundGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
        
        return $this->render('//outbound-grf/view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new InboundGrf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate($id , $act = null)
    {
        $this->layout = 'blank';
        if ($act == 'view'){
            // create OutboundGrf
            $modelOutbound = OutboundGrf::findOne($id_instruction_grf);
            // return print_r($modelOutbound->id_instruction_grf);// $modelGrf = Grf::findOne($id);
            $model = new InboundboundGrf();
            
            $model->id = $modelOutbound->id_instruction_grf;
            $model->status_listing = 43; // Partially Uploaded
            $model->id_modul = $this->id_modul;
            $model->grf_type = $modelOutbound->grf_type;
            $model->id_division = $modelOutbound->id_division;
            $model->id_region = $modelOutbound->id_region;
            $model->pic = $modelOutbound->pic;
            $model->grf_number = $modelOutbound->grf_number;
            $model->wo_number = $modelOutbound->wo_number;
            $model->file_attachment_1 = $modelOutbound->file_attachment_1;
            $model->file_attachment_2 = $modelOutbound->file_attachment_2;
            $model->purpose = $modelOutbound->purpose;
            $model->requestor = $modelOutbound->requestor;
            $model->wo_number = $modelOutbound->wo_number;
            $model->note = $modelOutbound->note;
            $model->id_modul = $modelOutbound->id_modul;
            $model->id_warehouse = $modelOutbound->id_warehouse;
            $model->incoming_date = $modelOutbound->incoming_date;
            $model->date_of_return = $modelOutbound->date_of_return;

            // if(!$model->save()){
            //    $error = $model->getErrors();
            //         $model->delete();
            //         return Displayerror::pesan($error);
            // };


            // echo $model->wo_number;
            $model->save();
            
            // create OutboundGrfDetail
            $modelInstructionDetail = InstructionGrfDetail::find()->andWhere(['id_instruction_grf' => $id])->all();
            foreach($modelInstructionDetail as $value){
                $modelDetail = new OutboundGrfDetail();
                
                $modelDetail->id_outbound_grf       = $value->id_instruction_grf;
                $modelDetail->id_item_im            = $value->id_item_im;             
                $modelDetail->qty_good              = $value->qty_good;
                $modelDetail->qty_noot_good          = $value->qty_noot_good;
                $modelDetail->qty_reject            = $value->qty_reject;
                $modelDetail->qty_dismantle_good    = $value->qty_dismantle_good;
                $modelDetail->qty_dismantle_ng      = $value->qty_dismantle_ng;
                $modelDetail->qty_good_rec      = $value->qty_good_rec;
                $modelDetail->status_listing        = ($value->idMasterItemImDetail->idMasterItemIm->sn_type == 1) ? 999 : 41;
                
                
                if (!$modelDetail->save()){
                    $error = $modelDetail->getErrors();
                    $model->delete();
                    return Displayerror::pesan($error);
                }
            }
            
        }
        
        $model = $this->findModel($id);
        
        $searchModel = new SearchOutboundGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);
                
        Yii::$app->session->set('idInboundGrf', $id);

        return $this->render('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    /**
     * Updates an existing OutboundGrf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

   public function actionCreatedetail($orafinCode = NULL){
		$this->layout = 'blank';
		$id = Yii::$app->session->get('idGrf');		
		
		if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){
			
			$data_im_code       = Yii::$app->request->post('im_code');
			$data_qty_good        = Yii::$app->request->post('qtygood');
			$data_qty_noot_good     = Yii::$app->request->post('qtynootgood');
			$data_qty_reject      = Yii::$app->request->post('qtyreject');
			$data_qty_dismantle_good   = Yii::$app->request->post('qtydismantlegood');
			$data_qty_dismantle_ng    = Yii::$app->request->post('qtydismantleng');
			$data_qty_good_rec    = Yii::$app->request->post('qtygoodrec');
	// 		$data_r_notgood_dis = Yii::$app->request->post('rnotgooddismantle');
			
			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}
			
			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_qty_good[$key] == '' && $data_qty_noot_good[$key] == '' && $data_qty_reject[$key] == '' && $data_qty_good[$key] == 0 && $data_qty_noot_good[$key] == 0 && $data_qty_reject[$key] == 0 && $data_qty_dismantle_good[$key] == '' && $data_qty_dismantle_ng[$key] == ''&& $data_qty_good_rec[$key] == ''){
					continue;
				}
				$values = explode(';',$value);
			
				$model = new InboundGrfDetail();
				$model->id_inbound_grf			= $id;
                // $model->status_listing = 43;
				$model->id_item_im				= $values[0];
				$model->qty_good				= ($data_qty_good[$key] == '') ? 0 : $data_qty_good[$key];
				$model->qty_noot_good			= ($data_qty_noot_good[$key] == '') ? 0 : $data_qty_noot_good[$key];
				$model->qty_reject				= ($data_qty_reject[$key] == '') ? 0 : $data_qty_reject[$key];
				$model->qty_dismantle_good		= ($data_qty_dismantle_good[$key] == '') ? 0 : $data_qty_dismantle_good[$key];
				$model->qty_dismantle_ng		= ($data_qty_dismantle_ng[$key] == '') ? 0 : $data_qty_dismantle_ng[$key];
				$model->qty_good_rec		= ($data_qty_good_rec[$key] == '') ? 0 : $data_qty_good_rec[$key];
                //semuanya tidak boleh lebih dari qty_request
				// $modelGrfDetailSum			= $qty_good + $qty_noot_good + $qty_reject + $qty_dismantle_good +
				// 							  $qty_dismantle_ng + $qty_good_rec;
				
				$modelMasterItem = MasterItemImDetail::findOne($values[0]);
                $overStock = 1;
                $pesan = [];
                if($model->qty_good > $modelMasterItem->s_good){
                    $pesan[] = $model->getAttributeLabel('qty_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($model->qty_noot_good > $modelMasterItem->s_not_good){
                    $pesan[] = $model->getAttributeLabel('qty_noot_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($model->qty_reject > $modelMasterItem->s_reject){
                    $pesan[] = $model->getAttributeLabel('qty_reject')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($model->qty_dismantle_good > $modelMasterItem->s_good_dismantle){
                    $pesan[] = $model->getAttributeLabel('qty_dismantle_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($model->qty_dismantle_ng > $modelMasterItem->s_not_good_dismantle){
                    $pesan[] = $model->getAttributeLabel('qty_dismantle_ng')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($model->qty_good_rec > $modelMasterItem->s_good_rec){
                    $pesan[] = $model->getAttributeLabel('qty_good_rec')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                
                if ($overStock == 0)
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);
                
                if(!$model->save()){
                    $error = $model->getErrors();
                    $error[0] = ['for IM Code '.$values[1]];
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
                }
                
                $this->changestock($model, 'minus');
            }

            Yii::$app->session->remove('detailinstruction');
            return json_encode(['status' => 'success']);
            // return 'success';
            
        }
		
		$modelInstruction = $this->findModel($id);
		$modelDetail = GrfDetail::find()->select(['orafin_code'])->andWhere(['id_grf' => $id])->all();
        // $modelDetail->orafin_code = $orafinCode;
		$orafinCode = ArrayHelper::map($modelDetail, 'orafin_code', 'orafin_code');
		
		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(), $orafinCode);        	// $idItemIm);

        return $this->render('createdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionSetsessiondetail(){
		if (Yii::$app->request->isPost){
			$data = Yii::$app->session->get('detailinstruction');
			
			$id   = Yii::$app->request->post('id');
			$val  = Yii::$app->request->post('val');
			$type = Yii::$app->request->post('type');
			
			$data[$id][$type] = $val;
			
			Yii::$app->session->set('detailinstruction', $data);
			return var_dump($data);
		}
	}

    public function actionCurrentstock(){
        if (Yii::$app->request->isPost){
            $id   = Yii::$app->request->post('id');
            
            $model = MasterItemImDetail::findOne($id);
            // return var_dump($model);
            $arr['s_good'] = $model->s_good;
            $arr['s_not_good'] = $model->s_not_good;
            $arr['s_reject'] = $model->s_reject;
            $arr['s_good_dismantle'] = $model->s_good_dismantle;
            $arr['s_not_good_dismantle'] = $model->s_not_good_dismantle;
            $arr['s_good_rec'] = $model->s_good_rec;
            return json_encode($arr);
        }
    }

    public function actionUpdatedetail($idDetail){
        $this->layout = 'blank';
        $model = InboundGrfDetail::findOne($idDetail);
        $model->scenario = 'updatedetail';
        $model->rem_good = $model->idMasterItemImDetail->s_good + $model->qty_good;
        $model->rem_not_good = $model->idMasterItemImDetail->s_not_good + $model->qty_noot_good;
        $model->rem_reject = $model->idMasterItemImDetail->s_reject + $model->qty_reject;
        $model->rem_good_dismantle = $model->idMasterItemImDetail->s_good_dismantle + $model->qty_dismantle_good;
        $model->rem_not_good_dismantle = $model->idMasterItemImDetail->s_not_good_dismantle + $model->qty_dismantle_ng;
        $model->rem_good_rec = $model->idMasterItemImDetail->s_good_rec + $model->qty_good_rec;
        
        if ($model->load(Yii::$app->request->post())) {
            $data['rem_good'] = $model->idMasterItemImDetail->s_good + $model->qty_good;
            $data['rem_not_good'] = $model->idMasterItemImDetail->s_not_good + $model->qty_noot_good;
            $data['rem_reject'] = $model->idMasterItemImDetail->s_reject + $model->qty_reject;
            $data['rem_good_dismantle'] = $model->idMasterItemImDetail->s_good_dismantle + $model->qty_dismantle_good;
            $data['rem_not_good_dismantle'] = $model->idMasterItemImDetail->s_not_good_dismantle + $model->qty_dismantle_ng;
            $data['rem_good_rec'] = $model->idMasterItemImDetail->s_good_rec + $model->qty_good_rec;
            
            $json = $data;
            if ($model->qty_good > $model->idMasterItemImDetail->s_good + $model->qty_good){
                $json['pesan'] = $model->getAttributeLabel('qty_good').' must be less than "'.$model->getAttributeLabel('rem_good').'".';
                return json_encode($json);
            }
            if ($model->qty_noot_good > $model->idMasterItemImDetail->s_not_good + $model->qty_noot_good){
                $json['pesan'] = $model->getAttributeLabel('qty_noot_good').' must be less than "'.$model->getAttributeLabel('s_not_good').'".';
                return json_encode($json);
            }
            if ($model->qty_reject > $model->idMasterItemImDetail->s_reject + $model->qty_reject){
                $json['pesan'] = $model->getAttributeLabel('qty_reject').' must be less than "'.$model->getAttributeLabel('s_reject').'".';
                return json_encode($json);
            }
            if ($model->qty_dismantle_good > $model->idMasterItemImDetail->s_good_dismantle + $model->qty_dismantle_good){
                $json['pesan'] = $model->getAttributeLabel('qty_dismantle_good').' must be less than "'.$model->getAttributeLabel('s_good_dismantle').'".';
                return json_encode($json);
            }
            if ($model->qty_dismantle_ng > $model->idMasterItemImDetail->s_not_good_dismantle + $model->qty_dismantle_ng){
                $json['pesan'] = $model->getAttributeLabel('rem_not_good_dismantle').' already change, and '.$model->getAttributeLabel('qty_dismantle_ng').' is more than current stock';
                return json_encode($json);
            }
            if ($model->qty_good_rec > $model->idMasterItemImDetail->s_good_rec + $model->qty_good_rec){
                $json['pesan'] = $model->getAttributeLabel('rem_good_rec').' already change, and '.$model->getAttributeLabel('qty_good_rec').' is more than current stock';
                return json_encode($json);
            }
            
            if (!$model->save()){
                $json['pesan'] = Displayerror::pesan($model->getErrors());
                return json_encode($json);
                // return Displayerror::pesan($model->getErrors());
            }           
            // $this->createLog($model);
            return json_encode(['pesan' => 'success']);
            // return 'success';
        } else {
            return $this->render('_formdetail', [
                'model' => $model,
            ]);
        }
    }
	

    /**
     * Updates an existing InboundGrf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'blank';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    

    public function actionUpdateasset($orafinCode = NULL)
     {
        $this->layout = 'blank';
        $id = Yii::$app->session->get('idGrf');     
        
        if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){
            
            $data_im_code       = Yii::$app->request->post('im_code');
            $data_asset_barcode       = Yii::$app->request->post('assetbarcode');

    //      $data_r_notgood_dis = Yii::$app->request->post('rnotgooddismantle');
            
            if (count($data_im_code) == 0){
                return json_encode(['status' => 'success']);
            }
            
            foreach($data_im_code as $key => $value){
                // if($data_r_good[$key] == '')
                if($data_asset_barcode[$key] == ''  && $data_asset_barcode[$key] == 0 ){
                    continue;
                }
                $values = explode(';',$value);
            
                $model = new InboundGrfDetail();
                // $model = $this->findModel($id);
                $model->id_inbound_grf          = $id;
                $model->status_listing = 43;
                $model->asset_barcode                = ($data_asset_barcode[$key] == '') ? 0 : $data_asset_barcode[$key];
                if(!$model->save()){
                    $error = $model->getErrors();
                    $error[0] = ['for IM Code '.$values[1]];
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
                }
                
                // $this->changestock($model, 'minus');
            }
            
            Yii::$app->session->remove('idGrf');
            return json_encode(['status' => 'success']);
            // return 'success';
            
        }else{
            // $modelInstruction = $this->findModel($id);
            // $model = InboundGrfDetail::findOne($id);
            $modelDetail = GrfDetail::find()->select(['orafin_code'])->andWhere(['id_grf' => $id])->all();
            // $modelDetail->orafin_code = $orafinCode;
            $orafinCode = ArrayHelper::map($modelDetail, 'orafin_code', 'orafin_code');
            
            $searchModel = new SearchMasterItemIm();
            $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(), $orafinCode);            // $idItemIm);

            return $this->render('updateasset', [
                // 'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
       
    }

    public function actionUploadsn($id){
        $this->layout = 'blank';
        $model = new UploadForm();
        
        $model->scenario = 'xls';
        
        if (Yii::$app->request->isPost){
            if (isset($_FILES['file']['size'])){
                if($_FILES['file']['size'] != 0){
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
                    //OutboundWhTransferDetailSn::deleteAll('id_outbound_wh_detail = '.Yii::$app->session->get('idOutboundWhTransferDetail'));
                    $row = 2;
                    $periksa = "\nplease check on row ";
                    $reqCol = [
                        'SERIAL_NUMBER' => '',
                        'MAC_ADDRESS' => '',
                        'CONDITION' => '',
                    ];
                    
                    //get max quantity based on detail
                    $modelDetail = InboundGrfDetail::findOne($id);
                    $maxQtyGood             = $modelDetail->qty_good;
                    $maxQtyNotGood          = $modelDetail->qty_not_good;
                    $maxQtyReject           = $modelDetail->qty_reject;
                    $maxQtyDismantleGood    = $modelDetail->qty_dismantle_good;
                    $maxQtyDismantleNg    = $modelDetail->qty_dismantle_ng;
                    $maxQtyGoodRec = $modelDetail->qty_good_rec;
                    
                    //get quantity already upload
                    $modelSn = InboundGrfDetailSn::find()->andWhere(['id_outbound_wh_detail' => $id]);
                    $qtyGood            = $modelSn->andWhere(['condition' => 'good'])->count();
                    $qtyNotGood         = $modelSn->andWhere(['condition' => 'not good'])->count();
                    $qtyReject          = $modelSn->andWhere(['condition' => 'reject'])->count();
                    $qtyGoodDismantle   = $modelSn->andWhere(['condition' => 'good dismantle'])->count();
                    $qtyNotGoodDismantle= $modelSn->andWhere(['condition' => 'not good dismantle'])->count();
                    
                    $newIdSn = [];
                    foreach ($datas as $key => $data) {
                        // periksa setiap kolom yang wajib ada, hanya di awal row
                        if ($row == 2) {
                            $missCol = array_diff_key($reqCol,$data);
                            if (count($missCol) > 0) {
                                InboundGrfDetailSn::deleteAll('id_inbound_grf_detail = '.$id);
                                return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                            }
                        }
                        $modelSn = new OutboundWhTransferDetailSn();

                        $modelSn->id_inbound_grf_detail = $id;
                        $modelSn->serial_number = (string)$data['SERIAL_NUMBER'];
                        $modelSn->mac_address = (string)$data['MAC_ADDRESS'];
                        $modelSn->condition = strtolower($data['CONDITION']);
                        
                        switch($modelSn->condition){
                            case 'good':
                                $qtyGood++;
                            break;
                            case 'not good':
                                $qtyNotGood++;
                            break;
                            case 'reject':
                                $qtyReject++;
                            break;
                            case 'good dismantle':
                                $qtyDismantleGood++;
                            break;
                            case 'not good dismantle':
                                $qtyDismantleNg++;
                            break;
                            case 'not good dismantle':
                                $qtyGoodRec++;
                            break;
                        }
                        
                        $maxErr = '';
                        if ($qtyGood > $maxQtyGood){
                            $maxErr = 'Quantity Good cannot be more than '. $maxQtyGood;
                        }
                        
                        if ($qtyNotGood > $maxQtyNotGood){
                            $maxErr = 'Quantity Not Good cannot be more than '. $maxQtyNotGood;
                        }
                        
                        if ($qtyReject > $maxQtyReject){
                            $maxErr = 'Quantity Reject cannot be more than '. $maxQtyReject;
                        }
                        
                        if ($qtyDismantleGood > $maxQtyDismantleGood){
                            $maxErr = 'Quantity Good Dismantle cannot be more than '. $maxQtyDismantleGood;
                        }
                        
                        if ($qtyDismantleNg > $maxQtyDismantleNg){
                            $maxErr = 'Quantity Not Good Dismantle cannot be more than '. $maxQtyDismantleNg;
                        }
                        if ($qtyGoodRec > $maxQtyGoodRec){
                            $maxErr = 'Quantity Not Good Dismantle cannot be more than '. $maxQtyGoodRec;
                        }
                        
                        if ($maxErr != ''){
                            // delete new data only
                            OutboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
                            return $maxErr;
                        }

                        if(!$modelSn->save()) {
                            // delete new data only
                            InboundGrfDetailSn::deleteAll(['id' => $newIdSn]);
                            $error = $modelSn->getErrors();
                            $error['line'] = [$periksa.$row];
                            return Displayerror::pesan($modelSn->getErrors());
                        }
                        $newIdSn[] = $modelSn->id;
                        $row++;
                    }
                    
                    if ($maxQtyGood == $qtyGood && 
                        $maxQtyNotGood == $qtyNotGood && 
                        $maxQtyReject == $qtyReject && 
                        $maxQtyDismantleGood == $qtyDismantleGood && 
                        $maxQtyDismantleNg == $qtyDismantleNg && 
                        $maxQtyGoodRec == $qtyGoodRec){
                            $modelDetail->status_listing = 41;
                            $modelDetail->save();
                    }else{
                        $modelDetail->status_listing = 43;
                        $modelDetail->save();
                    }
                    
                    $modelInboundGrfDetail = InboundGrfDetail::find()->where(['id_inbound_grf'=> $modelDetail->id_inbound_grf])->asArray()->all();
                    $cekStatus = 1;
                    foreach($modelInboundGrfDetail as $key => $value){
                        if($value['status_listing'] != 41){
                            $cekStatus++;
                        }
                    }
                    
                    if($cekStatus == 1){
                        $modelOutbound = $this->findModel(\Yii::$app->session->get('idGrf'));
                        $modelOutbound->status_listing = 42;
                        $modelOutbound->save();
                    }
                    
                    return 'success';
                    
                }
            }
        }
        
        return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
    }
   

    public function actionApprove($id){
        $model = $this->findModel($id);
        
        if ($model->status_listing == 1 || $model->status_listing == 2){
            $model->status_listing = 5;
            
            if ($model->save()){
                 // $this->createLog($model);
                return 'success';
            }
            
        }else{
            return 'Not Valid for Approve';
        }
    }

    public function actionRevise($id)
    {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if($model != null) {
            if(!empty($_POST['InboundGrf']['revision_remark'])) {
                $model->status_listing = 3;
                $model->revision_remark = $_POST['InboundGrf']['revision_remark'];
                if($model->save()) {
                    // $this->createLog($model);
                     // $this->createLog($model);

                    return 'success';
                } else {
                    return Displayerror::pesan($model->getErrors());
                }
            } else {
                return 'Please insert Revision/Rejection Remark';
            }
        } else {
            return 'data not found';
        }
    }

    public function actionReject($id)
    {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if($model != null) {
            if(!empty($_POST['InboundGrf']['revision_remark'])) {
                $model->status_listing = 6;
                $model->revision_remark = $_POST['InboundGrf']['revision_remark'];
                if($model->save()) {
                     // $this->createLog($model);
                 //    $arrAuth = ['/finance-invoice/index'];               

                    return 'success';
                } else {
                    return Displayerror::pesan($model->getErrors());
                }
            } else {
                return 'Please insert Revision/Rejection Remark';
            }
        } else {
            return 'data not found';
        }

    }
    public function actionSubmit($id){
        $model = InboundGrf::findOne($id);
        $modelDetail = InboundGrfDetail::find()->andWhere(['id_inbound_grf' => $id])->count();
        if ($modelDetail > 0){
            if($model->status_listing == 2 || $model->status_listing == 3){
                $model->status_listing = 2;
            }else{
                $model->status_listing = 1;
            }
        }else{
            $model->status_listing = 7;
        }
        
        if (!$model->save()){
            
            return Displayerror::pesan($model->getErrors());
        }
        
        Yii::$app->session->remove('idInboundGrf');
        $this->createLog($model);
        return 'success';
    }

    private function changestock($model, $action = 'add'){
        $modelIm = MasterItemImDetail::findOne($model->id_item_im);
        
        if ($action == 'add'){
            $modelIm->s_good                = $modelIm->s_good + $model->qty_good;
            $modelIm->s_not_good            = $modelIm->s_not_good + $model->qty_noot_good;
            $modelIm->s_reject              = $modelIm->s_reject + $model->qty_reject;
            $modelIm->s_good_dismantle      = $modelIm->s_good_dismantle + $model->qty_dismantle_good;
            $modelIm->s_not_good_dismantle  = $modelIm->s_not_good_dismantle + $model->qty_dismantle_ng;
            $modelIm->s_good_rec  = $modelIm->s_good_rec + $model->qty_good_rec;
        }else{
            $modelIm->s_good                = $modelIm->s_good - $model->qty_good;
            $modelIm->s_not_good            = $modelIm->s_not_good - $model->qty_noot_good;
            $modelIm->s_reject              = $modelIm->s_reject - $model->qty_reject;
            $modelIm->s_good_dismantle      = $modelIm->s_good_dismantle - $model->qty_dismantle_good;
            $modelIm->s_not_good_dismantle  = $modelIm->s_not_good_dismantle - $model->qty_dismantle_ng;
            $modelIm->s_good_rec  = $modelIm->s_good_rec + $model->qty_good_rec;
        }
        
        
        $modelIm->save();
    }
    

    /**
     * Deletes an existing InboundGrf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InboundGrf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InboundGrf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionDownloadfile($id, $modul = null, $relation = '', $upload = false) {
        $request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
         

        // if ($upload) {
            // $basepath = Yii::getAlias('@webroot') .'/uploads/AP/INVOICE/';
           
        // }else {
            $basepath = Yii::getAlias('@webroot') . '/';
        // }
        
        // if ($relation == 'document') {
  //           if ($relation == 'document') {
  //               $model = GrfDocument::findOne($id);
  //           }else {
  //               throw new NotFoundHttpException("The request page does not exist.", 1);

  //           }
        // }else{
          
               
  //           if ($modul=='log'){
  //               $model = LogGrf::findOne($id);
  //           }
            
        //  elseif($modul=='vendor'){
        //      $basepath = Yii::getAlias('@os') . '/web/';
        //      $model = OsVendorTermSheet::findOne($id);
        //  }
  //           else {
        $model = $this->findModel($id);  
        //     } 
        // }

        $path = ArrayHelper::getValue($model, $params['data'], 'Unknown');
        // $lok='';
        
// return $path;

        
        // if ($params['path'] === 'true') {
            // $lok = 'CA/IOM/'.$id.'/';
        // }
 
        $file = $basepath.$path;
        return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
        // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModel($id)
    {
        if (($model = InboundGrf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
