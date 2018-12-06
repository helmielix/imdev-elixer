<?php
namespace usermanagement\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\LaborTemp;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;
use app\models\TempWarehouse;
use app\models\TempTicketTrouble;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','synclabor','syncwarehouse','test', 'syncticket'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('index.php?r=admin/user');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	public function actionSynclabor() 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://im2dev.mncplaymedia.com/im/api/v1/user/teamleader");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$decode = json_decode(curl_exec($ch), true);
        $decode = ArrayHelper::index($decode, 'id');
		curl_close($ch);
        foreach ($decode as $key => $value) {
            $model = new LaborTemp();
            $model->nik =  $value['id'];
            $model->email = $value['email'];
            $model->name = $value['pic'];
            $model->division = 18;
			$model->id_warehouse = $value['warehouseID'];
            if(!$model->save()) return print_r($model->getErrors());			
        }
        $command = Yii::$app->db->createCommand("select _upsert_labor_im();")->query();  
	}
	
	public function actionSyncwarehouse() 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://im2dev.mncplaymedia.com/im/api/v1/wh");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$decode = json_decode(curl_exec($ch), true);
        $decode = ArrayHelper::index($decode, 'warehouseID');
		curl_close($ch);
        foreach ($decode as $key => $value) {
            $model = new TempWarehouse();
            $model->id_warehouse =  $value['warehouseID'];
            $model->warehouse_name = $value['warehousename'];
            if(!$model->save()) return print_r($model->getErrors());			
        }
        $command = Yii::$app->db->createCommand("select _upsert_warehouse_im();")->query();  
	}
	
	public function actionSyncticket() 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://oss.mncplaymedia.com/api/get_tt_osp.php");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$decode = json_decode(curl_exec($ch), true);
        $decode = ArrayHelper::index($decode, 'tt_number');
		curl_close($ch);
        foreach ($decode as $key => $value) {
            $model = new TempTicketTrouble();
            $model->crm_id =  $value['tt_number'];
            $model->crm_date_create = $value['date_create'];
            $model->crm_customer_id = $value['customerid'];
            $model->crm_subject = $value['subject'];
			$model->crm_last_status = $value['last_stat'];
			$model->crm_aging = $value['aging'];
			$model->crm_aging_ospm = $value['aging_ospm'];
			$model->crm_sla = $value['sla'];
			$model->crm_subcategory = $value['subcategory'];
			$model->crm_category = $value['category'];
			$model->crm_no_fat = $value['no_fat'];
			$model->crm_city = $value['kota'];
			$model->ticket_source = 'crm';

			$day_all = 0;
			$day_ospm = 0;
			if(strpos($value['aging'], 'day')){
				$day_all = substr($value['aging'], 0, 2);
			}

			if(strpos($value['aging_ospm'], 'day')){
				$day_ospm = substr($value['aging_ospm'], 0, 2);
			}

			$model->day_all = (int)$day_all;
			$model->day_ospm = (int)$day_ospm;
			
			// return print_r($day);
            if(!$model->save()) return print_r($model->getErrors());			
        }
         $command = Yii::$app->db->createCommand("select _upsert_ospm_ticket_trouble_crm();")->query();  
	}
}
