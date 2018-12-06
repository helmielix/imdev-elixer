<?php

namespace ca\controllers;

use Yii;
use app\models\Homepass;
use ca\models\SearchHomepass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HomepassController implements the CRUD actions for Homepass model.
 */
class HomepassController extends Controller
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
     * Lists all Homepass models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'map';
		if(\Yii::$app->session->get('homepass-setting') == null ) 
			\Yii::$app->session->set('homepass-setting',['id','status','streetname','postal_code','home_number','status_ca','status_govrel','status_iko']);
        $searchModel = new SearchHomepass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionSetting()
    {
		$this->layout = 'blank';		
		
        return $this->render('setting');
    }
	
	public function actionSubmitsetting() {
		\Yii::$app->session->set('homepass-setting', $_POST['setting']);
		$this->layout = 'map';
		
        $searchModel = new SearchHomepass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        return $this->redirect('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
	}

    /**
     * Displays a single Homepass model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$this->layout = 'blank';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Homepass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Homepass();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Homepass model.
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
     * Deletes an existing Homepass model.
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
     * Finds the Homepass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Homepass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Homepass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
