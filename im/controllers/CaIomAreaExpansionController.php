<?php

namespace ca\controllers;

use Yii;
use app\models\CaIomAreaExpansion;
use app\models\Province;
use app\models\Region;
use app\models\City;
use app\models\CaIomAndCity;
use app\models\LogCaIomAndCity;
use ca\models\SearchCaIomAreaExpansion;
use ca\models\SearchCaIomAndCity;
use ca\models\SearchLogCaIomAndCity;
use ca\models\SearchLogCaIomAreaExpansion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\LogCaIomAreaExpansion;
use common\widgets\Displayerror;
use common\widgets\Email;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class CaIomAreaExpansionController extends Controller
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
					'save' => ['POST'],
					'deletecity' => ['POST'],
					'reviseverify' => ['POST'],
					'reviseapprove' => ['POST'],
					'rejectverify' => ['POST'],
					'rejectapprove' => ['POST'],
					'downloadfile' => ['POST'],
                ],
            ],
        ];
    }

	// --- Index Pages ---
	// Page Index untuk Input. Menampilkan data dengan status hanya untuk Inputter searchFilter Parameters.
    public function actionIndex()
    {
        $searchModel = new SearchCaIomAreaExpansion();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexlog()
    {
        $searchModel = new SearchLogCaIomAreaExpansion();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Index untuk Verify. Menampilkan data dengan status hanya untuk Verificator searchFilter Parameters.
    public function actionIndexverify()
    {
        $searchModel = new SearchCaIomAreaExpansion();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Index untuk Approve. Menampilkan data dengan status hanya untuk Approver searchFilter Parameters.
    public function actionIndexapprove()
    {
        $searchModel = new SearchCaIomAreaExpansion();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Index untuk Approve. Menampilkan data dengan status hanya untuk Approver searchFilter Parameters.
    public function actionIndexoverview()
    {
        $searchModel = new SearchCaIomAreaExpansion();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// --- View Pages ---
	// Page View untuk inputter. Menampilkan data dengan tombol update dan delete.
    public function actionView($id)
    {
		$searchModel = new SearchCaIomandcity();
        $dataProvider = $searchModel->searchByIom(Yii::$app->request->queryParams, $id);
		$dataProvider->pagination = false;

        return $this->render('view', [
            'model' => $this->findModel($id),
			'dataProvider' => $dataProvider
        ]);
    }

	public function actionViewlog($id,$idLog)
    {
		$searchModel = new SearchLogCaIomandcity();
        $dataProvider = $searchModel->searchByIom(Yii::$app->request->queryParams, $id);
		$dataProvider->pagination = false;

        return $this->render('viewlog', [
            'model' => LogCaIomAreaExpansion::find()->where(['idlog'=> $idLog])->one(),
			'dataProvider' => $dataProvider
        ]);
    }

	public function actionViewoverview($id)
    {
		$searchModel = new SearchCaIomandcity();
        $dataProvider = $searchModel->searchByIom(Yii::$app->request->queryParams, $id);
		$dataProvider->pagination = false;

        return $this->render('view', [
            'model' => $this->findModel($id),
			'dataProvider' => $dataProvider
        ]);
    }

	// Page View untuk verificator. Menampilkan data dengan tombol verify, revise, reject.
    public function actionViewverify($id)
    {
        $searchModel = new SearchCaIomandcity();
        $dataProvider = $searchModel->searchByIom(Yii::$app->request->queryParams, $id);
		$dataProvider->pagination = false;
		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view', [
            'model' => $model,
			'dataProvider' => $dataProvider
        ]);
    }

	// Page View untuk approver. Menampilkan data dengan tombol approve, revise, reject.
    public function actionViewapprove($id)
    {
        $searchModel = new SearchCaIomandcity();
        $dataProvider = $searchModel->searchByIom(Yii::$app->request->queryParams, $id);
		$dataProvider->pagination = false;

		$model = $this->findModel($id);
		$model->scenario = 'revise';
        return $this->render('view', [
            'model' => $model,
			'dataProvider' => $dataProvider
        ]);
    }


	// Page Create. Redirect ke Page Index City jika berhasil save.
    public function actionCreate()
    {
        $model = new CaIomAreaExpansion();
		$modelLog = new LogCaIomAreaExpansion();
		$model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {
			$model->created_date = date('Y-m-d');
			$model->created_by = Yii::$app->user->identity->username;
			$model->updated_date = date('Y-m-d');
			$model->updated_by = Yii::$app->user->identity->username;
            $model->status = 7;
			$model->doc_file = 'temp_file';
			$model->file = UploadedFile::getInstance($model, 'file');
			$model->no_iom_area_exp =  $model->file->baseName;



            if($model->save()) {
				$session = Yii::$app->session;
				$session->set('idIom', $model->id);
				$model->file = UploadedFile::getInstance($model, 'file');
				if ($model->file != null) {
					if (!file_exists('uploads/CA/IOM_EXP/')) {
						mkdir('uploads/CA/IOM_EXP/', 0755, true);
					}
					$model->file = UploadedFile::getInstance($model, 'file');
					$model->doc_file = 'uploads/CA/IOM_EXP/'  .$model->file->baseName.'.'. $model->file->extension;
					$model->save();
					$this->createLog($model);
					$model->file->saveAs('uploads/CA/IOM_EXP/' .$model->file->baseName.'.'. $model->file->extension);
					$model->file = null;
				}

				$arrAuth = ['/ca-iom-area-expansion/index'];
				$header = 'Alert Verify CA IOM Area Expansion';
				$subject = 'This document is waiting for your verification. Please click this link document '.Url::base(true).'/ca-iom-area-expansion/viewverify?id='.$model->id;
				Email::sendEmail($arrAuth,$header,$subject);

				return $this->redirect(['indexcity']);
			}else{
				Yii::$app->session->setFlash('failed', Displayerror::pesan($model->getErrors()));
				return $this->redirect(['index']);
			}
		}
		return $this->render('create', [
			'model' => $model,
		]);
    }

	public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		$modelLog = new LogCaIomAreaExpansion();
		if($model->status == 3 || $model->status == 1 || $model->status == 2 || $model->status == 7) {

			if ($model->load(Yii::$app->request->post())) {

				$model->updated_date = date('Y-m-d');
				$model->updated_by = Yii::$app->user->identity->username;


				if($model->status == 3){
					$model->status = 2;
				}

				if(!isset($model->doc_file)){
					$model->doc_file = 'temp_file';
				}
				$model->file = UploadedFile::getInstance($model, 'file');
				if ($model->file != null) {
					if (!file_exists('uploads/CA/IOM_EXP/')) {
						mkdir('uploads/CA/IOM_EXP/', 0755, true);
					}
					$model->file = UploadedFile::getInstance($model, 'file');
					$model->no_iom_area_exp =  $model->file->baseName;
					$model->doc_file = 'uploads/CA/IOM_EXP/'  .$model->file->baseName.'.'. $model->file->extension;
					$model->save();
					$this->createLog($model);
					$model->file->saveAs('uploads/CA/IOM_EXP/' .$model->file->baseName.'.'. $model->file->extension);
					$model->file = null;
				}


				if($model->status == 3 || $model->status == 2) {
					$model->status =2;
				} else if($model->status == 7){
					$model->status =7;
				}else{
					$model->status =1;
				}

				$model->file = UploadedFile::getInstance($model, 'file');

				if ($model->file != null) {
					if (!file_exists('uploads/CA/IOM_EXP/')) {
						mkdir('uploads/CA/IOM_EXP/', 0755, true);
					}

					$model->file->saveAs('uploads/CA/IOM_EXP/' .$model->file->baseName.'.'. $model->file->extension);
					$model->doc_file = 'uploads/CA/IOM_EXP/'  .$model->file->baseName.'.'. $model->file->extension;
					$model->file = null;
				}



				if($model->save()) {
					$this->createLog($model);
					$arrAuth = ['/ca-iom-area-expansion/indexverify'];
					$header = 'Alert Verify CA IOM Area Expansion';
					$subject = 'This document is waiting for your verification. Please click this link document '.Url::base(true).'/ca-iom-area-expansion/viewverify?id='.$model->id;
					Email::sendEmail($arrAuth,$header,$subject);
					$session = Yii::$app->session;
					$session->set('idIom', $model->id);
					return $this->redirect(['indexcity']);
				}else{
				Yii::$app->session->setFlash('failed', Displayerror::pesan($model->getErrors()));
				return $this->redirect(['index']);
			}
			}
		}
		return $this->render('update', [
			'model' => $model,
		]);

    }


	// Page Index untuk Input. Menampilkan data city dengan IOM terkait.
	public function actionIndexcity()
    {
		$session = Yii::$app->session;
        $searchModel = new SearchCaIomAndCity();
        $dataProvider = $searchModel->searchByIom(Yii::$app->request->queryParams,Yii::$app->session->get('idIom'));

        return $this->render('indexcity', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexcitylog()
    {
		$session = Yii::$app->session;
        $searchModel = new SearchLogCaIomAndCity();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexcitylog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionCreatecity()
    {
		$model = new CaIomAndCity();
		$modelRegion = new Region();
		$modelRegion->scenario = 'createcity';
		$modelProvince = new Province();
		$model->id_ca_iom_area_expansion = Yii::$app->session->get('idIom');
        if ($model->load(Yii::$app->request->post())) {
			if(CaIomAndCity::find()->where(['id_ca_iom_area_expansion' => $model->id_ca_iom_area_expansion, 'id_city' => $model->id_city])->exists()){
				Yii::$app->session->setFlash('failed', 'City has been inputted');
				return $this->redirect(['indexcity']);
			}
			if ($model->save()) {
				$this->createLogCity($model);
				$modelIom = CaIomAreaExpansion::findOne($model->id_ca_iom_area_expansion);
				$modelIom->status = 1;
				$modelIom->save();
				return $this->redirect(['indexcity']);
			}
        }
		return $this->render('createcity', [
			'model' => $model,
			'modelProvince' => $modelProvince,
			'modelRegion' => $modelRegion,
		]);
	}

	public function actionSave($idIom)
	{
		$model = $this->findModel($idIom);
		if($model->status == 2 && $model->status == 3) {
			$model->status = 2;
		} else {
			$model->status = 1;
		}

		 \Yii::$app->getSession()->setFlash('success', 'IOM has been saved');
        return $this->redirect(['index']);
	}

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		if($model->status != 1 && $model->status != 6 && $model->status != 7){
			return 'Data cannot be deleted.';
		}
		$model->delete();
		 \Yii::$app->getSession()->setFlash('success', 'Data has been deleted');
        return $this->redirect(['index']);
    }

	public function actionDeletecity($id,$idIom)
    {
		$model = CaIomAndCity::findOne($id);
		//$idIom = $model->id_ca_iom_area_expansion;
		//return print_r($idIom);
		$this->createLogCity($model);
		CaIomAndCity::findOne($id)->delete();
		if(!CaIomAndCity::find()->where(['id_ca_iom_area_expansion'=>$idIom])->exists()){
			$modelIom = CaIomAreaExpansion::findOne($idIom);
			$modelIom->status = 7;
			$modelIom->save();
		}


        return $this->redirect(['indexcity']);
	}

	public function actionVerify($id)
    {
        $model = $this->findModel($id);
		if($model->status == 1 || $model->status == 2){
			$model->status = 4;
			if ($model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-iom-area-expansion/indexapprove'];
				$header = 'Alert Approve IOM AREA Expansion';
				$subject = 'This document is waiting your approval. Please click this link document : '.Url::base(true).'/ca-iom-area-expansion/viewapprove?id='.$model->id;
				Email::sendEmail($arrAuth,$header,$subject);
				\Yii::$app->getSession()->setFlash('success', 'Data has been Verified');
				return $this->redirect(['indexverify']);
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		}else{
			return $this->redirect(['indexverify']);
		}

    }
    public function actionApprove($id)
    {
        $model = $this->findModel($id);

		if($model->status == 4){
			$model->status = 5;

			if ( $model->save()) {
				$this->createLog($model);
				$arrAuth = ['/ca-ba-survey/index'];
				$header = 'Alert Approve IOM AREA Expansion';
				$subject = 'Document CA BA Survey is ready to create';
				Email::sendEmail($arrAuth,$header,$subject);
				\Yii::$app->getSession()->setFlash('success', 'Data has been Approved');
				return $this->redirect(['indexapprove']);
			} else {
				return Displayerror::pesan($model->getErrors());
			}
		}else{
			return $this->redirect(['createLog']);
		}


    }
    public function actionReviseverify($id)
    {
        $model = $this->findModel($id);

		if($model != null) {
			if($model->status == 1 || $model->status == 2){
				if ($model->load(Yii::$app->request->post())) {
					$model->status = 3;
					if($model->save()) {
						$this->createLog($model);
						$arrAuth = ['/ca-iom-area-expansion/index'];
						$header = 'Alert Revision IOM AREA Expansion';
						$subject = 'This document is need your revision. Please clik: '.Url::base(true).'/ca-iom-area-expansion/view?id='.$model->id;
						Email::sendEmail($arrAuth,$header,$subject);
						\Yii::$app->getSession()->setFlash('success', 'Data has been Revised');
						//if (strpos(Yii::$app->request->referrer, 'viewverifiy') !== false) {
						return $this->redirect(['indexverify']);
						//}
					} else {
						return Displayerror::pesan($model->getErrors());
					}
				} else {
					return 'Please insert Revision/Rejection Remark';
				}
			}else{
				return $this->redirect(['indexverify']);
			}
		} else {
			return 'data not found';
		}
    }
    public function actionReviseapprove($id)
    {
        $model = $this->findModel($id);
		if($model != null) {
			if($model->status == 4){
				if ($model->load(Yii::$app->request->post())) {
					$model->status = 3;
					if ( $model->save()) {
						$this->createLog($model);
							$arrAuth = ['/ca-iom-area-expansion/index'];
							$header = 'Alert Revision IOM AREA Expansion';
							$subject = 'This document is need your revision. Please clik: '.Url::base(true).'/ca-iom-area-expansion/view?id='.$model->id;
							Email::sendEmail($arrAuth,$header,$subject);
						\Yii::$app->getSession()->setFlash('success', 'Data has been Revised');
						return $this->redirect(['indexapprove']);
					} else {
						return Displayerror::pesan($model->getErrors());
					}
				}else {
					return 'Please insert Revision/Rejection Remark';
				}
			}else{
				return $this->redirect(['indexapprove']);
			}
		} else {
			return 'data not found';
		}

    }
    public function actionRejectverify($id)
    {
        $model = $this->findModel($id);
        if($model != null) {
			if($model->status == 1 || $model->status == 2){
				if(isset($_POST['CaIomAreaExpansion']['revision_remark'])) {
					$model->status = 6;
					$model->revision_remark = $_POST['CaIomAreaExpansion']['revision_remark'];
					if($model->save()) {
						$this->createLog($model);
						$arrAuth = ['/ca-iom-area-expansion/index'];
							$header = 'Alert Rejection IOM AREA Expansion';
							$subject = 'This document is Rejected. Please clik: '.Url::base(true).'/ca-iom-area-expansion/view?id='.$model->id;
							Email::sendEmail($arrAuth,$header,$subject);
						\Yii::$app->getSession()->setFlash('success', 'Data has been Rejected');
						return $this->redirect(['indexverify']);
					} else {
						return Displayerror::pesan($model->getErrors());
					}
				} else {
					return 'Please insert Revision/Rejection Remark';
				}
			}else{
				return $this->redirect(['indexverify']);
			}
		} else {
			return 'data not found';
		}
    }
    public function actionRejectapprove($id)
    {
        $model = $this->findModel($id);
        if($model != null) {
			if($model->status == 4){
				if(isset($_POST['CaIomAreaExpansion']['revision_remark'])) {
					$model->status = 6;
					$model->revision_remark = $_POST['CaIomAreaExpansion']['revision_remark'];

					if ( $model->save()) {
						$this->createLog($model);
						$arrAuth = ['/ca-iom-area-expansion/index'];
							$header = 'Alert Rejection IOM AREA Expansion';
							$subject = 'This document is Rejected. Please clik: '.Url::base(true).'/ca-iom-area-expansion/view?id='.$model->id;
							Email::sendEmail($arrAuth,$header,$subject);
						\Yii::$app->getSession()->setFlash('success', 'Data has been Rejected');
						return $this->redirect(['indexapprove']);
					} else {
						return Displayerror::pesan($model->getErrors());
					}
				} else {
					return 'Please insert Revision/Rejection Remark';
				}
			}else{
				return $this->redirect(['indexapprove']);
			}
		} else {
			return 'data not found';
		}


    }

	public function actionDownloadfile($id, $ca = null, $relation = true) {
		$request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
        $lok = '';


        $basepath = Yii::getAlias('@webroot') . '/';
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

    protected function findModel($id)
    {
        if (($model = CaIomAreaExpansion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	protected function createLog($model)
	{
		$modelLog = new LogCaIomAreaExpansion();
		$modelLog->setAttributes($model->attributes);
		$modelLog->updated_date = new \yii\db\Expression('NOW()');
		$modelLog->updated_by = Yii::$app->user->identity->id;
		if(!$modelLog->save()){
			return print_r($modelLog->getErrors());
		}
	}

	protected function createLogCity($model)
	{
		$modelLog = new LogCaIomAndCity();
		$modelLog->setAttributes($model->attributes);
		if(!$modelLog->save()){
			return print_r($modelLog->getErrors());
		}
	}


}
