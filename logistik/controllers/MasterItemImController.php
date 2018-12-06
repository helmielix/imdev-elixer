<?php

namespace logistik\controllers;

use Yii;
use common\models\MasterItemIm;
use common\models\MasterItemImDetail;
use common\models\SearchMasterItemIm;
use setting\models\MkmMasterItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Displayerror;

/**
 * MasterItemImController implements the CRUD actions for MasterItemIm model.
 */
class MasterItemImController extends Controller
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
     * Lists all MasterItemIm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexitemwarehouse()
    {
        $searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByItemDetail(Yii::$app->request->queryParams);

        return $this->render('indexitemwarehouse', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterItemIm model.
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
     * Creates a new MasterItemIm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterItemIm();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 27;
            $model->im_code =  $model->orafin_code.'.'.sprintf("%03d", $model->referenceGrouping->id_grouping).'.'.sprintf("%03d", $model->referenceBrand->id_grouping).'.'.sprintf("%03d", $model->referenceWarna->id_grouping).'.'.sprintf("%03d", $model->referenceType->id_grouping);
			
			$mkmmasteritem = MkmMasterItem::find()->andWhere(['item_code' => $model->name])->one();
			$model->name = $mkmmasteritem->item_desc;
			
			$modelcek = MasterItemIm::find()->andWhere(['like', 'im_code', $model->im_code]);
			if ( $modelcek->exists() ){
				$modelcek = $modelcek->orderBy('id desc')->one();
				$oldidim = explode('.',$modelcek->im_code);
				$newidim = $oldidim[5] + 1;
				
				$model->im_code = $model->im_code.'.'.sprintf("%04d", $newidim);
			}else{
				$model->im_code = $model->im_code.'.'.sprintf("%04d", 1);
			}
			// return var_dump($model);
			// return var_dump(Yii::$app->request->post());
			
			if(!$model->save()) {
                return Displayerror::pesan($model->getErrors());
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreatestock()
    {
        $model = new MasterItemImDetail();

        if ($model->load(Yii::$app->request->post())) {
            // $model->status = 27;
            // $model->im_code =  $model->orafin_code.'.'.sprintf("%03d", $model->grouping).'.'.sprintf("%03d", $model->brand).'.'.sprintf("%03d", $model->warna).'.'.sprintf("%03d", $model->type);
            
            // $mkmmasteritem = MkmMasterItem::find()->andWhere(['item_code' => $model->name])->one();
            // $model->name = $mkmmasteritem->item_desc;
            
            // $modelcek = MasterItemIm::find()->andWhere(['like', 'im_code', $model->im_code]);
                // if ( $modelcek->exists() ){
                //     $modelcek = $modelcek->orderBy('id desc')->one();
                //     $oldidim = explode('.',$modelcek->im_code);
                //     $newidim = $oldidim[5] + 1;
                    
                //     $model->im_code = $model->im_code.'.'.sprintf("%04d", $newidim);
                // }else{
                //     $model->im_code = $model->im_code.'.'.sprintf("%04d", 1);
                // }
            // return var_dump($model);
            // return var_dump(Yii::$app->request->post());
            
            if(!$model->save()) {
                return Displayerror::pesan($model->getErrors());
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('createstock', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterItemIm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->im_code =  $model->orafin_code.'.'.sprintf("%03d", $model->grouping).'.'.sprintf("%03d", $model->brand).'.'.sprintf("%03d", $model->warna).'.'.sprintf("%03d", $model->type);
			
			$mkmmasteritem = MkmMasterItem::find()->andWhere(['item_code' => $model->name])->one();
			$model->name = $mkmmasteritem->item_desc;
			
			$modelcek = MasterItemIm::find()->andWhere(['like', 'im_code', $model->im_code]);
			if ( $modelcek->exists() ){
				$modelcek = $modelcek->orderBy('id desc')->one();
				$oldidim = explode('.',$modelcek->im_code);
				$newidim = $oldidim[5] + 1;
				
				$model->im_code = $model->im_code.'.'.sprintf("%04d", $newidim);
			}else{
				$model->im_code = $model->im_code.'.'.sprintf("%04d", 1);
			}
			
			if(!$model->save()) {
                return Displayerror::pesan($model->getErrors());
            }
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
			$mkmmasteritem = MkmMasterItem::find()->andWhere(['item_code' => $model->orafin_code])->one();
			$model->name = $mkmmasteritem->item_code;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MasterItemIm model.
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
     * Finds the MasterItemIm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterItemIm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterItemIm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
