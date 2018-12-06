<?php

namespace divisisatu\controllers;

use Yii;
use common\models\Grf;
use common\models\InstructionGrf;
use common\models\InstructionGrfDetail;
use common\models\GrfDetail;
use common\models\SearchInstructionGrf;
use common\models\SearchInstructionGrfDetail;
use common\models\SearchInstructionGrfDetailSn;
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

/**
 * InstructionGrfController implements the CRUD actions for InstructionGrf model.
 */
class InstructionGrfController extends Controller
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
     * Lists all InstructionGrf models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionIndexdetail(){

		$this->layout = 'blank';
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idInstructionGrf'));

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
    public function actionIndexverify(){
        $searchModel = new SearchInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'verify');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexapprove(){
        $searchModel = new SearchInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexasset(){
        $searchModel = new SearchInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'asset');

        return $this->render('indexasset', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexsn(){
        $searchModel = new SearchInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'sn');

        return $this->render('indexsn', [
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
     * Displays a single InstructionGrf model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewdetail($id)

    {
        $this->layout = 'blank';
        Yii::$app->session->set('idGrf', $id);
        return $this->render('viewdetail', $this->detailView($id));
    }

    public function actionView($id)
    {
    	$this->layout = 'blank';
        Yii::$app->session->set('idGrf', $id);
        return $this->render('view', $this->detailView($id));
    }


    public function actionViewverify($id){
        $this->layout = 'blank';
         Yii::$app->session->set('idGrf', $id);
        return $this->render('view', $this->detailView($id));
    }

    public function actionViewapprove($id){
		$this->layout = 'blank';
		return $this->render('viewapprove', $this->detailView($id));
	}

    /**
     * Creates a new InstructionGrf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $act = null)
    {
        $this->layout = 'blank';
        $modelGrf = Grf::findOne($id);
        $model = new InstructionGrf();
        $model->id = $modelGrf->id;
        $model->status_listing = 43;
        $model->status_return = $modelGrf->status_return;
        $model->id_modul = $this->id_modul;
        $model->grf_number = $modelGrf->grf_number;
        $model->wo_number = $modelGrf->wo_number;
        $model->grf_type = $modelGrf->grf_type;
        $model->requestor = $modelGrf->requestor;
        $model->id_division = $modelGrf->id_division;
        $model->id_region = $modelGrf->id_region;
        $model->pic = $modelGrf->pic;
        $model->purpose = $modelGrf->purpose;
        $model->file_attachment_1 = $modelGrf->file_attachment_1;
        $model->file_attachment_2 = $modelGrf->file_attachment_2;
        $model->file_attachment_3 = $modelGrf->file_attachment_3;
        $model->id_warehouse = $modelGrf->id_warehouse;
        $modelGrf->created_date = date('Y-m-d', strtotime("+7 days"));
        $model->date_of_return = $modelGrf->created_date;
        // return print_r($idOutboundWh);
       if ($model->load(Yii::$app->request->post())) {
       		$model->status_listing = 1;
        if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			
			
			$model->save();
			
			Yii::$app->session->set('idInstructionGrf', $model->id);
        // Yii::$app->session->set('idInstructionGrf',$modelGrf->id);
        // // $model = $this->findModel($id);

        // if($model->save()){
				
				// $this->createLog($model);
				return 'success';
			}else{
				return $this->render('create', [
                'model' => $model,
            	]);
        	}

    }

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
				if($data_qty_good[$key] == '' && $data_qty_noot_good[$key] == '' && $data_qty_reject[$key] == '' && $data_qty_good[$key] == 0 && $data_qty_noot_good[$key] == 0 && $data_qty_reject[$key] == 0 && $data_qty_dismantle_good[$key] == '' && $data_qty_dismantle_ng[$key] == ''&& $data_qty_good_rec[$key] == ''){
					continue;
				}

                $data_qty_good[$key]          = ($data_qty_good[$key] == '') ? 0 : $data_qty_good[$key];
                $data_qty_noot_good[$key]       = ($data_qty_noot_good[$key] == '') ? 0 : $data_qty_noot_good[$key];
                $data_qty_reject[$key]        = ($data_qty_reject[$key] == '') ? 0 : $data_qty_reject[$key];
                $data_qty_dismantle_good[$key]      = ($data_qty_dismantle_good[$key] == '') ? 0 : $data_qty_dismantle_good[$key];
                $data_qty_dismantle_ng[$key]   = ($data_qty_dismantle_ng[$key] == '') ? 0 : $data_qty_dismantle_ng[$key];
                $data_qty_good_rec[$key]   = ($data_qty_good_rec[$key] == '') ? 0 : $data_qty_good_rec[$key];

				$values = explode(';',$value);
                // return print_r($values[0]);
                $modelitemim = MasterItemIm::find()->joinWith('masterItemImDetails')->andWhere(['master_item_im.id' => $values[0]])->one();
                // return print_r($modelitemim->im_code);

                $modelcek = InstructionGrfDetail::find()->andWhere(['and',['id_item_im' => $modelitemim->id], ['id_instruction_grf' => $id]]);
                $oldqty_good = 0;
                $oldqty_noot_good = 0;
                $oldqty_reject = 0;
                $oldqty_dismantle_good = 0;
                $oldqty_dismantle_ng = 0;
                $oldqty_good_rec = 0;
                if ( $modelcek->count() == 0 ){
                    $model = new InstructionGrfDetail();
                }else{
                    $model = $modelcek->one();
                    $oldqty_good                = $model->qty_good;
                    $oldqty_noot_good            = $model->qty_noot_good;
                    $oldqty_reject              = $model->qty_reject;
                    $oldqty_dismantle_good      = $model->qty_dismantle_good;
                    $oldqty_dismantle_ng        = $model->qty_dismantle_ng;
                    $oldqty_good_rec            = $model->qty_good_rec;
                }


                $modelMasterItem = MasterItemImDetail::findOne(['master_item_im_detail.id_master_item_im' => $values[0]]);
                $overStock = 1;
                $pesan = [];
                // return var_dump( Yii::$app->session->get('detailinstruction')[$values[0]]['update'][$values[0]] );
                $session = Yii::$app->session->get('detailinstruction')[$values[0]];
                if ( isset($session['update']) ){
                    $datagood       = $data_qty_good[$key] - $session['update'][$values[0]]['qtygood'];
                    $datanootgood    = $data_qty_noot_good[$key] - $session['update'][$values[0]]['qtynootgood'];
                    $datareject     = $data_qty_reject[$key] - $session['update'][$values[0]]['qtyreject'];
                    $datadisgood    = $data_qty_dismantle_good[$key] - $session['update'][$values[0]]['qtydismantlegood'];
                    $datadisng = $data_qty_dismantle_ng[$key] - $session['update'][$values[0]]['qtydismantleng'];
                    $datagoodrec = $data_qty_good_rec[$key] - $session['update'][$values[0]]['qtygoodrec'];
                }else{
                    $datagood       = $data_qty_good[$key];
                    $datanootgood    = $data_qty_noot_good[$key];
                    $datareject     = $data_qty_reject[$key];
                    $datadisgood    = $data_qty_dismantle_good[$key];
                    $datadisng      = $data_qty_dismantle_ng[$key];
                    $datagoodrec    = $data_qty_good_rec[$key];
                }

                if($datagood > $modelMasterItem->s_good){
                    $pesan[] = $model->getAttributeLabel('qty_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datanootgood > $modelMasterItem->s_not_good){
                    $pesan[] = $model->getAttributeLabel('qty_noot_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datareject > $modelMasterItem->s_reject){
                    $pesan[] = $model->getAttributeLabel('qty_reject')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datadisgood > $modelMasterItem->s_good_dismantle){
                    $pesan[] = $model->getAttributeLabel('qty_dismantle_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datadisng > $modelMasterItem->s_not_good_dismantle){
                    $pesan[] = $model->getAttributeLabel('qty_dismantle_ng')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datagoodrec > $modelMasterItem->s_good_rec){
                    $pesan[] = $model->getAttributeLabel('qty_good_rec')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }

                if ($overStock == 0){
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);
                }

                $model->id_instruction_grf       = $id;
                // $model->id_item_im               = $values[0];
                $model->id_item_im               = $modelitemim->id;
                $model->qty_good                 = $data_qty_good[$key];
                $model->qty_noot_good             = $data_qty_noot_good[$key];
                $model->qty_reject               = $data_qty_reject[$key];
                $model->qty_dismantle_good       = $data_qty_dismantle_good[$key];
                $model->qty_dismantle_ng         = $data_qty_dismantle_ng[$key];
                $model->qty_good_rec             = $data_qty_good_rec[$key];

                $newRec = false;
                if ( !$model->isNewRecord ){

                    if ( !isset($session['update']) ){
                        $model->qty_good                += $oldqty_good; 
                        $model->qty_noot_good            += $oldqty_noot_good; 
                        $model->qty_reject              += $oldqty_reject;  
                        $model->qty_dismantle_good      += $oldqty_dismantle_good;
                        $model->qty_dismantle_ng        += $oldqty_dismantle_ng;
                        $model->qty_good_rec            += $oldqty_good_rec;
                        // return "$oldreq_good, $oldreq_not_good, $oldreq_reject, $oldreq_good_dismantle, $oldreq_not_good_dismantle";
                    }

                }else{
                    $newRec = true;
                }

                if(!$model->save()){
                    $error = $model->getErrors();
                    $error[0] = ['for IM Code '.$values[1]];
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
                }

                if ( $newRec ){
                    $this->changestock($model, 'minus');
                }
            }

            Yii::$app->session->remove('detailinstruction');
            return json_encode(['status' => 'success']);
            // return 'success';

        }
		
		$modelInstruction = $this->findModel($id);
		$modelDetail = GrfDetail::find()->select(['orafin_code'])->andWhere(['id_grf' => $id])->all();
        // $modelDetail->orafin_code = $orafinCode;
		$orafinCode = ArrayHelper::map($modelDetail, 'orafin_code', 'orafin_code');
        // $orafinCode = [];
        $model = $this->findModel($id);
		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->getQueryParams(), $orafinCode);        	// $idItemIm);

        return $this->render('createdetail', [
            'model' => $model,
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
            $session = Yii::$app->session->get('detailinstruction');

            if ( isset($session[$id]['update']) ){
                $model->s_good              += $session[$id]['update'][$id]['qtygood'];
                $model->s_not_good          += $session[$id]['update'][$id]['qtynootgood'];
                $model->s_reject            += $session[$id]['update'][$id]['qtyreject'];
                $model->s_good_dismantle    += $session[$id]['update'][$id]['qtydismantlegood'];
                $model->s_not_good_dismantle+= $session[$id]['update'][$id]['qtydismantleng'];
                $model->s_not_good_rec      += $session[$id]['update'][$id]['qtygoodrec'];
            }
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
        $model = InstructionGrfDetail::findOne($idDetail);
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
     * Updates an existing InstructionGrf model.
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

            // return print_r($id);

            

    //      $data_r_notgood_dis = Yii::$app->request->post('rnotgooddismantle');
            
            foreach($data_im_code as $key => $value){
                // if($data_r_good[$key] == '')
                if($data_asset_barcode[$key] == ''  && $data_asset_barcode[$key] == 0 ){
                    continue;
                }
                $values = explode(';',$value);
            
                $model = InstructionGrfDetail::findOne( $id);
                // $model = $this->findModel($id);
                // $model->id_instruction_grf          = $id;
                // $model->status_listing = 43;
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
            // $model = InstructionGrfDetail::findOne($id);
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
                    $modelDetail = InstructionGrfDetail::findOne($id);
                    $maxQtyGood             = $modelDetail->qty_good;
                    $maxQtyNootGood          = $modelDetail->qty_noot_good;
                    $maxQtyReject           = $modelDetail->qty_reject;
                    $maxQtyDismantleGood    = $modelDetail->qty_dismantle_good;
                    $maxQtyDismantleNg    = $modelDetail->qty_dismantle_ng;
                    $maxQtyGoodRec = $modelDetail->qty_good_rec;
                    
                    //get quantity already upload
                    $modelSn = InstructionGrfDetailSn::find()->andWhere(['id_outbound_wh_detail' => $id]);
                    $qtyGood            = $modelSn->andWhere(['condition' => 'good'])->count();
                    $qtyNootGood         = $modelSn->andWhere(['condition' => 'noot good'])->count();
                    $qtyReject          = $modelSn->andWhere(['condition' => 'reject'])->count();
                    $qtyGoodDismantle   = $modelSn->andWhere(['condition' => 'good dismantle'])->count();
                    $qtyNootGoodDismantle= $modelSn->andWhere(['condition' => 'not good dismantle'])->count();
                    
                    $newIdSn = [];
                    foreach ($datas as $key => $data) {
                        // periksa setiap kolom yang wajib ada, hanya di awal row
                        if ($row == 2) {
                            $missCol = array_diff_key($reqCol,$data);
                            if (count($missCol) > 0) {
                                InstructionGrfDetailSn::deleteAll('id_instruction_grf_detail = '.$id);
                                return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                            }
                        }
                        $modelSn = new OutboundWhTransferDetailSn();

                        $modelSn->id_instruction_grf_detail = $id;
                        $modelSn->serial_number = (string)$data['SERIAL_NUMBER'];
                        $modelSn->mac_address = (string)$data['MAC_ADDRESS'];
                        $modelSn->condition = strtolower($data['CONDITION']);
                        
                        switch($modelSn->condition){
                            case 'good':
                                $qtyGood++;
                            break;
                            case 'not good':
                                $qtyNootGood++;
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
                        
                        if ($qtyNootGood > $maxQtyNootGood){
                            $maxErr = 'Quantity Not Good cannot be more than '. $maxQtyNootGood;
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
                            InstructionGrfDetailSn::deleteAll(['id' => $newIdSn]);
                            $error = $modelSn->getErrors();
                            $error['line'] = [$periksa.$row];
                            return Displayerror::pesan($modelSn->getErrors());
                        }
                        $newIdSn[] = $modelSn->id;
                        $row++;
                    }
                    
                    if ($maxQtyGood == $qtyGood && 
                        $maxQtyNootGood == $qtyNootGood && 
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
                    
                    $modelInstructionGrfDetail = InstructionGrfDetail::find()->where(['id_instruction_grf'=> $modelDetail->id_instruction_grf])->asArray()->all();
                    $cekStatus = 1;
                    foreach($modelInstructionGrfDetail as $key => $value){
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

    public function actionVerify($id)
    {   
        $model = $this->findModel($id);
        if($model->status_listing == 1 || $model->status_listing == 2){
            $model->status_listing = 4;
            if ($model->save()) {
                return 'success';
            } 
        }else{
            return 'Not valid for verify';
        }
    }
   

    public function actionApprove($id){
        $model = $this->findModel($id);
        
        if ($model->status_listing == 1 || $model->status_listing == 2|| $model->status_listing == 4){
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
            if(!empty($_POST['InstructionGrf']['revision_remark'])) {
                $model->status_listing = 3;
                $model->revision_remark = $_POST['InstructionGrf']['revision_remark'];
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
            if(!empty($_POST['InstructionGrf']['revision_remark'])) {
                $model->status_listing = 6;
                $model->revision_remark = $_POST['InstructionGrf']['revision_remark'];
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
        $model = InstructionGrf::findOne($id);
        $modelDetail = InstructionGrfDetail::find()->andWhere(['id_instruction_grf' => $id])->count();
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
        
        Yii::$app->session->remove('idInstructionGrf');
        $this->createLog($model);
        return 'success';
    }

    private function changestock($model, $action = 'add'){
        // $modelIm = MasterItemImDetail::findOne($model->id_item_im);
        $modelIm = MasterItemImDetail::find()->andWhere(['and', ['id_master_item_im' => $model->id_item_im], ['id_warehouse' => $model->idInstructionGrf->id_warehouse]])->one();
        
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
     * Deletes an existing InstructionGrf model.
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
     * Finds the InstructionGrf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionGrf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDownloadfile($id, $modul = null, $relation = '', $upload = false) {
        $request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
         

        // if ($upload) {
            // $basepath = Yii::getAlias('@webroot') .'/uploads/AP/INVOICE/';
           
        // }else {
            $basepath = Yii::getAlias('@grflost') . '/web'.'/';
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
        $model = Grf::findOne($id);  
// return $basepath;
        //     } 
        // }

        $path = ArrayHelper::getValue($model, $params['data'], 'Unknown');
        // $lok='';
        
        
        // if ($params['path'] === 'true') {
            // $lok = 'CA/IOM/'.$id.'/';
        // }
 
        $file = $basepath.$path;
        // return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
        // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModel($id)
    {
        if (($model = InstructionGrf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
