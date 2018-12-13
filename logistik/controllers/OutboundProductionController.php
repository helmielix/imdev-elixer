<?php

namespace logistik\controllers;

use Yii;
use common\models\OutboundProduction;
use common\models\OutboundProductionDetail;
// use common\models\OutboundProductionDetailSn;
use common\models\OutboundProductionDetailSetItem;
use common\models\SearchOutboundProduction;
use common\models\SearchOutboundProductionDetailSetItem;
use common\models\OutboundProductionDetailSetItemSn;
use common\models\SearchOutboundProductionDetail;
use common\models\SearchOutboundProductionDetailSn;
use common\models\InstructionProduction;
use common\models\InstructionProductionDetail;
use common\models\InstructionProductionDetailSetItem;
use common\models\SearchInstructionProductionDetail;
use common\models\MasterSn;
use common\models\MasterItemIm;
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
 * OutboundProductionController implements the CRUD actions for OutboundProduction model.
 */
class OutboundProductionController extends Controller
{
    private $id_modul = 1;
	private $last_transaction = 'TAG SN OUTBOUND Production ';
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
     * Lists all OutboundProduction models.
     * @return mixed
     */
    public function actionIndex()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchOutboundProduction();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'tagsn', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexprintsj()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchOutboundProduction();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'printsj', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove(){
		$arrIdWarehouse = $this->getIdWarehouse();
		$searchModel = new SearchOutboundProduction();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approve', $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Displays a single OutboundProduction model.
     * @param integer $id
     * @return mixed
     */

	private function detailView($id){
		$model = $this->findModel($id);

		Yii::$app->session->set('idOutboundProd', $id);

		$searchModel = new SearchOutboundProductionDetail();
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
		$model = InstructionProduction::findOne($id);

		$searchModel = new SearchInstructionProductionDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		return $this->render('//instruction-production/view', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionViewdetailsn($idOutboundProDetail){
		$this->layout = 'blank';
		$model = OutboundProductionDetail::findOne($idOutboundProDetail);

		$searchModel = new SearchOutboundProductionDetailSn();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $idOutboundProDetail);

		return $this->render('viewdetailsn', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    /**
     * Creates a new OutboundProduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id , $act = null)
    {
		$this->layout = 'blank';
		if ($act == 'view'){
			// create OutboundProduction
			$modelInstruction = InstructionProduction::findOne($id);
			$model = new OutboundProduction();

			$model->id_instruction_production = $modelInstruction->id;
			$model->status_listing = 43; // Partially Uploaded
			$model->id_modul = $this->id_modul;

			// $model->save();
			if(!$model->save())return print_r($model->getErrors());

			// create OutboundProductionDetail
			$modelInstructionDetail = InstructionProductionDetail::find()->andWhere(['id_instruction_production' => $id])->all();
			foreach($modelInstructionDetail as $value){
				$modelDetail = new OutboundProductionDetail();

				$modelDetail->id_outbound_production		= $value->id_instruction_production;
				$modelDetail->id_item_im			= $value->id_item_im;
				$modelDetail->qty				= $value->qty;

				if (!$modelDetail->save()){
					$error = $modelDetail->getErrors();
					$model->delete();
					return Displayerror::pesan($error);
				}

				$modelInstructionDetailItem = InstructionProductionDetailSetItem::find()->andWhere(['id_instruction_production_detail'=>$value->id])->all();

				foreach ($modelInstructionDetailItem as $val) {
					$modelMasterItem = MasterItemIm::findOne($val->id_item_set);

					$modelDetailItem = new OutboundProductionDetailSetItem();
					$modelDetailItem->id_outbound_production_detail = $modelDetail->id;
					$modelDetailItem->id_item_set = $val->id_item_set;
					$modelDetailItem->req_good = $val->req_good;
					$modelDetailItem->req_dis_good = $val->req_dis_good;
					$modelDetailItem->req_good_recond = $val->req_good_recond;
					$modelDetailItem->total = $val->total;
					$modelDetailItem->sn_type = $modelMasterItem->sn_type;

					if (!$modelDetailItem->save()){
						$error = $modelDetail->getErrors();
						$model->delete();
						return Displayerror::pesan($error);
					}
				}

				// $modelDetail->req_not_good			= $value->req_not_good;
				// $modelDetail->req_reject			= $value->req_reject;
				// $modelDetail->req_good_dismantle	= $value->req_good_dismantle;
				// $modelDetail->req_not_good_dismantle= $value->req_not_good_dismantle;
				// $modelDetail->status_listing		= ($value->idMasterItemIm->sn_type == 1) ? 999 : 41;


				
			}


		}

        $model = $this->findModel($id);

		$searchModel = new SearchOutboundProductionDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		Yii::$app->session->set('idOutboundProd', $id);

        return $this->render('create', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);

    }

    public function actionCreateItemSn($id = null){
    	$this->layout = 'blank';
    	$model = OutboundProductionDetail::findOne($id);

		$searchModel = new SearchOutboundProductionDetailSetItem();
        $dataProvider = $searchModel->searchByParent(Yii::$app->request->getQueryParams(), $id);

		Yii::$app->session->set('idOutboundProdDetail', $id);

        return $this->render('viewdetail_sn_upload', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }

    public function actionViewoutbound($id)
    {
        $this->layout ='blank';
        $model = $this->findModel($id);

		$searchModel = new SearchOutboundProductionDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

		Yii::$app->session->set('idOutboundProd', $id);

        return $this->render('create', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }

    /**
     * Updates an existing OutboundProduction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_instruction_production]);
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
			$modelOutboundWhDetail = OutboundProductionDetail::find()->where(['id_outbound_production'=> $id])->asArray()->all();
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
        	if (isset($_FILES['file'])) {
				if (isset($_FILES['file']['size'])) {
					if($_FILES['file']['size'] != 0) {
						$model->file = $_FILES['file'];
						$filename = $_FILES['file']['name'];
						$filepath = 'uploads/OUTPROD/';
					}
				}
			}
			// $model->driver = $_POST['OutboundProduction']['driver'];
			// $model->forwarder = $_POST['OutboundProduction']['forwarder'];
			// $model->plate_number = $_POST['OutboundProduction']['plate_number'];
			$model->no_sj = substr($model->idInstructionProduction->instruction_number, 0, 4).'/SJ-Jakarta-Div1/'.date('m/Y');
			$model->status_listing = 22;
			$model->file_attachment = $filepath.$model->id_instruction_production.'/'.$filename;
			if(!$model->save())return print_r($model->getErrors());
			// $model->save();
			// $model->save();
			return 'success';
        }
    }

	public function actionRevise($id){
		// revise for new instruction
		$model = InstructionProduction::findOne($id);

		if ($model->status_listing == 25){
			// status listing outbound bukan approve
			return 'Cannot revise. Data has been approve';;
		}

		if ( Yii::$app->request->post('InstructionProduction')['revision_remark'] != '' ){
			$model->status_listing = 3;
			$model->revision_remark = Yii::$app->request->post('InstructionProduction')['revision_remark'];

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
   //          $modeldetailsn = OutboundProductionDetailSn::find()->joinWith('idOutboundProDetail')->andWhere(['id_outbound_production' => $model->id_instruction_production])->all();
			// // foreach( $model->OutboundProductionDetails->OutboundProductionDetailSns as $modelsn){
			// foreach( $modeldetailsn as $modelsn){
			// 	if (is_string($modelsn->serial_number)){
			// 		$where = ['serial_number' => $modelsn->serial_number];
			// 	}else{
			// 		$where = ['mac_address' => $modelsn->mac_address];
			// 	}
			// 	$modelMasterSn = MasterSn::find()->andWhere($where)->andWhere(['status' => 27])->one();
			// 	$modelMasterSn->last_transaction = 'INTRANSIT';
			// 	$modelMasterSn->save();
			// 	$this->createLogmastersn($modelMasterSn);

			// }
            
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
			$model->revision_remark = Yii::$app->request->post('OutboundProduction')['revision_remark'];

			$model->save();

			return 'success';
		}

	}

	public function actionRestore($idOutboundProDetailSetItem, $id){
		// OutboundProductionDetailSn::deleteAll('id_outbound_production_detail = '.$idOutboundProDetail);
		$modeldetailsn = OutboundProductionDetailSetItemSn::find()->andWhere(['id_outbound_production_detail_set_item' => $idOutboundProDetailSetItem])->all();
		foreach($modeldetailsn as $modelsn){
			if ( is_string($modelsn->serial_number) ){
				$where = ['serial_number' => $modelsn->serial_number];
			}else{
				$where = ['mac_address' => $modelsn->mac_address];
			}
			// $modelMasterSn = MasterSn::find()->andWhere($where)->andWhere(['status' => 27])->one();
			// $modelMasterSn->last_transaction = $modelMasterSn->prev_last_transaction;
			// $modelMasterSn->condition = $modelMasterSn->last_condition;
			// $modelMasterSn->save();
			// $this->createLogmastersn($modelMasterSn);

			$modelsn->delete();
		}

		$model = OutboundProductionDetailSetItem::findOne($idOutboundProDetailSetItem);
		$model->status_listing = 999;
		$model->save();

        $modelOutbound = $model->idOutboundProductionDetail;
        $modelOutbound->status_listing = 43;
        $modelOutbound->save();


		return $this->actionCreateItemSn($id);
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
					//OutboundProductionDetailSn::deleteAll('id_outbound_production_detail = '.Yii::$app->session->get('idOutboundProductionDetail'));
					$row = 2;
					$periksa = "\nplease check on row ";
					$reqCol = [
						'SERIAL_NUMBER' => '',
						'MAC_ADDRESS' => '',
						'CONDITION' => '',
					];

					//get max quantity based on detail
					$modelDetail = OutboundProductionDetailSetItem::findOne($id);
					$maxQtyGood 			= $modelDetail->req_good;
					// $maxQtyNotGood 			= $modelDetail->req_not_good;
					// $maxQtyReject 			= $modelDetail->req_reject;
					$maxQtyGoodDismantle 	= $modelDetail->req_dis_good;
					$maxQtyGoodRecond = $modelDetail->req_good_recond;

					//get quantity already upload
					$modelSn = OutboundProductionDetailSetItemSn::find()->andWhere(['id_outbound_production_detail_set_item' => $id]);
					$qtyGood 			= $modelSn->andWhere(['condition' => 'good'])->count();
					// $qtyNotGood 		= $modelSn->andWhere(['condition' => 'not good'])->count();
					// $qtyReject 			= $modelSn->andWhere(['condition' => 'reject'])->count();
					$qtyGoodDismantle 	= $modelSn->andWhere(['condition' => 'good dismantle'])->count();
					$qtyGoodRecond= $modelSn->andWhere(['condition' => 'good recond'])->count();

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

						$modelSn = new OutboundProductionDetailSetItemSn();

						$modelSn->id_outbound_production_detail_set_item = $id;
						$modelSn->serial_number = (string)$data['SERIAL_NUMBER'];
						$modelSn->mac_address = (string)$data['MAC_ADDRESS'];
						$modelSn->condition = strtolower($data['CONDITION']);

						switch($modelSn->condition){
							case 'good':
								$qtyGood++;
							break;
							// case 'not good':
							// 	$qtyNotGood++;
							// break;
							// case 'reject':
							// 	$qtyReject++;
							// break;
							case 'good dismantle':
								$qtyGoodDismantle++;
							break;
							case 'good recond':
								$qtyGoodRecond++;
							break;
						}

						$maxErr = '';
						if ($qtyGood > $maxQtyGood){
							$maxErr = 'Quantity Good cannot be more than '. $maxQtyGood;
						}

						// if ($qtyNotGood > $maxQtyNotGood){
						// 	$maxErr = 'Quantity Not Good cannot be more than '. $maxQtyNotGood;
						// }

						// if ($qtyReject > $maxQtyReject){
						// 	$maxErr = 'Quantity Reject cannot be more than '. $maxQtyReject;
						// }

						if ($qtyGoodDismantle > $maxQtyGoodDismantle){
							$maxErr = 'Quantity Good Dismantle cannot be more than '. $maxQtyGoodDismantle;
						}

						if ($qtyGoodRecond > $maxQtyGoodRecond){
							$maxErr = 'Quantity Good Recond cannot be more than '. $maxQtyGoodRecond;
						}

						if ($maxErr != ''){
							// delete new data only
							OutboundProductionDetailSetItemSn::deleteAll(['id' => $newIdSn]);
							return $maxErr;
						}

						if(!$modelSn->save()) {
							// delete new data only
							OutboundProductionDetailSetItemSn::deleteAll(['id' => $newIdSn]);
							$error = $modelSn->getErrors();
							$error['line'] = [$periksa.$row];
							return Displayerror::pesan($modelSn->getErrors());
						}

						// simpan data di mastersn
						// if ( is_string( $modelSn->serial_number ) ){
						// 	$where = ['serial_number' => $modelSn->serial_number];
						// }else{
						// 	$where = ['mac_address' => $modelSn->mac_address];
						// }
						// $modelMasterSn = MasterSn::find()
						// 	->andWhere($where)
						// 	->andWhere(['status' => 27])
						// 	->one();
						// if ($modelMasterSn === null){
						// 	// tidak ada di master SN
      //                       OutboundProductionDetailSetItemSn::deleteAll(['id' => $newIdSn]);
						// 	return 'Serial number: '.$modelSn->serial_number.' tidak terdaftar dalam sistem';
						// }

						// $modelMasterSn->last_transaction = $this->last_transaction.$modelDetail->idOutboundProd->idInstructionProd->whOrigin->nama_warehouse;
						// $modelMasterSn->condition = $modelSn->condition;
						// $modelMasterSn->save();
						// $this->createLogmastersn($modelMasterSn);
						// simpan data di mastersn
						// $newIdSn[] = $modelSn->id;


						$row++;
					}

					if ($maxQtyGood == $qtyGood &&
						// $maxQtyNotGood == $qtyNotGood &&
						// $maxQtyReject == $qtyReject &&
						$maxQtyGoodDismantle == $qtyGoodDismantle &&
						$maxQtyGoodRecond == $qtyGoodRecond){
							$modelDetail->status_listing = 41;
							$modelDetail->save();
					}else{
						$modelDetail->status_listing = 43;
						$modelDetail->save();
					}

					// $modelOutboundWhDetail = OutboundProductionDetail::find()->where(['id_outbound_production'=> $modelDetail->id_outbound_production])->asArray()->all();
					// $cekStatus = 1;
					// foreach($modelOutboundWhDetail as $key => $value){
					// 	if($value['status_listing'] != 41){
					// 		$cekStatus++;
					// 	}
					// }
                    //
					// if($cekStatus == 1){
					// 	$modelOutbound = $this->findModel(\Yii::$app->session->get('idOutboundProd'));
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
				return $file;
                // throw new NotFoundHttpException('The requested page does not exist.');
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
			$model = InstructionProduction::findOne($id);
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

		$modelDetail = OutboundProductionDetail::find()->joinWith('idParameterMasterItem.idMasterItemIm')->select([
			'outbound_production_detail.id_item_im',
			'outbound_production_detail.req_good',
			'outbound_production_detail.req_not_good',
			'outbound_production_detail.req_good_dismantle',
			'outbound_production_detail.req_reject',
			'master_item_im.im_code',
			'master_item_im.name as item_name',
			'master_item_im.brand',
		])->where(['id_outbound_production' => $id])->all();

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


		$model = InstructionProduction::findOne($id);
        $searchModel = new SearchInstructionProductionDetail();
        $dataprovider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);
		$dataprovider->sort = false;

		$arrayreturn['model'] = $model;
		$arrayreturn['dataProvider'] = $dataprovider;
		$arrayreturn['searchModel'] = null;


        $pdf = new Pdf([
            // 'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('//instruction-production/view', $arrayreturn),
            'filename'=> 'instruction_production.pdf',
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'options' => [
                'title' => 'Instruction Production '.$model->instruction_number,

            ],
            'methods' => [
                'SetHeader' => ['Instruction Production'],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    /**
     * Deletes an existing OutboundProduction model.
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
     * Finds the OutboundProduction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OutboundProduction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OutboundProduction::findOne($id)) !== null) {
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
