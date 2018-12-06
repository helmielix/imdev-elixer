<?php

namespace divisisatu\controllers;

use Yii;
use common\models\InboundWhTransfer;
use common\models\LogInboundWhTransfer;
use common\models\InboundWhTransferDetail;
use common\models\InboundWhTransferDetailSn;
use common\models\SearchInboundWhTransfer;
use common\models\SearchLogInboundWhTransfer;
use common\models\SearchInboundWhTransferDetailSn;

use common\models\OutboundWhTransfer;
use common\models\OutboundWhTransferDetail;
use common\models\OutboundWhTransferDetailSn;
use common\models\SearchOutboundWhTransfer;
use common\models\SearchOutboundWhTransferDetail;
use common\models\SearchOutboundWhTransferDetailSn;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\UploadForm;
use common\models\MasterItemIm;
/**
 * InboundWhTransferController implements the CRUD actions for InboundWhTransfer model.
 */
class InboundWhTransferController extends Controller
{
    private $id_modul = 1;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
					'approve' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all InboundWhTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul, 'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionIndexlog()
      {
        $searchModel = new SearchLogInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul);

        return $this->render('indexlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexapprove()
    {
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul, 'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexdetail()
    {
		$this->layout = 'blank';
		
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'detail', \Yii::$app->session->get('idOutboundWh'));
		$model = $this->findModel(Yii::$app->session->get('idOutboundWh'));
		
		

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			
        ]);
    }
	
	public function actionIndextagsn()
    {
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'tagsn');
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InboundWhTransfer model.
     * @param integer $id
     * @return mixed
     */
	public function actionViewoutbound($id)
    {
        $this->layout = 'blank';
		
		$model = OutboundWhTransfer::findOne($id);
		
		$searchModel = new SearchOutboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		return $this->render('viewoutbound', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    public function actionView($id)
    {
        if($id == NULL){
			$id = \Yii::$app->session->get('idInboundWh');			
		}
		
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundWhTransfer();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$this->id_modul,'detail_sn', $id);
		// return print_r($dataProvider->models);
		$model = $this->findModelJoinOutbound($id);
		
		Yii::$app->session->set('idInboundWh',$id);
		
        return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewlog($id)
    {
        if($id == NULL){
			$id = \Yii::$app->session->get('idInboundWh');			
		}
		
		$this->layout = 'blank';
		
		$searchModel = new SearchLogInboundWhTransfer();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$this->id_modul,'detail_sn', $id);
		// return print_r($dataProvider->models);
		$model = $this->findModelJoinOutbound($id);
		
		Yii::$app->session->set('idInboundWh',$id);
		
        return $this->render('viewlog', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewapprove($id)
    {
        if($id == NULL){
			$id = \Yii::$app->session->get('idInboundWh');			
		}
		
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundWhTransfer();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
       $dataProvider = $searchModel->search(Yii::$app->request->post(),$this->id_modul,'detail_sn', $id);
		
		$model = $this->findModelJoinOutbound($id);
		
		Yii::$app->session->set('idInboundWh',$id);
		
        return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewsn($id = NULL)
    {
		if($id == NULL){
			$id = \Yii::$app->session->get('idInboundWh');			
		}
		
		if (basename(Yii::$app->request->referrer) != 'indextagsn'){
			throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
		}
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundWhTransfer();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$this->id_modul,'detail_sn', $id);
		
		// if (Yii::$app->request->isPost){
			// return var_dump(Yii::$app->request->post());
		// }
		$model = $this->findModelJoinOutbound($id);
		
		Yii::$app->session->set('idInboundWh',$id);
		
        return $this->render('viewsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewdetailsn($idInboundWhDetail = NULL)
    {
		if($idInboundWhDetail == NULL){
			$idInboundWhDetail = \Yii::$app->session->get('idInboundWhDetail');
			
		}
		$this->layout = 'blank';
		
		$searchModel = new SearchInboundWhTransferDetailSn();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->post(), $idInboundWhDetail);
		
		
		$model = InboundWhTransferDetail::findOne($idInboundWhDetail);
		
		//Yii::$app->session->set('idInboundWh',$id);
		
        return $this->render('viewdetailsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionUploadsn($id = NULL, $idInboundWh = NULL, $qty = NULL) {
        $this->layout = 'blank';
        $model = new UploadForm();

        $model->scenario = 'xls';
		
		if($id != NULL){
			\Yii::$app->session->set('idInboundWhDetail', $id);
		}
		if($idInboundWh != NULL){
			\Yii::$app->session->set('idInboundWh', $idInboundWh);
		}
		if($qty != NULL){
			\Yii::$app->session->set('maxQty', $qty);
		}

        if (isset($_FILES['file']['size'])) {
            if($_FILES['file']['size'] != 0) {
                $filename=('Uploads/'.$_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], 'Uploads/'.basename( $_FILES['file']['name']));
                $datas = \moonland\phpexcel\Excel::import($filename, [
                    'setFirstRecordAsKeys' => true,
                    // 'setIndexSheetByName' => true,
                    // 'getOnlySheet' => 'Sheet1'
                ]);
                if(isset($datas[0][0])){
                    $datas = $datas[0];
                }
                //InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.Yii::$app->session->get('idInboundWhDetail'));
                $row = 2;
                $periksa = "\nplease check on row ";
                $reqCol = [
                	'SERIAL_NUMBER' => '',
                	'MAC_ADDRESS' => '',
                ];
				$maxQty = Yii::$app->session->get('maxQty');
				$cekStatus = 0;
				
                foreach ($datas as $key => $data) {
					if(($key+1) > $maxQty){
						return 'Quantity cannot be more than '. $maxQty;
					}
					
                    // periksa setiap kolom yang wajib ada, hanya di awal row
                    if ($row == 2) {
                    	$missCol = array_diff_key($reqCol,$data);
                    	if (count($missCol) > 0) {
                            InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.Yii::$app->session->get('idInboundWhDetail'));
                    		return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                    	}
                    }
                    $model = new InboundWhTransferDetailSn();

                    $model->id_inbound_wh_detail = Yii::$app->session->get('idInboundWhDetail');
                    $model->serial_number = (string)$data['SERIAL_NUMBER'];
                    $model->mac_address = $data['MAC_ADDRESS'];

                    if(!$model->save()) {
                        InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.Yii::$app->session->get('idInboundWhDetail'));
                        $error = $model->getErrors();
                        $error['line'] = [$periksa.$row];
                        return print_r($model->getErrors());
                    }
                    $row++;
					$cekStatus++;
                }
				$modelInboundWhTransferDetail = InboundWhTransferDetail::findOne(Yii::$app->session->get('idInboundWhDetail'));
				$model = InboundWhTransferDetailSn::find()->where(['id_inbound_wh_detail'=>Yii::$app->session->get('idInboundWhDetail')])->asArray()->all();
				
				//check max qty
				if($maxQty == count($model)){
					$modelInboundWhTransferDetail->status_listing = 41;
					$modelInboundWhTransferDetail->save();
					
					//Add new stock to master item im
					$modelMasterItem = MasterItemIm::findOne($modelInboundWhTransferDetail->id_item_im);
					$modelMasterItem->stock_qty = $modelMasterItem->stock_qty + $maxQty;
					$modelMasterItem->save();
				}else{
					$modelInboundWhTransferDetail->status_listing = 43;
					$modelInboundWhTransferDetail->save();
				}
                
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				
				
				$modelInboundWhTransferDetail = InboundWhTransferDetail::find()->where(['id_inbound_wh'=> Yii::$app->session->get('idInboundWh')])->asArray()->all();
				$cekStatus = 1;
				foreach($modelInboundWhTransferDetail as $key => $value){
					// print_r($value['status_listing']);
					// break;
					if($value['status_listing'] != 41){
						$cekStatus++;
					}
				}
				
				if($cekStatus == 1){
					$modelInbound = $this->findModel(\Yii::$app->session->get('idInboundWh'));
					$modelInbound->status_listing = 42;
					$modelInbound->save();
				}
				
                return 'success';
            }
        }
		// print_r($id);
		
        return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
    }

    public function actionResetsn($idInboundWhDetail)
    {  		
		$model = InboundWhTransferDetail::findOne($idInboundWhDetail);
		
		// $modelMasterItem = MasterItemIm::findOne($model->id_item_im);
		// $modelMasterItem->stock_qty = $modelMasterItem->stock_qty - $model->qty;
		// $modelMasterItem->save();
		
        InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.$idInboundWhDetail);
		
		
		$modelInbounPO = InboundWhTransfer::findOne($model->id_inbound_wh);
		\Yii::$app->session->set('idInboundWh', $model->id_inbound_wh);
        $model->status_listing = 999;
		$model->save();
		
		$modelInbounPO->status_listing = 5;
		$modelInbounPO->save();

		return 'success';
    }
	
	public function actionApprove($id)
    {  
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if($model->status_listing == 1 ||  $model->status_listing == 2){
            $model->status_listing = 5;
            if ( $model->save()) {
            	$this->createLog($model);
               

                    return 'success';
            } else {
                return print_r($model->getErrors());
            }
        }else{
            return 'Not valid for approve';
        }
    }
	
	public function actionReturntoic($id)
    {  
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if($model->status_listing == 1 ||  $model->status_listing == 2){
            $model->status_listing = 5;
            if ( $model->save()) {
               //$this->createLog($model);
               

                    return 'success';
            } else {
                return print_r($model->getErrors());
            }
        }else{
            return 'Not valid for approve';
        }
    }
	
	public function actionRevise($id)
    {  
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
		if(!empty($_POST['InboundWhTransfer']['revision_remark'])) {
			if($model->status_listing == 1 || $model->status_listing == 2){
				$model->status_listing = 3;
				$model->revision_remark = $_POST['InboundWhTransfer']['revision_remark'];
				if ( $model->save()) {
					$this->createLog($model);
					return 'success';
				} else {
					return print_r($model->getErrors());
				}
			}else{
				return 'Not valid for approve';
			}
			
		}
        
    }
    
	
	public function actionCreate($idOutboundWh = NULL)
    {
        $model = new InboundWhTransfer();
		if($idOutboundWh == NULL){
			$idOutboundWh = \Yii::$app->session->get('idOutboundWh');
		}
		$this->layout = 'blank';
        if ($model->load(Yii::$app->request->post())) {
			// return print_r($idOutboundWh);
			$model->id_outbound_wh = $idOutboundWh;
			$model->id_modul = 1;
			$model->status_listing = 1;
			if($model->save()){
				Yii::$app->session->set('idInboundWhTransfer',$model->id_outbound_wh);
				Yii::$app->session->set('action','createdetail');
				$this->createLog($model);
				return 'success';
			}else{
				return print_r($model->getErrors());
			}
        } else {		
			\Yii::$app->session->set('idOutboundWh', $idOutboundWh);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionCreatedetail($idOutboundWh = NULL)
    {
        $model = new InboundWhTransferDetail();
		if($idOutboundWh == NULL){
			$idOutboundWh = \Yii::$app->session->get('idOutboundWh');
		}
		
		if(Yii::$app->request->post()){
			$quantities = $_POST['qty'];
			$items = $_POST['item'];
			$orafinCodes = $_POST['orafinCode'];
			$maxQty = $_POST['req_good'];
			$values = array();
			$cek = 1;
			
			foreach($quantities as $key  => $data){				
				if($quantities[$key] != NULL){
					if($quantities[$key] <= $maxQty[$key]){						
						if($quantities[$key] != $maxQty[$key] && $cek != 0) {
							$cek = 0;
						} 
						$values[] = [$idOutboundWh,$quantities[$key],$orafinCodes[$key],$items[$key]];
					}else{
						return 'Quantity cannot be more than '.$maxQty[$key];
					}
				}
			}
			Yii::$app->db
			->createCommand()
			->batchInsert('inbound_wh_transfer_detail', ['id_inbound_wh','qty', 'orafin_code','id_item_im'],$values)
			->execute();
			
			$status = 45; //intransit
			if($cek){
				$status = 1;
			}
			$modelInbound = $this->findModel($idOutboundWh);
			$modelInbound->status_listing = $status;
			$modelInbound->save();
			return 'success';
		}else{
			$idOutboundWh = InboundWhTransferDetail::find()
				->joinWith('idItemIm')
				->select(['inbound_wh_transfer_detail.qty','inbound_wh_transfer_detail.id_item_im','master_item_im.im_code'])
				->where(['id_inbound_wh'=>$idOutboundWh])->asArray()->all();
			// return print_r($idOutboundWh);
			$this->setSessionqtydetail($idOutboundWh);
			
			$this->layout = 'blank';
		
			$searchModel = new SearchInboundWhTransfer();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams,1,'detail', \Yii::$app->session->get('idOutboundWh'));
			$model = $this->findModel(Yii::$app->session->get('idOutboundWh'));
			
			return $this->render('indexdetail', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				
			]);
		}	
    }
	
	public function actionUpdatedetail($idOutboundWh = NULL)
    {
        $model = new InboundWhTransferDetail();
		if($idOutboundWh == NULL){
			$idOutboundWh = \Yii::$app->session->get('idOutboundWh');
		}
		
		if(Yii::$app->request->post()){
			$quantities = $_POST['qty'];
			$items = $_POST['item'];
			$orafinCodes = $_POST['orafinCode'];
			$maxQty = $_POST['req_good'];
			$values = array();
			$cek = 1;
			
			foreach($quantities as $key  => $data){
				$model = InboundWhTransferDetail::find()->where(['and',['id_inbound_wh'=>$idOutboundWh],['id_item_im'=>$items[$key]]])->one();
				if(isset($model)){
					$model->delete();
				}
			}
			foreach($quantities as $key  => $data){				
				if($quantities[$key] != NULL){
					if($quantities[$key] <= $maxQty[$key]){	
						if($quantities[$key] != $maxQty[$key] && $cek != 0) {
							$cek = 0;
						}  
						$values[] = [$idOutboundWh,$quantities[$key],$orafinCodes[$key],$items[$key]];
					}else{
						return 'Quantity cannot be more than '.$maxQty[$key];
					}
				}
			}
			Yii::$app->db
			->createCommand()
			->batchInsert('inbound_wh_transfer_detail', ['id_inbound_wh','qty', 'orafin_code','id_item_im'],$values)
			->execute();
			
			$status = 45; //intransit
			if($cek){
				$status = 1;
			}
			$modelInbound = $this->findModel($idOutboundWh);
			$modelInbound->status_listing = $status;
			$modelInbound->save();
			return 'success';
		}else{
			$idOutboundWh = InboundWhTransferDetail::find()
				->joinWith('idItemIm')
				->select(['inbound_wh_transfer_detail.qty','inbound_wh_transfer_detail.id_item_im','master_item_im.im_code'])
				->where(['id_inbound_wh'=>$idOutboundWh])->asArray()->all();
			// return print_r($idOutboundWh);
			$this->setSessionqtydetail($idOutboundWh);
			
			$this->layout = 'blank';
		
			$searchModel = new SearchInboundWhTransfer();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams,1,'detail', \Yii::$app->session->get('idOutboundWh'));
			$model = $this->findModel(Yii::$app->session->get('idOutboundWh'));
			
			return $this->render('indexdetail', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				
			]);
		}	
    }

	protected function setSessionqtydetail($idInboundWhs)
    {		 
        $aray = [];
        foreach ($idInboundWhs as $data => $value) {  
			// return print_r($value['im_code']);
			$reqQty = $value['qty'];
			// $item = $value['id_item_im'];
			$imCode = $value['im_code'];
			
            // save to session
            $aray[$value['im_code']] = [
                $reqQty
            ];
        }
        Yii::$app->session->set('countQty', $aray);
    }

    /**
     * Updates an existing InboundWhTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($idOutboundWh)
    {
        $model = $this->findModel($idOutboundWh);

        if($idOutboundWh == NULL){
			$idOutboundWh = \Yii::$app->session->get('idOutboundWh');
		}
		$this->layout = 'blank';
        if ($model->load(Yii::$app->request->post())) {
			// return print_r($idOutboundWh);
			$model->id_outbound_wh = $idOutboundWh;
			$model->id_modul = 1;
			($model->status_listing == 3)?
				$model->status_listing = 2 : $model->status_listing = 1;
			
			if($model->save()){
				Yii::$app->session->set('idInboundWhTransfer',$model->id_outbound_wh);
				Yii::$app->session->set('action','updatedetail');
				$this->createLog($model);
				return 'success';
			}else{
				return print_r($model->getErrors());
			}
        } else {		
			\Yii::$app->session->set('idOutboundWh', $idOutboundWh);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InboundWhTransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     protected function createLog($model)
    {
        $modelLog = new LogInboundWhTransfer();
        $modelLog->setAttributes($model->attributes);
        // $modelLog->save();
		if(!$modelLog->save()){
			return print_r($modelLog->save());
		}
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    

    /**
     * Finds the InboundWhTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InboundWhTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InboundWhTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelJoinOutbound($id)
    {
       $model = InboundWhTransfer::find()->select([
									'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
									'outbound_wh_transfer.no_sj',
									'instruction_wh_transfer.wh_origin',
									'instruction_wh_transfer.wh_destination',
									'inbound_wh_transfer.status_listing',
									'inbound_wh_transfer.arrival_date',
									'inbound_wh_transfer.created_date',
									'inbound_wh_transfer.updated_date',
								])
								->joinWith('idOutboundWh.idInstructionWh')->one();
		return $model;
    }
}
