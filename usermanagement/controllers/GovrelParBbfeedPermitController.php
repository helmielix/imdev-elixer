<?php

namespace usermanagement\controllers;

use Yii;
use app\models\GovrelParBbfeedPermit;
use usermanagement\models\SearchGovrelParBbfeedPermit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Email;
use yii\helpers\Url;

/**
 * GovrelParBbfeedPermitController implements the CRUD actions for GovrelParBbfeedPermit model.
 */
class GovrelParBbfeedPermitController extends Controller
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
     * Lists all GovrelParBbfeedPermit models.
     * @return mixed
     */
    public function actionIndex()
    {
        
		 $this->layout = 'map';


        $searchModel = new SearchGovrelParBbfeedPermit();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	 public function actionIndexverify()
    {

        $this->layout = 'map';


        $searchModel = new SearchGovrelParBbfeedPermit();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'verify');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexapprove()
    {

         $this->layout = 'map';



        $searchModel = new SearchGovrelParBbfeedPermit();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexoverview()
    {

         $this->layout = 'map';



        $searchModel = new SearchGovrelParBbfeedPermit();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'overview');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GovrelParBbfeedPermit model.
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
     * Creates a new GovrelParBbfeedPermit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
	
	
    {
	
	    $this->layout = 'blank';
	
        $model = new GovrelParBbfeedPermit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			$model->status_listing = 1;
			
			if($model->save()) {
			
			
			        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			
			         $arrAuth = ['/govrel-par-bbfeed-permit/indexverify'];
	                $header = 'Alert Verify Parameter Backbone Feeder Permit ';
	                $subject = 'This document is waiting your verify. Please click this link document :'.Url::base(true).'/govrel-par-bbfeed-permit/indexverify#viewverify?id='.$model->id.'&header=Detail Parameter Backbone Feeder Permit';
	                Email::sendEmail($arrAuth, $header, $subject);

					return 'success';

                   
			 } else {
			   
			     print_r($model->getErrors());
                 return $this->renderAjax('create', [
                'model' => $model,
				
					
            ]);
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
		   
		   
		            $arrAuth = ['/govrel-par-bbfeed-permit/indexapprove'];
	                $header = 'Alert Approval Parameter PIC Backbone Feeder Permit ';
	                $subject = 'This document is waiting your approval. Please click this link document :'.Url::base(true).'/govrel-par-bbfeed-permit/indexapprove#viewapprove?id='.$model->id.'&header=Detail Parameter PIC Backbone Feeder Permit';
	                Email::sendEmail($arrAuth, $header, $subject);
	   
			return 'success';

        } else {
			print_r($model->getErrors());
			echo "error";
		}	

        }else {return 'failed';}
       
    }
	
	public function actionApprove($id)
	
    {

        $this->layout = 'blank';

	    $model = $this->findModel($id);
		if($model->status_listing == 1){
        $model->status_listing = 5;	
		if($model->save()) {
		
		            $arrAuth = ['/govrel-par-bbfeed-permit/indexoverview'];
	                $header = 'Alert Approval Parameter PIC Backbone Feeder Permit ';
	                $subject = 'This document has been approved. Please click this link document :'.Url::base(true).'/govrel-par-bbfeed-permit/indexoverview#viewoverview?id='.$model->id.'&header=Detail Parameter PIC Backbone Feeder Permit';
	                Email::sendEmail($arrAuth, $header, $subject);
	   
		
		
			return 'success';

        } else {
			
			print_r($model->getErrors());
			echo "error";
		}		

         }else {return 'failed';}
	
    }
	
	
	public function actionRevise($id)
	
    {

       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		
		if($model->status_listing == 1 ||  $model->status_listing == 2 || $model->status_listing == 4 ){
		
		if($model != null) {
			if(isset($_POST['GovrelParBbfeedPermit']['revision_remark'])) {
				$model->status_listing = 3;
				$model->revision_remark = $_POST['GovrelParBbfeedPermit']['revision_remark'];
				if($model->save()) {
				
				    $arrAuth = ['/govrel-par-bbfeed-permit/index'];
	                $header = 'Alert Revise Parameter PIC Backbone Feeder Permit ';
	                $subject = 'This document is waiting your revise. Please click this link document :'.Url::base(true).'/govrel-par-bbfeed-permit/index#update?id='.$model->id.'&header=Detail Parameter PIC Backbone Feeder Permit';
	                Email::sendEmail($arrAuth, $header, $subject);
				
				
				
					return 'success';
				} else {
					return 'error with messages: '.print_r($model->getErrors());
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
		
		if($model->status_listing == 1 ||  $model->status_listing == 2 || $model->status_listing == 4 ){
		
		if($model != null) {
			if(isset($_POST['GovrelParBbfeedPermit.']['revision_remark'])) {
				$model->status_listing = 6;
				$model->revision_remark = $_POST['GovrelParBbfeedPermit.']['revision_remark'];
				if($model->save()) {
				
				   $arrAuth = ['/govrel-par-bbfeed-permit/indexoverview'];
	                $header = 'Alert Reject Parameter PIC Backbone Feeder Permit ';
	                $subject = 'This document has been reject. Please click this link document :'.Url::base(true).'/govrel-par-bbfeed-permit/indexoverview#viewoverview?id='.$model->id.'&header=Detail Parameter PIC Backbone Feeder Permit';
	                Email::sendEmail($arrAuth, $header, $subject);
				
				
					return 'success';
				} else {
					return 'error with messages: '.print_r($model->getErrors());
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
     * Updates an existing GovrelParBbfeedPermit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	
	   $this->layout = 'blank';

        $model = $this->findModel($id);
		
		if($model->status_listing == 1 ||  $model->status_listing == 2 || $model->status_listing == 3 ){
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
             if ($model->status_listing == 3)
			  {
			  
			     $model->status_listing = 2;
			  }
			  
			  
            if($model->save()) {
			
			        $arrAuth = ['/govrel-par-bbfeed-permit/indexverify'];
	                $header = 'Alert Verify Parameter PIC Backbone Feeder Permit ';
	                $subject = 'This document is waiting your verify. Please click this link document :'.Url::base(true).'/govrel-par-bbfeed-permit/indexverify#viewverify?id='.$model->id.'&header=Detail Parameter PIC Backbone Feeder Permit';
	                Email::sendEmail($arrAuth, $header, $subject);
			
			        return 'success';

                   
			 } else {
			   
			     print_r($model->getErrors());
                 return $this->renderAjax('update', [
                'model' => $model,
				
					
            ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
		
		}else {return 'failed';}
    }

    /**
     * Deletes an existing GovrelParBbfeedPermit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$model=$this->findModel($id);
		
		if($model->status_listing == 6 || $model->status_listing == 1  || $model->status_listing == 5){
		
		
        $this->findModel($id)->delete();

        return 'success';
		
		}else {return 'failed';}
    }

    /**
     * Finds the GovrelParBbfeedPermit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GovrelParBbfeedPermit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GovrelParBbfeedPermit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
