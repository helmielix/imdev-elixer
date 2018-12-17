<?php
namespace api\controllers;

use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\CaIomAndCity;
use app\models\City;
use app\models\Subdistrict;
use app\models\District;
use common\models\Warehouse;
use common\models\MkmMasterItem;
use common\models\MasterItemIm;
use common\models\Grf;
use common\models\GrfDetail;
use common\models\Reference;
use common\widgets\Numbertoroman;
use common\widgets\Displayerror;

/**
 * Site controller
 */
class SiteController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'common\models\Grf';
    private $id_modul = 4;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
				'rules' => [
                    [
                        'actions' => ['login', 'error','getcity', 'getregion', 'getdistrict', 'getsubdistrict','getcityapproved','getiombycity','getdistrictbyiom','test','get-warehouse','get-master-item-im','create-grf','create-grf-foro'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create-grf','create-grf-foro'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
					'actions' => [
                    'getregion' => ['POST'],
					'getcity' => ['POST'],
					'getcityapproved' => ['POST'],
					'getdistrict' => ['POST'],
					'getsubdistrict' => ['POST'],
					'getiombycity' => ['POST'],
					'getdistrictbyiom' => ['POST'],
					'create-grf' => ['POST'],
					'create-grf-foro' => ['POST'],
                ],
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
        return $this->redirect('../dashboard-ca/index');
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
            return $this->redirect('../dashboard-ca/index');
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
	
	public function actionGetregion() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$cities = City::find()->where(['id_province' => $cat_id])->all();
				
				$ids = [];
				$j = 0;
				for($i = 0; $i < count($cities); $i++) {
					if(!in_array($cities[$i]->idRegion->id,$ids)) {
						array_push($ids, $cities[$i]->idRegion->id);
						$out[$j]['id'] = $cities[$i]->idRegion->id;
						$out[$j]['name'] = $cities[$i]->idRegion->name;
						$j++;
					}					
				} 
				
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
    public function actionGetcity() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id_region = $parents[0];
				$id_province = $parents[1];
				$out = City::find()->where(['id_region' => $id_region])->andWhere(['id_province'=> $id_province])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetcityapproved() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id_region = $parents[0];
				$out = CaIomAndCity::find()->joinWith(['idCity'],false)->joinWith(['idCaIomAreaExpansion'],false)
					->where(['city.id_region' => $id_region])->andWhere(['ca_iom_area_expansion.status'=> 5])->select('city.id as id, city.name as name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetdistrict() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$out = District::find($cat_id)->where(['id_city' => $cat_id])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetsubdistrict() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$out = Subdistrict::find($cat_id)->where(['id_district' => $cat_id])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetiombycity() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$datas = CaIomAndCity::find($cat_id)->where(['id_city' => $cat_id])->orderBy(['id'=>SORT_DESC])->all();
				for($i=0;$i<count($datas);$i++) {
					if($datas[$i]->idCaIomAreaExpansion->status == 5) {
						$out[$i]['id'] = $datas[$i]->id;
						$out[$i]['name'] = $datas[$i]->idCaIomAreaExpansion->no_iom_area_exp;
					}
				}
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionGetdistrictbyiom() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$city = CaIomAndCity::findOne($cat_id)->idCity->id;
				$out = District::find()->where(['id_city' => $city])->select('id, name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	public function actionGetWarehouse(){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$model = Warehouse::find()->all();

    	return $model;
	}

	public function actionGetMasterItemIm(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$model = MasterItemIm::find()->all();

    	return $model;
    }


    public function actionCreateGrf(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		
    	$model = new Grf();
		$model->id_modul = $this->id_modul;
		$model->id_warehouse = 2;
		$newidinst = Grf::find()->andWhere(['and',['like', 'grf_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
		$newidinstexist = Grf::find()->andWhere(['and',['grf_number' => $newidinst],['id_modul' => $model->id_modul]])->exists();
		$newidinst++;
		
		$monthroman = Numbertoroman::convert(date('n'));
		
		$model->grf_number = sprintf("%04d", $newidinst).'/GRF-IC1/WT/'.$monthroman.date('/Y');


        if (Yii::$app->request->post()) {
        	$request = Yii::$app->request->post();
        	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")); 
        	// return $request;

        	$modelRefRequestor = Reference::find()->where(['description'=>$request['requestor']])->one();
        	$modelRefGrf = Reference::find()->where(['description'=>$request['grf_type']])->one();
        	$arrListItem = $request['list_item'];
        	// return $arrListItem;

        	$model->requestor = $modelRefRequestor->id;
        	$model->wo_number = $request['wo_number'];
        	$model->file_attachment_1 = $request['file_name_1'];
        	$model->file_attachment_2 = $request['file_name_2'];
        	$model->file_attachment_3 = $request['file_name_3'];
        	$model->purpose = $request['purpose'];
        	$model->pic = $request['pic'];
        	$model->id_region = $request['id_region'];
        	$model->id_division = $request['id_division'];
        	$model->id_modul = $request['id_modul'];
        	$model->grf_type = $modelRefGrf->id;
        	$model->source = $request['source'];
        	$model->created_by = 5;
        	$model->updated_by = 5;
        	$model->user_grf_others = $request['created_by'];
        	$model->id_grf_others = $request['id_grf_others'];
			
			// $model->id_division = Yii::$app->user->identity->id_division;
			$model->status_listing = 5;

        	$model->save();

			$context = stream_context_create($opts);
			$content_file_1 = file_get_contents($request['file_attachment_1'],false,$context);
			$content_file_2 = file_get_contents($request['file_attachment_2'],false,$context);
			$content_file_3 = file_get_contents($request['file_attachment_3'],false,$context);
			$filepath = 'uploads/GRFOTHERS/';
			$basepath = Yii::getAlias('@webroot') . '/';

			if (!file_exists($filepath.$model->id.'/')) {
				mkdir($filepath.$model->id.'/', 0777, true);
			}

			file_put_contents($basepath.$filepath.$model->id.'/'.$request['file_name_1'], $content_file_1);
			file_put_contents($basepath.$filepath.$model->id.'/'.$request['file_name_2'], $content_file_2);
			file_put_contents($basepath.$filepath.$model->id.'/'.$request['file_name_3'], $content_file_3);
			
			if (!$model->save()){
				return $model->getErrors();
			}else{
				// return $model->id;
				foreach ($arrListItem as $key => $value) {
					$modelDetail = new GrfDetail();
					$modelDetail->id_grf = $model->id;
					$modelDetail->orafin_code = $value['orafin_code'];
					$modelDetail->qty_request = $value['qty'];
					$modelDetail->qty_return = 0;
					if(!$modelDetail->save()){
						return json_encode($modelDetail->getErrors());
					}
				}
				// return 'masuk';
			}
			
			
			// $model->save();
			
			// Yii::$app->session->set('idGrf', $model->id);
			
			// if (!file_exists($filepath1.$model->id.'/')) {
			// 	mkdir($filepath1.$model->id.'/', 0777, true);
			// }
			// // return print_r($model->file_attachment_2);
			// if (!file_exists($filepath2.$model->id.'/')) {
			// 	mkdir($filepath2.$model->id.'/', 0777, true);
			// }
			// move_uploaded_file($_FILES['file1']['tmp_name'], $model->file_attachment_1);
			// move_uploaded_file($_FILES['file2']['tmp_name'], $model->file_attachment_2);
			
            // return 'success';
        } else{
        	return array('status'=>'failed');
        }
    }

    public function actionCreateGrfForo(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		    
    	$model = new Grf();
        if (Yii::$app->request->post()) {
        	$model->detachBehavior('blameable');
        	$request = Yii::$app->request->post();
        	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")); 
        	// return $request;

        	$modelcek = Grf::find()->andWhere(['grf_number' => $request['grf_number']])->andWhere(['!=','status_listing',3])->exists();
        	if ($modelcek) {
        		return ['status' => 'failed', 'reason' => 'GRF Number: '.$request['grf_number'].' already exists. '];				
        	}

        	$modelceking = Grf::find()->andWhere(['grf_number' => $request['grf_number']])->andWhere(['=','status_listing',3]);
        	if ($modelceking->exists()) {        		
        		$model = $modelceking->one();
        	}else{
        		$model = new Grf();
        	}

			$model->id_modul = $this->id_modul;
			$model->id_warehouse = 2;		
        	
        	$arrListItem = $request['list_item'];
        	// return $arrListItem;

        	$model->file_attachment_1 = $request['file_name_1'];
        	$model->file_attachment_2 = $request['file_name_2'];
        	$model->file_attachment_3 = $request['file_name_3'];
        	$model->wo_number = $request['wo_number'];
        	$model->grf_number = $request['grf_number'];
        	$model->grf_type = $request['grf_type'];
        	$model->requestor = $request['requestor'];
        	$model->id_vendor = $request['id_vendor'];
        	$model->id_division = $request['id_division'];
        	$model->id_region = $request['id_region'];
        	$model->team_leader = $request['team_leader'];
        	$model->team_name = $request['team_name'];
        	$model->purpose = $request['purpose'];
        	$model->id_modul = $request['id_modul'];
        	$model->source = $request['source'];
        	$model->id_grf_others = $request['id_grf_others'];
        	        	
        	$model->created_by = 21;
        	$model->updated_by = 21;
        	$model->verified_by = 21;
        	$model->approved_by = 21;
        	// $model->user_grf_others = $request['created_by'];
						
			$model->status_listing = 5;

			$context = stream_context_create($opts);
			$content_file_1 = file_get_contents($this->file_url($request['file_attachment_1']),false,$context);
			$content_file_2 = file_get_contents($this->file_url($request['file_attachment_2']),false,$context);
			$content_file_3 = file_get_contents($this->file_url($request['file_attachment_3']),false,$context);
			$filepath = 'uploads/GRF/FORO/';
			$basepath = Yii::getAlias('@grflost') . '/web/';

        	$model->save();
			if (!file_exists($basepath.$filepath.$model->id.'/')) {
				mkdir($basepath.$filepath.$model->id.'/', 0777, true);
			}			

			file_put_contents($basepath.$filepath.$model->id.'/'.$request['file_name_1'], $content_file_1);
			file_put_contents($basepath.$filepath.$model->id.'/'.$request['file_name_2'], $content_file_2);
			file_put_contents($basepath.$filepath.$model->id.'/'.$request['file_name_3'], $content_file_3);

			$model->file_attachment_1 = $filepath.$model->id.'/'.$request['file_name_1'];
			$model->file_attachment_2 = $filepath.$model->id.'/'.$request['file_name_2'];
			$model->file_attachment_3 = $filepath.$model->id.'/'.$request['file_name_3'];			
			
			if (!$model->save()){
				// return Displayerror::pesan($model->getErrors());
				return ['status' => 'failed', 'reason' => Displayerror::pesan($model->getErrors())];				
			}else{
				// return $model->id;
				foreach ($arrListItem as $key => $value) {
					$modelDetail = new GrfDetail();
					$modelDetail->id_grf = $model->id;
					$modelDetail->orafin_code = $value['orafin_code'];
					$modelDetail->qty_request = $value['qty'];
					$modelDetail->qty_return = 0;
					if(!$modelDetail->save()){
						return ['status' => 'failed', 
							'reason' => Displayerror::pesan($modelDetail->getErrors()) 
							// 'reason' => 'gagal save detail'
						];
						// return json_encode($modelDetail->getErrors());
					}
				}
				// return 'masuk';
			}
						
            return array('status'=>'success');
        } else{
        	return array('status'=>'failed');
        }
    }

    private function file_url($url)
    {    	
		$parts = parse_url($url);
		$path_parts = array_map('rawurldecode', explode('/', $parts['path']));

	    return
	      $parts['scheme'] . '://' .
	      $parts['host'] .
	      implode('/', array_map('rawurlencode', $path_parts))
	    ;
		
    }

    public function actionUpdateoutboundgrf(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	 if (Yii::$app->request->post()) {
	    	$request = Yii::$app->request->post();
	    	return $request;
    	 }else{
    	 	return 'failed';
    	 }
    }
}
