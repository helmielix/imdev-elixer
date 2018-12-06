<?php

namespace ca\controllers;

use Yii;
use app\models\ViewReportBasurveyRegion;
use app\models\searchViewReportBasurveyRegion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ViewReportBasurveyRegionController implements the CRUD actions for ViewReportBasurveyRegion model.
 */
class ViewReportBasurveyRegionController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all ViewReportBasurveyRegion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new searchViewReportBasurveyRegion();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ViewReportBasurveyRegion model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ViewReportBasurveyRegion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ViewReportBasurveyRegion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    
			 $value = Yii::$app->mailer->compose()
	                -> setFrom (['dyah@elixer.co.id' => 'F Dyah K'])
	                -> setTo(['fdyahk@yahoo.com'])
	                -> setSubject ( 'Alert Verify Report BA Survey Region' )
	                -> setHtmlBody( 'This document is waiting your approval. Please click this link document :'.Yii::getAlias('@web').'/reportbasurveyregion/indexverify')
	                -> send();
		
            return $this->redirect(['view', 'id' => $model->region]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ViewReportBasurveyRegion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->region]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ViewReportBasurveyRegion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ViewReportBasurveyRegion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ViewReportBasurveyRegion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ViewReportBasurveyRegion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
