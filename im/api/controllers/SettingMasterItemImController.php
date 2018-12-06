<?php

namespace setting\controllers;

use Yii;
use setting\models\InboundPo;
use setting\models\SearchInboundPo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\OrafinRr;
use common\models\SearchOrafinRr;
use common\models\OrafinViewMkmPrToPay;

use setting\models\InboundPoDetail;

/**
 * InboundPoController implements the CRUD actions for InboundPo model.
 */
class SettingMasterItemImController extends Controller
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
     * Lists all InboundPo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexdetailsn()
    {
        $searchModel = new SearchInboundPo();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InboundPo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InboundPo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idOrafinRr = NULL)
    {
        $model = new InboundPo();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
			$searchModel = new SearchOrafinRr();
			$dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,$idOrafinRr);
			
			$modelOrafin = OrafinRr::find()->where(['=','id',$idOrafinRr])->one();
			
            return $this->render('create', [
                'model' => $model,
				'modelOrafin' => $modelOrafin,
				'dataProvider' => $dataProvider
            ]);
        }
    }
	
	public function actionCreatedetail($rrNumber ,$orafinCode )
    {
        $model = new InboundPoDetail();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
			// $searchModel = new SearchOrafinRr();
			// $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,$idOrafinRr);
			
			// $modelOrafin = OrafinRr::find()->where(['=','id',$idOrafinRr])->one();
			
            return $this->render('createdetail', [
                'model' => $model,
				// 'modelOrafin' => $modelOrafin,
				// 'dataProvider' => $dataProvider
            ]);
        }
    }

    /**
     * Updates an existing InboundPo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InboundPo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InboundPo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InboundPo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InboundPo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
