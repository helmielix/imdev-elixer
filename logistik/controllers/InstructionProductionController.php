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
use common\models\SearchMasterItemIm;
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

    public function actionIndexlog()
    {
        $searchModel = new SearchLogInstructionProduction();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove()
    {
        return $this->render('index', $this->listIndex('approve'));
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
		// echo basename(Yii::$app->request->referrer);

		// $basename = explode('?', basename(Yii::$app->request->referrer));
		// if ($basename[0] == 'view'){
			// return $this->redirect(['index']);
			// // throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
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
    
    	// return print_r(Url::base());
		$model = MasterItemIm::find()
			->where(['=', 'id', $idItem])
			->one();
		
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
			$data_r_dis_good = Yii::$app->request->post('rdisgood');
			$data_r_good_recon  = Yii::$app->request->post('rgoodrecon');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '' && $data_r_good[$key] == 0 && $data_r_notgood[$key] == 0 && $data_r_reject[$key] == 0){
					continue;
				}
				$values = explode(';',$value);

				$model = new InstructionProductionDetail();
				$model->id_instruction_wh	= $id;
				$model->id_item_im			= $values[0];
				$model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$model->req_not_good		= ($data_r_notgood[$key] == '') ? 0 : $data_r_notgood[$key];
				$model->req_reject			= ($data_r_reject[$key] == '') ? 0 : $data_r_reject[$key];

				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				if($model->req_good > $modelMasterItem->s_good){
					$pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_not_good > $modelMasterItem->s_not_good){
					$pesan[] = $model->getAttributeLabel('req_not_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_reject > $modelMasterItem->s_reject){
					$pesan[] = $model->getAttributeLabel('req_reject')." is more than Stock for IM Code ".$values[1];
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
		$modelDetail = InstructionProductionDetailSetItem::find()->select(['id_item_set'])->andWhere(['id_instruction_production_detail' => $id])->all();
		$idItemIm = ArrayHelper::map($modelDetail, 'id_item_set', 'id_item_set');

		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->post(),$model->id, $idItemIm);

        return $this->render('create_item_set_detail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionCreatedetail(){
		$this->layout = 'blank';
		$id = Yii::$app->session->get('idInstProd');

		if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){

			$data_im_code   = Yii::$app->request->post('im_code');
			$data_r_good    = Yii::$app->request->post('rgood');
			$data_r_notgood = Yii::$app->request->post('rnotgood');
			$data_r_reject  = Yii::$app->request->post('rreject');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '' && $data_r_good[$key] == 0 && $data_r_notgood[$key] == 0 && $data_r_reject[$key] == 0){
					continue;
				}
				$values = explode(';',$value);

				$model = new InstructionProductionDetail();
				$model->id_instruction_wh	= $id;
				$model->id_item_im			= $values[0];
				$model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$model->req_not_good		= ($data_r_notgood[$key] == '') ? 0 : $data_r_notgood[$key];
				$model->req_reject			= ($data_r_reject[$key] == '') ? 0 : $data_r_reject[$key];

				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				if($model->req_good > $modelMasterItem->s_good){
					$pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_not_good > $modelMasterItem->s_not_good){
					$pesan[] = $model->getAttributeLabel('req_not_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_reject > $modelMasterItem->s_reject){
					$pesan[] = $model->getAttributeLabel('req_reject')." is more than Stock for IM Code ".$values[1];
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
		$modelDetail = InstructionProductionDetail::find()->andWhere(['id_instruction_wh' => $id])->count();
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
			return print_r($modelLog->save());
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
