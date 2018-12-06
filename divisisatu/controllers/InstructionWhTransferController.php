<?php

namespace divisisatu\controllers;

use Yii;
use common\models\InstructionWhTransfer;
use common\models\InstructionWhTransferDetail;
use common\models\MasterItemIm;
use common\models\SearchInstructionWhTransfer;
use common\models\SearchInstructionWhTransferDetail;
use common\models\SearchMasterItemIm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\widgets\Displayerror;
use common\widgets\Numbertoroman;
use common\widgets\Email;

/**
 * InstructionWhTransferController implements the CRUD actions for InstructionWhTransfer model.
 */
class InstructionWhTransferController extends Controller
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
     * Lists all InstructionWhTransfer models.
     * @return mixed
     */
    private function listIndex($action)
    {
        $searchModel = new SearchInstructionWhTransfer();
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
	
	public function actionIndexapprove()
    {
        return $this->render('index', $this->listIndex('approve'));
    }
	
	public function actionIndexdetail(){
		$this->layout = 'blank';
		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idInstWhTr'));

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Displays a single InstructionWhTransfer model.
     * @param integer $id
     * @return mixed
     */
    private function detailView($id)
    {		
		$model = $this->findModel($id);
		
		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		Yii::$app->session->set('idInstWhTr', $model->id);
		
        return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }
	
	public function actionView($id){
		// echo basename(Yii::$app->request->referrer);
		
		// $basename = explode('?', basename(Yii::$app->request->referrer));
		// if ($basename[0] == 'view'){
			// return $this->redirect(['index']);
			// // throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		// }
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
	}
	
	public function actionViewapprove($id){
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
	}

    /**
     * Creates a new InstructionWhTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->layout = 'blank';
        $model = new InstructionWhTransfer();
		$model->scenario = 'create';
		$model->id_modul = $this->id_modul;
		$newidinst = InstructionWhTransfer::find()->andWhere(['and',['like', 'instruction_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
		$newidinstexist = InstructionWhTransfer::find()->andWhere(['and',['instruction_number' => $newidinst],['id_modul' => $model->id_modul]])->exists();
		$newidinst++;
		
		$monthroman = Numbertoroman::convert(date('n'));
		
		$model->instruction_number = sprintf("%04d", $newidinst).'/INST-IC1/WT/'.$monthroman.date('/Y');

        if ($model->load(Yii::$app->request->post())) {
			
			
			$model->status_listing = 7;
			
			if (isset($_FILES['file'])) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$model->file = $_FILES['file'];
						$filename = $_FILES['file']['name'];
						$filepath = 'uploads/INST/DIVSATU/';
					}
				}
			}
			
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			$model->file_attachment = $filepath.$model->id.'/'.$filename;
			$model->save();
			
			Yii::$app->session->set('idInstWhTr', $model->id);
			
			if (!file_exists($filepath.$model->id.'/')) {
				mkdir($filepath.$model->id.'/', 0777, true);
			}
			move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
			
            return 'success';
        } else {
			Yii::$app->session->remove('idInstWhTr');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InstructionWhTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$this->layout = 'blank';
        $model = $this->findModel($id);

		Yii::$app->session->set('idInstWhTr', $model->id);
        if ($model->load(Yii::$app->request->post())) {
			
			$filename = '';
			if (isset($_FILES['file'])) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$model->file = $_FILES['file'];
						$filename = $_FILES['file']['name'];
						$filepath = 'uploads/INST/DIVSATU/';
						$model->file_attachment = $filepath.$model->id.'/'.$filename;
					}
				}
			}
			
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			
			if ($filename != ''){
				move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
			}
			
			return 'success';
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionCreatedetail(){
		$this->layout = 'blank';
		$id = Yii::$app->session->get('idInstWhTr');		
		
		if (Yii::$app->request->isPost && empty(Yii::$app->request->post('SearchMasterItemIm'))){			
			
			$data_im_code   = Yii::$app->request->post('im_code');
			$data_r_good    = Yii::$app->request->post('rgood');
			$data_r_notgood = Yii::$app->request->post('rnotgood');
			$data_r_reject  = Yii::$app->request->post('rreject');
			
			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}
			
			foreach($data_im_code as $key => $value){
				// if($data_r_good[$key] == '')
				if($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '' && $data_r_good[$key] == 0 && $data_r_notgood[$key] == 0 && $data_r_reject[$key] == 0){
					continue;
				}
				$values = explode(';',$value);
			
				$model = new InstructionWhTransferDetail();
				$model->id_instruction_wh	= $id;
				$model->id_item_im			= $values[0];
				$model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
				$model->req_not_good		= ($data_r_notgood[$key] == '') ? 0 : $data_r_notgood[$key];
				$model->req_reject			= ($data_r_reject[$key] == '') ? 0 : $data_r_reject[$key];
				
				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				if($model->req_good > $modelMasterItem->s_good){
					$pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_not_good > $modelMasterItem->s_not_good){
					$pesan[] = $model->getAttributeLabel('req_not_good')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				if($model->req_reject > $modelMasterItem->s_reject){
					$pesan[] = $model->getAttributeLabel('req_reject')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				
				if ($overStock == 0)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);
				
				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}
			}
			
			return json_encode(['status' => 'success']);
			// return 'success';
			
		}
		
		$modelDetail = InstructionWhTransferDetail::find()->select(['id_item_im'])->andWhere(['id_instruction_wh' => $id])->all();
		$idItemIm = ArrayHelper::map($modelDetail, 'id_item_im', 'id_item_im');
		
		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->post(), $idItemIm);

        return $this->render('createdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	public function actionUpdatedetail($idDetail){
		$this->layout = 'blank';
		$model = InstructionWhTransferDetail::findOne($idDetail);
		
		if ($model->load(Yii::$app->request->post())) {
			
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}			
			
			return 'success';
        } else {
            return $this->render('_formdetail', [
                'model' => $model,
            ]);
        }
	}
	
	public function actionSubmit($id){
		$model = InstructionWhTransfer::findOne($id);
		$modelDetail = InstructionWhTransferDetail::find()->andWhere(['id_instruction_wh' => $id])->count();
		if ($modelDetail > 0){
			if($model->status_listing == 2 || $model->status_listing == 3){
				$model->status_listing = 2;
			}else{
				$model->status_listing = 1;
			}
		}else{
			$model->status_listing = 7;
		}
		
		if (!$model->save()){
			return Displayerror::pesan($model->getErrors());
		}
		
		Yii::$app->session->remove('idInstWhTr');
		return 'success';
	}
	
	public function actionApprove($id){
		$model = $this->findModel($id);
		
		if ($model->status_listing == 1){
			$model->status_listing = 5;
			
			if ($model->save()){
				return 'success';
			}
			
		}else{
			return 'Not Valid for Approve';
		}
	}

	public function actionRevise($id)
    {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			if(!empty($_POST['InstructionWhTransfer']['revision_remark'])) {
				$model->status_listing = 3;
				$model->revision_remark = $_POST['InstructionWhTransfer']['revision_remark'];
				if($model->save()) {
					// $this->createLog($model);

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
    }

    public function actionReject($id)
    {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if($model != null) {
			if(!empty($_POST['InstructionWhTransfer']['revision_remark'])) {
				$model->status_listing = 6;
				$model->revision_remark = $_POST['InstructionWhTransfer']['revision_remark'];
				if($model->save()) {
                     // $this->createLog($model);
				 //    $arrAuth = ['/finance-invoice/index'];				

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

    }

    /**
     * Deletes an existing InstructionWhTransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	InstructionWhTransferDetail::deleteAll('id_instruction_wh = :id_instruction_wh', [':id_instruction_wh' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDownloadfile($id, $modul = null, $relation = '', $upload = false) {
		$request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
         

        // if ($upload) {
            // $basepath = Yii::getAlias('@webroot') .'/uploads/AP/INVOICE/';
           
        // }else {
            $basepath = Yii::getAlias('@webroot') . '/';
        // }
        
		// if ($relation == 'document') {
  //           if ($relation == 'document') {
  //               $model = InstructionWhTransferDocument::findOne($id);
  //           }else {
  //               throw new NotFoundHttpException("The request page does not exist.", 1);

  //           }
		// }else{
          
               
  //           if ($modul=='log'){
  //               $model = LogInstructionWhTransfer::findOne($id);
  //           }
			
		// 	elseif($modul=='vendor'){
		// 		$basepath = Yii::getAlias('@os') . '/web/';
		// 		$model = OsVendorTermSheet::findOne($id);
		// 	}
  //           else {
		$model = $this->findModel($id);  
        //     } 
        // }

        $path = ArrayHelper::getValue($model, $params['data'], 'Unknown');
        // $lok='';
        
// return $path;

        
        // if ($params['path'] === 'true') {
            // $lok = 'CA/IOM/'.$id.'/';
        // }
 
        $file = $basepath.$path;
		// return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
        // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}

    /**
     * Finds the InstructionWhTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionWhTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstructionWhTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
