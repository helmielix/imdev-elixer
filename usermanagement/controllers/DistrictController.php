<?php

namespace usermanagement\controllers;

use Yii;
use app\models\District;
use app\models\City;
use app\models\Region;
use usermanagement\models\SearchDistrict;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class DistrictController extends Controller
{
	// Inherit dari behaviors class controller. Mengatur action mana yang harus dengan method POST
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

	// Page Index. Menampilkan keseluruhan data dengan searchFilter Parameters.
    public function actionIndex()
    {
        $searchModel = new SearchDistrict();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Create. Redirect ke Page Index jika berhasil save.
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	// Page Update. Redirect ke Page Index jika berhasil save.
    public function actionCreate()
    {
        $model = new District();
		$modelRegion = new Region();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
		     $value = Yii::$app->mailer->compose()
	                -> setFrom (['dyah@elixer.co.id' => 'F Dyah K'])
	                -> setTo(['fdyahk@yahoo.com'])
	                -> setSubject ( 'Alert Verify District' )
	                -> setHtmlBody( 'This document is waiting your approval. Please click this link document :'.Yii::getAlias('@web').'/district/indexverify')
	                -> send();
		
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
				'modelRegion' => $modelRegion,
            ]);
        }
    }

	// Page Update. Redirect ke Page Index jika berhasil save.
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelRegion = $model->idCity->idRegion;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'modelRegion' => $modelRegion,
            ]);
        }
    }

    // Action Delete. Redirect ke Page Index jika berhasil delete.
    public function actionDelete($id)
    {
	
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    // Function untuk find District berdasarkan id
    protected function findModel($id)
    {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	// Action Mengambil List City berdasarkan dedrop Region
	public function actionGetcity() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
				$out = City::find($cat_id)->where(['id_region' => $cat_id])->select('id,name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
}
