<?php

namespace logistik\controllers;

use Yii;
use common\models\OutboundGrf;
use common\models\SearchOutboundGrf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\InstructionGrf;
use common\models\InstructionGrfDetail;
use common\models\GrfDetail;
use common\models\Grf;
use common\models\OutboundGrfDetail;
use common\models\OutboundGrfDetailSn;
use common\models\SearchInstructionGrf;
use common\models\SearchInstructionGrfDetail;
use common\models\SearchOutboundGrfDetail;
use common\models\SearchOutboundGrfDetailSn;
use common\models\SearchGrfDetail;
use common\widgets\Displayerror;
use common\models\UploadForm;
use common\models\Reference;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Worksheet;
use yii\helpers\ArrayHelper;
use common\widgets\Email;
use kartik\mpdf\Pdf;
use linslin\yii2\curl;

/**
 * OutboundGrfController implements the CRUD actions for OutboundGrf model.
 */
class OutboundGrfController extends Controller
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
     * Lists all OutboundGrf models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchOutboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'tagsn');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexprintsj()
    {
        $searchModel = new SearchOutboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'printsj');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndexapprove(){
        $searchModel = new SearchOutboundGrf();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approve');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function detailView($id){
        $model = $this->findModel($id);
        
        Yii::$app->session->set('idInstructionGrf', $id);
        
        $searchModel = new SearchOutboundGrfDetail();
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
        $model = InstructionGrf::findOne($id);
        
        $searchModel = new SearchGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
        
        return $this->render('//instruction-grf/viewapprove', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewdetailsn($idOutboundGrfDetail){
        $this->layout = 'blank';
        $model = OutboundGrfDetail::findOne($idOutboundGrfDetail);
        
        $searchModel = new SearchOutboundGrfDetailSn();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $idOutboundGrfDetail);
        
        return $this->render('viewdetailsn', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new OutboundGrf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
      public function actionCreate($id , $act = null)
    {
        $this->layout = 'blank';
        if ($act == 'view'){
            // create OutboundGrf
            $modelInstruction = InstructionGrf::findOne($id);
            $modelGrf = Grf::findOne($id);
            $model = new OutboundGrf();
            
            $model->id_instruction_grf = $modelInstruction->id;
            $model->status_listing = 43; // Partially Uploaded
            $model->id_modul = $this->id_modul;
            $model->grf_type = $modelGrf->grf_type;
            $model->id_division = 2;
            $model->id_region = $modelGrf->id_region;
            $model->pic = $modelGrf->pic;
            $model->grf_number = $modelGrf->grf_number;
            $model->wo_number = $modelGrf->wo_number;
            $model->file_attachment_1 = $modelGrf->file_attachment_1;
            $model->file_attachment_2 = $modelGrf->file_attachment_2;
            $model->purpose = $modelGrf->purpose;
            $model->requestor = $modelGrf->requestor;
            $model->wo_number = $modelGrf->wo_number;
            $model->note = $modelInstruction->note;
            $model->id_modul = $modelInstruction->id_modul;
            $model->id_warehouse = $modelInstruction->id_warehouse;
            $model->incoming_date = $modelInstruction->incoming_date;
            $model->date_of_return = $modelInstruction->date_of_return;
            $model->created_by = Yii::$app->user->identity->id;
			

            // if(!$model->save()){
            //    $error = $model->getErrors();
            //         $model->delete();
            //         return Displayerror::pesan($error);
            // };
                

            // echo $model->wo_number;
			if(!$model->save())return print_r($model->getErrors());
            // $model->save();
            
            // create OutboundGrfDetail
            $modelInstructionDetail = InstructionGrfDetail::find()->andWhere(['id_instruction_grf' => $id])->all();
            foreach($modelInstructionDetail as $value){
                $modelDetail = new OutboundGrfDetail();
                // return $value->id_instruction_grf;
                $modelDetail->id_outbound_grf       = $value->id_instruction_grf;
                $modelDetail->id_item_im            = $value->id_item_im;             
                $modelDetail->qty_good              = $value->qty_good;
                $modelDetail->qty_noot_good          = $value->qty_noot_good;
                $modelDetail->qty_reject            = $value->qty_reject;
                $modelDetail->qty_dismantle_good    = $value->qty_dismantle_good;
                $modelDetail->qty_dismantle_ng      = $value->qty_dismantle_ng;
                $modelDetail->qty_good_rec      = $value->qty_good_rec;
                $modelDetail->status_listing        = ($value->idMasterItemIm->sn_type == 1) ? 999 : 41;
                
                
                if (!$modelDetail->save()){
                    $error = $modelDetail->getErrors();
                    $model->delete();
                    return Displayerror::pesan($error);
                }
            }
            
        }
        
        $model = $this->findModel($id);
        
        $searchModel = new SearchOutboundGrfDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);
                
        Yii::$app->session->set('idOutboundGrf', $id);

        return $this->render('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    /**
     * Updates an existing OutboundGrf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_instruction_grf]);
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
            $modelOutboundGrfDetail = OutboundGrfDetail::find()->where(['id_outbound_grf'=> $id])->asArray()->all();
            $cekStatus = 1;
            foreach($modelOutboundGrfDetail as $key => $value){
                if($value['status_listing'] != 41){
                    $cekStatus++;
                }
            }
            
            if($cekStatus == 1){
                $modelOutbound = $this->findModel($id);
                $modelOutbound->status_listing = 42;
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
            // $model->driver = $_POST['OutboundGrf']['driver'];
            // $model->forwarder = $_POST['OutboundGrf']['forwarder'];
            // $model->plate_number = $_POST['OutboundGrf']['plate_number'];
            $model->no_sj = substr($model->grf_number, 0, 4).'/SJ-Jakarta-Div1/'.date('m/Y');
            $model->status_listing = 22;
            
            $model->save();
            return 'success';
        } 
    }

    public function actionRevise($id){
        // revise for new Instruction
        $model = InstructionGrf::findOne($id);
        
        if ($model->status_listing == 25){
            // status listing outbound bukan approve
            return 'Cannot revise. Data has been approve';;
        }
        
        if ( Yii::$app->request->post('InstructionGrf')['revision_remark'] != '' ){
            $model->status_listing = 3;
            $model->revision_remark = Yii::$app->request->post('InstructionGrf')['revision_remark'];
            
            $model->save();
            
            return 'success';
        }else{
            return 'Please insert Revision Remark';
        }
    }

    public function actionApprove($id){
        $model = $this->findModel($id);
        
        if ($model->status_listing == 22){
            if($model->idInstructionGrf->idGrf->source != null){
                $model->status_listing = 5;
                $model->published_date = date('Y-m-d');
                if($model->save()){
                    $modelGrf = Grf::findOne($id);
                    $modelDetailGrf = OutboundGrfDetail::find()
                        ->andWhere(['id_outbound_grf' => $id])->all();

                    $list_item = [];
                    for($i=0; $i<count($modelDetailGrf); $i++){
                        $list_item[$i] = [
                            'orafin_code' => $modelDetailGrf[$i]->idMasterItemIm->orafin_code,
                            'im_code' => $modelDetailGrf[$i]->idMasterItemIm->im_code,
                            'brand' => $modelDetailGrf[$i]->idMasterItemIm->referenceBrand->description,
                            'type' => $modelDetailGrf[$i]->idMasterItemIm->referenceType->description,
                            'warna' => $modelDetailGrf[$i]->idMasterItemIm->referenceWarna->description,
                            'sn_type' => $modelDetailGrf[$i]->idMasterItemIm->referenceSn->description,
                            'qty_request' => $modelDetailGrf[$i]->qty_return
                        ];
                    }
                    if($modelGrf->source != null){
                        $curl = new curl\Curl();
                        $response = $curl
                        ->setOption(
                            CURLOPT_POSTFIELDS,
                            http_build_query([
                            'id_grf' => $modelGrf->id_grf_others,
                            'no_sj' => $model->surat_jalan_number,
                            'list_item' => $list_item,
                        ])
                        )
                        ->setOption(CURLOPT_RETURNTRANSFER, true)
                        ->post('http://server001:8020/foro/api/web/site/update-grf');
                        return $response;
                    }
                    return 'success';
                }else{
                    return print_r($model->getErrors());
                }
            }else{
                $model->status_listing = 25;
                $model->published_date = date('Y-m-d');
                if(!$model->save()){
                    return print_r($model->getErrors());
                }
            }
            
            
            
            // return 'success';
        }else{
            return 'failed';
        }
    }

    public function actionTestUpdateGrf($id){
		// \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
		$modelDetailGrf = OutboundGrfDetail::find()          
            ->andWhere(['id_outbound_grf' => $id])->all();

		$list_item = [];
		for($i=0; $i<count($modelDetailGrf); $i++){
			$list_item[$i] = [
				'orafin_code' => $modelDetailGrf[$i]->idMasterItemIm->orafin_code,
				'im_code' => $modelDetailGrf[$i]->idMasterItemIm->im_code,
                'brand' => $modelDetailGrf[$i]->idMasterItemIm->referenceBrand->description,
                'type' => $modelDetailGrf[$i]->idMasterItemIm->referenceType->description,
                'warna' => $modelDetailGrf[$i]->idMasterItemIm->referenceWarna->description,
                'sn_type' => $modelDetailGrf[$i]->idMasterItemIm->referenceSn->description,
				'qty_request' => $modelDetailGrf[$i]->qty_return
			];
		}
		// return print_r($list_item);
        $modelGrf = Grf::findOne($id);
        $curl = new curl\Curl();
        $response = $curl
        ->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query([
             'id_grf' => $modelGrf->id_grf_others,
             'no_sj' => $model->surat_jalan_number,

             'list_item' => $list_item,
        ])
        )
        ->setOption(CURLOPT_RETURNTRANSFER, true)
        ->post('http://server001:8020/foro/api/web/site/update-grf');
        return $response;
    }

    public function actionReviseoutbound($id){
        $model = $this->findModel($id);
        
        if ($model->status_listing != 22){
            // status listing instruction bukan approve
            return 'failed';
        }
        
        if (Yii::$app->request->isPost){
            $model->status_listing = 3;
            $model->revision_remark = Yii::$app->request->post('OutboundGrf')['revision_remark'];
            
            $model->save();
            
            return 'success';
        }
        
    }
    public function actionRestore($idOutboundGrfDetail, $id){
        OutboundGrfDetailSn::deleteAll('id_outbound_grf_detail = '.$idOutboundGrfDetail);
        
        $model = OutboundGrfDetail::findOne($idOutboundGrfDetail);
        $model->status_listing = 43;
        $model->save();
        
        return $this->actionCreate($id);
    }

    public function actionUploadsn($id){
        $this->layout = 'blank';
        $model = new UploadForm();
        
        $model->scenario = 'xls';
        
        if (Yii::$app->request->isPost){
            // return print_r('tes');
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
                    //OutboundGrfDetailSn::deleteAll('id_outbound_grf_detail = '.Yii::$app->session->get('idOutboundGrfDetail'));
                    $row = 2;
                    $periksa = "\nplease check on row ";
                    $reqCol = [
                        'SERIAL_NUMBER' => '',
                        'MAC_ADDRESS' => '',
                        'CONDITION' => '',
                    ];
                    
                    //get max quantity based on detail
                    $modelDetail = OutboundGrfDetail::findOne($id);
                    // return print_r($model->qty_good);
                    $maxQtyGood             = $modelDetail->qty_good;
                    $maxQtyNotGood          = $modelDetail->qty_noot_good;
                    $maxQtyReject           = $modelDetail->qty_reject;
                    $maxQtyGoodDismantle    = $modelDetail->qty_dismantle_good;
                    $maxQtyNotGoodDismantle = $modelDetail->qty_dismantle_ng;
                    $maxQtyGoodRec = $modelDetail->qty_good_rec;
                    
                    //get quantity already upload
                    $modelSn = OutboundGrfDetailSn::find()->andWhere(['id_outbound_grf_detail' => $id]);
                    $qtyGood            = $modelSn->andWhere(['condition' => 'good'])->count();
                    $qtyNotGood         = $modelSn->andWhere(['condition' => 'not good'])->count();
                    $qtyReject          = $modelSn->andWhere(['condition' => 'reject'])->count();
                    $qtyGoodDismantle   = $modelSn->andWhere(['condition' => 'good dismantle'])->count();
                    $qtyNotGoodDismantle= $modelSn->andWhere(['condition' => 'not good dismantle'])->count();
                    $qtyGoodRec= $modelSn->andWhere(['condition' => ' good recondition'])->count();
                    
                    $newIdSn = [];
                    foreach ($datas as $key => $data) {
                        // periksa setiap kolom yang wajib ada, hanya di awal row
                        if ($row == 2) {
                            $missCol = array_diff_key($reqCol,$data);
                            if (count($missCol) > 0) {
                                return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                            }
                        }
                        $modelSn = new OutboundGrfDetailSn();

                        $modelSn->id_outbound_grf_detail = $id;
                        $modelSn->serial_number = (string)$data['SERIAL_NUMBER'];
                        $modelSn->mac_address = $data['MAC_ADDRESS'];
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
                            case 'good dismantle':
                                $qtyGoodDismantle++;
                            break;
                            case 'not good dismantle':
                                $qtyNotGoodDismantle++;
                            break;
                            case 'good rec':
                                $qtyGoodRec++;
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
                        if ($qtyGoodRec > $maxQtyGoodRec){
                            $maxErr = 'Quantity Good Recondition cannot be more than '. $maxQtyGoodRec;
                        }
                        
                        if ($maxErr != ''){
                            // delete new data only
                            OutboundGrfDetailSn::deleteAll(['id' => $newIdSn]);
                            return $maxErr;
                        }

                        if(!$modelSn->save()) {
                            // return print_r($modelSn->getErrors());
                            // delete new data only
                            OutboundGrfDetailSn::deleteAll(['id' => $newIdSn]);
                            $error = $modelSn->getErrors();
                            $error['line'] = [$periksa.$row];
                            return Displayerror::pesan($modelSn->getErrors());
                        }
                    // return print_r('tes');
                        $newIdSn[] = $modelSn->id;
                        $row++;
                    }
                    
                    if ($maxQtyGood == $qtyGood && 
                        $maxQtyNotGood == $qtyNotGood && 
                        $maxQtyReject == $qtyReject && 
                        $maxQtyGoodDismantle == $qtyGoodDismantle && 
                        $maxQtyNotGoodDismantle == $qtyNotGoodDismantle && $maxQtyGoodRec == $qtyGoodRec){
                            $modelDetail->status_listing = 41;
                            $modelDetail->save();
                    }else{
                        $modelDetail->status_listing = 43;
                        $modelDetail->save();
                    }
                    
                    $modelOutboundGrfDetail = OutboundGrfDetail::find()->where(['id_outbound_grf'=> $modelDetail->id_outbound_grf])->asArray()->all();
                    $cekStatus = 1;
                    foreach($modelOutboundGrfDetail as $key => $value){
                        if($value['status_listing'] != 41){
                            $cekStatus++;
                        }
                    }
                    
                    if($cekStatus == 1){
                        $modelOutbound = $this->findModel(\Yii::$app->session->get('idOutboundGrf'));
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
            $model = InstructionGrf::findOne($id);
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

    public function actionExportpdf($id) {
        
        $arrayreturn = $this->detailView($id);
        $model = $arrayreturn['model'];
        $dataprovider = $arrayreturn['dataProvider'];
        $dataprovider->sort = false;
        $arrayreturn['dataProvider'] = $dataprovider;
        
        
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

    /**
     * Deletes an existing OutboundGrf model.
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
     * Finds the OutboundGrf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OutboundGrf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OutboundGrf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
