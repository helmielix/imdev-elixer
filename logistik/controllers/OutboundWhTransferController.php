<?php

namespace logistik\controllers;

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
use common\models\MasterSn;
use common\models\LogMasterSn;
use common\models\UploadForm;
use common\models\Reference;
use common\models\UserWarehouse;
use common\models\Warehouse;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Worksheet;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\widgets\Displayerror;
use common\widgets\Email;

use kartik\mpdf\Pdf;

/**
 * OutboundWhTransferController implements the CRUD actions for OutboundWhTransfer model.
 */
class OutboundWhTransferController extends Controller
{
    private $id_modul = 1;
	private $last_transaction = 'TAG SN OUTBOUND WH ';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'downloadfile' => ['POST'],
                ],
            ],
        ];
    }
	
	protected function getIdWarehouse(){
    	$arrIdWarehouse = [];
    	if (Yii::$app->user->identity->wh_level == 1 || Yii::$app->user->identity->id == 5){
    		$modelUserWarehouse = Warehouse::find()->select('id as id_warehouse')->asArray()->all();
    	}else{
    		$modelUserWarehouse = UserWarehouse::find()->select('id_warehouse')->where(['id_user'=>Yii::$app->user->identity->id])->asArray()->all();
    	}

        foreach ($modelUserWarehouse as $key => $value) {
        	array_push($arrIdWarehouse, $value['id_warehouse']);
        }

        return $arrIdWarehouse;
    }

    /**
     * Lists all OutboundWhTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchOutboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'tagsn', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexprintsj()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchOutboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'printsj', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove(){
		$arrIdWarehouse = $this->getIdWarehouse();
		$searchModel = new SearchOutboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approve', $arrIdWarehouse);

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

	private function detailView($id){
		$model = $this->findModel($id);

		Yii::$app->session->set('idInstWhTr', $id);

		$searchModel = new SearchOutboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		return [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
	}

    public function actionView($id)
    {
		$this->layout = 'blank';

		return $this->render('view', $this->detailView($id));
    }

	public function actionViewapprove($id)
    {
		$this->layout = 'blank';

		return $this->render('view', $this->detailView($id));
    }

	public function actionViewprintsj($id)
    {
		$this->layout = 'blank';

		$output = $this->detailView($id);
		$model = $output['model'];
		if ( $model->print_time == null ){
			$model->print_time = date('Y-m-d H:i:s');
		}
		$model->save();

		return $this->render('viewprint', $output);
    }



	public function actionViewinstruction($id){
		$this->layout = 'blank';
		$model = InstructionWhTransfer::findOne($id);

		$searchModel = new SearchInstructionWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

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
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $idOutboundWhDetail);

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

			$model->save();

			// create OutboundWhTransferDetail
			$modelInstructionDetail = InstructionWhTransferDetail::find()->andWhere(['id_instruction_wh' => $id])->all();
			foreach($modelInstructionDetail as $value){
				$modelDetail = new OutboundWhTransferDetail();

				$modelDetail->id_outbound_wh		= $value->id_instruction_wh;
				$modelDetail->id_item_im			= $value->id_item_im;
				$modelDetail->req_good				= $value->req_good;
				$modelDetail->req_not_good			= $value->req_not_good;
				$modelDetail->req_revocation			= $value->req_revocation;
				$modelDetail->req_dismantle	= $value->req_dismantle;
				$modelDetail->req_revocation= $value->req_revocation;
				$modelDetail->req_revocation1= $value->req_revocation1;
				$modelDetail->req_revocation2= $value->req_revocation2;
				$modelDetail->status_listing		= ($value->idMasterItemIm->sn_type == 1) ? 999 : 41;


				if (!$modelDetail->save()){
					$error = $modelDetail->getErrors();
					$model->delete();
					return Displayerror::pesan($error);
				}
			}


		}

        $model = $this->findModel($id);

		$searchModel = new SearchOutboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		Yii::$app->session->set('idOutboundWh', $id);

        return $this->render('create', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);

    }

    public function actionViewoutbound($id)
    {
        $this->layout ='blank';
        $model = $this->findModel($id);

		$searchModel = new SearchOutboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		Yii::$app->session->set('idOutboundWh', $id);

        return $this->render('create', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
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

	public function actionSubmitsn($id){
		$model = $this->findModel($id);

		if ($model->status_listing == 3){
			$model->status_listing = 2;
		}else{
			$modelOutboundWhDetail = OutboundWhTransferDetail::find()->where(['id_outbound_wh'=> $id])->asArray()->all();
			$cekStatus = 1;
			foreach($modelOutboundWhDetail as $key => $value){
				if($value['status_listing'] != 41){
					$cekStatus++;
				}
			}

			if($cekStatus == 1){
				$modelOutbound = $this->findModel($id);
				$modelOutbound->status_listing = 42;
				$modelOutbound->save();
			}else{
                $modelOutbound = $this->findModel($id);
				$modelOutbound->status_listing = 43;
				$modelOutbound->save();
            }
		}

		$model->save();

		return 'success';
	}

    public function actionSubmitsj($id)
    {
        $model = $this->findModel($id);

		// if ($model->status_listing == 22){
			// return 'failed';
		// }

        if ($model->load(Yii::$app->request->post())) {
			// $model->driver = $_POST['OutboundWhTransfer']['driver'];
			// $model->forwarder = $_POST['OutboundWhTransfer']['forwarder'];
			// $model->plate_number = $_POST['OutboundWhTransfer']['plate_number'];
			$model->no_sj = substr($model->idInstructionWh->instruction_number, 0, 4).'/SJ-Jakarta-Div1/'.date('m/Y');
			$model->status_listing = 22;

			$model->save();
			return 'success';
        }
    }

	public function actionRevise($id){
		// revise for new instruction
		$model = InstructionWhTransfer::findOne($id);

		if ($model->status_listing == 25){
			// status listing outbound bukan approve
			return 'Cannot revise. Data has been approve';;
		}

		if ( Yii::$app->request->post('InstructionWhTransfer')['revision_remark'] != '' ){
			$model->status_listing = 3;
			$model->revision_remark = Yii::$app->request->post('InstructionWhTransfer')['revision_remark'];

			$model->save();

			return 'success';
		}else{
			return 'Please insert Revision Remark';
		}
	}

	public function actionApprove($id){
		$model = $this->findModel($id);

		if ($model->status_listing == 22){
			$model->status_listing = 25;
			$model->published_date = date('Y-m-d');

			// change all SN to INTRANSIT
            $modeldetailsn = OutboundWhTransferDetailSn::find()->joinWith('idOutboundWhDetail')->andWhere(['id_outbound_wh' => $model->id_instruction_wh])->all();
			// foreach( $model->outboundWhTransferDetails->outboundWhTransferDetailSns as $modelsn){
			foreach( $modeldetailsn as $modelsn){
				if (is_string($modelsn->serial_number)){
					$where = ['serial_number' => $modelsn->serial_number];
				}else{
					$where = ['mac_address' => $modelsn->mac_address];
				}
				$modelMasterSn = MasterSn::find()->andWhere($where)->andWhere(['status' => 27])->one();
				$modelMasterSn->last_transaction = 'INTRANSIT';
				$modelMasterSn->save();
				$this->createLogmastersn($modelMasterSn);

			}
            
            $model->save();

			return 'success';
		}else{
			return 'failed';
		}
	}

	public function actionReviseoutbound($id){
		$model = $this->findModel($id);

		if ($model->status_listing != 22){
			// status listing instruction bukan approve
			return 'failed';
		}

		if (Yii::$app->request->isPost){
			$model->status_listing = 3;
			$model->revision_remark = Yii::$app->request->post('OutboundWhTransfer')['revision_remark'];

			$model->save();

			return 'success';
		}

	}

	public function actionRestore($idOutboundWhDetail, $id){
		// OutboundWhTransferDetailSn::deleteAll('id_outbound_wh_detail = '.$idOutboundWhDetail);
		$modeldetailsn = OutboundWhTransferDetailSn::find()->andWhere(['id_outbound_wh_detail' => $idOutboundWhDetail])->all();
		foreach($modeldetailsn as $modelsn){
			if ( is_string($modelsn->serial_number) ){
				$where = ['serial_number' => $modelsn->serial_number];
			}else{
				$where = ['mac_address' => $modelsn->mac_address];
			}
			$modelMasterSn = MasterSn::find()->andWhere($where)->andWhere(['status' => 27])->one();
			$modelMasterSn->last_transaction = $modelMasterSn->prev_last_transaction;
			$modelMasterSn->condition = $modelMasterSn->last_condition;
			$modelMasterSn->save();
			$this->createLogmastersn($modelMasterSn);

			$modelsn->delete();
		}

		$model = OutboundWhTransferDetail::findOne($idOutboundWhDetail);
		$model->status_listing = 999;
		$model->save();

        $modelOutbound = $model->idOutboundWh;
        $modelOutbound->status_listing = 43;
        $modelOutbound->save();


		return $this->actionCreate($id);
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

					//get max quantity based on detail
					$modelDetail = OutboundWhTransferDetail::findOne($id);
					$maxQtyGood 			= $modelDetail->req_good;
					$maxQtyNotGood 			= $modelDetail->req_not_good;
					$maxQtyReject 			= $modelDetail->req_revocation;
					$maxQtyDismantle 	= $modelDetail->req_dismantle;
					$maxQtyRevocation = $modelDetail->req_revocation;
					$maxQtyRevocation1 = $modelDetail->req_revocation1;
					$maxQtyRevocation2 = $modelDetail->req_revocation2;

					//get quantity already upload
					$modelSn = OutboundWhTransferDetailSn::find()->andWhere(['id_outbound_wh_detail' => $id]);
					$qtyGood 			= $modelSn->andWhere(['condition' => 'good'])->count();
					$qtyNotGood 		= $modelSn->andWhere(['condition' => 'not good'])->count();
					$qtyReject 			= $modelSn->andWhere(['condition' => 'reject'])->count();
					$qtyDismantle 	= $modelSn->andWhere(['condition' => 'dismantle'])->count();
					$qtyRevocation= $modelSn->andWhere(['condition' => 'revocation'])->count();
					$qtyRevocation1= $modelSn->andWhere(['condition' => 'revocation1'])->count();
					$qtyRevocation2= $modelSn->andWhere(['condition' => 'revocation2'])->count();

					$newIdSn = [];
					foreach ($datas as $key => $data) {
						// periksa setiap kolom yang wajib ada, hanya di awal row
						if ($row == 2) {
							$missCol = array_diff_key($reqCol,$data);
							if (count($missCol) > 0) {
								return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
							}
						}

						if ($data['SERIAL_NUMBER'] == '' && $data['MAC_ADDRESS'] == '' && $data['CONDITION'] == ''){
							continue;
						}

						$modelSn = new OutboundWhTransferDetailSn();

						$modelSn->id_outbound_wh_detail = $id;
						$modelSn->serial_number = (string)$data['SERIAL_NUMBER'];
						$modelSn->mac_address = (string)$data['MAC_ADDRESS'];
						$modelSn->condition = strtolower($data['CONDITION']);

						switch($modelSn->condition){
							case 'good':
								$qtyGood++;
							break;
							case 'not good':
								$qtyNotGood++;
							break;
							case 'reject':
								$qtyReject++;
							break;
							case 'dismantle':
								$qtyDismantle++;
							break;
							case 'revocation':
								$qtyRevocation++;
							break;
							case 'revocation1':
								$qtyRevocation1++;
							break;
							case 'revocation2':
								$qtyRevocation2++;
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

						if ($qtyDismantle > $maxQtyDismantle){
							$maxErr = 'Quantity Dismantle cannot be more than '. $maxQtyDismantle;
						}

						if ($qtyRevocation > $maxQtyRevocation){
							$maxErr = 'Quantity Revocation cannot be more than '. $maxQtyRevocation;
						}

						if ($qtyRevocation1 > $maxQtyRevocation1){
							$maxErr = 'Quantity Revocation1 cannot be more than '. $maxQtyRevocation1;
						}

						if ($qtyRevocation2 > $maxQtyRevocation2){
							$maxErr = 'Quantity Revocation2 cannot be more than '. $maxQtyRevocation2;
						}

						if ($maxErr != ''){
							// delete new data only
							OutboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
							return $maxErr;
						}

						if(!$modelSn->save()) {
							// delete new data only
							OutboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
							$error = $modelSn->getErrors();
							$error['line'] = [$periksa.$row];
							return Displayerror::pesan($modelSn->getErrors());
						}

						// simpan data di mastersn
						if ( is_string( $modelSn->serial_number ) ){
							$where = ['serial_number' => $modelSn->serial_number];
						}else{
							$where = ['mac_address' => $modelSn->mac_address];
						}
						$modelMasterSn = MasterSn::find()
							->andWhere($where)
							->andWhere(['status' => 27])
							->one();
						if ($modelMasterSn === null){
							// tidak ada di master SN
                            OutboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
							return 'Serial number: '.$modelSn->serial_number.' tidak terdaftar dalam sistem';
						}

						$modelMasterSn->last_transaction = $this->last_transaction.$modelDetail->idOutboundWh->idInstructionWh->whOrigin->nama_warehouse;
						$modelMasterSn->condition = $modelSn->condition;
						$modelMasterSn->save();
						$this->createLogmastersn($modelMasterSn);
						// simpan data di mastersn


						$newIdSn[] = $modelSn->id;
						$row++;
					}

					if ($maxQtyGood == $qtyGood &&
						$maxQtyNotGood == $qtyNotGood &&
						$maxQtyReject == $qtyReject &&
						$maxQtyDismantle == $qtyDismantle &&
						$maxQtyRevocation == $qtyRevocation &&
						$maxQtyRevocation1 == $qtyRevocation1 &&
						$maxQtyRevocation2 == $qtyRevocation2){
							$modelDetail->status_listing = 41;
							$modelDetail->save();
					}else{
						$modelDetail->status_listing = 43;
						$modelDetail->save();
					}

					// $modelOutboundWhDetail = OutboundWhTransferDetail::find()->where(['id_outbound_wh'=> $modelDetail->id_outbound_wh])->asArray()->all();
					// $cekStatus = 1;
					// foreach($modelOutboundWhDetail as $key => $value){
					// 	if($value['status_listing'] != 41){
					// 		$cekStatus++;
					// 	}
					// }
                    //
					// if($cekStatus == 1){
					// 	$modelOutbound = $this->findModel(\Yii::$app->session->get('idOutboundWh'));
					// 	$modelOutbound->status_listing = 42;
					// 	$modelOutbound->save();
					// }

					return 'success';

				}
			}
		}

		return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
	}

	public function actionDownloadfile($id, $relation = ''){
		if ($id == 'template' || $id == 'templatemac'){
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

				// hide mac address column
				if ($id == 'template'){
					$excel2->getActiveSheet()->getColumnDimension('B')->setVisible(false);
				}else{
					$excel2->getActiveSheet()->getColumnDimension('B')->setVisible(true);
				}

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
				// return $file;
                throw new NotFoundHttpException('The requested page does not exist.');
            }
		}else if ($id == 'instruction'){
			$file = Yii::getAlias('@webroot') . '/uploads/TemplateInputSN.xlsx';

			if (file_exists($file)) {
				return Yii::$app->response->sendFile($file);
			}else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
		}

		$request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;

		if ($relation == 'instruction'){
			$model = InstructionWhTransfer::findOne($id);
			$basepath = Yii::getAlias('@webroot') . '/';
			$path = ArrayHelper::getValue($model, $params['data'], 'Unknown');
		}

		$file = $basepath.$path;

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

	public function actionExportsj($id){
		$this->layout = 'blank';
		$arrayreturn = $this->detailView($id);
		$model = $arrayreturn['model'];
		$dataprovider = $arrayreturn['dataProvider'];
		$dataprovider->sort = false;
		$arrayreturn['dataProvider'] = $dataprovider;

		$modelDetail = OutboundWhTransferDetail::find()->joinWith('idMasterItemIm')->select([
			'outbound_wh_transfer_detail.id_item_im',
			'outbound_wh_transfer_detail.req_good',
			'outbound_wh_transfer_detail.req_not_good',
			'outbound_wh_transfer_detail.req_dismantle',
			'outbound_wh_transfer_detail.req_revocation',
			'outbound_wh_transfer_detail.req_revocation1',
			'outbound_wh_transfer_detail.req_revocation2',
			'master_item_im.im_code',
			'master_item_im.name as item_name',
			'master_item_im.brand',
		])->where(['id_outbound_wh' => $id])->all();

		return $this->render('viewprintpdf', [
				'model' => $model,
				'modelDetail' => $modelDetail,
				'dataProvider' => $dataprovider
			]);
	}

	public function actionExportpdf($id) {

		$arrayreturn = $this->detailView($id);
		$model = $arrayreturn['model'];
		$dataprovider = $arrayreturn['dataProvider'];
		$dataprovider->sort = false;
		$arrayreturn['dataProvider'] = $dataprovider;

		// return $this->render('viewprintpdf', $arrayreturn);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('viewprint', $arrayreturn),
            'filename'=> 'Surat_jalan.pdf',
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

    public function actionExportinstruction($id) {


		$model = InstructionWhTransfer::findOne($id);
        $searchModel = new SearchInstructionWhTransferDetail();
        $dataprovider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);
		$dataprovider->sort = false;

		$arrayreturn['model'] = $model;
		$arrayreturn['dataProvider'] = $dataprovider;
		$arrayreturn['searchModel'] = null;


        $pdf = new Pdf([
            // 'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('//instruction-wh-transfer/view', $arrayreturn),
            'filename'=> 'instruction_warehouse_transfer.pdf',
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'options' => [
                'title' => 'Instruction warehouse transfer '.$model->instruction_number,

            ],
            'methods' => [
                'SetHeader' => ['Instruction Warehouse'],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
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
	
	private function createLogmastersn($model){
		$modelLog = new LogMasterSn();
        $modelLog->setAttributes($model->attributes);
		if(!$modelLog->save()){
			throw new NotFoundHttpException(Displayerror::pesan($modelLog->getErrors()));
			return Displayerror::pesan($modelLog->getErrors());
		}
		
	}
}
