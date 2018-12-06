<?php

namespace usermanagement\controllers;

use Yii;
use app\models\Region;
use usermanagement\models\SearchRegion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class RegionController extends Controller
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
        $searchModel = new SearchRegion();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	// Page Create. Redirect ke Page Index jika berhasil save.
    public function actionCreate()
    {
        $model = new Region();

        if ($model->load(Yii::$app->request->post()) ) {
			if(Region::find()->where(['ilike','name',$model->name])->exists()){
				Yii::$app->session->setFlash('failed', "Region has been inputted");
				return $this->redirect(['index']);
			}
			$model->status = 27;
            if($model->save()){
                $value = Yii::$app->mailer->compose()
	                -> setFrom (['dyah@elixer.co.id' => 'F Dyah K'])
	                -> setTo(['fdyahk@yahoo.com'])
	                -> setSubject ( 'Alert Verify Region' )
	                -> setHtmlBody( 'This document is waiting your approval. Please click this link document :'.Yii::getAlias('@web').'/region/indexverify')
	                -> send();
                return $this->redirect(['index']);
            } else {
                return print_r($model->getErrors());
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
        //$this->findModel($id)->delete();
		
		$model = $this->findModel($id);
		$model->status = 18;
		$model->save();

        return $this->redirect(['index']);
    }

    // Function untuk find Region berdasarkan id
    protected function findModel($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function createLog($model)
	{
		$modelLog = new LogRegion();
		$modelLog->setAttributes($model->attributes);
		$modelLog->save();
	}
}
