<?php

namespace logistik\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use common\models\MasterItemIm;
use common\models\ParameterMasterItem;
use common\models\ParameterMasterItemDetail;
use common\models\SearchParameterMasterItem;
use common\models\SearchParameterMasterItemDetail;
use common\models\SearchMasterItemIm;

use common\widgets\Displayerror;
/**
 * ParameterMasterItemController implements the CRUD actions for ParameterMasterItem model.
 */
class ParameterMasterItemController extends Controller
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
     * Lists all ParameterMasterItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchParameterMasterItem();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexdetail()
    {
		$this->layout = 'blank';
		
        $searchModel = new SearchParameterMasterItemDetail();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams, \Yii::$app->session->get('idParameter'));
		// $model = $this->findModel(Yii::$app->session->get('idInboundPo'));
		
        return $this->render('indexdetail', [
        	// 'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			
        ]);
    }

    /**
     * Displays a single ParameterMasterItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGetorafin() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$name = $parents[0];
				// $out = CaIomAndCity::find()->joinWith(['idCity'],false)->joinWith(['idCaIomAreaExpansion'],false)
					// ->where(['city.id_region' => $id_region])->andWhere(['ca_iom_area_expansion.status'=> 5])->select('city.id as id, city.name as name')->asArray()->all();
				$out = MasterItemIm::find()//->joinWith(['idRegion'])
					->where(['name' => $name])->select('distinct(orafin_code) as id, orafin_code as name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetim() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat = $parents[0];
				// $out = CaIomAndCity::find()->joinWith(['idCity'],false)->joinWith(['idCaIomAreaExpansion'],false)
					// ->where(['city.id_region' => $id_region])->andWhere(['ca_iom_area_expansion.status'=> 5])->select('city.id as id, city.name as name')->asArray()->all();
				$out = MasterItemIm::find()//->joinWith(['idRegion'])
					->where(['orafin_code' => $cat])->select('id as id, im_code as name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetitemdetail($id = NULL)
    {
    	// return print_r(Url::base());
		$model = MasterItemIm::find()
			->where(['=', 'id', $id])
			->one();
		
		$arrResult = array(
			'grouping' => $model->referenceGrouping->description,
			'brand' => $model->referenceBrand->description,	
			'type' => $model->referenceType->description,
			'warna' => $model->referenceWarna->description,
			'uom' => $model->uom,
			'sn' => $model->referenceSn->description,
         );	

		return json_encode($arrResult);
    }

    public function actionSubmit($id){
		$model = ParameterMasterItem::findOne($id);
		$modelDetail = ParameterMasterItemDetail::find()->andWhere(['id_parameter' => $id])->count();
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

		Yii::$app->session->remove('idParameter');
		// $this->createLog($model);
		return 'success';
	}

    public function actionCreatedetail(){
		$this->layout = 'blank';
		$id = Yii::$app->session->get('idParameter');
		$id_item = Yii::$app->session->get('idItem');

		if (Yii::$app->request->isPost){
			// return;
			// return $id_item;
			$data_im_code       = Yii::$app->request->post('im_code');
			$data_qty        = Yii::$app->request->post('qty');

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){

				if( $data_qty[$key] == '' ||
					$data_qty[$key] == 0){
					continue;
				}
				$data_qty[$key] 			= ($data_qty[$key] == '') ? 0 : $data_qty[$key];

				$values = explode(';',$value);


				// $modelMasterItem = MasterItemIm::find()->where(['im_code'=>$values[1]])->one();
				// return print_r($values[0]);

				$modelcek = ParameterMasterItemDetail::find()->andWhere(['id_parameter' => $id]);
				$oldqty = 0;
				// if ( $modelcek->count() == 0 ){
					$model = new ParameterMasterItemDetail();
				// }else{
				// 	$model = $modelcek->one();
				// 	$oldqty 				= $model->qty_item_child;
				// }

				$model->id_parameter		= $id;
				$model->id_item_parent		= $id_item;
				// $model->id_item_im				= $values[0];
				$model->id_item_child				= $values[0];
				$model->qty_item_child				= $data_qty[$key];

				// $newRec = false;
				if ( !$model->isNewRecord ){

					if ( !isset($session['update']) ){
						$model->qty_item_child				+= $oldqty;
						// return "$oldreq_good, $oldreq_not_good, $oldreq_reject, $oldreq_good_dismantle, $oldreq_not_good_dismantle";
					}

				}

				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}

				
			}

			Yii::$app->session->remove('detailinstruction');
			return json_encode(['status' => 'success']);
			// return 'success';

		}

		$modelInstruction = $this->findModel($id);
		// $modelDetail = ParameterMasterItemDetail::find()->select(['id_item_im'])->andWhere(['id_instruction_wh' => $id])->all();
		// $idItemIm = ArrayHelper::map($modelDetail, 'id_item_im', 'id_item_im');
		$idItemIm = [];

		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('createdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    public function actionCreate()
    {
    	$this->layout = 'blank';
        $model = new ParameterMasterItem();

        if ($model->load(Yii::$app->request->post())) {
        	$model->status_listing = 1;
        	if($model->save()){
        		Yii::$app->session->set('idParameter', $model->id);
        		Yii::$app->session->set('idItem', $model->id_item);
        	}
            return 'success';
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ParameterMasterItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ParameterMasterItem model.
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
     * Finds the ParameterMasterItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParameterMasterItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParameterMasterItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
