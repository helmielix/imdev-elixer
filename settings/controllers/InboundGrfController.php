<?php

namespace divisisatu\controllers;

use Yii;
use common\models\Grf;
use common\models\InboundGrf;
use common\models\SearchInboundGrf;
use common\models\SearchGrf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InboundGrfController implements the CRUD actions for InboundGrf model.
 */
class InboundGrfController extends Controller
{
    /**
     * @inheritdoc
     */
    private $id_modul = 1;
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
     * Lists all InboundGrf models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexapprove(){
        $searchModel = new SearchInboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single InboundGrf model.
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
     * Creates a new InboundGrf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $act = null)
    {
        $this->layout = 'blank';
        $modelGrf = Grf::findOne($id);
        $model = new InboundGrf();
       if ($model->load(Yii::$app->session->get('idInboundGrf')) {
        $model->id = $modelGrf->id;
        $model->status_listing = 43;
        $model->id_modul = $this->id_modul;
        $model->grf_number = $modelGrf->grf_number;
        $model->wo_number = $modelGrf->wo_number;
        $model->grf_type = $modelGrf->grf_type;
        $model->requestor = $modelGrf->requestor;
        $model->division = $modelGrf->division;
        $model->id_region = $modelGrf->id_region;
        $model->pic = $modelGrf->pic;
        $model->purpose = $modelGrf->purpose;
        $model->file1 = $modelGrf->file1;
        $model->file2 = $modelGrf->file2;

        Yii::$app->session->set('idInboundGrf',$model->id);
        // $model = $this->findModel($id);

        if($model->save()){
				
				// $this->createLog($model);
				return 'success';
			}
		}else{
				return $this->render('create', [
                'model' => $model,
            	]);
        	}

    }

    /**
     * Updates an existing InboundGrf model.
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
     * Deletes an existing InboundGrf model.
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
     * Finds the InboundGrf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InboundGrf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InboundGrf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
