<?php
namespace logistik\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\CaIomAndCity;
use app\models\City;
use app\models\Subdistrict;
use app\models\District;

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
                        'actions' => ['login', 'error','getcity', 'getregion', 'getdistrict', 'getsubdistrict','getcityapproved','getiombycity','getdistrictbyiom','test'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', ],
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
					'getdistrictbyiom' => ['POST']
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
}
