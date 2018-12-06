<?php

namespace divisisatu\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use common\widgets\Displayerror;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use common\widgets\Numbertoroman;
use divisisatu\models\StockOpnameInternalAdjust;
use divisisatu\models\MasterItemIm;
use divisisatu\models\MasterItemImSearch;
use divisisatu\models\StockOpnameInternal;
use divisisatu\models\StockOpnameInternalSearch;



/**
 * StockOpnameInternalController implements the CRUD actions for StockOpnameInternal model.
 */
class StockOpnameInternalController extends Controller
{
    private $id_modul = 1;
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
     * Lists all StockOpnameInternal models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new StockOpnameInternalSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     // $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, $action);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    private function listIndex($action)
    {
        $searchModel = new StockOpnameInternalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, $action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

	public function actionIndex()
    {
        return $this->render('index', $this->listIndex('input'));
    }
    

    /**
     * Displays a single StockOpnameInternal model.
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
     * Creates a new StockOpnameInternal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'blank';
        $model = new StockOpnameInternal();
        $model->id_modul = $this->id_modul;

        $masterItemIm = MasterItemIm::find()->all();

        $searchModel = new MasterItemImSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $newidinst = StockOpnameInternal::find()->andWhere(['and',['like', 'stock_opname_number', '%/'.substr('0'.date('m'), -2).substr(date('Y'), -2), false],['id_modul' => $model->id_modul]])->count() + 1;

		$model->stock_opname_number = sprintf("%04d", $newidinst).'/SO/Div1/'.substr('0'.date('m'), -2).substr(date('Y'), -2);
        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = 5;
            $model->updated_by = 5;
            $model->status_listing = 34;
            $model->id_warehouse = $_POST['StockOpnameInternal']['id_warehouse'];
            $model->created_date = new \yii\db\Expression('NOW()');
            // echo $model->time_cut_off_data;

            if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}

			Yii::$app->session->set('idStockOpname', $model->stock_opname_number);


            forEach ($masterItemIm as $im) {
                $junction = new StockOpnameInternalAdjust();
                $junction->stock_opname_number = $model->stock_opname_number;
                $junction->im_code = $im->im_code;
                $junction->s_good = $im->s_good;
                $junction->s_not_good = $im->s_not_good;
                $junction->s_reject = $im->s_reject;
                $junction->s_dismantle_good = $im->s_dismantle_good;
                $junction->s_dismantle_not_good = $im->s_dismantle_not_good;
                $junction->s_good_recondition = $im->s_good_recondition;
                $junction->save(false);
            }
            //$model->linkAll('im_code', $masterItemIm, [], true, true);
            return 'success';
        } else {
            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }


    /**
     * Updates an existing StockOpnameInternal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'blank';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StockOpnameInternal model.
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
     * Finds the StockOpnameInternal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockOpnameInternal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockOpnameInternal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDetail($id)
    {
        // $this->layout = 'blank';
        $searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('detail', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddPic($id)
    {
        $this->layout = 'blank';
        $stockOpnameDetail = StockOpnameInternalAdjust::findAll(['stock_opname_number' => $id]);

        $data = array();
        forEach ($stockOpnameDetail as $row) {
            $itemDetails = MasterItemIm::find()
                ->where(['im_code' => $row->im_code])
                ->one();

            array_push($data, [
                'orafin_code' => $itemDetails->orafin_code,
                'im_code' => $row->im_code,
                'name' => $itemDetails->name,
                'brand' => $itemDetails->brand,
                'grouping' => $itemDetails->grouping,
                'sn_type' => $itemDetails->sn_type,
                'type' => $itemDetails->type,
                's_good' => $row->s_good,
                's_not_good' => $row->s_not_good,
                's_reject' => $row->s_reject,
                's_dismantle_good' => $row->s_dismantle_good,
                's_dismantle_not_good' => $row->s_dismantle_not_good,
                's_good_recondition' => $row->s_good_recondition,
                'f_good' => $row->f_good,
                'f_not_good' => $row->f_not_good,
                'f_reject' => $row->f_reject,
                'f_dismantle_good' => $row->f_dismantle_good,
                'f_dismantle_not_good' => $row->f_dismantle_not_good,
                'f_good_recondition' => $row->f_good_recondition,
                'adj_good' => $row->adj_good,
                'adj_not_good' => $row->adj_not_good,
                'adj_reject' => $row->adj_reject,
                'adj_dismantle_good' => $row->adj_dismantle_good,
                'adj_dismantle_not_good' => $row->adj_dismantle_not_good,
                'adj_good_recondition' => $row->adj_good_recondition,
                'remark' => $row->remark,
                'file' => $row->file,
            ]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['stock_opname_number'],
            ],
        ]);

        return $this->render('_form-view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportExcel() {
        $this->layout = 'blank';
        return $this->render('export-excel');
    }

    public function actionExportExcelIntransit() {
        $this->layout = 'blank';
        return $this->render('export-excel-intransit');
    }



}
