<?php

namespace logistik\controllers;

use Yii;

use common\models\InstructionProduction;
use common\models\LogInstructionProduction;
use common\models\InstructionProductionDetail;
use common\models\InstructionProductionDetailSetItem;
use common\models\MasterItemIm;
use common\models\SearchInstructionProduction;
use common\models\SearchLogInstructionProduction;
use common\models\SearchInstructionProductionDetail;
use common\models\SearchInstructionProductionDetailSetItem;
use common\models\SearchMasterItemIm;
use common\models\SearchParameterMasterItem;
use common\models\SearchParameterMasterItemDetail;
use common\models\ParameterMasterItem;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\widgets\Displayerror;
use common\widgets\Numbertoroman;
use common\widgets\Email;

/**
 * InstructionProduction implements the CRUD actions for InstructionProduction model.
 */
class InstructionProductionController extends Controller
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
     * Lists all InstructionProduction models.
     * @return mixed
     */
    private function listIndex($action)
    {
        $searchModel = new SearchInstructionProduction();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, $action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

	public function actionIndex()
    {
        return $this->render('index', $this->listIndex('input'));
    }

    public function actionIndexdeclare()
    {
        return $this->render('indexdeclare', $this->listIndex('input_declare'));
    }

    public function actionIndexapprovedeclare()
    {
        return $this->render('indexdeclare', $this->listIndex('approve_declare'));
    }

	public function actionIndexapprove()
    {
        return $this->render('index', $this->listIndex('approve'));
    }

    public function actionIndexlog()
    {
        $searchModel = new SearchLogInstructionProduction();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexdetail(){
		$this->layout = 'blank';
		$searchModel = new SearchInstructionProductionDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idInstProd'));

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Displays a single InstructionProduction model.
     * @param integer $id
     * @return mixed
     */
    private function detailView($id)
    {
		$model = $this->findModel($id);

		$searchModel = new SearchInstructionProductionDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);

		Yii::$app->session->set('idInstProd', $model->id);

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

	public function actionViewdetail($id){
		$this->layout = 'blank';
		$model = InstructionProductionDetail::findOne($id);
		$searchModel = new SearchInstructionProductionDetailSetItem();
		$dataProvider =  $searchModel->searchByParent(Yii::$app->request->post(), $id);

		return $this->render('viewdetail', [
			'par' => 'viewdetail',
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionViewDeclare($id){
		$this->layout = 'blank';
	}

	public function actionViewaprovedeclare($id){
		$this->layout = 'blank';

		
	}

	public function actionViewdetailDeclare($id){
		$this->layout = 'blank';
		$model = InstructionProduction::find()->select([
													'instruction_production.id',
													'instruction_production.instruction_number',
													'instruction_production.target_produksi',
													'instruction_production.id_warehouse',
													'outbound_production.no_sj',
												])
											  ->joinWith('idOutboundProduction')
											  ->one();
		$searchModel = new SearchInstructionProductionDetail();
		$dataProvider =  $searchModel->search(Yii::$app->request->post(), $id);

		return $this->render('viewdetail_declare', [
			'par' => 'viewdetail',
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionViewlog($id){
		// echo basename(Yii::$app->request->referrer);

		// $basename = explode('?', basename(Yii::$app->request->referrer));
		// if ($basename[0] == 'view'){
			// return $this->redirect(['index']);
			// // throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		return $this->render('viewlog', $this->detailView($id));
	}

	public function actionViewapprove($id){
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
	}

    /**
     * Creates a new InstructionProduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->layout = 'blank';
        $model = new InstructionProduction();
		$model->scenario = 'create';
		$model->id_modul = $this->id_modul;

    	if ($model->load(Yii::$app->request->post())) {
					$newidinst = InstructionProduction::find()->andWhere(['and',['like', 'instruction_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
					$newidinstexist = InstructionProduction::find()->andWhere(['and',['instruction_number' => $newidinst],['id_modul' => $model->id_modul]])->exists();
					$newidinst++;

					$monthroman = Numbertoroman::convert(date('n'));

					$model->instruction_number = sprintf("%04d", $newidinst).'/INST-IC1/WT/'.$monthroman.date('/Y');

					$model->status_listing = 7;

					if (isset($_FILES['file'])) {
						if (isset($_FILES['file']['size'])) {
							if($_FILES['file']['size'] != 0) {
								$model->file = $_FILES['file'];
								// return print_r($_FILES['file']);
								$filename = $_FILES['file']['name'];
								$filepath = 'uploads/INST/DIVSATU/';
							}
						}
					}
					$model->file_attachment = 'tmp_file';
					if (!$model->save()){
						return Displayerror::pesan($model->getErrors());
					}
					$model->file_attachment = $filepath.$model->id.'/'.$filename;
					$model->save();

					Yii::$app->session->set('idInstProd', $model->id);

					if (!file_exists($filepath.$model->id.'/')) {
						mkdir($filepath.$model->id.'/', 0777, true);
					}
					move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
					 $this->createLog($model);

            return 'success';
        } else {
						Yii::$app->session->remove('idInstProd');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateDeclare($id = null){
    	$this->layout = 'blank';
    	$model = new InstructionProduction();
        if ($model->load(Yii::$app->request->post())) {
        	$id = $_POST['InstructionProduction']['instruction_number'];
        	
        	$model = $this->findModel($id);
        	$model->status_declare = 7;
        	Yii::$app->session->set('idInstProd', $model->id);
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}

			
			 $this->createLog($model);
			return 'success';
        } else {
            return $this->render('create_declare', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateDeclareDetail($id = NULL){
    	$this->layout = 'blank';
    	if($id == NULL) $id = Yii::$app->session->get('idInstProd');

		if (Yii::$app->request->isPost){

			$data_im_code   = Yii::$app->request->post('im_code');
			$data_qty    = Yii::$app->request->post('qtydeclare');
			// $data_r_dis_good = Yii::$app->request->post('rgooddismantle');
			// $data_r_good_recon  = Yii::$app->request->post('rgoodrec');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}
			$cek = 1;
			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_qty[$key] == '' && $data_qty[$key] == 0 ){
					continue;
				}
				$values = explode(';',$value);

				$model = InstructionProductionDetail::findOne($values[0]);
				
				$model->qty_declare			= ($data_qty[$key] == '') ? 0 : $data_qty[$key];
				

				$overStock = 1;
				$pesan = [];
				if($model->qty_declare > $model->qty){
					$pesan[] = $model->getAttributeLabel('qty_declare')." is more than Request for IM Code ".$values[1];
					$overStock = 0;
				}

				if($model->qty_declare != $model->qty){
					$cek++;
				}

				if ($overStock == 0)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);

				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}
			}

			if($cek == 1){
				$model = InstructionProduction::findOne($id);
				$model->status_declare = 1;
				$model->save();
			}

			return json_encode(['status' => 'success']);
			// return 'success';

		}
    }

    /**
     * Updates an existing InstructionProduction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$this->layout = 'blank';
        $model = $this->findModel($id);

		Yii::$app->session->set('idInstProd', $model->id);
        if ($model->load(Yii::$app->request->post())) {

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
			 $this->createLog($model);
			return 'success';
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateItemSet(){
    	$this->layout = 'blank';
		$id = Yii::$app->session->get('idInstProd');

		$model = new InstructionProductionDetail();

		if ($model->load(Yii::$app->request->post())){
			// return masuk;
			$model->id_instruction_production = $id;

			if($model->save()){
				Yii::$app->session->set('idInstProdDetail', $model->id);
				Yii::$app->session->set('idItemPar', $model->id_item_im);
				return 'success';
			}else{
				return print_r($model->getErrors());
			}
		}

		return $this->render('createitemset', [
            'model' => $model,
        ]);
    }

    public function actionUpdateItemSet($idDetail){
    	$this->layout = 'blank';
		$id = Yii::$app->session->get('idInstProd');

		$model = InstructionProductionDetail::findOne($idDetail);

		if ($model->load(Yii::$app->request->post())){
			// return masuk;
			$model->id_instruction_production = $id;

			if($model->save()){
				Yii::$app->session->set('idInstProdDetail', $model->id);
				return 'success';
			}else{
				return print_r($model->getErrors());
			}
		}

		return $this->render('createitemset', [
            'model' => $model,
        ]);
    }

    public function actionGetim($idItem){
    
    	$model = ParameterMasterItem::find()->select(['master_item_im.im_code as im_code'])->joinWith('idMasterItemIm')->where(['=', 'parameter_master_item.id', $idItem])->one();
    	// return print_r(Url::base());
		// $model = MasterItemIm::find()
		// 	->where(['=', 'id', $idItem])
		// 	->one();
		
		$arrResult = array(
			'im_code' => $model->im_code,
         );

		return json_encode($arrResult);
    }
    

    public function actionCreateItemSetDetail($id = NULL){
    	$this->layout = 'blank';
    	if($id == NULL) $id = Yii::$app->session->get('idInstProdDetail');

		if (Yii::$app->request->isPost){

			$data_im_code   = Yii::$app->request->post('im_code');
			$data_r_good    = Yii::$app->request->post('rgood');
			$data_r_dis_good = Yii::$app->request->post('rgooddismantle');
			$data_r_good_recon  = Yii::$app->request->post('rgoodrec');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_r_good[$key] == '' && $data_r_dis_good[$key] == '' && $data_r_good_recon[$key] == '' && $data_r_good[$key] == 0 && $data_r_dis_good[$key] == 0 && $data_r_good_recon[$key] == 0){
					continue;
				}
				$values = explode(';',$value);

				$model = new InstructionProductionDetailSetItem();
				$model->id_instruction_production_detail	= $id;
				$model->id_item_set			= $values[0];
				$model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$model->req_dis_good		= ($data_r_dis_good[$key] == '') ? 0 : $data_r_dis_good[$key];
				$model->req_good_recond			= ($data_r_good_recon[$key] == '') ? 0 : $data_r_good_recon[$key];

				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				if($model->req_good > $modelMasterItem->s_good){
					$pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_dis_good > $modelMasterItem->s_not_good){
					$pesan[] = $model->getAttributeLabel('req_dis_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_good_recond > $modelMasterItem->s_reject){
					$pesan[] = $model->getAttributeLabel('data_r_good_recon')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}

				if ($overStock == 0)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);

				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}
			}

			return json_encode(['status' => 'success']);
			// return 'success';

		}
		$model = InstructionProduction::findOne(Yii::$app->session->get('idInstProd'));
		$modelProdDetail = InstructionProductionDetail::findOne($id);

		$modelDetail = InstructionProductionDetailSetItem::find()->select(['id_item_set'])->andWhere(['id_instruction_production_detail' => $id])->all();
		$idItemIm = ArrayHelper::map($modelDetail, 'id_item_set', 'id_item_set');

		// return json_encode($idItemIm);
		// return print_r(Yii::$app->session->get('idItemPar'));
		$searchModel = new SearchParameterMasterItemDetail();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(), Yii::$app->session->get('idItemPar'));

        return $this->render('create_item_set_detail', [
        	'modelProdDetail' => $modelProdDetail,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateSupportingItem($id = NULL){
    	$this->layout = 'blank';
    	if($id == NULL) $id = Yii::$app->session->get('idInstProd');
    	// if($id == NULL) $idProd = Yii::$app->session->get('idInstProd');

		if (Yii::$app->request->isPost){
			



			$data_im_code   = Yii::$app->request->post('im_code');
			$data_r_good    = Yii::$app->request->post('rgood');
			$data_r_dis_good = Yii::$app->request->post('rgooddismantle');
			$data_r_good_recon  = Yii::$app->request->post('rgoodrec');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_r_good[$key] == '' && $data_r_dis_good[$key] == '' && $data_r_good_recon[$key] == '' && $data_r_good[$key] == 0 && $data_r_dis_good[$key] == 0 && $data_r_good_recon[$key] == 0){
					continue;
				}
				$values = explode(';',$value);

				$modelDetail = new InstructionProductionDetail();

				$modelDetail->id_instruction_production = $id;
				$modelDetail->id_item_im = $values[0];
				$modelDetail->qty = $data_r_good[$key] + $data_r_dis_good[$key] + $data_r_good_recon[$key];
				if(!$modelDetail->save()){
					return print_r($modelDetail->getErrors());
				}


				$model = new InstructionProductionDetailSetItem();
				$model->id_instruction_production_detail	= $modelDetail->id;
				$model->id_item_set			= $values[0];
				$model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$model->req_dis_good		= ($data_r_dis_good[$key] == '') ? 0 : $data_r_dis_good[$key];
				$model->req_good_recond			= ($data_r_good_recon[$key] == '') ? 0 : $data_r_good_recon[$key];

				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				// if($model->req_good > $modelMasterItem->s_good){
				// 	$pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
				// 	$overStock = 0;
				// }
				// if($model->req_dis_good > $modelMasterItem->s_not_good){
				// 	$pesan[] = $model->getAttributeLabel('req_dis_good')." is more than Stock for IM Code ".$values[1];
				// 	$overStock = 0;
				// }
				// if($model->req_good_recond > $modelMasterItem->s_reject){
				// 	$pesan[] = $model->getAttributeLabel('data_r_good_recon')." is more than Stock for IM Code ".$values[1];
				// 	$overStock = 0;
				// }

				if ($overStock == 0)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);

				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}
			}

			return json_encode(['status' => 'success']);
			// return 'success';

		}
		$model = InstructionProduction::findOne(Yii::$app->session->get('idInstProd'));
		$modelProdDetail = InstructionProductionDetail::findOne($id);

		$modelDetail = InstructionProductionDetailSetItem::find()->select(['id_item_set'])->andWhere(['id_instruction_production_detail' => $id])->all();
		$idItemIm = ArrayHelper::map($modelDetail, 'id_item_set', 'id_item_set');

		// return json_encode($idItemIm);
		// return print_r($model->id_warehouse);
		// $searchModel = new SearchMasterItemIm();
  //       $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->getQueryParams(), $model->id_warehouse);
		$searchModel = new SearchParameterMasterItemDetail();
        $dataProvider = $searchModel->searchByParent(Yii::$app->request->post(), Yii::$app->session->get('idItemPar'));

        return $this->render('create_supporting_item', [
        	'modelProdDetail' => $modelProdDetail,
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
				$model->s_good				+= $session[$id]['update'][$id]['rgood'];
				$model->s_not_good			+= $session[$id]['update'][$id]['rnotgood'];
				$model->s_reject			+= $session[$id]['update'][$id]['rreject'];
				$model->s_dismantle			+= $session[$id]['update'][$id]['rdismantle'];
				$model->s_revocation		+= $session[$id]['update'][$id]['rrevocation'];
				$model->s_good_rec 			+= $session[$id]['update'][$id]['rgood_rec'];
				$model->s_good_for_recond	+= $session[$id]['update'][$id]['rgood_for_recond'];
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

	public function actionCreatedetail(){
		$this->layout = 'blank';
		$id = Yii::$app->session->get('idInstProd');

		if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){

			$data_im_code   = Yii::$app->request->post('im_code');
			$data_r_good    = Yii::$app->request->post('rgood');
			$data_r_dis_good = Yii::$app->request->post('rnotgood');
			$data_r_good_recon  = Yii::$app->request->post('rreject');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_r_good[$key] == '' && $data_r_dis_good[$key] == '' && $data_r_good_recon[$key] == '' && $data_r_good[$key] == 0 && $data_r_dis_good[$key] == 0 && $data_r_good_recon[$key] == 0){
					continue;
				}
				$values = explode(';',$value);

				$model = new InstructionProductionDetail();
				$model->id_instruction_wh	= $id;
				$model->id_item_im			= $values[0];
				$model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$model->req_dis_good		= ($data_r_dis_good[$key] == '') ? 0 : $data_r_dis_good[$key];
				$model->data_r_good_recon			= ($data_r_good_recon[$key] == '') ? 0 : $data_r_good_recon[$key];

				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				if($model->req_good > $modelMasterItem->s_good){
					$pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_dis_good > $modelMasterItem->s_not_good){
					$pesan[] = $model->getAttributeLabel('req_dis_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->data_r_good_recon > $modelMasterItem->s_reject){
					$pesan[] = $model->getAttributeLabel('data_r_good_recon')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}

				if ($overStock == 0)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);

				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}
			}

			return json_encode(['status' => 'success']);
			// return 'success';

		}

		$modelDetail = InstructionProductionDetail::find()->select(['id_item_im'])->andWhere(['id_instruction_wh' => $id])->all();
		$idItemIm = ArrayHelper::map($modelDetail, 'id_item_im', 'id_item_im');

		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->post(), $idItemIm);

        return $this->render('createdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionUpdatedetail($idDetail){
		$this->layout = 'blank';
		$model = InstructionProductionDetail::findOne($idDetail);

		if ($model->load(Yii::$app->request->post())) {

			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}

			return 'success';
        } else {
            return $this->render('_formdetail', [
                'model' => $model,
            ]);
        }
	}

	public function actionSubmit($id){
		$model = InstructionProduction::findOne($id);
		$modelDetail = InstructionProductionDetail::find()->andWhere(['id_instruction_production' => $id])->count();
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
			 $this->createLog($model);
			return Displayerror::pesan($model->getErrors());
		}

		Yii::$app->session->remove('idInstProd');
		return 'success';
	}

	public function actionApprove($id){
		$model = $this->findModel($id);

		if ($model->status_listing == 1){
			$model->status_listing = 5;

			if ($model->save()){
				 $this->createLog($model);
				return 'success';
			}

		}else{
			return 'Not Valid for Approve';
		}
	}

    /**
     * Deletes an existing InstructionProduction model.
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
     * Finds the InstructionProduction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionProduction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function createLog($model)
    {
        $modelLog = new LogInstructionProduction();
        $modelLog->setAttributes($model->attributes);

		if(!$modelLog->save()){
			return print_r($modelLog->getErrors());
		}
    }

    protected function findModel($id)
    {
        if (($model = InstructionProduction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
