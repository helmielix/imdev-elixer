<?php

namespace divisisatu\controllers;

use Yii;
use common\models\OutboundWhTransfer;
use common\models\OutboundWhTransferDetail;
use common\models\OutboundWhTransferDetailSn;
use common\models\SearchOutboundWhTransfer;
use common\models\SearchOutboundWhTransferDetail;
use common\models\SearchOutboundWhTransferDetailSn;
use common\models\InstructionWhTransfer;
use common\models\InstructionWhTransferDetail;
use common\models\SearchInstructionWhTransferDetail;
use common\models\UploadForm;
use common\models\Reference;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Worksheet;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\widgets\Displayerror;
use common\widgets\Email;

/**
 * OutboundWhTransferController implements the CRUD actions for OutboundWhTransfer model.
 */
class OutboundWhTransferController extends Controller
{
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
     * Lists all OutboundWhTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchOutboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'tagsn');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexprintsj()
    {
        $searchModel = new SearchOutboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'printsj');

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
    public function actionView($id)
    {
		$this->layout = 'blank';
		
		$model = $this->findModel($id);
		
		$searchModel = new SearchOutboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
    }
	
	public function actionViewinstruction($id){
		$this->layout = 'blank';
		$model = InstructionWhTransfer::findOne($id);
		
		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
		
		return $this->render('//instruction-wh-transfer/view', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	public function actionViewdetailsn($idOutboundWhDetail){
		$this->layout = 'blank';
		$model = OutboundWhTransferDetail::findOne($idOutboundWhDetail);
		
		$searchModel = new SearchOutboundWhTransferDetailSn();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $idOutboundWhDetail);
		
		return $this->render('viewdetailsn', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Creates a new OutboundWhTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id , $act = null)
    {
		$this->layout = 'blank';
		if ($act == 'view'){
			// create OutboundWhTransfer
			$modelInstruction = InstructionWhTransfer::findOne($id);
			$model = new OutboundWhTransfer();
			
			$model->id_instruction_wh = $modelInstruction->id;
			$model->status_listing = 43; // Partially Uploaded
			$model->id_modul = $this->id_modul;
			$model->no_sj = substr($modelInstruction->instruction_number, 0, 4).'/SJ-Jakarta-Div1/'.date('m/Y');
			
			$model->save();
			
			// create OutboundWhTransferDetail
			$modelInstructionDetail = InstructionWhTransferDetail::find()->andWhere(['id_instruction_wh' => $id])->all();
			foreach($modelInstructionDetail as $value){
				$modelDetail = new OutboundWhTransferDetail();
				
				$modelDetail->id_outbound_wh		= $value->id_instruction_wh;
				$modelDetail->id_item_im			= $value->id_item_im;				
				$modelDetail->req_good				= $value->req_good;
				$modelDetail->req_not_good			= $value->req_not_good;
				$modelDetail->req_reject			= $value->req_reject;
				$modelDetail->req_good_dismantle	= $value->req_good_dismantle;
				$modelDetail->req_not_good_dismantle= $value->req_not_good_dismantle;
				$modelDetail->status_listing		= ($value->idMasterItemIm->sn_type == 1) ? 999 : 43;
				
				
				$modelDetail->save();
			}
			
		}
		
        $model = $this->findModel($id);
		
		$searchModel = new SearchOutboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
				
		Yii::$app->session->set('idOutboundWh', $id);

        // if ($model->load(Yii::$app->request->post())) {
			
			// if (!$model->save()){
				// return Displayerror::pesan($model->getErrors());
			// }
            // return $this->redirect(['view', 'id' => $model->id_instruction_wh]);
        // } else {
            return $this->render('create', [
                'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
            ]);
        // }
    }

    /**
     * Updates an existing OutboundWhTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_instruction_wh]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSubmitsj($id)
    {
        $model = $this->findModel($id);

        // if ($model->load(Yii::$app->request->post())) {
        // return print_r($_POST['OutboundWhTransfer']['plate_number']);
    	$model->driver = $_POST['OutboundWhTransfer']['driver'];
    	$model->forwarder = $_POST['OutboundWhTransfer']['forwarder'];
    	$model->plate_number = $_POST['OutboundWhTransfer']['plate_number'];
    	$model->status_listing = 25;
    	$model->save();
        return 'success';
        // } 
    }
	
	public function actionReviseinstruction($id){
		$model = InstructionWhTransfer::findOne($id);
		
		if ($model->status_listing != 5){
			// status listing instruction bukan approve
			return 'failed';
		}
		
		if (Yii::$app->request->isPost){
			$model->status_listing = 3;
			$model->revision_remark = Yii::$app->request->post('InstructionWhTransfer')['revision_remark'];
			
			$model->save();
			
			return 'success';
		}
		
	}
	
	public function actionUploadsn($id){
		$this->layout = 'blank';
		$model = new UploadForm();
		
		$model->scenario = 'xls';
		
		if (Yii::$app->request->isPost){
			if (isset($_FILES['file']['size'])){
				if($_FILES['file']['size'] != 0){
					$filename=('uploads/'.$_FILES['file']['name']);
					move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.basename( $_FILES['file']['name']));
					$datas = \moonland\phpexcel\Excel::import($filename, [
						'setFirstRecordAsKeys' => true,
						// 'setIndexSheetByName' => true,
						// 'getOnlySheet' => 'Sheet1'
					]);
					if(isset($datas[0][0])){
						$datas = $datas[0];
					}
					//OutboundWhTransferDetailSn::deleteAll('id_outbound_wh_detail = '.Yii::$app->session->get('idOutboundWhTransferDetail'));
					$row = 2;
					$periksa = "\nplease check on row ";
					$reqCol = [
						'SERIAL_NUMBER' => '',
						'MAC_ADDRESS' => '',
						'CONDITION' => '',
					];
					
					$modelDetail = OutboundWhTransferDetail::findOne($id);
					$maxQtyGood 			= $modelDetail->req_good;
					$maxQtyNotGood 			= $modelDetail->req_not_good;
					$maxQtyReject 			= $modelDetail->req_reject;
					$maxQtyGoodDismantle 	= $modelDetail->req_good_dismantle;
					$maxQtyNotGoodDismantle = $modelDetail->req_not_good_dismantle;
					
					$modelSn = OutboundWhTransferDetailSn::find()->andWhere(['id_outbound_wh_detail' => $id]);
					$qtyGood 			= $modelSn->andWhere(['condition' => 'Good'])->count();
					$qtyNotGood 		= $modelSn->andWhere(['condition' => 'Not Good'])->count();
					$qtyReject 			= $modelSn->andWhere(['condition' => 'Reject'])->count();
					$qtyGoodDismantle 	= $modelSn->andWhere(['condition' => 'Good Dismantle'])->count();
					$qtyNotGoodDismantle= $modelSn->andWhere(['condition' => 'Not Good Dismantle'])->count();
					
					foreach ($datas as $key => $data) {
						// periksa setiap kolom yang wajib ada, hanya di awal row
						if ($row == 2) {
							$missCol = array_diff_key($reqCol,$data);
							if (count($missCol) > 0) {
								OutboundWhTransferDetailSn::deleteAll('id_outbound_wh_detail = '.$id);
								return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
							}
						}
						$modelSn = new OutboundWhTransferDetailSn();

						$modelSn->id_outbound_wh_detail = $id;
						$modelSn->serial_number = (string)$data['SERIAL_NUMBER'];
						$modelSn->mac_address = (string)$data['MAC_ADDRESS'];
						$modelSn->condition = $data['CONDITION'];
						
						switch($modelSn->condition){
							case 'Good':
								$qtyGood++;
							break;
							case 'Not Good':
								$qtyNotGood++;
							break;
							case 'Reject':
								$qtyReject++;
							break;
							case 'Good Dismantle':
								$qtyGoodDismantle++;
							break;
							case 'Not Good Dismantle':
								$qtyNotGoodDismantle++;
							break;
						}
						
						$maxErr = '';
						if ($qtyGood > $maxQtyGood){
							$maxErr = 'Quantity Good cannot be more than '. $maxQtyGood;
						}
						
						if ($qtyNotGood > $maxQtyNotGood){
							$maxErr = 'Quantity Not Good cannot be more than '. $maxQtyNotGood;
						}
						
						if ($qtyReject > $maxQtyReject){
							$maxErr = 'Quantity Reject cannot be more than '. $maxQtyReject;
						}
						
						if ($qtyGoodDismantle > $maxQtyGoodDismantle){
							$maxErr = 'Quantity Good Dismantle cannot be more than '. $maxQtyGoodDismantle;
						}
						
						if ($qtyNotGoodDismantle > $maxQtyNotGoodDismantle){
							$maxErr = 'Quantity Not Good Dismantle cannot be more than '. $maxQtyNotGoodDismantle;
						}
						
						if ($maxErr != ''){
							OutboundWhTransferDetailSn::deleteAll('id_outbound_wh_detail = '.$id);
							return $maxErr;
						}

						if(!$modelSn->save()) {
							OutboundWhTransferDetailSn::deleteAll('id_outbound_wh_detail = '.$id);
							$error = $modelSn->getErrors();
							$error['line'] = [$periksa.$row];
							return Displayerror::pesan($modelSn->getErrors());
						}
						$row++;
					}
					
					if ($maxQtyGood == $qtyGood && 
						$maxQtyNotGood == $qtyNotGood && 
						$maxQtyReject == $qtyReject && 
						$maxQtyGoodDismantle == $qtyGoodDismantle && 
						$maxQtyNotGoodDismantle == $qtyNotGoodDismantle){
							$modelDetail->status_listing = 41;
							$modelDetail->save();
					}else{
						$modelDetail->status_listing = 43;
						$modelDetail->save();
					}
					
					$modelOutboundPoDetail = OutboundWhTransferDetail::find()->where(['id_outbound_wh'=> $modelDetail->id_outbound_wh])->asArray()->all();
					$cekStatus = 1;
					foreach($modelOutboundPoDetail as $key => $value){
						if($value['status_listing'] != 41){
							$cekStatus++;
						}
					}
					
					if($cekStatus == 1){
						$modelOutbound = $this->findModel(\Yii::$app->session->get('idOutboundWh'));
						$modelOutbound->status_listing = 42;
						$modelOutbound->save();
					}
					
					return 'success';
					
				}
			}
		}
		
		return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
	}
	
	public function actionDownloadfile($id){
		if ($id == 'template'){
			$file = Yii::getAlias('@webroot') . '/uploads/TemplateInputSN.xlsx';
			$fileOut7 = Yii::getAlias('@webroot') . '/uploads/TemplateInputSN.xlsx';
			if (file_exists($file)) {
				// modify file before download
                $objPHPExcel = new \PHPExcel();
                $excel2 = \PHPExcel_IOFactory::createReader('Excel2007');
                $excel2 = $excel2->load($file);
				
				$excel2->setActiveSheetIndex(1);
                $modelCondition = Reference::find()->andWhere(['table_relation' => ['good_type', 'dismantle_type']])->orderBy('id_grouping asc')->all();
                if ($modelCondition !== null) {
                    $col = 1; //col B (index 0) (position)
                    $row = 2;
                    foreach ($modelCondition  as $key => $value) {
                        $excel2->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $modelCondition[$key]->description);
                        $rowpos = $row;
                        $row++;
                    }
                }
				
				$valRow = 2500;
				$excel2->setActiveSheetIndex(0);
				
				// CONDITION
                $objValidation = $excel2->getActiveSheet()->getCell('C2')->getDataValidation();
                $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
                $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setFormula1('=Sheet2!$B$2:$B$'.$rowpos);
                for ($i=3; $i <= $valRow; $i++) {
                    $excel2->getActiveSheet()->getCell("C$i")->setDataValidation(clone $objValidation);
                }
                // CONDITION
				
				$excel2->getSheetByName('Sheet2')
                    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
					
				$objWriter = \PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
                $objWriter->save($fileOut7);
                return Yii::$app->response->sendFile($fileOut7);
			}else {
				return $file;
                // throw new NotFoundHttpException('The requested page does not exist.');
            }
		}
	}

    /**
     * Deletes an existing OutboundWhTransfer model.
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
     * Finds the OutboundWhTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OutboundWhTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OutboundWhTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
