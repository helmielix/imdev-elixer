<?php

namespace grflost\controllers;

use Yii;
use common\models\Grf;
use common\models\GrfDetail;
use common\models\Reference;
use common\models\OutboundGrf;
use common\models\MasterItemIm;
use common\models\SearchGrf;
use common\models\SearchOutboundGrf;
use common\models\SearchGrfDetail;
use common\models\SearchMasterItemIm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\widgets\Displayerror;
use common\widgets\Numbertoroman;
use common\widgets\Email;
use common\models\MkmMasterItem;
use kartik\mpdf\Pdf;
use yii\helpers\Json;


/**
 * GrfController implements the CRUD actions for Grf model.
 */
class GrfController extends Controller
{
    /**
     * @inheritdoc
     */
	private $id_modul = 4;
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
     * Lists all Grf models.
     * @return mixed
     */
    private function listIndex($action)
    {
        $searchModel = new SearchGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    private function listIndexothers($action)
    {
        $searchModel = new SearchGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }
	
	public function actionIndex()
    {
        $searchModel = new SearchGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexverify()
    {
        return $this->render('index', $this->listIndex('verify'));
    }
	
	public function actionIndexapprove()
    {
        return $this->render('index', $this->listIndex('approve'));
    }

	public function actionIndexothers()
    {
        return $this->render('indexothers', $this->listIndex('inputothers'));
    }

    public function actionIndexothersverify()
    {
        return $this->render('indexothers', $this->listIndex('verifyothers'));
    }

    public function actionIndexothersapprove()
    {
        return $this->render('indexothers', $this->listIndex('approveothers'));
    }

    public function actionIndexmr()
    {
        $searchModel = new SearchOutboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'grfmr');

        return $this->render('indexmr', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexdetail(){

		$this->layout = 'blank';
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idGrf'));

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Displays a single Grf model.
     * @param integer $id
     * @return mixed
     */
    private function detailView($id)
    {		
		$model = $this->findModel($id);
		
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		// Yii::$app->session->set('idGrf', $model->id);
		
        return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    private function detailViewothers($id)
    {		
		$model = $this->findModel($id);
		
		$searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		// Yii::$app->session->set('idGrf', $model->id);
		
        return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionViewmr($id){
        $this->layout = 'blank';
        $model = OutboundGrf::findOne($id);
        
        $searchModel = new SearchOutboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'grfmr');
        
        return $this->render('viewmr', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionCreatemr($id){
        $this->layout = 'blank';
        $model = OutboundGrf::findOne($id);
        
        $searchModel = new SearchOutboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'grfmr');
        
        return $this->render('viewmr', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionView($id){
		$this->layout = 'blank';
		Yii::$app->session->set('idGrf', $id);
		return $this->render('view', $this->detailView($id));
	}
	public function actionViewverify($id){
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
	}

	public function actionViewapprove($id){
		$this->layout = 'blank';
		return $this->render('view', $this->detailView($id));
	}

	public function actionViewothers($id){
		$this->layout = 'blank';
		Yii::$app->session->set('idGrf', $id);
		return $this->render('view', $this->detailViewothers($id));
	}

	public function actionViewothersverify($id){
		$this->layout = 'blank';
		Yii::$app->session->set('idGrf', $id);
		return $this->render('view', $this->detailViewothers($id));
	}

	public function actionViewothersapprove($id){
		$this->layout = 'blank';
		Yii::$app->session->set('idGrf', $id);
		return $this->render('view', $this->detailViewothers($id));
	}

    /**
     * Creates a new Grf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->layout = 'blank';
        $model = new Grf();
		$model->id_modul = $this->id_modul;
		$model->id_warehouse = 2;
		$model->status_return = 31;
		$newidinst = Grf::find()->andWhere(['and',['like', 'grf_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
		$newidinstexist = Grf::find()->andWhere(['and',['grf_number' => $newidinst],['id_modul' => $model->id_modul]])->exists();
		$newidinst++;
		
		$monthroman = Numbertoroman::convert(date('n'));
		
		$model->grf_number = sprintf("%04d", $newidinst).'/GRF-IC1/WT/'.$monthroman.date('/Y');

        if ($model->load(Yii::$app->request->post())) {
			
			$model->id_division = Yii::$app->user->identity->id_division;
			$model->status_listing = 7;
			
			// $model->date_of_return = Date('y:m:d', strtotime("+3 days"));
			
			if (isset($_FILES['file1'])) {
				if (isset($_FILES['file1']['size'])) {
					if($_FILES['file1']['size'] != 0) {
						$model->file1 = $_FILES['file1'];
						$filename = $_FILES['file1']['name'];
						$filepath1 = 'uploads/GRF/IKR/';
						$model->file_attachment_1 = $filepath1.$model->id.'/'.$filename;
					}
				}
			}

			if (isset($_FILES['file2'])) {
				if (isset($_FILES['file2']['size'])) {
					if($_FILES['file2']['size'] != 0) {
						$model->file2 = $_FILES['file2'];
						$filename = $_FILES['file2']['name'];
						$filepath2 = 'uploads/GRF/IKR/';
						$model->file_attachment_2 = $filepath2.$model->id.'/'.$filename;
					}
				}
			}

			if (isset($_FILES['file3'])) {
				if (isset($_FILES['file3']['size'])) {
					if($_FILES['file3']['size'] != 0) {
						$model->file3 = $_FILES['file3'];
						$filename = $_FILES['file3']['name'];
						$filepath3 = 'uploads/GRF/IKR/';
						$model->file_attachment_3 = $filepath3.$model->id.'/'.$filename;
					}
				}
			}
			
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			
			
			$model->save();
			// return print_r($model->file_attachment_1);
			
			Yii::$app->session->set('idGrf', $model->id);
			
			if (!file_exists($filepath1.$model->id.'/')) {
				mkdir($filepath1.$model->id.'/', 0777, true);
			}
			if (!file_exists($filepath2.$model->id.'/')) {
				mkdir($filepath2.$model->id.'/', 0777, true);
			}
			if (!file_exists($filepath3.$model->id.'/')) {
				mkdir($filepath3.$model->id.'/', 0777, true);
			}
			move_uploaded_file($_FILES['file1']['tmp_name'], $model->file_attachment_1);
			move_uploaded_file($_FILES['file2']['tmp_name'], $model->file_attachment_2);
			move_uploaded_file($_FILES['file3']['tmp_name'], $model->file_attachment_3);
			
            return 'success';
        } else {
			// Yii::$app->session->remove('idGrf');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateothers()
    {
		$this->layout = 'blank';
        $model = new Grf();
		$model->id_modul = $this->id_modul;
		$model->id_warehouse = 2;
		$model->status_return = 31;
		$newidinst = Grf::find()->andWhere(['and',['like', 'grf_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
		$newidinstexist = Grf::find()->andWhere(['and',['grf_number' => $newidinst],['id_modul' => $model->id_modul]])->exists();
		$newidinst++;
		
		$monthroman = Numbertoroman::convert(date('n'));
		
		$model->grf_number = sprintf("%04d", $newidinst).'/GRF-IC1/WT/'.$monthroman.date('/Y');

        if ($model->load(Yii::$app->request->post())) {

			$model->source = 'others';
			$model->id_division = Yii::$app->user->identity->id_division;
			$model->status_listing = 7;
			
			// $model->date_of_return = Date('y:m:d', strtotime("+3 days"));
			
			if (isset($_FILES['file1'])) {
				if (isset($_FILES['file1']['size'])) {
					if($_FILES['file1']['size'] != 0) {
						$model->file1 = $_FILES['file1'];
						$filename = $_FILES['file1']['name'];
						$filepath1 = 'uploads/GRF/IKR/';
						$model->file_attachment_1 = $filepath1.$model->id.'/'.$filename;
					}
				}
			}

			if (isset($_FILES['file2'])) {
				if (isset($_FILES['file2']['size'])) {
					if($_FILES['file2']['size'] != 0) {
						$model->file2 = $_FILES['file2'];
						$filename = $_FILES['file2']['name'];
						$filepath2 = 'uploads/GRF/IKR/';
						$model->file_attachment_2 = $filepath2.$model->id.'/'.$filename;
					}
				}
			}

			if (isset($_FILES['file3'])) {
				if (isset($_FILES['file3']['size'])) {
					if($_FILES['file3']['size'] != 0) {
						$model->file3 = $_FILES['file3'];
						$filename = $_FILES['file3']['name'];
						$filepath3 = 'uploads/GRF/IKR/';
						$model->file_attachment_3 = $filepath3.$model->id.'/'.$filename;
					}
				}
			}
			
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			
			
			$model->save();
			// return print_r($model->file_attachment_1);
			
			Yii::$app->session->set('idGrf', $model->id);
			
			if (!file_exists($filepath1.$model->id.'/')) {
				mkdir($filepath1.$model->id.'/', 0777, true);
			}
			if (!file_exists($filepath2.$model->id.'/')) {
				mkdir($filepath2.$model->id.'/', 0777, true);
			}
			if (!file_exists($filepath3.$model->id.'/')) {
				mkdir($filepath3.$model->id.'/', 0777, true);
			}
			move_uploaded_file($_FILES['file1']['tmp_name'], $model->file_attachment_1);
			move_uploaded_file($_FILES['file2']['tmp_name'], $model->file_attachment_2);
			move_uploaded_file($_FILES['file3']['tmp_name'], $model->file_attachment_3);
			
            return 'success';
        } else {
			// Yii::$app->session->remove('idGrf');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Grf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$this->layout = 'blank';
        $model = $this->findModel($id);

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

			if($model->status_listing == 3)	$model->status_listing = 2;

			
			if (!$model->save()){
				return Displayerror::pesan($model->getErrors());
			}
			
		Yii::$app->session->set('idGrf', $model->id);
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
		$idGrf = Yii::$app->session->get('idGrf');		
		
	  	if ((Yii::$app->request->isPost)) {
			
			$data_item_code  = Yii::$app->request->post('orafin_code');
			$data_qty_request  = Yii::$app->request->post('qty_request');
			$data_qty_return  = Yii::$app->request->post('qty_return');
			// $data_im_code  = Yii::$app->request->post('im_code');
			// $data_r_notgood = Yii::$app->request->post('rnotgood');
			// $data_r_reject  = Yii::$app->request->post('rreject');
			// return print_r($data_im_code);
			
			// if (count($data_im_code) == 0){
			// 	return json_encode(['status' => 'success']);
			// }
			
			foreach($data_item_code as $key => $value){
				// if($data_qty_request[$key] == '')
				if($data_qty_request[$key] == '' && $data_qty_request[$key] == 0 && 
					$data_qty_return[$key] == '' && $data_qty_return[$key] == 0){
					continue;
				}
				$values = explode(';',$value);
			
				$model = new GrfDetail();
				$model->id_grf	= $idGrf;
				$model->orafin_code	= $values[0];
				$model->qty_request			= ($data_qty_request[$key] == '') ? 0 : $data_qty_request[$key];
				$model->qty_return		= ($data_qty_return[$key] == '') ? 0 : $data_qty_return[$key];
				
				/*
				$modelMasterItem = MasterItemIm::findOne($values[0]);
				$overStock = 1;
				$pesan = [];
				if($model->qty_request > $modelMasterItem->s_good){
					$pesan[] = $model->getAttributeLabel('qty_request')." is more than Stock for IM Code ".$values[1];
					$overStock = 0;
				}
				
				if ($overStock == 0)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);
				*/
				
				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}
			}
			
			return json_encode(['status' => 'success']);
			// return 'success';
			
		}
		
		$modelDetail = GrfDetail::find()->select(['orafin_code'])->where(['id_grf' => $idGrf])->all();
		$orafinCode = ArrayHelper::map($modelDetail, 'orafin_code', 'orafin_code');
		
		$searchModel = new SearchMasterItemIm();
        $dataProvider = $searchModel->searchMasterOrafin(Yii::$app->request->post(), $orafinCode);

        return $this->render('createdetail', [
        	'idGrf' => $idGrf,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}


	public function actionSetsessionreturn(){
		if (Yii::$app->request->isPost){
			// $data = Yii::$app->session->get('detailinbound');
			
			$id   = Yii::$app->request->post('id');
			$val  = Yii::$app->request->post('val');
			
			$data[$id] = $val;
			
			// Yii::$app->session->set('detailinbound', $data);
			return var_dump($data);
		}
	}

	public function actionSetsessiondetail(){
		// $model = new MasterItem();
		$aray = [];
		if(Yii::$app->request->post('qty_request')){
			$session = Yii::$app->session;
			$session->remove('countQty');

			$qty = Yii::$app->request->post('qty_request');
			$itemCode = Yii::$app->request->post('orafin_code');
			// return print_r($itemCode);
			foreach ($qty as $data => $value) {  
				$reqQty = $value;
				$aray[$itemCode[$data]] = [
	                $reqQty
	            ];
			}
			// return print_r($aray);
			Yii::$app->session->set('countQty', $aray);
			return 'success';
		}
		// if ($model->load(Yii::$app->request->post())) {
		// 	return print_r($_POST['qty_request']);
		// }
		// else{
			// return 'failed';
		// }
	}

	// public function actionUpdatedetail($idDetail){
	// 	$this->layout = 'blank';
	// 	$model = GrfDetail::findOne($idDetail);
	// 	Yii::$app->session->set('idInstWhTr', $model->id_grf);
		
	// 	if ($model->load(Yii::$app->request->post())) {
			
	// 		if (!$model->save()){
	// 			return Displayerror::pesan($model->getErrors());
	// 		}			
			
	// 		return 'success';
 //        } else {
 //            return $this->render('_formdetail', [
 //                'model' => $model,
 //            ]);
 //        }
	// }
	
	public function actionUpdatedetail($id=null){
		$this->layout = 'blank';
		$data_id  = Yii::$app->request->post('id');
		$data_qty_return = Yii::$app->request->post('qty_return');
		$data_status_return = Yii::$app->request->post('status_return');
		$model = GrfDetail::findOne($data_id[0]);
		$model->qty_return = $data_qty_return[0]; 
		$model->status_return = $data_status_return[0];
		Yii::$app->session->set('idGrf', $model->id_grf);
		
		if ( $model->qty_request == $model->qty_return ){
				$model->status_return = 36;
			}else{
				$model->status_return = 31;
			}
		// return print_r($model);
		if (Yii::$app->request->post()) {
			
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
		$model = Grf::findOne($id);
		$modelDetail = GrfDetail::find()->andWhere(['id_grf' => $id])->count();
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
		
		Yii::$app->session->remove('idGrf');
		return 'success';
	}

	 public function actionVerify($id)
    {   
        $model = $this->findModel($id);
        if($model->status_listing == 1 || $model->status_listing == 2){
            $model->status_listing = 4;
            $model->verified_by = Yii::$app->user->identity->id;

            if ($model->save()) {
                return 'success';
            } 
        }else{
            return 'Not valid for verify';
        }
    }
	
	public function actionApprove($id){
		$model = $this->findModel($id);
		
		if ($model->status_listing == 4){
			$model->status_listing = 5;
			$model->approved_by = Yii::$app->user->identity->id;
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
			if(!empty($_POST['Grf']['revision_remark'])) {
				$model->status_listing = 3;
				$model->revision_remark = $_POST['Grf']['revision_remark'];
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
			if(!empty($_POST['Grf']['revision_remark'])) {
				$model->status_listing = 6;
				$model->revision_remark = $_POST['Grf']['revision_remark'];
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
     * Deletes an existing Grf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	GrfDetail::deleteAll('id_grf = :id_grf', [':id_grf' => $id]);
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
  //               $model = GrfDocument::findOne($id);
  //           }else {
  //               throw new NotFoundHttpException("The request page does not exist.", 1);

  //           }
		// }else{
          
               
  //           if ($modul=='log'){
  //               $model = LogGrf::findOne($id);
  //           }
			
		// 	elseif($modul=='vendor'){
		// 		$basepath = Yii::getAlias('@os') . '/web/';
		// 		$model = OsVendorTermSheet::findOne($id);
		// 	}
  //           else {
// return $basepath;
		$model = $this->findModel($id);  
        //     } 
        // }

        $path = ArrayHelper::getValue($model, $params['data'], 'Unknown');
        // $lok='';
        

        
        // if ($params['path'] === 'true') {
            // $lok = 'CA/IOM/'.$id.'/';
        // }
 
        $file = $basepath.$path;
		return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
        // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}

	public function actionSavehandovertime($id){
        $model = $this->findModel($id);     
        if (Yii::$app->request->post()){
            // $time = Yii::$app->request->post('time');
            // $model->handover_time = date('Y-m-d ').$time;
            // $model->save();
            
            return 'success';
        }else{
            return 'failed';
        }
    }

     public function actionExportpdf($id) {
        
        $arrayreturn = $this->detailView($id);
        $model = $arrayreturn['model'];
        $dataprovider = $arrayreturn['dataProvider'];
        $dataprovider->sort = false;
        $arrayreturn['dataProvider'] = $dataprovider;
        
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('viewmr', $arrayreturn),
            'filename'=> 'Material_Return.pdf',
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'options' => [
                'title' => 'Surat Jalan '.$model->no_sj,

            ],
            'methods' => [
                'SetHeader' => ['Surat Jalan'],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    /**
     * Finds the Grf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionType(){
        if (isset(Yii::$app->request->post()['grf_type'])) {
            $item = Yii::$app->request->post()['grf_type'];
            $desc = Reference::findOne($type);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['type' => $desc->id, 'desc' => $desc->type];
        }

        $out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cat_id = $parents[0];
                switch ($cat_id) {
                    case 23:
                        $where = ['id' => 20];
                        break;
                    // case 23:
                    //     $where = ['id' => 20,19];
                    //     break;
                    default:
                        $where = ['table_relation' => ['grf_type']];
                }
				$out = Reference::find($cat_id)->andWhere($where)->select('id as id,description as name')->asArray()->all();
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    protected function findModel($id)
    {
        if (($model = Grf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
