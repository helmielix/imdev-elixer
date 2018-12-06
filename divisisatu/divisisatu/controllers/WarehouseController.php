<?php

namespace divisisatu\controllers;

use Yii;
use common\models\Warehouse;
use common\models\UserWarehouse;
use common\models\SearchWarehouse;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.
 */
class WarehouseController extends Controller
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
     * Lists all Warehouse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchWarehouse();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Warehouse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$searchModel = new SearchWarehouse();
		$dataProvider = $searchModel->searchByUserwarehouse(Yii::$app->request->queryParams, $id);
		
        return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Warehouse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUserwarehouse($idwarehouse){
		$model = new UserWarehouse();
		
		if (Yii::$app->request->isPost) {
			$iduser = Yii::$app->request->post('UserWarehouse')['id_user'];
			$idwarehouse = Yii::$app->request->post('UserWarehouse')['id_warehouse'];
			UserWarehouse::deleteAll('id_warehouse = '.$idwarehouse);
			//InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.Yii::$app->session->get('idInboundWhDetail'));
			foreach($iduser as $id_user){
				$model = new UserWarehouse();
				$model->id_user = $id_user;
				$model->id_warehouse = $idwarehouse;
				if (!$model->save()){
					return var_dump($model->getErrors());
				}
			}
			
			// return var_dump(Yii::$app->request->post('UserWarehouse'));
			// $model->save();
			// if (!$model->save()){
				// return var_dump($model->getErrors());
			// }
            return $this->redirect(['view', 'id' => $model->id_warehouse]);
        } else {
			$model->id_warehouse = $idwarehouse;
			$userwarehouse = UserWarehouse::find()->andWhere(['id_warehouse' => $idwarehouse])->all();
			// return var_dump(ArrayHelper::map($userwarehouse, 'id_user', 'id_user'));
			$model->id_user = ArrayHelper::map($userwarehouse, 'id_user', 'id_user');
			
            return $this->render('createuser', [
                'model' => $model,
            ]);
        }
	}

    /**
     * Updates an existing Warehouse model.
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
     * Deletes an existing Warehouse model.
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
     * Finds the Warehouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Warehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Warehouse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
