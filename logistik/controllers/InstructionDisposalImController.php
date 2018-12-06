<?php

namespace logistik\controllers;

use Yii;
use common\models\InstructionDisposalIm;
use common\models\searchInstructionDisposalIm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\InstructionDisposal;
use common\models\SearchInstructionDisposalDetail;
use common\widgets\Displayerror;

/**
 * InstructionDisposalImController implements the CRUD actions for InstructionDisposalIm model.
 */
class InstructionDisposalImController extends Controller
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
     * Lists all InstructionDisposalIm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new searchInstructionDisposalIm();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OutboundWhTransfer model.
     * @param integer $id
     * @return mixed
     */

    public function actionViewdisposal($id){
        $this->layout = 'blank';
        $model = InstructionDisposal::findOne($id);
        
        $searchModel = new SearchInstructionDisposalDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
        
        return $this->render('//instruction-disposal/view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $this->layout = 'blank';
        
        $model = $this->findModel($id);
        
        $searchModel = new SearchInstructionDisposalDetailIm();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
        
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    /**
     * Creates a new InstructionDisposalIm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id , $act = null)
    {
    $this->layout = 'blank';
        if ($act == 'view'){
            // create OutboundWhTransfer
            $modelDisposal = InstructionDisposal::findOne($id);
            $model = new InstructionDisposalIm();
            
            $model->id_disposal_am = $modelDisposal->id;
            $model->status_listing = 43; // Partially Uploaded
            $model->id_modul = $this->id_modul;
            $model->save();
            
            $modelDisposalDetail = InstructionDisposalDetail::find()->andWhere(['id_disposal_am' => $id])->all();
            
        }
        
        $model = $this->findModel($id);
        
        $searchModel = new SearchInstructionDisposalDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
             

        // if ($model->load(Yii::$app->request->post())) {
            
     

            if (!$model->save()){
                return Displayerror::pesan($model->getErrors());
            }
              Yii::$app->session->set('idInstWhTr', $model->id);
            // return $this->redirect(['view', 'id' => $model->id_instruction_wh]);
        // } else {
            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        // }
    }

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
     * Deletes an existing InstructionDisposalIm model.
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
     * Finds the InstructionDisposalIm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionDisposalIm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstructionDisposal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
