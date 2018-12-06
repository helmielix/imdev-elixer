<?php

namespace usermanagement\controllers;

use Yii;
use app\models\GovrelParameterPicProblem;
use usermanagement\models\SearchGovrelParameterPicProblem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Email;
use common\widgets\Displayerror;
use yii\helpers\Url;

/**
 * GovrelParameterPicProblemController implements the CRUD actions for GovrelParameterPicProblem model.
 */
class GovrelParameterPicProblemController extends Controller
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
					 'verify' => ['POST'],
					 'approve' => ['POST'],
					 'reject' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all GovrelParameterPicProblem models.
     * @return mixed
     */
    public function actionIndex()
    {

		 $this->layout = 'map';


        $searchModel = new SearchGovrelParameterPicProblem();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexVerify()
    {

        $this->layout = 'map';


        $searchModel = new SearchGovrelParameterPicProblem();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove()
    {

         $this->layout = 'map';



        $searchModel = new SearchGovrelParameterPicProblem();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexoverview()
    {

         $this->layout = 'map';



        $searchModel = new SearchGovrelParameterPicProblem();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'overview');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GovrelParameterPicProblem model.
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

	public function actionViewverify($id)

    {

          $this->layout = 'blank';

	     return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);


    }


	public function actionViewapprove($id)

    {

        $this->layout = 'blank';

	    return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);


    }

    /**
     * Creates a new GovrelParameterPicProblem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'blank';

        $model = new GovrelParameterPicProblem();

        if ($model->load(Yii::$app->request->post())) {

        	$model->status_listing = 1;
		 
			if($model->save()) {

			        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			        $arrAuth = ['/govrel-parameter-pic-problem/indexverify'];
	                $header = 'Alert Verify Parameter PIC Problem ';
	                $subject = 'This document is waiting your verify. Please click this link document :'.Url::base(true).'/govrel-parameter-pic-problem/indexverify#viewverify?id='.$model->id.'&header=Detail Parameter PIC Problem';
	                Email::sendEmail($arrAuth, $header, $subject);


					return 'success';


			 } else {

			     return Displayerror::pesan($model->getErrors());

            }



        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

	public function actionVerify($id)

    {

	   $this->layout = 'blank';

		$model = $this->findModel($id);
		
		if($model->status_listing == 2 || $model->status_listing == 1 ){
		
        $model->status_listing = 4;
		
		if($model->save()) {

	                $arrAuth = ['/govrel-parameter-pic-problem/indexapprove'];
	                $header = 'Alert Approval Parameter PIC Problem ';
	                $subject = 'This document is waiting your approval. Please click this link document :'.Url::base(true).'/govrel-parameter-pic-problem/indexapprove#viewapprove?id='.$model->id.'&header=Detail Parameter PIC Problem';
	                Email::sendEmail($arrAuth, $header, $subject);


			return 'success';

        } else {
			return Displayerror::pesan($model->getErrors());
		}
		
		}else {return 'failed';}

    }

	public function actionApprove($id)

    {

        $this->layout = 'blank';

	    $model = $this->findModel($id);
		
		if($model->status_listing == 1 ){
		
        $model->status_listing = 5;
    


		if($model->save()) {

		            $arrAuth = ['/govrel-parameter-pic-problem/indexoverview'];
	                $header = 'Alert Approval Parameter PIC Problem ';
	                $subject = 'This document has been approval. Please click this link document :'.Url::base(true).'/govrel-parameter-pic-problem/indexoverview#viewoverview?id='.$model->id.'&header=Detail Parameter PIC Problem';
	                Email::sendEmail($arrAuth, $header, $subject);



			return 'success';

        } else {

			return Displayerror::pesan($model->getErrors());
		}
		
		}else {return 'failed';}

    }


	public function actionRevise($id)

    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		
		if($model->status_listing == 4  || $model->status_listing == 2 || $model->status_listing == 1){
	

		if($model != null) {
			if(isset($_POST['GovrelParamaterPicProblem']['revision_remark'])) {
				$model->status_listing = 3;
				$model->revision_remark = $_POST['GovrelParamaterPicProblem']['revision_remark'];
				if($model->save()) {

				    $arrAuth = ['/govrel-parameter-pic-problem/index'];
	                $header = 'Alert Revise Parameter PIC Problem ';
	                $subject = 'This document is waiting your revise. Please click this link document :'.Url::base(true).'/govrel-parameter-pic-problem/index#view?id='.$model->id.'&header=Detail Parameter PIC Problem';
	                Email::sendEmail($arrAuth, $header, $subject);



					return 'success';
				} else {
					return Displayerror::pesan($model->getErrors());
				}
			} else {
				return 'Please insert Revision/Rejection Remark';
			}
		} else {
			return 'data not found';
		}
		
		
		}else {return 'failed';}

    }




   public function actionReject($id)

    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		
		if($model->status_listing == 4  || $model->status_listing == 2 || $model->status_listing == 1){
	
		
		if($model != null) {
			if(isset($_POST['GovrelParamaterPicProblem']['revision_remark'])) {
				$model->status_listing = 6;
				$model->revision_remark = $_POST['GovrelParamaterPicProblem']['revision_remark'];
				if($model->save()) {

				    $arrAuth = ['/govrel-parameter-pic-problem/indexoverview'];
	                $header = 'Alert Reject Parameter PIC Problem ';
	                $subject = 'This document has been reject. Please click this link document :'.Url::base(true).'/govrel-parameter-pic-problem/indexoverview#viewoverview?id='.$model->id.'&header=Detail Parameter PIC Problem';
	                Email::sendEmail($arrAuth, $header, $subject);


					return 'success';
				} else {
					return Displayerror::pesan($model->getErrors());
				}
			} else {
				return 'Please insert Revision/Rejection Remark';
			}
		} else {
			return 'data not found';
		}
		
		}else {return 'failed';}

    }


    /**
     * Updates an existing GovrelParameterPicProblem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $this->layout = 'blank';

        $model = $this->findModel($id);
		
		if($model->status_listing == 3  || $model->status_listing == 2 || $model->status_listing == 1){
	
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

             if ($model->status_listing == 3)
			  {

			     $model->status_listing = 2;
			  }


            if($model->save()) {


			        $arrAuth = ['/govrel-parameter-pic-problem/indexverify'];
	                $header = 'Alert Verify Parameter PIC Problem ';
	                $subject = 'This document is waiting your verify. Please click this link document :'.Url::base(true).'/govrel-parameter-pic-problem/indexverify#viewverify?id='.$model->id.'&header=Detail Parameter PIC Problem';
	                Email::sendEmail($arrAuth, $header, $subject);

			        return 'success';


			 } else {

			     return Displayerror::pesan($model->getErrors());

            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
		
		}else {return 'failed';}
    }

    /**
     * Deletes an existing GovrelParameterPicProblem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
		$model=$this->findModel($id);
		
		if($model->status_listing == 6 || $model->status_listing == 1 || $model->status_listing == 5 ){
		
		
        $this->findModel($id)->delete();

        return 'success';
		
		}else {return 'failed';}
    }

    /**
     * Finds the GovrelParameterPicProblem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GovrelParameterPicProblem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GovrelParameterPicProblem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
