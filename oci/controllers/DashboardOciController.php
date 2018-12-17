<?php

namespace oci\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use os\models\SearchDashOsNewTask;
use os\models\DashOsNewTask;
use common\models\DashboardRequest;
// use app\models\DashOsOutsourcePersonel;
// use app\models\DashOsVendor;
// use app\models\DashOsGa;

use common\models\PoRequisitions;
/**
 * BukuTamuController implements the CRUD actions for BukuTamu model.
 */
class DashboardOciController extends Controller
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
        $model = PoRequisitions::find()->andWhere(['INTERFACE_SOURCE_CODE' => 'PRF-001052'])->one();
        // $model = City::find()->andWhere(['id' => 3374])->one();
        echo var_dump($model);
        return true;
    }

    public function actionIndexsd()
    {

        $task_date='';
        $task='';
        $table_source='';
		$stdk = '';
        if (isset(Yii::$app->request->queryParams['SearchDashOsNewTask'])) {
            $params = Yii::$app->request->queryParams['SearchDashOsNewTask'];
            extract($params);
            // return "select action_dash_ppl_new_task('$task_date','$table_source','$task','');";
        }
        $data = Yii::$app->db->createCommand("select _dash_os_new_task_new('$task_date','$table_source','$task','$stdk','');")->queryAll();

        $this->layout = 'map';
        $searchModel = new SearchDashOsNewTask();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$arrFilter = ['or','1=0'];
		$isAddFilter = false;
		if(Yii::$app->user->can('/os-outsource-salary/index')) {
            array_push($arrFilter,['ilike','table_source','Outsource Salary Revision']);
        }
        if(Yii::$app->user->can('/os-outsource-salary/indexverify')) {
            array_push($arrFilter,['ilike','table_source','Outsource Salary Verification']);
        }
        if(Yii::$app->user->can('/os-outsource-salary/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','Outsource Salary Approval']);
        }
        if(Yii::$app->user->can('/os-outsource-salary/index')) {
            array_push($arrFilter,['ilike','table_source','Outsource Salary Rejection']);
        }

        if(Yii::$app->user->can('/os-outsource-personil/index')) {
            array_push($arrFilter,['ilike','table_source','Outsource Personil Revision']);
        }
        if(Yii::$app->user->can('/os-outsource-personil/indexverify')) {
            array_push($arrFilter,['ilike','table_source','Outsource Personil Verification']);
        }
        if(Yii::$app->user->can('/os-outsource-personil/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','Outsource Personil Approval']);
        }
        if(Yii::$app->user->can('/os-outsource-personil/index')) {
            array_push($arrFilter,['ilike','table_source','Outsource Personil Rejection']);
        }

        if(Yii::$app->user->can('/os-outsource-parameter/index')) {
            array_push($arrFilter,['ilike','table_source','Salary Parameter Revision']);
        }
        if(Yii::$app->user->can('/os-outsource-parameter/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','Salary Parameter Approval']);
        }
        if(Yii::$app->user->can('/os-outsource-parameter/index')) {
            array_push($arrFilter,['ilike','table_source','Salary Parameter Rejection']);
        }

        if(Yii::$app->user->can('/os-ga-vehicle-parameter/index')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Parameter Revision']);
        }
        if(Yii::$app->user->can('/os-ga-vehicle-parameter/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Parameter Approval']);
        }
        if(Yii::$app->user->can('/os-ga-vehicle-parameter/index')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Parameter Rejection']);
        }

		if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/index')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost IKO Revision']);
        }
        if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost IKO Approval']);
        }
		if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexverify')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost IKO Verification']);
        }
        if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/index')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost IKO Rejection']);
        }

		if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/index')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost OSP Revision']);
        }
        if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost OSP Approval']);
        }
		if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexverify')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost OSP Verification']);
        }
        if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/index')) {
            array_push($arrFilter,['ilike','table_source','GA Vehicle Operational Cost OSP Rejection']);
        }

        if(Yii::$app->user->can('/os-ga-driver-parameter/index')) {
            array_push($arrFilter,['ilike','table_source','GA Driver Parameter Revision']);
        }
        if(Yii::$app->user->can('/os-ga-driver-parameter/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','GA Driver Parameter Approval']);
        }
        if(Yii::$app->user->can('/os-ga-driver-parameter/index')) {
            array_push($arrFilter,['ilike','table_source','GA Driver Parameter Rejection']);
        }

        if(Yii::$app->user->can('/os-vendor-regist-vendor/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor Registration Revision']);
        }
        if(Yii::$app->user->can('/os-vendor-regist-vendor/indexverify')) {
            array_push($arrFilter,['ilike','table_source','Vendor Registration Verification']);
        }
        if(Yii::$app->user->can('/os-vendor-regist-vendor/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','Vendor Registration Approval']);
        }
        if(Yii::$app->user->can('/os-vendor-regist-vendor/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor Registration Rejection']);
        }

        if(Yii::$app->user->can('/os-vendor-pob/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor PO Blanket Revision']);
        }
        if(Yii::$app->user->can('/os-vendor-pob/indexverify')) {
            array_push($arrFilter,['ilike','table_source','Vendor PO Blanket Verification']);
        }
        if(Yii::$app->user->can('/os-vendor-pob/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','Vendor PO Blanket Approval']);
        }
        if(Yii::$app->user->can('/os-vendor-pob/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor PO Blanket Rejection']);
        }

        if(Yii::$app->user->can('/os-vendor-term-sheet/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor Term Sheet Revision']);
        }
        if(Yii::$app->user->can('/os-vendor-term-sheet/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor Term Sheet Input']);
        }
        if(Yii::$app->user->can('/os-vendor-term-sheet/indexverify')) {
            array_push($arrFilter,['ilike','table_source','Vendor Term Sheet Verification']);
        }
        if(Yii::$app->user->can('/os-vendor-term-sheet/indexapprove')) {
            array_push($arrFilter,['ilike','table_source','Vendor Term Sheet Approval']);
        }
        if(Yii::$app->user->can('/os-vendor-term-sheet/index')) {
            array_push($arrFilter,['ilike','table_source','Vendor Term Sheet Rejection']);
        }


		$dataProvider->query->andFilterWhere($arrFilter);
		$dataProvider->query->orderBy(['task_date'=>SORT_ASC,'task'=>SORT_ASC]);

        $modelDash = new DashboardRequest();
		$modelDash->id_module = 8;
		$modelDash->requestor = Yii::$app->user->identity->id;
		$modelDash->request_date = new \yii\db\Expression('NOW()');
		$modelDash->save();

		$modelDashOsGa = new DashOsGa();
		$modelDashOsVendor = new DashOsVendor();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelDashOsGa' => $modelDashOsGa,
			'modelDashOsVendor' => $modelDashOsVendor,
        ]);

    }

	public function actionMap()
	{
		$this->layout = 'main-full';

	}

	public function actionGetDashChartOsPersonel($cityGa = NULL){
		$modelsOutsource = DashOsOutsourcePersonel::find()->all();

		//modelsPersonel
		$cityPersonel = [];
		$male_iko = [];
		$female_iko = [];
		$male_osp = [];
		$female_osp = [];
		foreach ($modelsOutsource as $model) {
			array_push($cityPersonel,$model->city);
			array_push($male_iko,$model->male_iko*1);
			array_push($female_iko,$model->female_iko*1);
			array_push($male_osp,$model->male_osp*1);
			array_push($female_osp,$model->female_osp*1);
		}

		//model GA
		Yii::$app->db->createCommand("select _dash_os_ga_stdk();")->query();
		if($cityGa==NULL){
			$modelsGa = DashOsGa::find()
			->where(['like','city','Kota Jakarta Selatan'])
			->all();
		}else{
			$modelsGa = DashOsGa::find()
			->where(['like','city',$cityGa])
			->all();
		}


		$cityGa = [];
		$month = [];
		$year = [];
		$sum_stdk = [];
		$totalsum = [];
		$source = [];
		$stdk = [];
		foreach ($modelsGa as $model) {
            if (in_array($model->city, $cityGa) && in_array($model->month, $month)) {
                $key = array_search($model->city, $cityGa);
                $sum_stdk[$key] = $sum_stdk[$key] + $model->sum_stdk;
                $source[$key] = $source[$key].", Total STDK {$model->source} : {$model->sum_stdk}";
            }else {
                array_push($sum_stdk,$model->sum_stdk);
                array_push($cityGa,$model->city);
                array_push($month,$model->month);
                array_push($year,$model->year);
                array_push($source,"Total STDK ".strtoupper(strtolower($model->source))." : {$model->sum_stdk}");
            }
		}

        for ($i=0; $i < count($sum_stdk); $i++) {
            $stdk[$i]['y'] = $sum_stdk[$i];
            $stdk[$i]['tip']   = $source[$i];
        }

		// return print_r($source);
		//model vendor
		$modelOsVendor = DashOsVendor::find()->all();
		//modelsOutsource
		$project_type = [];
		$total = [];
		foreach ($modelOsVendor as $model) {
			array_push($project_type,$model->project_type);
			array_push($total,$model->total*1);
		}

		$arrResult = array(
			'cityPersonel' => $cityPersonel,
			'male_iko' => $male_iko,
			'female_iko' => $female_iko,
			'male_osp' => $male_osp,
			'female_osp' => $female_osp,

			'cityGa' => $cityGa,
			'month' => $month,
			'year' => $year,
			'sum_stdk' => $stdk,
			'source' => $source,

			'project_type' => $project_type,
			'total' => $total,
         );

		return json_encode($arrResult);
	}

	public function actionGetDashChartOsGa($city = 'Kota Jakarta Selatan'){

		$modelsGa = DashOsGa::find()->andFilterWhere(['city'=>$city])->all();

		//modelsOutsource
		$city = [];
		$month = [];
		$year = [];
		$sum_stdk = [];
		foreach ($modelsGa as $model) {
			array_push($city,$model->city);
			array_push($month,$model->month);
			array_push($year,$model->year);
			array_push($sum_stdk,$model->sum_stdk);
		}

		$arrResult = array(
			'city' => $city,
			'month' => $month,
			'year' => $year,
			'sum_stdk' => $sum_stdk,
         );

		return json_encode($arrResult);
	}



}
