<?php

namespace ca\controllers;

use Yii;
use app\models\CaBaSurvey;
use app\models\CaReference;
use app\models\CaBaSurveyReference;
use app\models\Area;
use app\models\Region;
use app\models\City;
use app\models\CaIomAreaExpansion;
use app\models\CaIomAndCity;
use app\models\District;
use app\models\Subdistrict;
use app\models\Rw;
use app\models\Homepass;
use app\models\AttributeHomepass;
use ca\models\SearchCaBaSurvey;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\httpclient\XmlParser;
use common\widgets\Unzip;
use app\models\LogCaBaSurvey;
use common\widgets\Displayerror;
use common\widgets\Email;
use ppl\models\SearchPplIkoAtp;
use ppl\models\SearchPplOspAtp;
use ca\models\SearchLogCaBaSurvey;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class CaBaSurveyController extends Controller
{
	// Inherit dari behaviors class controller. Mengatur action mana yang harus dengan method POST
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
					'verify' => ['POST'],
					'approve' => ['POST'],
					'revise' => ['POST'],
					'reject' => ['POST'],
					'get-iom' => ['POST'],
					'verify_presurvey' => ['POST'],
					'approve_presurvey' => ['POST'],
					'verify_iom' => ['POST'],
					'approve_iom' => ['POST'],
					'repermit' => ['POST'],
					'revise_presurvey' => ['POST'],
					'reject' => ['POST'],
					'reject_presurvey' => ['POST'],
					'revise_iom' => ['POST'],
					'downloadfile' => ['POST'],
                ],
            ],
        ];
    }

	// --- Index Pages ---
	// Page Index untuk Pre-survey. Menampilkan data dengan status hanya untuk Verificator searchFilter Parameters.
    public function actionIndex_presurvey()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input_presurvey');

        return $this->render('index_presurvey', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexverify_presurvey()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify_presurvey');

        return $this->render('index_presurvey', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove_presurvey()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve_presurvey');

        return $this->render('index_presurvey', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Index untuk Input. Menampilkan data dengan status hanya untuk Inputter searchFilter Parameters.
    public function actionIndex()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexlog()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchLogCaBaSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndex_iom()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input_iom');

        return $this->render('index_iom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Index untuk Verify. Menampilkan data dengan status hanya untuk Verificator searchFilter Parameters.
    public function actionIndexverify()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexverify_iom()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify_iom');

        return $this->render('index_iom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove_iom()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve_iom');

        return $this->render('index_iom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Index untuk Approve. Menampilkan data dengan status hanya untuk Approver searchFilter Parameters.
    public function actionIndexapprove()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndex_invitation_iko()
    {
        $this->layout = 'map';
        $searchModel = new SearchPplIkoAtp();
        $dataProvider = $searchModel->searchByActioninvit(Yii::$app->request->queryParams,'input');

        return $this->render('@ppl/views/ppl-iko-atp/indexinvite', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndex_invitation_osp()
    {
        $this->layout = 'map';
        $searchModel = new SearchPplOspAtp();
        $dataProvider = $searchModel->searchByActioninvit(Yii::$app->request->queryParams,'input');

        return $this->render('@ppl/views/ppl-osp-atp/indexinvite', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionCreate_presurvey()
    {

        $model = new CaBaSurvey();
		$modelArea = new Area();
		$modelRegion = new Region();
		$modelCity = new City();
		$modelDistrict = new District();
		$modelIom = new CaIomAreaExpansion();
		$this->layout = 'blank';

		$model->scenario = 'create';

		if ($model->load(Yii::$app->request->post()) && $modelArea->load(Yii::$app->request->post())) {
			$model->status_listing = 999;
			$model->status_presurvey = 7;
			$model->pic_survey = 123;
			$model->qty_hp_pot = 0;
			$model->qty_soho_pot = 0;
			$model->avr_occupancy_rate = '-';
			$model->myr_population_hv = '-';
			$model->dev_method = '-';
			$model->access_to_sell = '-';
			$model->occupancy_use_dth = '-';
			$model->competitors = '-';
			$model->contact_survey = '-';
			$model->file_xls = '-';
			$model->file_pdf = '-';
			$model->file_doc = '-';
			$no_iom = $_POST['CaIomAreaExpansion']['no_iom_area_exp'];
			$model->no_iom = $_POST['CaIomAreaExpansion']['no_iom_area_exp'];


			$modelNewArea = Area::find()->where(['=','id',$model->id_area])->one();
			if(empty($modelNewArea)) {
				$modelNewArea = new Area();
				$modelNewArea->id = $model->id_area;
				$modelNewArea->id_subdistrict = $modelArea->id_subdistrict;
				$modelNewArea->owner = $modelArea->owner;
				if(! $modelNewArea->save()) return Displayerror::pesan($modelNewArea->getErrors());
			}

			$model->created_by = Yii::$app->user->identity->username;
			$model->created_date = date('Y-m-d');
			$model->updated_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');

			if($model->save()) {
				$this->createLog($model);
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				if($model->status_listing == 1) {
					$arrAuth = ['/ca-ba-survey/indexverify'];
	                $header = 'Alert Verify CA BA Survey';
	                $subject = 'This document is waiting your verify. Please click this link document :'.Url::base(true).'/ca-ba-survey/indexverify#viewverify?id='.$model->id.'?header=Verify_CA_BA_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);
				}
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
        } else {
            return $this->render('create_presurvey', [
                'model' => $model,
				'modelArea' => $modelArea,
				'modelRegion' => $modelRegion,
				'modelCity' => $modelCity,
				'modelDistrict' => $modelDistrict,
				'modelIom' => $modelIom,
            ]);
        }
    }

	public function actionUpdate_presurvey($id)
    {

        $model = $this->findModel($id);
		$modelArea = $model->idArea;
		$modelRegion = $model->idArea->idSubdistrict->idDistrict->idCity->idRegion;
		$modelCity = $model->idArea->idSubdistrict->idDistrict->idCity;
		$modelDistrict = $model->idArea->idSubdistrict->idDistrict;
		$modelIom = new CaIomAreaExpansion();
		$this->layout = 'blank';

		$model->scenario = 'update_presurvey';

		if ($model->load(Yii::$app->request->post()) && $modelArea->load(Yii::$app->request->post())) {
			// $model->status_listing = 999;
			if($model->status_presurvey == 3){
				$model->status_presurvey = 2;
			}

			// $model->qty_hp_pot = 0;
			// $model->qty_soho_pot = 0;
			// $model->avr_occupancy_rate = '-';
			// $model->myr_population_hv = '-';
			// $model->dev_method = '-';
			// $model->access_to_sell = '-';
			// $model->occupancy_use_dth = '-';
			// $model->competitors = '-';
			// $model->pic_survey = 999;
			// $model->contact_survey = '-';
			// $model->file_xls = '-';
			// $model->file_pdf = '-';
			// $model->file_doc = '-';
			// $no_iom = $_POST['CaIomAreaExpansion']['no_iom_area_exp'];
			// $model->no_iom = $_POST['CaIomAreaExpansion']['no_iom_area_exp'];


			$modelNewArea = Area::find()->where(['=','id',$model->id_area])->one();
			if(empty($modelNewArea)) {
				$modelNewArea = new Area();
				$modelNewArea->id = $model->id_area;
				$modelNewArea->id_subdistrict = $modelArea->id_subdistrict;
				$modelNewArea->owner = $modelArea->owner;
				if(! $modelNewArea->save()) return Displayerror::pesan($modelNewArea->getErrors());
			}


			if($model->save()) {
				//$this->createLog($model);
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				if($model->status_listing == 1) {
					$arrAuth = ['/ca-ba-survey/indexverify'];
	                $header = 'Alert Verify CA BA Survey';
	                $subject = 'This document is waiting your verify. Please click this link document : '.Url::base(true).'/ca-ba-survey/indexverify#viewverify?id='.$model->id.'?header=Verify_CA_BA_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);
				}
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
        } else {
            return $this->render('update_presurvey', [
                'model' => $model,
				'modelArea' => $modelArea,
				'modelRegion' => $modelRegion,
				'modelCity' => $modelCity,
				'modelDistrict' => $modelDistrict,
				'modelIom' => $modelIom,
            ]);
        }
    }

	public function actionIndexoverview()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

	public function actionIndexoverview_presurvey()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('ca-ba-survey-setting') == null )
			\Yii::$app->session->set('ca-ba-survey-setting',['status_listing','city','district','subdistrict','id_area','survey_date']);
        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'overview_presurvey');
        return $this->render('index_presurvey_overview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

	public function actionSetting()
    {
		$this->layout = 'blank';

        return $this->render('setting');
    }

	public function actionSubmitsetting() {
		\Yii::$app->session->set('ca-ba-survey-setting', $_POST['setting']);
		$this->layout = 'map';

        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->redirect('indexoverview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
	}

    public function actionView($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
		$searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'view');

        return $this->render('view', [
            'model' => $model,
        ]);

    }

	public function actionViewlog($id)
    {
		$this->layout = 'blank';
		$model = LogCaBaSurvey::findOne($id);
		$model->scenario = 'revise';
		$searchModel = new SearchLogCaBaSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_log', [
            'model' => $model,
        ]);

    }
    public function actionViewverify($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionViewapprove($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view', [
            'model' => $model,
        ]);
    }

	public function actionViewoverview($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view', [
            'model' => $model,
        ]);
    }

	public function actionView_presurvey($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view_presurvey', [
            'model' => $model,
        ]);
    }

	public function actionViewoverview_presurvey($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view_presurvey', [
            'model' => $model,
        ]);
    }

	public function actionViewverify_presurvey($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view_presurvey', [
            'model' => $model,
        ]);
    }

	public function actionViewapprove_presurvey($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view_presurvey', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {

        $model = new CaBaSurvey();
		$modelArea = new Area();
		$modelRegion = new Region();
		$modelCity = new City();
		$modelDistrict = new District();
		$modelIom = new CaIomAreaExpansion();
		$this->layout = 'blank';

		$model->scenario = 'create';

		if ($model->load(Yii::$app->request->post()) && $modelArea->load(Yii::$app->request->post())) {
			$model->status_listing=7;

			$model->qty_soho_pot = 0;
			$model->qty_hp_pot = 0;
			$model->property_area_type = $_POST['CaBaSurvey']['property_area_type'];
			$model->house_type = $_POST['CaBaSurvey']['house_type'];
			$model->access_to_sell = $_POST['CaBaSurvey']['access_to_sell'];
			$model->myr_population_hv = $_POST['CaBaSurvey']['myr_population_hv'];
			$model->dev_method = $_POST['CaBaSurvey']['dev_method'];
			$model->competitors = $_POST['CaBaSurvey']['competitors'];
			$model->occupancy_use_dth = $_POST['CaBaSurvey']['occupancy_use_dth'];

			$modelNewArea = Area::find()->where(['=','id',$model->id_area])->one();
			if(empty($modelNewArea)) {
				$modelNewArea = new Area();
				$modelNewArea->id = $model->id_area;
				$modelNewArea->id_subdistrict = $modelArea->id_subdistrict;
				$modelNewArea->owner = $modelArea->owner;
				if(! $modelNewArea->save()) return Displayerror::pesan($modelNewArea->getErrors());
			}

			$model->created_by = Yii::$app->user->identity->username;
			$model->created_date = date('Y-m-d');
			$model->updated_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');

			$model->doc_file = 'tempName';
			$model->file_doc = 'tempName';

			if($model->save()) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$filename = $_FILES['file']['name'];
						if (!file_exists('uploads/CA/KMZ/')) {
							mkdir('uploads/CA/KMZ/', 0777, true);
						}
						move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/CA/KMZ/'.$model->id.'.kmz');
						$model->kmz_file = 'uploads/CA/KMZ/'.$model->id.'.kmz';
						Unzip::unzip(Yii::getAlias('@webroot').'/uploads/CA/KMZ/'.$model->id.'.kmz', false, true, true);
						$this->createLog($model);

						$doc = new \DOMDocument();
						$doc->load(Yii::getAlias('@webroot').'/uploads/CA/KMZ/'.$model->id.'/doc.kml');
						$placemarks = $doc->getElementsByTagName("Placemark");
						$i=0;
						$savedPolygon = false;
						$savedPoint = false;
						foreach ($placemarks as $placemark) {
							if($placemark->childNodes[3]->nodeValue == 'RUMAH') {
								$coordinates = explode(',',$placemark->childNodes[7]->nodeValue);
								$modelHomepass = new Homepass();
								$attributes = explode('|',$placemark->childNodes[1]->nodeValue);
								$modelHomepass->streetname = $attributes[2];
								$modelHomepass->home_number = $attributes[3];
								if ($attributes[4] != '') {
									$modelHomepass->kodepos = $attributes[4]*1;
								} else {
									$modelHomepass->kodepos = 0;
								}
								$modelHomepass->potency_type = '-';
								$modelHomepass->iom_type = $model->iom_type;
								$modelHomepass->id_ca_ba_survey = $model->id;
								$modelHomepass->status_ca = 'Input BAS';
								$modelHomepass->geom =  new \yii\db\Expression('ST_SetSRID(ST_MakePoint('.$coordinates[0].','.$coordinates[1].'),4326)');
								if(!$modelHomepass->save()) {
                                    return Displayerror::pesan($modelHomepass->getErrors());
								} else {
									$savedPoint = true;
								}
							}
							if($placemark->childNodes[3]->nodeValue == 'boundary_rw') {
								$datas = explode(',', $placemark->childNodes[7]->nodeValue);
								$insertText = "ST_GeomFromText('MULTIPOLYGON(((".$datas[0];
								for ($i=1; $i<count($datas);$i++) {
									if($i%2 == 0) {
										$data = preg_split('/\s+/', $datas[$i]);
										$insertText .= $data[1]." ";
									} else {
										$insertText .= $datas[$i];
										if($i != count($datas)-2) $insertText .= ",";
									}
								}

								$insertText .= ")))',4326)";
								$model->geom = new \yii\db\Expression($insertText);
								if(!$model->save()) {
                                    return Displayerror::pesan($model->getErrors());
								} else {
									$savedPolygon = true;
								}
							}
						}
						if($savedPolygon && $savedPoint) {
							$model->status_listing = 1;
							$model->save();
						}
					}
				}
				if (isset($_FILES['file_doc']['size'])) {
					if($_FILES['file_doc']['size'] != 0) {
						$filename = $_FILES['file_doc']['name'];
						if (!file_exists('uploads/CA/BAS/'.$model->id.'/')) {
							mkdir('uploads/CA/BAS/'.$model->id.'/', 0777, true);
						}
						move_uploaded_file($_FILES['file_doc']['tmp_name'], 'uploads/CA/BAS/'.$model->id.'/'.$filename);
						$model->doc_file = 'uploads/CA/BAS/'.$model->id.'/'.$_FILES['file_doc']['name'];
						$model->save();
					}
				}
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

				if($model->status_listing == 1) {
					$arrAuth = ['/ca-ba-survey/indexverify'];
	                $header = 'Alert Verify CA BA Survey';
	                $subject = 'This document is waiting your verify. Please click this link document : '.Url::base(true).'/ca-ba-survey/indexverify#viewverify?id='.$model->id.'?header=Verify_CA_BA_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);
				}
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
        } else {
            return $this->render('create', [
                'model' => $model,
				'modelArea' => $modelArea,
				'modelRegion' => $modelRegion,
				'modelCity' => $modelCity,
				'modelDistrict' => $modelDistrict,
				'modelIom' => $modelIom,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $this->layout = 'blank';

		$model = $this->findModel($id);
		if(isset($model->xls_file) || isset($model->doc_file)){
			$model->scenario = 'update_no_file';
		}else{
			$model->scenario = 'update';
		}
       // $model->pic_survey = null;

		$modelArea = new Area();
		$modelRegion = new Region();
		$modelCity = new City();
		$modelDistrict = new District();
		$modelIom = new CaIomAreaExpansion();
		if($model->status_presurvey==5 && $model->status_listing==999){
			$model->revision_remark = null;
		}

        if ($model->load(Yii::$app->request->post()) && $modelArea->load(Yii::$app->request->post())) {
			if($model->status_listing == 3 || $model->status_listing == 28) $model->status_listing=2;
			if($model->status_listing == 999) $model->status_listing=1;

			$model->qty_soho_pot = 0;
			$model->qty_hp_pot = 0;
			if(!empty($_POST['CaBaSurvey']['pic_iom_special'])){
				$model->pic_iom_special = $_POST['CaBaSurvey']['pic_iom_special'];
			}else{
				$model->pic_iom_special = 123;
			}


			$modelNewArea = Area::find()->where(['=','id',$model->id_area])->one();
			if(empty($modelNewArea)) {
				$modelNewArea = new Area();
				$modelNewArea->id = $model->id_area;
				$modelNewArea->id_subdistrict = $modelArea->id_subdistrict;
				$modelNewArea->owner = $modelArea->owner;
				$modelNewArea->save();
			}

			$model->updated_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');

			$model->file_xls = 'tempName';
			$model->file_doc = 'tempName';
			$model->file_pdf = 'tempName';

			if($model->save()) {

				CaBaSurveyReference::deleteAll('id_ca_ba_survey = :parent', [':parent' => $model->id]);
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['house_type']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['property_area_type']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['avr_occupancy_rate']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['myr_population_hv']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['dev_method']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['access_to_sell']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['competitors']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}
				$tempArr = [];
				$tempArr = explode(',',$_POST['CaBaSurvey']['occupancy_use_dth']);
				foreach ($tempArr as $tempData) {
					$modelCaBaSurveyReference = new CaBaSurveyReference();
					$modelReference = CaReference::findOne($tempData);
					$modelCaBaSurveyReference->id_ca_ba_survey = $model->id;
					$modelCaBaSurveyReference->id_ca_reference = $modelReference->id;
					if(!$modelCaBaSurveyReference->save()){
						return print_r($modelCaBaSurveyReference->getErrors());
					}
				}

				if (isset($_FILES['file_xls']['size'])) {
					if($_FILES['file_xls']['size'] != 0) {
						$filename = basename($_FILES['file_xls']['name']);
						$file_ext = explode(".", strtolower($filename));
						if (!file_exists('uploads/CA/XLS/')) {
							mkdir('uploads/CA/XLS/', 0777, true);
						}
						move_uploaded_file($_FILES['file_xls']['tmp_name'], 'uploads/CA/XLS/'.$model->id.'.'.$file_ext[1]);
						$filedir = 'uploads/CA/XLS/'.$model->id.'.'.$file_ext[1];
						$model->file_xls = 'uploads/CA/XLS/'.$model->id.'.'.$file_ext[1];
						$model->xls_file = 'uploads/CA/XLS/'.$model->id.'.'.$file_ext[1];
						$model->save();
						//return $filename;
					}
				}
				if (isset($_FILES['file_doc']['size'])) {
					if($_FILES['file_doc']['size'] != 0) {
						$filename = basename($_FILES['file_doc']['name']);
						$file_ext = explode(".", strtolower($filename));
						if (!file_exists('uploads/CA/APD/'.$model->id.'/')) {
							mkdir('uploads/CA/APD/'.$model->id.'/', 0777, true);
						}
						move_uploaded_file($_FILES['file_doc']['tmp_name'], 'uploads/CA/APD/'.$model->id.'/'.$model->id.'.'.$file_ext[1]);

						$filedir = 'uploads/CA/APD/'.$model->id.'/'.$model->id.'.'.$file_ext[1];
						$model->file_doc = $filedir;
						$model->doc_file = $filedir;

						//$model->save();
					}
				}

				if (isset($_FILES['file_pdf']['size'])) {
					if($_FILES['file_pdf']['size'] != 0) {
						$filename = basename($_FILES['file_pdf']['name']);
						$file_ext = explode(".", strtolower($filename));
						if (!file_exists('uploads/CA/APD_DRAFT/'.$model->id.'/')) {
							mkdir('uploads/CA/APD_DRAFT/'.$model->id.'/', 0777, true);
						}
						move_uploaded_file($_FILES['file_pdf']['tmp_name'], 'uploads/CA/APD_DRAFT/'.$model->id.'/'.$model->id.'.'.$file_ext[1]);
						$filedir = 'uploads/CA/APD_DRAFT/'.$model->id.'/'.$model->id.'.'.$file_ext[1];
						$model->file_pdf = $filedir;
						$model->pdf_file = $filedir;
						$model->save();

					}
				}

				if($model->status_listing == 1 || $model->status_listing == 2 ) {
					$arrAuth= ['/ca-ba-survey/indexverify'];
	                $header= 'Alert Verify CA BA Survey';
	                $subject= 'This document is waiting your verify. Please click this link document : '.Url::base(true).'/ca-ba-survey/indexverify#viewverify?id='.$model->id.'?header=Verify_CA_BA_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);
				}


				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
        } else {

			// return print_r($model->pic_survey;
            return $this->render('update', [
                'model' => $model,
				'modelArea' => $model->idArea,
				'modelRegion' => $model->idArea->idSubdistrict->idDistrict->idCity->idRegion,
				'modelCity' => $model->idArea->idSubdistrict->idDistrict->idCity,
				'modelDistrict' => $model->idArea->idSubdistrict->idDistrict,
				'modelIom' => $modelIom,

            ]);
        }
    }

	public function actionGetIom() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$iom = CaIomAndCity::find()->where(['id_city' => $cat_id])->all();

				$ids = [];
				$j = 0;
				for($i = 0; $i < count($cities); $i++) {
					if(!in_array($cities[$i]->idIom->id,$ids)) {
						array_push($ids, $iom[$i]->idIom->id);
						$out[$j]['id'] = $iom[$i]->idIom->id;
						$out[$j]['no_iom_area_exp'] = $iom[$i]->idIom->no_iom_area_exp;
						$j++;
					}
				}

				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}

    public function actionDelete($id)
    {
		$model = $this->findModel($id);

		if( $model->status_listing == 1 || $model->status_listing == 6 || $model->status_presurvey == 1 || $model->status_presurvey == 6 || $model->status_iom == 1 || $model->status_iom == 6){
			$modelLog = new LogCaBaSurvey();
			$modelLog->setAttributes($model->attributes);
			$modelLog->status_listing= 13;
			$modelLog->save();
			$this->findModel($id)->delete();

			return 'success';
		}else{
			return 'May delete if status listing is "Inputted" or "Rejected"';
		}

    }

	public function actionDelete_iom($id)
    {
		$model = $this->findModel($id);
		if( $model->status_iom == 1 || $model->status_iom == 6){
			//$this->findModel($id)->delete();
			$model->no_iom = null;
			$model->file_iom_rollout = null;
			$model->status_iom = 999;
			$model->save();
			return 'success';
		}else{
			return 'May delete if status listing is "Inputted" or "Rejected"';
		}

    }

    public function actionVerify($id)
    {
        $model = $this->findModel($id);
		if($model->status_listing == 1 || $model->status_listing == 2){
			$model->status_listing = 4;
			$model->updated_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');
			if ($model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-ba-survey/indexverify'];
				$header = 'Alert Approval BA Survey' ;
				$subject = 'This document is waiting your approval. Please click this link document :'.Url::base(true).'/ca-ba-survey/indexapprove#viewapprove?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
				Email::sendEmail($arrAuth,$header,$subject);
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		}
    }

	public function actionVerify_presurvey($id)
    {
        $model = $this->findModel($id);
		if($model->status_presurvey == 1 || $model->status_presurvey == 2){
			$model->status_presurvey = 4;
			if ($model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-ba-survey/indexapprove'];
				$header = 'Alert Approval BA Survey' ;
				$subject = 'This document is waiting your approval. Please click this link document :'.Url::base(true).'/ca-ba-survey/indexapprove#viewapprove?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
				Email::sendEmail($arrAuth,$header,$subject);
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		}
    }

	public function actionApprove_presurvey($id)
    {
        $model = $this->findModel($id);
		if($model->status_presurvey == 4){
			$model->status_presurvey = 5;
			$model->updated_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');

			if ( $model->save()) {
				$model->revision_remark = null;
				$model->save();
				$this->createLog($model);
				$arrAuth = ['/ca-iom-area-expansion/index'];
				$header = 'Alert Input Roll Out';
				$subject = 'This document is waiting your input. Please click this link document : '.Url::base(true).'/ca-ba-survey/index_potensial#create_iom?id='.$model->id.'&header=Create_IOM';
				Email::sendEmail($arrAuth,$header,$subject);
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		}else{
			return $this->redirect(['indexapprove_presurvey']);
		}
    }

	public function actionApprove($id)
    {
        $model = $this->findModel($id);
		if($model->status_listing == 4){
			$model->status_listing = 5;
			$model->status_iom = 999;
			$model->updated_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');

			if ( $model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-iom-area-expansion/index'];
				$header = 'Alert Input Roll Out';
				$subject = 'This document is waiting your input. Please click this link document : '.Url::base(true).'/ca-ba-survey/index_potensial#create_iom?id='.$model->id.'&header=Create_IOM';
				Email::sendEmail($arrAuth,$header,$subject);
				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		}else{
			return $this->redirect(['indexapprove']);
		}
    }



	//------------ IOM PAGES ---------

	public function actionIndexverify_potensial()
    {
		$this->layout = 'map';

        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams, 'verifypotensial');
        return $this->render('index_iom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionIndexapprove_potensial()
    {
		$this->layout = 'map';

        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams, 'approvepotensial');
        return $this->render('index_iom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex_potensial()
    {

		$this->layout = 'map';

        $searchModel = new SearchCaBaSurvey();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'inputpotensial');

        return $this->render('index_iom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionView_potensial($id)
    {
		$this->layout = 'blank';
        return $this->render('view_potensial', [
            'model' => $this->findModel($id),
        ]);
    }
	public function actionView_iom($id)
    {
		$this->layout = 'blank';
        return $this->render('view_iom', [
            'model' => $this->findModel($id),
        ]);
    }
	public function actionViewverify_iom($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view_iom', [
            'model' => $model,
        ]);
    }
    public function actionViewapprove_iom($id)
    {
		$this->layout = 'blank';
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view_iom', [
            'model' => $model,
        ]);
    }
	public function actionCreate_iom($id)
    {
		$this->layout = 'blank';

        $model = $this->findModel($id);
		// if($model->file_iom_rollout == null)$model->scenario = 'create_iom';


		if (isset($_FILES['file_iom']['size']) || $model->load(Yii::$app->request->post())) {
			if($_FILES['file_iom']['size'] != 0) {
				if (!file_exists('uploads/CA/IOM/'.$model->id.'/')) {
					mkdir('uploads/CA/IOM/'.$model->id.'/', 0777, true);
				}
				move_uploaded_file($_FILES['file_iom']['tmp_name'], 'uploads/CA/IOM/'.$model->id.'/'.$_FILES['file_iom']['name']);
				if($model->status_iom==3 || $model->status_iom==2){
					$model->status_iom=2;
				} else if($model->status_iom==999){
					$model->status_iom=1;
				}
				$model->updated_by = Yii::$app->user->identity->username;
				$model->updated_date = date('Y-m-d');
				//$model->iom_file = 'uploads/CA/IOM/'.$model->id.'/'.$_FILES['file_iom']['name'];
				$model->file_iom_rollout = 'uploads/CA/IOM/'.$model->id.'/'.$_FILES['file_iom']['name'];
				$model->file_iom = 'uploads/CA/IOM/'.$model->id.'/'.$_FILES['file_iom']['name'];
				$basename = explode('.',$_FILES['file_iom']['name'])[0];
				$model->no_iom =  $basename;
				if($model->save()) {
					$this->createLog($model);
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						$arrAuth = ['/ca-ba-survey/indexverify'];
						$header = 'Alert Verify IOM Roll Out';
						$subject = 'This document is waiting your verify. Please click this link document : '.Url::base(true).'/ca-ba-survey/indexverify#viewverify?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
						Email::sendEmail($arrAuth,$header,$subject);
					return 'success';
				} else {
					return Displayerror::pesan($model->getErrors());
				}
			}
		}else if(isset($_POST['file_iom_terisi']) || $model->load(Yii::$app->request->post())){
			if($model->status_iom==3 || $model->status_iom==2){
				$model->status_iom=2;
				$model->save();
			}else{
				$model->status_iom = 1;
			}
			return $this->redirect('index_iom');
		}else {
            return $this->render('create_iom', [
                'model' => $model,
            ]);
        }

    }

	public function actionVerify_iom($id)
    {
        $model = $this->findModel($id);
        $model->status_iom = 4;
        if ($model->save()) {
			$this->createLog($model);
			$arrAuth = ['/ca-ba-survey/indexverify_iom'];
			$header = 'Alert Approval BA Survey' ;
			$subject = 'This document is waiting your approval. Please click this link document : '.Url::base(true).'/ca-ba-survey/indexverify_potensial#viewverify_potensial?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
			Email::sendEmail($arrAuth,$header,$subject);

            return 'success';
        } else {
            return Displayerror::pesan($model->getErrors());
        }
    }
	public function actionApprove_iom($id)
    {
        $model = $this->findModel($id);
        $model->status_iom = 5;

        if ( $model->save()) {
			$this->createLog($model);
			$arrAuth = ['/govrel-ba-distribution/index'];
			$header = 'Alert BA Distribution Govrel';
			$subject = 'BA Distribution is ready to process. Please click this link document : http://10.9.39.41/foro/govrel/web/govrel-ba-distribution/index#create?idCaBaSurvey='.$model->id.'&header=Create_BA_Distribution';
			Email::sendEmail($arrAuth,$header,$subject);
            return 'success';
        } else {
            return Displayerror::pesan($model->getErrors());
        }
    }

	public function actionDelete_potensial($id)
    {
        $model = $this->findModel($id);
        $model->status_iom = null;
        $model->no_iom = null;
        $model->iom_file = null;

        if ( $model->save()) {
            return 'success';
        } else {
            return Displayerror::pesan($model->getErrors());
        }
    }

	public function actionRepermit($id)
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			$model->status_listing = 28;
			if($model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-ba-survey/index'];
				$header = 'Alert need revise CA BA Survey';
				$subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index#view?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
				Email::sendEmail($arrAuth,$header,$subject);


				return 'success';
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		} else {
			return 'data not found';
		}
    }

	public function actionRevise($id)
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_listing = 3;
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {
					$this->createLog($model);
					$arrAuth = ['/ca-ba-survey/index'];
					$header = 'Alert need revise CA BA Survey';
	                $subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index#view?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);


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

	public function actionRevise_presurvey($id)
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_presurvey = 3;
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {
					$this->createLog($model);
					$arrAuth = ['/ca-ba-survey/index'];
					$header = 'Alert need revise CA BA Survey';
	                $subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index#view?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);


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
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_listing = 6;
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {
				$this->createLog($model);
				   $arrAuth = ['/ca-ba-survey/index'];
					$header = 'Alert need revise CA BA Survey';
	                $subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index#view?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);

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

	public function actionReject_presurvey($id)
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_presurvey = 6;
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {
				$this->createLog($model);
				   $arrAuth = ['/ca-ba-survey/index'];
					$header = 'Alert need revise CA BA Survey';
	                $subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index#view?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
	                Email::sendEmail($arrAuth,$header,$subject);

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

	public function actionReject_iom($id)
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		$model->scenario = 'revise';
		if($model != null) {
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_iom = 6;
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {
				$this->createLog($model);
				   $arrAuth = ['/ca-ba-survey/index_iom'];
					$header = 'Alert rejected IOM';
	                $subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index_iom#view_iom?id='.$model->id.'&header=Detail_IOM';
	                Email::sendEmail($arrAuth,$header,$subject);

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

	public function actionRevise_iom($id)
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		$model->scenario = 'revise';
		if($model != null) {
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_iom = 3;
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-ba-survey/index'];
				$header = 'Alert need revise CA BA Survey';
				$subject = 'This document is waiting your revise. Please click this link document : '.Url::base(true).'/ca-ba-survey/index#view?id='.$model->id.'&header=Detail_Berita_Acara_Survey';
				Email::sendEmail($arrAuth,$header,$subject);


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




   public function actionReject_potensial($id)

    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			if(isset($_POST['CaBaSurvey']['revision_remark'])) {
				$model->status_iom = 'rejected';
				$model->revision_remark = $_POST['CaBaSurvey']['revision_remark'];
				if($model->save()) {

				   Yii::$app->mailer->compose()
	                -> setFrom (['system@elixer.co.id' => 'Mailer System'])
	                -> setTo(['fdyahk@yahoo.com'])
	                -> setSubject ( 'Alert Verify CA BA Survey' )
	                -> setHtmlBody( 'Document BA Survey for Area ID: '.$model->id_area.' is rejected. With reason'.$model->revision_remark)
	                -> send();

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

	public function actionDownloadfile($id, $modul = null, $relation = true) {
		$request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
        $lok = '';

        if ($modul) {
            $basepath = Yii::getAlias('@'.$modul) .'/web/';
        }else {
            $basepath = Yii::getAlias('@webroot') . '/';
        }

        $model = $this->findModel($id);

        $path = ArrayHelper::getValue($model, $params['data'], 'Unknown');

        // if ($params['path'] === 'true') {
            // $lok = 'CA/IOM/'.$id.'/';
        // }

        $file = $basepath.$lok.$path;
		//return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
            // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}

	public function actionExportxls($id) {

		$modelCa = CaBaSurvey::findOne($id);


		\moonland\phpexcel\Excel::export([
			'models' => AttributeHomepass::find()->where(['id_ca_ba_survey'=>$id])->all(),
			'fileName' => $modelCa->xls_file,
			'columns' => ['id','region','city','district','subdistrict','id_area','streetname','kodepos','iom_type','potency_type'],
			'headers' => ['id' => 'ID','region'=>'Region','streetname' => 'Street Name', 'kodepos' => 'Kode Pos', 'iom_type'=>'IOM Type' ,'Potency Type'],
		]);
	}


    protected function findModel($id)
    {
        if (($model = CaBaSurvey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	protected function createLog($model)
	{
		$modelLog = new LogCaBaSurvey();
		$modelAttr = CaBaSurvey::findOne($model->id);

		$modelLog->setAttributes($model->attributes);
		if(!$modelLog->save()){
			return print_r($modelLog->getErrors());
		}
	}

	public function actionCreatepolygon() {
		$model = $this->findModel($_POST['id_ca_ba_survey']);

		$model->geom = new \yii\db\Expression("ST_Transform(ST_GeomFromText('".$_POST['coordinates']."',3857),4326)");

		if($model->status_listing == 3) {
			$model->status_listing=2;
		}

		if($model->status_presurvey == 7){
			$model->status_presurvey = 1;
		}



		if($model->save()) {
			$this->createLog($model);
			return 'success';
		} else {
			return print_r($model->getErrors());
		}
	}

}
