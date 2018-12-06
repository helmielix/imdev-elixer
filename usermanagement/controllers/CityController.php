<?php

namespace usermanagement\controllers;

use Yii;
use app\models\City;
use usermanagement\models\SearchCity;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CityController extends Controller
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
        $searchModel = new SearchCity();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	// Page Create. Redirect ke Page Index jika berhasil save.
    public function actionCreate()
    {
        $model = new City();

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()) {
			
			     $value = Yii::$app->mailer->compose()
	                -> setFrom (['dyah@elixer.co.id' => 'F Dyah K'])
	                -> setTo(['fdyahk@yahoo.com'])
	                -> setSubject ( 'Alert Verify City' )
	                -> setHtmlBody( 'This document is waiting your approval. Please click this link document :'.Yii::getAlias('@web').'/city/indexverify')
	                -> send();
			
				return $this->redirect(['index']);
			} 
		};
		return $this->render('create', [
			'model' => $model,
		]);
    }

    // Page Update. Redirect ke Page Index jika berhasil save.
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    
    // Action Delete. Redirect ke Page Index jika berhasil delete.
    public function actionDelete($id)
    {
		
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
		
    }

    
    // Function untuk find City berdasarkan id
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
