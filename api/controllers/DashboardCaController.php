<?php

namespace setting\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use setting\models\SearchDashCaNewTask;
use app\models\DashCaHpByCity;
use yii\data\ActiveDataProvider;

/**
 * BukuTamuController implements the CRUD actions for BukuTamu model.
 */
class DashboardCaController extends Controller
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

    {	$task_date='';
        $task='';
        $table_source='';
        if (isset(Yii::$app->request->queryParams['SearchDashCaNewTask'])) {
            $params = Yii::$app->request->queryParams['SearchDashCaNewTask'];
            extract($params);
            // return "select action_dash_iko_new_task('$task_date','$table_source','$task','');";
        }
        $data = Yii::$app->db->createCommand("select _dash_ca_new_task('$task_date','$table_source','$task','');")->queryAll();

        $this->layout = 'map';
        $searchModel = new SearchDashCaNewTask();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$arrFilter = ['or','1=0'];
		$isAddFilter = false;
		if(Yii::$app->user->can('/ca-iom-area-expansion/index')) {
			array_push($arrFilter,['ilike','table_source','IOM AREA EXPANSION Revision']);
		}
		if(Yii::$app->user->can('/ca-iom-area-expansion/index')) {
			array_push($arrFilter,['ilike','table_source','IOM AREA EXPANSION Rejection']);
		}
		if(Yii::$app->user->can('/ca-iom-area-expansion/indexverify')) {
			array_push($arrFilter,['ilike','table_source','IOM AREA EXPANSION Verification']);
		}
		if(Yii::$app->user->can('/ca-iom-area-expansion/indexapprove')) {
			array_push($arrFilter,['ilike','table_source','IOM AREA EXPANSION Approval']);
		}
		
		if(Yii::$app->user->can('/ca-ba-survey/index')) {
			array_push($arrFilter,['ilike','table_source','BA SURVEY Revision']);
		}
		if(Yii::$app->user->can('/ca-ba-survey/index')) {
			array_push($arrFilter,['ilike','table_source','BA SURVEY Rejection']);
		}
		if(Yii::$app->user->can('/ca-ba-survey/indexverify')) {
			array_push($arrFilter,['ilike','table_source','BA SURVEY Verification']);
		}
		if(Yii::$app->user->can('/ca-ba-survey/indexapprove')) {
			array_push($arrFilter,['ilike','table_source','BA SURVEY Approval']);
		}
		
		if(Yii::$app->user->can('/ca-ba-survey/index_iom')) {
			array_push($arrFilter,['ilike','table_source','IOM Rollout Input']);
		}
		if(Yii::$app->user->can('/ca-ba-survey/indexverify_iom')) {
			array_push($arrFilter,['ilike','table_source','IOM Rollout Verification']);
		}
		if(Yii::$app->user->can('/ca-ba-survey/indexapprove_iom')) {
			array_push($arrFilter,['ilike','table_source','IOM Rollout Approval']);
		} 
		if(Yii::$app->user->can('/ca-ba-survey/index_iom')) {
			array_push($arrFilter,['ilike','table_source','IOM Rollout Revision']);
		} 
		if(Yii::$app->user->can('/ca-ba-survey/index_iom')) {
			array_push($arrFilter,['ilike','table_source','IOM Rollout Rejection']);
		}

		if(Yii::$app->user->can('/ca-ba-survey/index_presurvey')) {
     	 array_push($arrFilter,['ilike','table_source','PRE-SURVEY Revision']);
	    }
	    if(Yii::$app->user->can('/ca-ba-survey/index_presurvey')) {
     	 array_push($arrFilter,['ilike','table_source','PRE-SURVEY Rejection']);
	    }
	    if(Yii::$app->user->can('/ca-ba-survey/indexverify_presurvey')) {
	      array_push($arrFilter,['ilike','table_source','PRE-SURVEY Verification']);
	    }
	    if(Yii::$app->user->can('/ca-ba-survey/indexapprove_presurvey')) {
	      array_push($arrFilter,['ilike','table_source','PRE-SURVEY Approval']);
	    }

	    if(Yii::$app->user->can('/ppl-iko-atp/indexverify')) {
	      array_push($arrFilter,['ilike','table_source','IKO ATP Invitation']);
	    }
	    if(Yii::$app->user->can('/ppl-osp-atp/indexverify')) {
	      array_push($arrFilter,['ilike','table_source','OSP ATP Invitation']);
	    }
			
		$dataProvider->query->andFilterWhere($arrFilter);
		$dataProvider->query->orderBy(['task_date'=>SORT_ASC,'task'=>SORT_ASC]);
		
		$model = new DashCaHpByCity();
		
        return $this->render('index', [
			'model' => $model,
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