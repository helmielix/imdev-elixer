<?php

namespace logistik\controllers;

use Yii;
use common\models\Grf;
use common\models\InstructionGrf;
use common\models\LogInstructionGrf;
use common\models\InstructionGrfDetail;
use common\models\GrfDetail;
use common\models\SearchInstructionGrf;
use common\models\SearchLogInstructionGrf;
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
use common\widgets\Email;
use yii\helpers\Url;

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
        $dataProvider = $searchModel->searchByGrfDetail(Yii::$app->request->queryParams, Yii::$app->session->get('idGrf'));

        Yii::$app->session->set('idGrf', Yii::$app->session->get('idGrf'));

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

    public function actionIndexoverview(){
        $searchModel = new SearchInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'overview');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
  

    public function actionIndexlog(){
        $searchModel = new SearchLogInstructionGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('indexlog', [
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
        $dataProvider = $searchModel->searchByGrfDetail(Yii::$app->request->queryParams, $id);
		
		// Yii::$app->session->set('idGrf', $model->id);
		
        return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionViewlog($id)
    {
    	$this->layout = 'blank';
    	$model = LogInstructionGrf::findOne($id);
		
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->searchByGrfDetail(Yii::$app->request->queryParams, $model->id);
		
		
		return $this->render('viewlog', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);		

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
		return $this->render('view', $this->detailView($id));
	}

	public function actionViewoverview($id){
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
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
        $model->status_listing = 53;
        $model->status_return = $modelGrf->status_return;
        $model->id_modul = $this->id_modul;
        // $model->sentdate = date('Y-m-d', strtotime("+1 days"));
        // $model->id_grf = $modelGrf->id;

        // $model->wo_number = $modelGrf->wo_number;
        // $model->grf_type = $modelGrf->grf_type;
        // $model->requestor = $modelGrf->requestor;
        // $model->id_division = $modelGrf->id_division;
        // $model->id_region = $modelGrf->id_region;
        // $model->pic = $modelGrf->pic;
        // $model->purpose = $modelGrf->purpose;
        // $model->file_attachment_1 = $modelGrf->file_attachment_1;
        // $model->file_attachment_2 = $modelGrf->file_attachment_2;
        // $model->file_attachment_3 = $modelGrf->file_attachment_3;
        
        // $model->id_warehouse = $modelGrf->id_warehouse;
        // $modelGrf->created_date = date('Y-m-d', strtotime("+7 days"));
        // $model->date_of_return = $modelGrf->created_date;
        // $model->team_leader = $modelGrf->team_leader;
        // $model->team_name = $modelGrf->team_name;
        // return print_r($idOutboundWh);


        if ($model->load(Yii::$app->request->post())) {
       		// $model->status_listing = 1;
            if (!$model->save()){
    			return Displayerror::pesan($model->getErrors());
    		}
    			
    			
    		Yii::$app->session->set('idGrf', $model->id);
            // Yii::$app->session->set('idInstructionGrf',$modelGrf->id);
            // $model = $this->findModel($id);

                
            $this->createLog($model);
            return 'success';
        }else{
            return $this->render('create', [
                'model' => $model,
                'modelGrf' => $modelGrf,
            ]);
        }

    }

    public function actionCreatedetail($orafinCode){
        $this->layout = 'blank';
        $id = Yii::$app->session->get('idGrf');
        $newitem = [];

        if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){

        	// return var_dump(Yii::$app->session->get('detailinstruction'));

        	$data_im_code  = array_keys(Yii::$app->session->get('detailinstruction'));
        	// return var_dump($data_im_code);
        	$data_r_good          	 = array_column(Yii::$app->session->get('detailinstruction'), 'rgood');
            $data_r_notgood       	 = array_column(Yii::$app->session->get('detailinstruction'), 'rnotgood');
            $data_r_reject        	 = array_column(Yii::$app->session->get('detailinstruction'), 'rreject');
            $data_r_dismantle     	 = array_column(Yii::$app->session->get('detailinstruction'), 'rdismantle');
            $data_r_revocation    	 = array_column(Yii::$app->session->get('detailinstruction'), 'rrevocation');
            $data_r_good_for_recond  = array_column(Yii::$app->session->get('detailinstruction'), 'rgoodforrecond');
            $data_r_good_rec         = array_column(Yii::$app->session->get('detailinstruction'), 'rgoodrec');
        	// return var_dump($data_r_notgood);
        	// return var_dump(array_column(Yii::$app->session->get('detailinstruction'), 'rgood'));
        	// return var_dump(Yii::$app->session->get('detailinstruction'));

            // $data_im_code         	 = Yii::$app->request->post('im_code');
            // $data_r_good          	 = Yii::$app->request->post('rgood');
            // $data_r_notgood       	 = Yii::$app->request->post('rnotgood');
            // $data_r_reject        	 = Yii::$app->request->post('rreject');
            // $data_r_dismantle     	 = Yii::$app->request->post('rdismantle');
            // $data_r_revocation    	 = Yii::$app->request->post('rrevocation');
            // $data_r_good_for_recond  = Yii::$app->request->post('rgoodforrecond');
            // $data_r_good_rec         = Yii::$app->request->post('rgoodrec');

            if (count($data_im_code) == 0){
                return json_encode(['status' => 'success']);
            }

            $idnya='';
            foreach (InstructionGrfDetail::find()
            		->andWhere(['and',['id_instruction_grf' => $id]])
            		->joinWith('idMasterItemIm')
                    ->andWhere(['orafin_code' => $orafinCode])
            		->all() as $detail) {
            	// hapus semua detail yg sesuaii instrukssi grf yg sesuai orafin codenya, pengembalian stok dilakukan di model InstructionGrfDetail
            	// $idnya .= $detail->id.',';            	

			    $detail->delete();
			}

			// return json_encode(['status' => 'error', 'id' => 109, 'pesan' => "delete all $idnya"]);

            foreach($data_im_code as $key => $value){
            	
                $data_r_good[$key]              = !isset($data_r_good[$key]) ? 0 : $data_r_good[$key];
                $data_r_notgood[$key]           = !isset($data_r_notgood[$key]) ? 0 : $data_r_notgood[$key];
                $data_r_reject[$key]            = !isset($data_r_reject[$key]) ? 0 : $data_r_reject[$key];
                $data_r_dismantle[$key]         = !isset($data_r_dismantle[$key]) ? 0 : $data_r_dismantle[$key];
                $data_r_revocation[$key]        = !isset($data_r_revocation[$key]) ? 0 : $data_r_revocation[$key];
                $data_r_good_rec[$key]          = !isset($data_r_good_rec[$key]) ? 0 : $data_r_good_rec[$key];
                $data_r_good_for_recond[$key]   = !isset($data_r_good_for_recond[$key]) ? 0 : $data_r_good_for_recond[$key];

                if( 
                	// ($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '' && $data_r_dismantle[$key] == '' && $data_r_revocation[$key] == '' && $data_r_good_rec[$key] == '' && $data_r_good_for_recond[$key] == '') ||
                    ($data_r_good[$key] == 0 && $data_r_notgood[$key] == 0 && $data_r_reject[$key] == 0 && $data_r_dismantle[$key] == 0 && $data_r_revocation[$key] == 0 && $data_r_good_rec[$key] == 0 && $data_r_good_for_recond[$key] == 0)){
                    continue;
                }

                
                // $values = explode(';',$value);
                $values[0] = $value;

                $modelitemim = MasterItemIm::find()->joinWith('masterItemImDetails')->andWhere(['master_item_im_detail.id' => $values[0]])->one();
                // $modelallitemim = ArrayHelper::getColumn(MasterItemIm::find()->joinWith('masterItemImDetails')->andWhere(['orafin_code' => $modelitemim->orafin_code])->andWhere(['not in', 'master_item_im.id', $newitem])->all(), 'id');

                
                $values[1] = $modelitemim->im_code;

    //             foreach (InstructionGrfDetail::find()->where(['and',['id_item_im' => $modelallitemim],['id_instruction_grf' => $id]])->all() as $detail) {
				//     $detail->delete();
				// }
                // InstructionGrfDetail::deleteAll(['and',['id_item_im' => $modelallitemim],['id_instruction_grf' => $id]]);

                $modelcek = InstructionGrfDetail::find()->andWhere(['and',['id_item_im' => $modelitemim->id], ['id_instruction_grf' => $id]]);
                $oldreq_good = 0;
                $oldreq_not_good = 0;
                $oldreq_reject = 0;
                $oldreq_dismantle = 0;
                $oldreq_revocation = 0;
                $oldreq_good_rec = 0;
                $oldreq_good_for_recond = 0;
                if ( $modelcek->count() == 0 ){
                    $model = new InstructionGrfDetail();
                }else{
                	// seharusnya sudah tidak masuk if ini, karena data sudah dihapus semua sebelum foreach
                    $model = $modelcek->one();
                    $oldreq_good                = $model->qty_good;
                    $oldreq_not_good            = $model->qty_not_good;
                    $oldreq_reject              = $model->qty_reject;
                    $oldreq_dismantle           = $model->qty_dismantle;
                    $oldreq_revocation          = $model->qty_revocation;
                    $oldreq_good_rec            = $model->qty_good_rec;
                    $oldreq_good_for_recond     = $model->qty_good_for_recond;

                    // $oldmodel = $model;
                    // $oldmodel->qty_good 			= 0;
                    // $oldmodel->qty_not_good 		= 0;
                    // $oldmodel->qty_reject 			= 0;
                    // $oldmodel->qty_dismantle 		= 0;
                    // $oldmodel->qty_revocation 		= 0;
                    // $oldmodel->qty_good_rec 		= 0;
                    // $oldmodel->qty_good_for_recond 	= 0;
                    // $oldmodel->save();
                    // $oldmodel->delete();
                    // if (!$oldmodel->save()) {
                    // 	return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => 'gagal']);
                    // }

                }

                $modelMasterItem = MasterItemImDetail::findOne($values[0]);
                $overStock = 1;
                $pesan = [];
                // return var_dump( Yii::$app->session->get('detailinstruction')[$values[0]]['update'][$values[0]] );
                $session = Yii::$app->session->get('detailinstruction')[$values[0]];
                if ( isset($session['update']) ){
                    $datagood            = $data_r_good[$key] - $session['update'][$values[0]]['rgood'];
                    $datanotgood         = $data_r_notgood[$key] - $session['update'][$values[0]]['rnotgood'];
                    $datareject          = $data_r_reject[$key] - $session['update'][$values[0]]['rreject'];
                    $datadismantle       = $data_r_dismantle[$key] - $session['update'][$values[0]]['rdismantle'];
                    $datarevocation      = $data_r_revocation[$key] - $session['update'][$values[0]]['rrevocation'];
                    $datagood_rec        = $data_r_good_rec[$key] - $session['update'][$values[0]]['rgoodrec'];
                    $datagood_for_recond = $data_r_good_for_recond[$key] - $session['update'][$values[0]]['rgoodforrecond'];
                }else{
                    $datagood            = $data_r_good[$key];
                    $datanotgood         = $data_r_notgood[$key];
                    $datareject          = $data_r_reject[$key];
                    $datadismantle       = $data_r_dismantle[$key];
                    $datarevocation      = $data_r_revocation[$key];
                    $datagood_rec        = $data_r_good_rec[$key];
                    $datagood_for_recond = $data_r_good_for_recond[$key];
                }

                if($datagood > $modelMasterItem->s_good){
                    $pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datanotgood > $modelMasterItem->s_not_good){
                    $pesan[] = $model->getAttributeLabel('req_not_good')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datareject > $modelMasterItem->s_reject){
                    $pesan[] = $model->getAttributeLabel('req_reject')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datadismantle > $modelMasterItem->s_dismantle){
                    $pesan[] = $model->getAttributeLabel('req_dismantle')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datarevocation > $modelMasterItem->s_revocation){
                    $pesan[] = $model->getAttributeLabel('req_revocation')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datagood_rec > $modelMasterItem->s_good_rec){
                    $pesan[] = $model->getAttributeLabel('req_good_rec')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }
                if($datagood_for_recond > $modelMasterItem->s_good_for_recond){
                    $pesan[] = $model->getAttributeLabel('req_good_for_recond')." is more than Stock for IM Code ".$values[1];
                    $overStock = 0;
                }

                if ($overStock == 0){
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);
                }

                $model->id_instruction_grf       = $id;
                // $model->id_item_im               = $values[0];
                $model->id_item_im              = $modelitemim->id;
                $model->qty_good                = $data_r_good[$key];
                $model->qty_not_good            = $data_r_notgood[$key];
                $model->qty_reject              = $data_r_reject[$key];
                $model->qty_dismantle           = $data_r_dismantle[$key];
                $model->qty_revocation          = $data_r_revocation[$key];
                $model->qty_good_rec            = $data_r_good_rec[$key];
                $model->qty_good_for_recond     = $data_r_good_for_recond[$key];

                $totalqty = $model->qty_good + $model->qty_not_good + $model->qty_reject + $model->qty_dismantle + $model->qty_revocation + $model->qty_good_rec + $model->qty_good_for_recond;

                $newRec = false;
                if ( !$model->isNewRecord ){

                    if ( !isset($session['update']) ){
                        $model->qty_good                += $oldreq_good;
                        $model->qty_not_good            += $oldreq_not_good;
                        $model->qty_reject              += $oldreq_reject;
                        $model->qty_dismantle           += $oldreq_dismantle;
                        $model->qty_revocation          += $oldreq_revocation;
                        $model->qty_good_rec            += $oldreq_good_rec;
                        $model->qty_good_for_recond     += $oldreq_good_for_recond;
                        // return "$oldreq_good, $oldreq_not_good, $oldreq_reject, $oldreq_dismantle, $oldreq_revocation";
                    }

                }else{
                    $newRec = true;
                }

                $modelGrfDetail = GrfDetail::find()->andWhere(['orafin_code' => $orafinCode])->andWhere(['id_grf' => $id])->one();
                
                $modeldetail = InstructionGrfDetail::find()
                            ->select([new \yii\db\Expression('sum(qty_good + qty_not_good + qty_reject + qty_dismantle + qty_revocation + qty_good_rec + qty_good_for_recond) as qty_good')])
                            ->joinWith('idMasterItemIm')
                            ->andWhere(['and',['id_instruction_grf' => $id]])
                            ->andWhere(['orafin_code' => $orafinCode])->one();
                $totalqty = $totalqty + $modeldetail->qty_good;

                if ($totalqty > $modelGrfDetail->qty_request) {
                	return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => "Input Qty:$totalqty, melebihi Qty Request:{$modelGrfDetail->qty_request}."]);
                }

                if(!$model->save()){
                    $error = $model->getErrors();
                    $error[0] = ['for IM Code '.$values[1]];
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
                }

                $newitem[] = $model->id_item_im;

                if ( $newRec ){
                    $this->changestock($model, 'minus');
                }
            }

            Yii::$app->session->remove('detailinstruction');
            return json_encode(['status' => 'success']);
            // return 'success';

        }

        $modelInstruction = $this->findModel($id);
        $modelGrfDetail = GrfDetail::find()->andWhere(['orafin_code' => $orafinCode])->andWhere(['id_grf' => $id])->one();
        $modelDetail = MasterItemIm::find()->andWhere(['orafin_code' => $orafinCode])->all();
        $idItemIm = ArrayHelper::map($modelDetail, 'id', 'id');
        
    	$modelinstructiongrfdetail = InstructionGrfDetail::find()                
    		->select([
    			'master_item_im_detail.id as id_item_im',
				'qty_good',
				'qty_not_good',
				'qty_reject',
				'qty_dismantle',
				'qty_revocation',
				'qty_good_rec',
				'qty_good_for_recond',
    		])
            ->joinWith('idMasterItemIm.masterItemImDetails')
            ->andWhere(['and', ['id_instruction_grf' => $modelInstruction->id], ['master_item_im_detail.id_warehouse' => $modelInstruction->id_warehouse] ])
            ->andWhere(['orafin_code' => $orafinCode])->all();
        if (count($modelinstructiongrfdetail) > 0) {
        	# code...
	        $data = [];
	        foreach ($modelinstructiongrfdetail as $key => $modeldetails) {
	           	// return var_dump($modeldetails->idMasterItemIm);
	        	$data[$modeldetails->id_item_im]['rgood'] = $modeldetails->qty_good;
				$data[$modeldetails->id_item_im]['rnotgood'] = $modeldetails->qty_not_good;
				$data[$modeldetails->id_item_im]['rreject'] = $modeldetails->qty_reject;
				$data[$modeldetails->id_item_im]['rdismantle'] = $modeldetails->qty_dismantle;
				$data[$modeldetails->id_item_im]['rrevocation'] = $modeldetails->qty_revocation;
				$data[$modeldetails->id_item_im]['rgoodrec'] = $modeldetails->qty_good_rec;
				$data[$modeldetails->id_item_im]['rgoodforrecond'] = $modeldetails->qty_good_for_recond;
				$data[$modeldetails->id_item_im]['update'] = $data;
	           	
	        }
			Yii::$app->session->set('detailinstruction', $data);        
        }



        $searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->getQueryParams(), $modelInstruction->id_warehouse, null, $idItemIm);

        return $this->render('createdetailinstruksi', [
            'model' => $modelGrfDetail,
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
                $model->s_good              += $session[$id]['update'][$id]['rgood'];
                $model->s_not_good          += $session[$id]['update'][$id]['rnotgood'];
                $model->s_reject            += $session[$id]['update'][$id]['rreject'];
                $model->s_dismantle         += $session[$id]['update'][$id]['rdismantle'];
                $model->s_revocation        += $session[$id]['update'][$id]['rrevocation'];
                $model->s_good_rec          += $session[$id]['update'][$id]['rgoodrec'];
                $model->s_good_for_recond   += $session[$id]['update'][$id]['rgoodforrecond'];
            }
            // return var_dump($model);
            $arr['s_good']            = $model->s_good;
            $arr['s_not_good']        = $model->s_not_good;
            $arr['s_reject']          = $model->s_reject;
            $arr['s_dismantle']       = $model->s_dismantle;
            $arr['s_revocation']      = $model->s_revocation;
            $arr['s_good_rec']        = $model->s_good_rec;
            $arr['s_good_for_recond'] = $model->s_good_for_recond;
            // $arr['req_request'] 	  = array_sum( $session );
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
        $modelGrf = Grf::findOne($id);
        $idwarehouse = $model->id_warehouse;

        if ($model->load(Yii::$app->request->post())) {
            if ( $idwarehouse != $model->id_warehouse ){
                $modelcek = InstructionGrfDetail::find()->andWhere(['id_instruction_grf' => $id])->count();
                if ($modelcek > 0){
                    return 'Hapus semua item sebelum mengganti Warehouse';
                }
            }

            if (!$model->save()){
                return Displayerror::pesan($model->getErrors());
            }

            // $this->createLog($model);
            return 'success';
            
        } else {
            if ($model->status_listing == 53) {
                $model->id_warehouse = '';
            }
            return $this->render('update', [
                'model' => $model,
                'modelGrf' => $modelGrf,
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
            	$this->createLog($model);
	        	$arrAuth = ['/instruction-grf/indexapprove'];
			    $header = 'Alert Approval Instruction GRF';
		        $subject = 'This document is waiting your approval. Please click this link document : '.Url::base(true).'instruction-grf/indexapprove#viewapprove?id='.$model->id.'&header=Detail_Good_Request_Form';
		        Email::sendEmail($arrAuth,$header,$subject);		        

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
                $this->createLog($model);
	      //   	$arrAuth = ['/outbound-grf/indexreg'];
			    // $header = 'Alert TAG SN Outbound GRF';
		     //    $subject = 'This document is waiting your action. Please click this link document : '.Url::base(true).'outbound-grf/indexreg#viewinstruction?id='.$model->id.'&header=Create_Tag_SN';
		     //    Email::sendEmail($arrAuth,$header,$subject);		        
                return 'success';
            }
            
        }else{
            return 'Not Valid for Approve';
        }
    }

    public function actionRevisegrf($id)
    {
        $model = $this->findModel($id);
        $modelgrf = $model->idGrf;
        $modelgrf->status_listing = 3;
        $modelgrf->save();
                
        $foro = false;
        switch ($modelgrf->source) {
            case 'Vendor-IKO':
                $table = 'iko_grf_vendor';
                $grf_number = $modelgrf->grf_number;
                $foro = true;
                break;
            
             case 'Inhouse-IKO':
                $table = 'iko_grf_inhouse';
                $grf_number = $modelgrf->grf_number;
                $foro = true;
                break;
        }
        if ($foro) {
            $command = Yii::$app->dbforo->createCommand("update $table set status_listing = 3 where grf_number = '$grf_number'")->query();
        }


        $model->delete();
        GrfDetail::deleteAll(['id_grf' => $id]);
        return "success";
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
                    $this->createLog($model);
		        	$arrAuth = ['/instruction-grf/index'];
				    $header = 'Alert Need Revise Instruction GRF';
		        	$subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'instruction-grf/index#view?id='.$model->id.'&header=Detail_Good_Request_Form';
			        Email::sendEmail($arrAuth,$header,$subject);		        

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
                    $this->createLog($model);
		        	$arrAuth = ['/instruction-grf/index'];
				    $header = 'Alert Reject Instruction GRF';
		        	$subject = 'This document is reject. Please click this link document : '.Url::base(true).'instruction-grf/index#view?id='.$model->id.'&header=Detail_Good_Request_Form';
			        Email::sendEmail($arrAuth,$header,$subject);		        

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
        $model = $this->findModel($id);;
        $readyverify = 1;
        $totalqty = 0;
        // return var_dump($model->idGrf->idGrfDetail);
        
        $status = 53;
        $modelgrfdetail = GrfDetail::find()->andWhere(['id_grf' => $id])->all();
        foreach ($modelgrfdetail as $grfdetail) {        
            $modeldetail = InstructionGrfDetail::find()
                ->select([new \yii\db\Expression('sum(qty_good + qty_not_good + qty_reject + qty_dismantle + qty_revocation + qty_good_rec + qty_good_for_recond) as qty_good')])
                ->joinWith('idMasterItemIm')
                ->andWhere(['id_instruction_grf' => Yii::$app->session->get('idGrf')])
                ->andWhere(['orafin_code' => $grfdetail->orafin_code])->one();
            if ( !isset($modeldetail->qty_good) || $modeldetail->qty_good < $model->qty_request ) {
                // ada yg belum closed
                $readyverify++;
            }
            $totalqty += $modeldetail->qty_good;
	        
        }
              
        $sendmail = false;
        if ($readyverify == 1){
            if($model->status_listing == 2 || $model->status_listing == 3){
                $model->status_listing = 2;
            }else{
                $model->status_listing = 1;
            }
            $sendmail = true;
        }else{
            if ($totalqty == 0) {                
                $model->status_listing = 53; //new grf
            }else{
                $model->status_listing = 43; //partial
            }
        }
        
        if (!$model->save()){
            
            return Displayerror::pesan($model->getErrors());
        }
        
        Yii::$app->session->remove('idInstructionGrf');
        $this->createLog($model);
        if ($sendmail) {
        	$arrAuth = ['/instruction-grf/indexverify'];
		    $header = 'Alert Verify Instruction GRF';
	        $subject = 'This document is waiting your verify. Please click this link document : '.Url::base(true).'instruction-grf/indexverify#viewverify?id='.$model->id.'&header=Detail_Good_Request_Form';
	        Email::sendEmail($arrAuth,$header,$subject);
        }

        return 'success';
    }

    private function changestock($model, $action = 'add'){
        // $modelIm = MasterItemImDetail::findOne($model->id_item_im);
        $modelIm = MasterItemImDetail::find()->andWhere(['and', ['id_master_item_im' => $model->id_item_im], ['id_warehouse' => $model->idInstructionGrf->id_warehouse]])->one();
        
        if ($action == 'add'){
            $modelIm->s_good                = $modelIm->s_good + $model->qty_good;
            $modelIm->s_not_good            = $modelIm->s_not_good + $model->qty_not_good;
            $modelIm->s_reject              = $modelIm->s_reject + $model->qty_reject;
            $modelIm->s_dismantle      = $modelIm->s_dismantle + $model->qty_dismantle;
            $modelIm->s_revocation  = $modelIm->s_revocation + $model->qty_revocation;
            $modelIm->s_good_rec  = $modelIm->s_good_rec + $model->qty_good_rec;
            $modelIm->s_good_for_recond  = $modelIm->s_good_for_recond + $model->qty_good_for_recond;
        }else{
            $modelIm->s_good                = $modelIm->s_good - $model->qty_good;
            $modelIm->s_not_good            = $modelIm->s_not_good - $model->qty_not_good;
            $modelIm->s_reject              = $modelIm->s_reject - $model->qty_reject;
            $modelIm->s_dismantle      = $modelIm->s_dismantle - $model->qty_dismantle;
            $modelIm->s_revocation  = $modelIm->s_revocation - $model->qty_revocation;
            $modelIm->s_good_rec  = $modelIm->s_good_rec + $model->qty_good_rec;
            $modelIm->s_good_for_recond  = $modelIm->s_good_for_recond + $model->qty_good_for_recond;
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
        $model = $this->findModel($id);
        $model->status_listing = 13;
        $model->save();
        $this->createLog($model);

        foreach($model->getIdInstructionGrfDetail as $modeldetail){
            $modeldetail->qty_good              = 0;
            $modeldetail->qty_not_good          = 0;
            $modeldetail->qty_reject            = 0;
            $modeldetail->qty_dismantle         = 0;
            $modeldetail->qty_revocation        = 0;
            $modeldetail->qty_good_rec          = 0;
            $modeldetail->qty_good_for_recond   = 0;
            $modeldetail->save();
            // update stock at model beforesave
        }

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

    protected function createLog($model)
    {
        $modelLog = new LogInstructionGrf();
        $modelLog->setAttributes($model->attributes);
        $modelLog->save();
    }

}
