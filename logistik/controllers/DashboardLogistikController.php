<?php

namespace logistik\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\SearchDashInboundPoNewTask;
// use app\models\DashCaHpByCity;
use yii\data\ActiveDataProvider;

/**
 * BukuTamuController implements the CRUD actions for BukuTamu model.
 */
class DashboardLogistikController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    public function actionIndex()

    {	
// throw new \yii\web\ForbiddenHttpException('akses ditutup sementara');
		$task_date='';
        $task='';
        $table_source='';
        if (isset(Yii::$app->request->queryParams['SearchDashInboundPoNewTask'])) {
            $params = Yii::$app->request->queryParams['SearchDashInboundPoNewTask'];
            extract($params);
            // return "select action_dash_iko_new_task('$task_date','$table_source','$task','');";
        }
        $data = Yii::$app->db->createCommand("select _dash_inbound_po_new_task('$task_date','$table_source','$task','');")->queryAll();

        $this->layout = 'map';
        $searchModel = new SearchDashInboundPoNewTask();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$arrFilter = ['or','1=0'];
		$isAddFilter = false;
		if(Yii::$app->user->can('/inbound-po/index')) {
			array_push($arrFilter,['ilike','table_source','INBOUND PO Revision']);
		}
		// if(Yii::$app->user->can('/inbound-po/index')) {
		// 	array_push($arrFilter,['ilike','table_source','INBOUND PO Rejection']);
		// }
		if(Yii::$app->user->can('/inbound-po/indexverify')) {
			array_push($arrFilter,['ilike','table_source','INBOUND PO Verification']);
		}
		if(Yii::$app->user->can('/inbound-po/indexapprove')) {
			array_push($arrFilter,['ilike','table_source','INBOUND PO Approval']);
		}
		if(Yii::$app->user->can('/inbound-po/indextagsn')) {
			array_push($arrFilter,['ilike','table_source','INBOUND PO TAG SN']);
		}

		
		
			
		$dataProvider->query->andFilterWhere($arrFilter);
		$dataProvider->query->orderBy(['task_date'=>SORT_ASC,'task'=>SORT_ASC]);
		
		// $model = new DashCaHpByCity();
		
        return $this->render('index', [
			// 'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
	
	public function actionMap()
	{
		$this->layout = 'main-full';
		
	}
	
	public function actionGetDashCaHpByCity($city = NULL)
    {
		if($city == NULL){
			$command = Yii::$app->db->createCommand("select _dash_ca_hp_by_city('Kota Jakarta Selatan'::text);")->query();
		}else{
			$command = Yii::$app->db->createCommand("select _dash_ca_hp_by_city('$city'::text);")->query();
		}
		
		$models = DashCaHpByCity::find()->all();
		
		
		$cities = [];
		$hp_submit = [];
		$hp_on_process = [];
		$hp_aktif = [];
		$hp_rejected = [];
		$hp_rejected = [];
		$yearmonth = [];
		foreach ($models as $model) {
			array_push($cities,$model->city);
			array_push($hp_submit,$model->hp_submit*1);
			array_push($hp_on_process,$model->hp_on_process*1);
			array_push($hp_aktif,$model->hp_aktif*1);
			array_push($hp_rejected,$model->hp_rejected*1);
			array_push($yearmonth,$model->yearmonth);
		}
		$arrResult = array(
			'cities' => $cities,
			'hp_submit' => $hp_submit,
			'hp_on_process' => $hp_on_process,
			'hp_aktif' => $hp_aktif,
			'hp_rejected' => $hp_rejected,
			'yearmonth' => $yearmonth,
		  
         );
		 		
		
		return json_encode($arrResult);
		
		  
    }

}
