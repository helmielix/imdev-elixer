<?php

namespace logistik\controllers;

use Yii;
use common\models\InstructionWhTransfer;
use common\models\LogInstructionWhTransfer;
use common\models\InstructionWhTransferDetail;
use common\models\MasterItemIm;
use common\models\MasterItemImDetail;
use common\models\SearchInstructionWhTransfer;
use common\models\SearchLogInstructionWhTransfer;
use common\models\SearchInstructionWhTransferDetail;
use common\models\SearchMasterItemIm;
use common\models\SearchInboundWhTransfer;
use common\models\InboundWhTransfer;

use common\models\OutboundWhTransferDetailSn;
use common\models\InboundWhTransferDetailSn;
use common\models\OutboundWhTransferDetail;
use common\models\InboundWhTransferDetail;
use common\models\MasterSn;
use common\models\LogMasterSn;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\widgets\Displayerror;
use common\widgets\Email;
use common\widgets\Numbertoroman;
use yii\helpers\Url;

use common\models\UserWarehouse;
use common\models\Warehouse;

/**
 * InstructionWhTransferController implements the CRUD actions for InstructionWhTransfer model.
 */
class InstructionWhTransferController extends Controller
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
     * Lists all InstructionWhTransfer models.
     * @return mixed
     */
    private function listIndex($action)
    {
        $searchModel = new SearchInstructionWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul, $action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

	public function actionIndex()
    {
        return $this->render('index', $this->listIndex('input'));
    }

	public function actionIndexapprove()
    {
        return $this->render('index', $this->listIndex('approve'));
    }

    public function actionIndexoverview()
    {
        return $this->render('index', $this->listIndex('overview'));
    }

    public function actionIndexlog()
    {
        $searchModel = new SearchLogInstructionWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexdetail(){
		$this->layout = 'blank';
		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->session->get('idInstWhTr'));

		Yii::$app->session->remove('detailinstruction');

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Displays a single InstructionWhTransfer model.
     * @param integer $id
     * @return mixed
     */
    private function detailView($id)
    {
		$model = $this->findModel($id);

		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		Yii::$app->session->set('idInstWhTr', $model->id);

        return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

	public function actionView($id){
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
	}

	public function actionViewreport($id){
		$this->layout = 'blank';

		$arrIdWarehouse = [];
        if (Yii::$app->user->identity->id == 5){
            $modelUserWarehouse = Warehouse::find()->select('id as id_warehouse')->asArray()->all();
        }else{
            $modelUserWarehouse = UserWarehouse::find()->select('id_warehouse')->where(['id_user'=>Yii::$app->user->identity->id])->asArray()->all();
        }

        foreach ($modelUserWarehouse as $key => $value) {
        	array_push($arrIdWarehouse, $value['id_warehouse']);
        }

		$searchModel = new SearchInboundWhTransfer();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul,'verifydetail', $id, $arrIdWarehouse);

		$model = InboundWhTransfer::find()->select([
					'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
					'outbound_wh_transfer.no_sj',
					'outbound_wh_transfer.plate_number',
					'outbound_wh_transfer.driver',
					'instruction_wh_transfer.wh_origin',
					'instruction_wh_transfer.wh_destination',
					'instruction_wh_transfer.instruction_number',
					'inbound_wh_transfer.status_listing',
					'inbound_wh_transfer.arrival_date',
					'inbound_wh_transfer.created_date',
					'inbound_wh_transfer.updated_date',
					'inbound_wh_transfer.revision_remark',
				])
				->joinWith('idOutboundWh.idInstructionWh')
				->andWhere(['id' => $id])->one();

		Yii::$app->session->set('idInstWhTr',$id);

        return $this->render('//inbound-wh-transfer/viewreport', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
	}

	public function actionViewlog($id){
		$this->layout = 'blank';
		$model = LogInstructionWhTransfer::findOne($id);

		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $model->id);

		return $this->render('viewlog', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
     * Creates a new InstructionWhTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->layout = 'blank';
        $model = new InstructionWhTransfer();
		// $model->scenario = 'create';
		$model->id_modul = $this->id_modul;
		$newidinst = InstructionWhTransfer::find()->andWhere(['and',['like', 'instruction_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count();
		if ($newidinst == 0){
			$newidinst = 1;
		}else{
			$newidinst++;
		}

		$monthroman = Numbertoroman::convert(date('n'));

		$model->instruction_number = sprintf("%04d", $newidinst).'/INST-IC1/WT/'.$monthroman.date('/Y');

        if ($model->load(Yii::$app->request->post())) {


			$model->status_listing = 7;

			$filepath = '';
			if (isset($_FILES['file'])) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$model->file = $_FILES['file'];
						$filename = $_FILES['file']['name'];
						$filepath = 'uploads/INST/DIVSATU/';
					}
				}
			}

			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}elseif ($filepath != '') {			
				$model->file_attachment = $filepath.$model->id.'/'.$filename;
				$model->save();
				if (!file_exists($filepath.$model->id.'/')) {
					mkdir($filepath.$model->id.'/', 0777, true);
				}
				move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
			}


			Yii::$app->session->set('idInstWhTr', $model->id);

			$this->createLog($model);

            return 'success';
        } else {
			Yii::$app->session->remove('idInstWhTr');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InstructionWhTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$this->layout = 'blank';
        $model = $this->findModel($id);
		$whorigin = $model->wh_origin;

		Yii::$app->session->set('idInstWhTr', $model->id);
        if ($model->load(Yii::$app->request->post())) {

			if ( $whorigin != $model->wh_origin ){
				$modelcek = InstructionWhTransferDetail::find()->andWhere(['id_instruction_wh' => $id])->count();
				if ($modelcek > 0){
					return 'Hapus semua item sebelum mengganti Warehouse Asal';
				}
			}


			$filename = '';
			if (isset($_FILES['file'])) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$model->file = $_FILES['file'];
						$filename = $_FILES['file']['name'];
						$filepath = 'uploads/INST/DIVSATU/';
						$model->file_attachment = $filepath.$model->id.'/'.$filename;
					}
				}
			}

			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}

			if ($filename != ''){
				move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
			}

			// $this->createLog($model);
			return 'success';
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

	public function actionCreatedetail(){
		$this->layout = 'blank';
		$id = Yii::$app->session->get('idInstWhTr');

		if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){

			$data_im_code         = Yii::$app->request->post('im_code');
			$data_r_good          = Yii::$app->request->post('rgood');
			$data_r_notgood       = Yii::$app->request->post('rnotgood');
			$data_r_reject        = Yii::$app->request->post('rreject');
			$data_r_dismantle     = Yii::$app->request->post('rdismantle');
			$data_r_revocation    = Yii::$app->request->post('rrevocation');
			$data_r_good_for_recond  = Yii::$app->request->post('rgoodforrecond');
			$data_r_good_rec  	  = Yii::$app->request->post('rgoodrec');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){

				if( ($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '' && $data_r_dismantle[$key] == '' && $data_r_revocation[$key] == '' && $data_r_good_rec[$key] == '' && $data_r_good_for_recond[$key] == '') ||
					($data_r_good[$key] == 0 && $data_r_notgood[$key] == 0 && $data_r_reject[$key] == 0 && $data_r_dismantle[$key] == 0 && $data_r_revocation[$key] == 0 && $data_r_good_rec[$key] == 0 && $data_r_good_for_recond[$key] == 0)){
					continue;
				}
				$data_r_good[$key] 				= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$data_r_notgood[$key]			= ($data_r_notgood[$key] == '') ? 0 : $data_r_notgood[$key];
				$data_r_reject[$key]			= ($data_r_reject[$key] == '') ? 0 : $data_r_reject[$key];
				$data_r_dismantle[$key]			= ($data_r_dismantle[$key] == '') ? 0 : $data_r_dismantle[$key];
				$data_r_revocation[$key]		= ($data_r_revocation[$key] == '') ? 0 : $data_r_revocation[$key];
				$data_r_good_rec[$key]			= ($data_r_good_rec[$key] == '') ? 0 : $data_r_good_rec[$key];
				$data_r_good_for_recond[$key]	= ($data_r_good_for_recond[$key] == '') ? 0 : $data_r_good_for_recond[$key];

				$values = explode(';',$value);

				$modelitemim = MasterItemIm::find()->joinWith('masterItemImDetails')->andWhere(['master_item_im_detail.id' => $values[0]])->one();

				$modelcek = InstructionWhTransferDetail::find()->andWhere(['and',['id_item_im' => $modelitemim->id], ['id_instruction_wh' => $id]]);
				$oldreq_good = 0;
				$oldreq_not_good = 0;
				$oldreq_reject = 0;
				$oldreq_dismantle = 0;
				$oldreq_revocation = 0;
				$oldreq_good_rec = 0;
				$oldreq_good_for_recond = 0;
				if ( $modelcek->count() == 0 ){
					$model = new InstructionWhTransferDetail();
				}else{
					$model = $modelcek->one();
					$oldreq_good 				= $model->req_good;
					$oldreq_not_good 			= $model->req_not_good;
					$oldreq_reject 				= $model->req_reject;
					$oldreq_dismantle 			= $model->req_dismantle;
					$oldreq_revocation 			= $model->req_revocation;
					$oldreq_good_rec 			= $model->req_good_rec;
					$oldreq_good_for_recond		= $model->req_good_for_recond;
				}

				$modelMasterItem = MasterItemImDetail::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				// return var_dump( Yii::$app->session->get('detailinstruction')[$values[0]]['update'][$values[0]] );
				$session = Yii::$app->session->get('detailinstruction')[$values[0]];
				if ( isset($session['update']) ){
					$datagood 			 = $data_r_good[$key] - $session['update'][$values[0]]['rgood'];
					$datanotgood 		 = $data_r_notgood[$key] - $session['update'][$values[0]]['rnotgood'];
					$datareject 		 = $data_r_reject[$key] - $session['update'][$values[0]]['rreject'];
					$datadismantle 		 = $data_r_dismantle[$key] - $session['update'][$values[0]]['rdismantle'];
					$datarevocation 	 = $data_r_revocation[$key] - $session['update'][$values[0]]['rrevocation'];
					$datagood_rec 		 = $data_r_good_rec[$key] - $session['update'][$values[0]]['rgoodrec'];
					$datagood_for_recond = $data_r_good_for_recond[$key] - $session['update'][$values[0]]['rgoodforrecond'];
				}else{
					$datagood 			 = $data_r_good[$key];
					$datanotgood 		 = $data_r_notgood[$key];
					$datareject 		 = $data_r_reject[$key];
					$datadismantle 		 = $data_r_dismantle[$key];
					$datarevocation 	 = $data_r_revocation[$key];
					$datagood_rec 		 = $data_r_good_rec[$key];
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

				$model->id_instruction_wh		= $id;
				// $model->id_item_im				= $values[0];
				$model->id_item_im				= $modelitemim->id;
				$model->req_good				= $data_r_good[$key];
				$model->req_not_good			= $data_r_notgood[$key];
				$model->req_reject				= $data_r_reject[$key];
				$model->req_dismantle			= $data_r_dismantle[$key];
				$model->req_revocation			= $data_r_revocation[$key];
				$model->req_good_rec			= $data_r_good_rec[$key];
				$model->req_good_for_recond		= $data_r_good_for_recond[$key];

				$newRec = false;
				if ( !$model->isNewRecord ){

					if ( !isset($session['update']) ){
						$model->req_good				+= $oldreq_good;
						$model->req_not_good			+= $oldreq_not_good;
						$model->req_reject				+= $oldreq_reject;
						$model->req_dismantle			+= $oldreq_dismantle;
						$model->req_revocation			+= $oldreq_revocation;
						$model->req_good_rec			+= $oldreq_good_rec;
						$model->req_good_for_recond		+= $oldreq_good_for_recond;
						// return "$oldreq_good, $oldreq_not_good, $oldreq_reject, $oldreq_dismantle, $oldreq_revocation";
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
		$modelDetail = InstructionWhTransferDetail::find()->select(['id_item_im'])->andWhere(['id_instruction_wh' => $id])->all();
		$idItemIm = ArrayHelper::map($modelDetail, 'id_item_im', 'id_item_im');
		$idItemIm = [];

		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->getQueryParams(), $modelInstruction->wh_origin, $idItemIm);

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

	public function actionSetsessionreport(){
		if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
			$data = Yii::$app->session->get('detailreport');

			$id_detail   = Yii::$app->request->post('id');
			$val  = Yii::$app->request->post('val');
			$type = Yii::$app->request->post('type');

			if (!is_array($val)){
				// non SN
				// cek max qty
				$command = (new \yii\db\Query())
					->select ([
						new \yii\db\Expression('req_good - qty_good as good'),
						new \yii\db\Expression('req_not_good - qty_not_good as not_good'),
						new \yii\db\Expression('req_reject - qty_reject as reject'),
						new \yii\db\Expression('req_dismantle - qty_dismantle as dismantle'),
						new \yii\db\Expression('req_revocation - qty_revocation as revocation'),
						new \yii\db\Expression('req_good_rec - qty_good_rec as good_rec'),
						new \yii\db\Expression('req_good_for_recond - qty_good_for_recond as good_for_recond'),
					])
					->from('outbound_wh_transfer_detail, inbound_wh_transfer_detail')
					->andWhere(['outbound_wh_transfer_detail.id' => $id_detail[1]])
					->andWhere(['inbound_wh_transfer_detail.id' => $id_detail[0]])
					->createCommand();
				$command = Yii::$app->db->createCommand($command->sql, $command->params)
					->queryOne();

				$errorMax = '';
				switch($type){
					case 'adjsgood[]':
						if ($val > $command['good']){
							$errorMax = $command['good'];
						}
					break;
					case 'adjsnotgood[]':
						if ($val > $command['not_good']){
							$errorMax = $command['not_good'];
						}
					break;
					case 'adjsreject[]':
						if ($val > $command['reject']){
							$errorMax = $command['reject'];
						}
					break;
					case 'adjsdismantle[]':
						if ($val > $command['dismantle']){
							$errorMax = $command['dismantle'];
						}
					break;
					case 'adjsrevocation[]':
						if ($val > $command['revocation']){
							$errorMax = $command['revocation'];
						}
					case 'adjsgood_rec[]':
						if ($val > $command['good_rec']){
							$errorMax = $command['good_rec'];
						}
					case 'adjsgood_for_recond[]':
						if ($val > $command['good_for_recond']){
							$errorMax = $command['good_for_recond'];
						}
					break;
				}
				if ( is_numeric($errorMax) ){
					return "This value is more than max stock:".$errorMax;
				}

			}

			$data[$id_detail[0]][$type] = $val;

			Yii::$app->session->set('detailreport', $data);
			return 'success';
			return var_dump($data);
		}
	}

	public function actionCurrentstock(){
		if (Yii::$app->request->isPost){
			$id   = Yii::$app->request->post('id');

			$model = MasterItemImDetail::findOne($id);
			$session = Yii::$app->session->get('detailinstruction');

			if ( isset($session[$id]['update']) ){
				$model->s_good				+= $session[$id]['update'][$id]['rgood'];
				$model->s_not_good			+= $session[$id]['update'][$id]['rnotgood'];
				$model->s_reject			+= $session[$id]['update'][$id]['rreject'];
				$model->s_dismantle			+= $session[$id]['update'][$id]['rdismantle'];
				$model->s_revocation		+= $session[$id]['update'][$id]['rrevocation'];
				$model->s_good_rec 			+= $session[$id]['update'][$id]['rgoodrec'];
				$model->s_good_for_recond	+= $session[$id]['update'][$id]['rgoodforrecond'];
			}
			// return var_dump($model);
			$arr['s_good'] 			  = $model->s_good;
			$arr['s_not_good'] 		  = $model->s_not_good;
			$arr['s_reject']		  = $model->s_reject;
			$arr['s_dismantle']		  = $model->s_dismantle;
			$arr['s_revocation']	  = $model->s_revocation;
			$arr['s_good_rec'] 		  = $model->s_good_rec;
			$arr['s_good_for_recond'] = $model->s_good_for_recond;
			return json_encode($arr);
		}
	}

	public function actionUpdatedetail($idDetail){
		// unused
		$this->layout = 'blank';
		$model = InstructionWhTransferDetail::findOne($idDetail);
		$model->scenario = 'updatedetail';
		// $model->rem_good = $model->idMasterItemImDetail->s_good + $model->req_good;
		// $model->rem_not_good = $model->idMasterItemImDetail->s_not_good + $model->req_not_good;
		// $model->rem_reject = $model->idMasterItemImDetail->s_reject + $model->req_reject;
		// $model->rem_dismantle = $model->idMasterItemImDetail->s_dismantle + $model->req_dismantle;
		// $model->rem_revocation = $model->idMasterItemImDetail->s_revocation + $model->req_revocation;

		$idMasterItemImDetail = MasterItemImDetail::find()->andWhere(['and', ['id_master_item_im' => $model->id_item_im], ['id_warehouse' => $model->idInstructionWh->wh_origin]])->one();
		// if ($model->load(Yii::$app->request->post())) {

		// 	$data['rem_good'] 			 = $idMasterItemImDetail->s_good + $model->req_good;
		// 	$data['rem_not_good'] 		 = $idMasterItemImDetail->s_not_good + $model->req_not_good;
		// 	$data['rem_reject'] 		 = $idMasterItemImDetail->s_reject + $model->req_reject;
		// 	$data['rem_dismantle'] 		 = $idMasterItemImDetail->s_dismantle + $model->req_dismantle;
		// 	$data['rem_revocation'] 	 = $idMasterItemImDetail->s_revocation + $model->req_revocation;
		// 	$data['rem_good_rec'] 		 = $idMasterItemImDetail->s_good_rec + $model->req_good_rec;
		// 	$data['rem_good_for_recond'] = $idMasterItemImDetail->s_good_for_recond + $model->req_good_for_recond;

		// 	$json = $data;
		// 	if ($model->req_good > $idMasterItemImDetail->s_good + $model->req_good){
		// 		$json['pesan'] = $model->getAttributeLabel('req_good').' must be less than "'.$model->getAttributeLabel('rem_good').'".';
		// 		return json_encode($json);
		// 	}
		// 	if ($model->req_not_good > $idMasterItemImDetail->s_not_good + $model->req_not_good){
		// 		$json['pesan'] = $model->getAttributeLabel('req_not_good').' must be less than "'.$model->getAttributeLabel('s_not_good').'".';
		// 		return json_encode($json);
		// 	}
		// 	if ($model->req_reject > $idMasterItemImDetail->s_reject + $model->req_reject){
		// 		$json['pesan'] = $model->getAttributeLabel('req_reject').' must be less than "'.$model->getAttributeLabel('s_reject').'".';
		// 		return json_encode($json);
		// 	}
		// 	if ($model->req_dismantle > $idMasterItemImDetail->s_dismantle + $model->req_dismantle){
		// 		$json['pesan'] = $model->getAttributeLabel('req_dismantle').' must be less than "'.$model->getAttributeLabel('s_dismantle').'".';
		// 		return json_encode($json);
		// 	}
		// 	if ($model->req_revocation > $idMasterItemImDetail->s_revocation + $model->req_revocation){
		// 		$json['pesan'] = $model->getAttributeLabel('rem_revocation').' already change, and '.$model->getAttributeLabel('req_revocation').' is more than current stock';
		// 		return json_encode($json);
		// 	}

		// 	if (!$model->save()){
		// 		$json['pesan'] = Displayerror::pesan($model->getErrors());
		// 		return json_encode($json);
		// 		// return Displayerror::pesan($model->getErrors());
		// 	}
		// 	// $this->createLog($model);
		// 	return json_encode(['pesan' => 'success']);
		// 	// return 'success';
  //       } else {

			// set session for update
			Yii::$app->session->remove('detailinstruction');

			$data[$idMasterItemImDetail->id]['rgood'] = $model->req_good;
			$data[$idMasterItemImDetail->id]['rnotgood'] = $model->req_not_good;
			$data[$idMasterItemImDetail->id]['rreject'] = $model->req_reject;
			$data[$idMasterItemImDetail->id]['rdismantle'] = $model->req_dismantle;
			$data[$idMasterItemImDetail->id]['rrevocation'] = $model->req_revocation;
			$data[$idMasterItemImDetail->id]['rgoodrec'] = $model->req_good_rec;
			$data[$idMasterItemImDetail->id]['rgoodforrecond'] = $model->req_good_for_recond;
			$data[$idMasterItemImDetail->id]['update'] = $data;

			Yii::$app->session->set('detailinstruction', $data);

			$searchModel = new SearchMasterItemIm();
			// $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->queryParams, $model->idInstructionWh->wh_origin, [$model->id_item_im]);
			$dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->queryParams, $model->idInstructionWh->wh_origin, [$idMasterItemImDetail->id]);

			return $this->render('createdetail', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);

            // return $this->render('_formdetail', [
                // 'model' => $model,
            // ]);
        // }
	}

	public function actionSubmit($id){
		$model = InstructionWhTransfer::findOne($id);
		$modelDetail = InstructionWhTransferDetail::find()->andWhere(['id_instruction_wh' => $id])->count();
		$sendmail = false;
		if ($modelDetail > 0){
			if($model->status_listing == 2 || $model->status_listing == 3){
				$model->status_listing = 2;
			}else{
				$model->status_listing = 1;
			}
			$sendmail = true;
		}else{
			$model->status_listing = 7;
		}

		if (!$model->save()){
			return Displayerror::pesan($model->getErrors());
		}

		Yii::$app->session->remove('idInstWhTr');
		$this->createLog($model);
		if ($sendmail) {
			// sendmail untuk status 1 atau 2
			$arrAuth = ['/instruction-wh-transfer/indexapprove'];
		    $header = 'Alert Approve Instruction Warehouse Transfer';
	        $subject = 'This document is waiting your approval. Please click this link document : '.Url::base(true).'instruction-wh-transfer/indexapprove#viewapprove?id='.$model->id.'&header=Approve_INSTRUCTION_WH';
	        Email::sendEmail($arrAuth,$header,$subject);
		}
		return 'success';
	}

	public function actionReporttoamd($id){
		$model = InstructionWhTransfer::find()->joinWith('outboundWhTransfer.idInboundWh')->andWhere(['id' => $id])->one();

		if ( Yii::$app->request->post() ){
			$sn_type = Yii::$app->request->post('sn_type');
			$id_detail = Yii::$app->request->post('id_detail');
			$id_detail = explode(';', $id_detail);
			$modeloutbounddetail = OutboundWhTransferDetail::findOne($id_detail[1]);
			$modelinbounddetail = InboundWhTransferDetail::findOne($id_detail[0]);

			if ($sn_type == 1){
				// item ber SN
				$adjssn = Yii::$app->request->post('adjssn')[0];

				$dataInboundSN = ArrayHelper::index( InboundWhTransferDetailSn::find()
					->select([new \yii\db\Expression("case when old_serial_number is null then serial_number else old_serial_number end as serial_number"),])
					->andWhere(['id_inbound_wh_detail' => $id_detail[0]])
					->all(), 'serial_number');
				$dataSN = ArrayHelper::map( OutboundWhTransferDetailSn::find()
					->andWhere(['id_outbound_wh_detail' => $id_detail[1]])
					->andWhere(['not in', 'serial_number', $dataInboundSN])
					->all() ,'serial_number', 'condition');

				foreach ($dataSN as $SNcek => $condition){

					if ( strpos($adjssn, $SNcek) !== false ){
						// SN termasuk dalam adjust
						// // get log for last_transaction
						// $logmastersn = LogMasterSn::find()->andWhere(['serial_number' => $SNcek])->orderBy('idlog desc')->one();
						$logmastersn = MasterSn::find()->andWhere(['serial_number' => $SNcek])->andWhere(['status' => 27])->one();
						$last_transaction = $logmastersn->prev_last_transaction;
						// // get log for last_transaction

						// update stock
						// $masterstock = MasterItemImDetail::findOne($modeloutbounddetail->id_item_im);
						$masterstock = MasterItemImDetail::find()->andWhere(['and', ['id_warehouse' => $modeloutbounddetail->idOutboundWh->idInstructionWh->wh_origin], ['id_master_item_im' => $modeloutbounddetail->id_item_im]])->one();
						$cond = 's_'.str_replace(' ','_',$condition);
						$masterstock->{$cond} += 1;
						$masterstock->save();

					}else{
						// SN tidak termasuk dalam adjust = intransit
						$last_transaction = 'INTRANSIT';
						// dont need, SN already INTRANSIT at this moment
					}
					// update data outbound dan instruction menghilangkan setiap SN pada foreach
					OutboundWhTransferDetailSn::deleteAll(['serial_number' => $SNcek]);

					// // update master SN
					$mastersn = MasterSn::find()->andWhere(['serial_number' => $SNcek])->andWhere(['status' => 27])->one();
					if ( isset($last_transaction) ){
						$mastersn->last_transaction = $last_transaction;
						$mastersn->condition = $mastersn->last_condition;
					}
					$mastersn->save();
					// // update master SN
				}

				// return var_dump ( $dataSN );

			}else{
				// item Non SN
				// return var_dump( Yii::$app->request->post('adjsnotgood')[0] );
				// update stock, inputtan adjust menambah kembali stok gudang awal
				// $masterstock = MasterItemImDetail::findOne($modeloutbounddetail->id_item_im);
				$masterstock = MasterItemImDetail::find()->andWhere(['and', ['id_warehouse' => $modeloutbounddetail->idOutboundWh->idInstructionWh->wh_origin], ['id_master_item_im' => $modeloutbounddetail->id_item_im]])->one();

				$masterstock->s_good 			+= Yii::$app->request->post('adjsgood')[0];
				$masterstock->s_not_good 		+= Yii::$app->request->post('adjsnotgood')[0];
				$masterstock->s_reject 			+= Yii::$app->request->post('adjsreject')[0];
				$masterstock->s_dismantle 		+= Yii::$app->request->post('adjsdismantle')[0];
				$masterstock->s_revocation 		+= Yii::$app->request->post('adjsrevocation')[0];
				$masterstock->s_good_rec 		+= Yii::$app->request->post('adjsgood_rec')[0];
				$masterstock->s_good_for_recond += Yii::$app->request->post('adjsgood_for_recond')[0];
				$masterstock->save();
			}

			$modelinbounddetail->status_listing = 36;
			$modelinbounddetail->status_tagsn   = 41;
			$modelinbounddetail->status_report  = 36;
			$modelinbounddetail->save();

			$modeloutbounddetail->req_good 				 = $modelinbounddetail->qty_good;
			$modeloutbounddetail->req_not_good 			 = $modelinbounddetail->qty_not_good;
			$modeloutbounddetail->req_reject 			 = $modelinbounddetail->qty_reject;
			$modeloutbounddetail->req_dismantle 	 	 = $modelinbounddetail->qty_dismantle;
			$modeloutbounddetail->req_revocation 		 = $modelinbounddetail->qty_revocation;
			$modeloutbounddetail->req_good_rec 			 = $modelinbounddetail->qty_good_rec;
			$modeloutbounddetail->req_good_for_recond	 = $modelinbounddetail->qty_good_for_recond;
			$modeloutbounddetail->save();

			$modelinstructiondetail = InstructionWhTransferDetail::find()->andWhere(['id_instruction_wh' => $id, 'id_item_im' => $modeloutbounddetail->id_item_im ])->one();
			$modelinstructiondetail->req_good				= $modelinbounddetail->qty_good;
			$modelinstructiondetail->req_not_good			= $modelinbounddetail->qty_not_good;
			$modelinstructiondetail->req_reject				= $modelinbounddetail->qty_reject;
			$modelinstructiondetail->req_dismantle			= $modelinbounddetail->qty_dismantle;
			$modelinstructiondetail->req_revocation			= $modelinbounddetail->qty_revocation;
			$modelinstructiondetail->req_good_rec 			= $modelinbounddetail->qty_good_rec;
			$modelinstructiondetail->req_good_for_recond 	= $modelinbounddetail->qty_good_for_recond;
			$modelinstructiondetail->save();


			// send email disini

			// send email disini

			$done = 0;
			foreach($model->outboundWhTransfer->idInboundWh->inboundWhTransferDetails as $modeldetail){
				if ( $modeldetail->status_report == 31 ){
					$done++;
				}
			}
			if ($done == 0){
				// semua item sudah report to AMD
				$model->status_listing = 5;
				$model->save();

				$model->outboundWhTransfer->idInboundWh->status_listing = 36;
				$model->outboundWhTransfer->idInboundWh->save();
			}

			return 'success';
		}
	}

	public function actionApprove($id){
		$model = $this->findModel($id);

		if ($model->status_listing == 1 || $model->status_listing == 2){
			$model->status_listing = 5;

			if ($model->save()){
				 $this->createLog($model);
				$arrAuth = ['/outbound-wh-transfer/index'];
                $header = 'Tagging SN Warehouse Transfer';
                $subject = 'This document is ready for tagging SN. Please click this link document : '.Url::base(true).'/outbound-wh-transfer/index#view?id='.$model->id.'&header=Detail_Material_Warehouse';
                Email::sendEmail($arrAuth,$header,$subject,$model->wh_origin);
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
			if(!empty($_POST['InstructionWhTransfer']['revision_remark'])) {
				$model->status_listing = 3;
				$model->revision_remark = $_POST['InstructionWhTransfer']['revision_remark'];
				if($model->save()) {
					// $this->createLog($model);
					$this->createLog($model);
					$arrAuth = ['/instruction-wh-transfer/index'];
	                $header = 'Alert Need Revise Warehouse Transfer';
	                $subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/instruction-wh-transfer/index#view?id='.$model->id.'&header=Detail_Material_Warehouse';
	                Email::sendEmail($arrAuth,$header,$subject,$model->wh_origin);

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
			if(!empty($_POST['InstructionWhTransfer']['revision_remark'])) {
				$model->status_listing = 6;
				$model->revision_remark = $_POST['InstructionWhTransfer']['revision_remark'];
				if($model->save()) {
                     $this->createLog($model);
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

    /**
     * Deletes an existing InstructionWhTransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	// InstructionWhTransferDetail::deleteAll('id_instruction_wh = :id_instruction_wh', [':id_instruction_wh' => $id]);
        $model = $this->findModel($id);
		$model->status_listing = 13;
		$model->save();
		$this->createLog($model);

		foreach($model->instructionWhTransferDetails as $modeldetail){
			$modeldetail->req_good				= 0;
			$modeldetail->req_not_good			= 0;
			$modeldetail->req_reject			= 0;
			$modeldetail->req_dismantle			= 0;
			$modeldetail->req_revocation		= 0;
			$modeldetail->req_good_rec 		 	= 0;
			$modeldetail->req_good_for_recond	= 0;
			$modeldetail->save();
			// update stock at model beforesave
		}

        return $this->redirect(['index']);
    }

	private function changestock($model, $action = 'add'){
		// $modelIm = MasterItemImDetail::findOne($model->id_item_im);
		$modelIm = MasterItemImDetail::find()->andWhere(['and', ['id_master_item_im' => $model->id_item_im], ['id_warehouse' => $model->idInstructionWh->wh_origin]])->one();

		if ($action == 'add'){
			$modelIm->s_good				= $modelIm->s_good + $model->req_good;
			$modelIm->s_not_good			= $modelIm->s_not_good + $model->req_not_good;
			$modelIm->s_reject				= $modelIm->s_reject + $model->req_reject;
			$modelIm->s_dismantle			= $modelIm->s_dismantle + $model->req_dismantle;
			$modelIm->s_revocation 			= $modelIm->s_revocation + $model->req_revocation;
			$modelIm->s_good_rec 			= $modelIm->s_good_rec + $model->req_good_rec;
			$modelIm->s_good_for_recond 	= $modelIm->s_good_for_recond + $model->req_good_for_recond;
		}else{
			$modelIm->s_good				= $modelIm->s_good - $model->req_good;
			$modelIm->s_not_good			= $modelIm->s_not_good - $model->req_not_good;
			$modelIm->s_reject				= $modelIm->s_reject - $model->req_reject;
			$modelIm->s_dismantle			= $modelIm->s_dismantle - $model->req_dismantle;
			$modelIm->s_revocation 			= $modelIm->s_revocation - $model->req_revocation;
			$modelIm->s_good_rec 			= $modelIm->s_good_rec - $model->req_good_rec;
			$modelIm->s_good_for_recond 	= $modelIm->s_good_for_recond - $model->req_good_for_recond;
		}


		$modelIm->save();
	}

	public function actionDeletedetail($id){
		$model = InstructionWhTransferDetail::findOne($id);
		Yii::$app->session->remove('detailinstruction');
		if ($model === null){
			$this->layout = 'blank';
			return $this->render('view', $this->detailView(Yii::$app->session->get('idInstWhTr')));
		}
		$idInstWhTr = $model->id_instruction_wh;
		$cacheModel = $model;
		if ($model->delete()){
			$this->changestock($cacheModel);
			// $this->layout = 'blank';
			return $this->actionIndexdetail();
			// return $this->render('view', $this->detailView($idInstWhTr));
			// return $this->redirect(['view', 'id' => $idInstWhTr]);
		}


	}

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
  //               $model = InstructionWhTransferDocument::findOne($id);
  //           }else {
  //               throw new NotFoundHttpException("The request page does not exist.", 1);

  //           }
		// }else{


  //           if ($modul=='log'){
  //               $model = LogInstructionWhTransfer::findOne($id);
  //           }

		// 	elseif($modul=='vendor'){
		// 		$basepath = Yii::getAlias('@os') . '/web/';
		// 		$model = OsVendorTermSheet::findOne($id);
		// 	}
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
		// return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
        // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}

	protected function createLog($model)
    {
        $modelLog = new LogInstructionWhTransfer();
        $modelLog->setAttributes($model->attributes);
		if(!$modelLog->save()){
			throw new NotFoundHttpException(Displayerror::pesan($modelLog->getErrors()));
			return Displayerror::pesan($modelLog->getErrors());
		}
    }

    /**
     * Finds the InstructionWhTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionWhTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstructionWhTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
