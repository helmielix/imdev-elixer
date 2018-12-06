<?php
 
namespace divisisatu\controllers;

use Yii;
use common\models\OutboundRepair;
use common\models\OutboundRepairDetail;
use common\models\OutboundRepairDetailSn;
use common\models\SearchOutboundRepair;
use common\models\SearchOutboundRepairDetail;
use common\models\SearchOutboundRepairDetailSn;
use common\models\InstructionRepair;
use common\models\InstructionRepairDetail;
use common\models\SearchInstructionRepairDetail;
use common\models\UploadForm;
use common\models\Reference;
use common\models\SearchMasterItemIm;
use common\models\MasterItemIm;
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
 * OutboundRepairController implements the CRUD actions for OutboundRepair model.
 */
class OutboundRepairController extends Controller {

    private $id_modul = 1;

    public function behaviors() {
        return [
             'AccessBehavior' => [
                'class' => \common\components\AccessBehavior::className()
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OutboundRepair models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchOutboundRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'tagsn');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexprintsj() {
        $searchModel = new SearchOutboundRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'printsj');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexapproval() {
        $searchModel = new SearchOutboundRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'approval');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OutboundRepair model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->layout = 'blank';

        $model = $this->findModel($id);

        $searchModel = new SearchOutboundRepairDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);

        return $this->render('view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewapprove($id) {
        $this->layout = 'blank';

        $model = $this->findModel($id);

        $searchModel = new SearchOutboundRepairDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);

        return $this->render('view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewinstruction($id) {
        $this->layout = 'blank';
        $model = InstructionRepair::findOne($id);

        $searchModel = new SearchInstructionRepairDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);

        return $this->render('//instruction-repair/view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewdetailsn($idOutboundRepairDetail) {
        $this->layout = 'blank';
        $model = OutboundRepairDetail::findOne($idOutboundRepairDetail);

        $searchModel = new SearchOutboundRepairDetailSn();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $idOutboundRepairDetail);

        return $this->render('viewdetailsn', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRestoresn($idOutboundRepairDetail, $idItem) {
        $model = OutboundRepairDetail::findOne($idOutboundRepairDetail);
        $modelReturn = OutboundRepair::findOne($model->id_outbound_repair);
        $modelItem = MasterItemIm::findOne($idItem);

        OutboundRepairDetailSn::deleteAll('id_outbound_repair_detail = ' . $idOutboundRepairDetail);

        $model->status_listing = 41;
        $model->update();


        $searchModel = new SearchOutboundRepairDetailSn();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $idOutboundRepairDetail);
        return $this->redirect(['index']);
    }

    public function actionAddqtyrecond($idOutboundRepairDetail, $idItem) {
        $this->layout = 'blank';
        // return print_r($idItem);
        $model = OutboundRepairDetail::findOne($idOutboundRepairDetail);
        $modelItem = MasterItemIm::findOne($idItem);
        $modelOutbound = OutboundRepair::findOne($model->id_outbound_repair);
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                return print_r($model->getErrors());
            }
            return 'success';
        } else {
            return $this->render('_formrecond', [
                        'model' => $model,
                        'modelItem' => $modelItem,
                        'modelOutbound' => $modelOutbound,
            ]);
        }
    }

    /**
     * Creates a new OutboundRepair model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $act = null) {
        $this->layout = 'blank';
        if ($act == 'view') {
            // create OutboundRepair
            $modelInstruction = InstructionRepair::findOne($id);
            $model = new OutboundRepair();

            $model->id_instruction_repair = $modelInstruction->id;
            $model->status_listing = 43; // Partially Uploaded
            $model->id_modul = $this->id_modul;
            $model->no_sj = substr($modelInstruction->instruction_number, 0, 4) . '/SJ-Jakarta-Div1/' . date('m/Y');

            $model->save();

            // create OutboundRepairDetail
            $modelInstructionDetail = InstructionRepairDetail::find()->andWhere(['id_instruction_repair' => $id])->all();
            foreach ($modelInstructionDetail as $value) {
                $modelDetail = new OutboundRepairDetail();

                $modelDetail->id_outbound_repair = $value->id_instruction_repair;
                $modelDetail->id_item_im = $value->id_item_im;
                $modelDetail->req_good = $value->req_good;
                $modelDetail->req_not_good = $value->req_not_good;
                $modelDetail->req_reject = $value->req_reject;
                $modelDetail->req_good_dismantle = $value->req_good_dismantle;
                $modelDetail->req_not_good_dismantle = $value->req_not_good_dismantle;
                $modelDetail->status_listing = ($value->idMasterItemIm->sn_type == 1) ? 999 : 43;


                $modelDetail->save();
            }
        }

        $model = $this->findModel($id);

        $searchModel = new SearchOutboundRepairDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);

        Yii::$app->session->set('idOutboundRepair', $id);

        // if ($model->load(Yii::$app->request->post())) {
        // if (!$model->save()){
        // return Displayerror::pesan($model->getErrors());
        // }
        // return $this->redirect(['view', 'id' => $model->id_instruction_repair]);
        // } else {
        return $this->render('create', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        // }
    }

    /**
     * Updates an existing OutboundRepair model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_instruction_repair]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSubmitsj($id) {
        $model = $this->findModel($id);
//        echo "<pre>";print_r($_FILES);exit();
        if (isset($_FILES['file']['size'])) {
            if ($_FILES['file']['size'] != 0) {
                $filename = ('Uploads/AttachmentSuratJalan' . $_FILES['file']['name']);
                $model->file_attachment = $filename;
                move_uploaded_file($_FILES['file']['tmp_name'], 'Uploads/AttachmentSuratJalan' . basename($_FILES['file']['name']));
            }
        }
        if ($model->load(Yii::$app->request->post())) {
            // return print_r($model->forwarder);
            $model->status_listing = 22;
            if (!$model->save()) {
                return print_r($model->getErrors());
            }
            return 'success';
        }
    }

    public function actionReviseinstruction($id) {
        $model = InstructionRepair::findOne($id);

        if ($model->status_listing != 5) {
            // status listing instruction bukan approve
            return 'failed';
        }

        if (Yii::$app->request->isPost) {
            $model->status_listing = 3;
            $model->revision_remark = Yii::$app->request->post('InstructionRepair')['revision_remark'];

            $model->save();

            return 'success';
        }
    }

    public function actionReviseoutbound($id) {
        $model = $this->findModel($id);

        if ($model->status_listing != 22) {
            // status listing instruction bukan approve
            return 'failed';
        }

        if (Yii::$app->request->isPost) {
            $model->status_listing = 3;
            $model->revision_remark = Yii::$app->request->post('OutboundRepair')['revision_remark'];

            $model->save();

            return 'success';
        }
    }

    private function inputInbound($param, $details) {
//        print_r($param);
//        exit();
//        $inboundDetail=new \common\models\InboundRepairDetail();
        $inbound = new \common\models\InboundRepair();
        $inbound->id_instruction_repair = $param['id_instruction_repair'];
        $inbound->driver = $param['driver'];
        $inbound->forwarder = $param['forwarder'];
        $inbound->no_sj = $param['no_sj'];
        $inbound->plate_number = $param['plate_number'];
        $inbound->revision_remark = $param['revision_remark'];
        $inbound->id_modul = $param['id_modul'];
        $inbound->file_attachment = $param['file_attachment'];
        $data = array();
        foreach ($details as $detail) {
//            var_dump($detail);exit();
            $delta = 0 - $detail['req_reject'];
            $data[] = [$detail->idOutboundRepair->id_instruction_repair, $detail['id_item_im'], 0, $detail['req_reject'], $delta, $detail['status_listing']];
        }
        $detailsql = Yii::$app->db
                ->createCommand()
                ->batchInsert('inbound_repair_detail', ['id_instruction_repair', 'id_barang', 'qty_terima', 'req_qty', 'delta', 'status'], $data)
                ->execute();

        return $inbound->save();
    }

    public function actionApprove($id) {
        $model = $this->findModel($id);
        $detail = OutboundRepairDetail::find()->joinWith(['idOutboundRepair'])->where(['id_instruction_repair' => $id])->all();
        if ($model->status_listing == 22) {
            $model->status_listing = 5;

            if ($model->save() && $this->inputInbound($model, $detail)) {
                return 'success';
            }
        } else {
            return 'Not Valid for Approve';
        }
    }

    public function actionUploadsn($id) {
        $this->layout = 'blank';
        $model = new UploadForm();

        $model->scenario = 'xls';

        if (Yii::$app->request->isPost) {

            if (isset($_FILES['file']['size'])) {
                if ($_FILES['file']['size'] != 0) {

                    $filename = ('Uploads/' . $_FILES['file']['name']);
                    move_uploaded_file($_FILES['file']['tmp_name'], 'Uploads/' . basename($_FILES['file']['name']));
                    $datas = \moonland\phpexcel\Excel::import($filename, [
                                'setFirstRecordAsKeys' => true,
                                    // 'setIndexSheetByName' => true,
                                    // 'getOnlySheet' => 'Sheet1'
                    ]);
                    if (isset($datas[0][0])) {
                        $datas = $datas[0];
                    }
                    //OutboundRepairDetailSn::deleteAll('id_outbound_repair_detail = '.Yii::$app->session->get('idOutboundRepairDetail'));
                    $row = 2;
//                    print_r($datas);exit();
                    $periksa = "\nplease check on row ";
                    $reqCol = [
                        'SERIAL_NUMBER' => '',
//                        'MAC_ADDRESS' => '',
                            // 'CONDITION' => '',
                    ];

                    $modelDetail = OutboundRepairDetail::findOne($id);
                    $maxQtyGood = $modelDetail->req_good;
                    $maxQtyNotGood = $modelDetail->req_not_good;
                    $maxQtyReject = $modelDetail->req_reject;
                    $maxQtyGoodDismantle = $modelDetail->req_good_dismantle;
                    $maxQtyNotGoodDismantle = $modelDetail->req_not_good_dismantle;

                    $modelSn = OutboundRepairDetailSn::find()->andWhere(['id_outbound_repair_detail' => $id]);
                    $qtyGood = $modelSn->andWhere(['condition' => 'Good'])->count();
                    $qtyNotGood = $modelSn->andWhere(['condition' => 'Not Good'])->count();
                    $qtyReject = $modelSn->andWhere(['condition' => 'Reject'])->count();
                    $qtyGoodDismantle = $modelSn->andWhere(['condition' => 'Good Dismantle'])->count();
                    $qtyNotGoodDismantle = $modelSn->andWhere(['condition' => 'Not Good Dismantle'])->count();
//                    print_r($datas);exit();
                    foreach ($datas as $key => $data) {
                        // periksa setiap kolom yang wajib ada, hanya di awal row
                        if ($row == 2) {
                            $missCol = array_diff_key($reqCol, $data);
                            if (count($missCol) > 0) {
                                OutboundRepairDetailSn::deleteAll('id_outbound_repair_detail = ' . $id);
                                return "Column " . implode(array_keys($missCol), ", ") . " is not exist in XLS File";
                            }
                        }
                        if ($data['SERIAL_NUMBER'] != "") {
                            $modelSn = new OutboundRepairDetailSn();

                            $modelSn->id_outbound_repair_detail = $id;
                            $modelSn->serial_number = (string) $data['SERIAL_NUMBER'];
                            if (isset($data['MAC_ADDRESS'])) {
                                $modelSn->mac_address = (string) $data['MAC_ADDRESSS'];
                            }
                            $modelSn->condition = 'Reject';

                            switch ($modelSn->condition) {
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

                            if ($maxQtyGood != null) {
                                if ($qtyGood > $maxQtyGood) {
                                    $maxErr = 'Quantity Good cannot be more than ' . $maxQtyGood;
                                }
                            }

                            if ($maxQtyNotGood != null) {
                                if ($qtyNotGood > $maxQtyNotGood) {
                                    $maxErr = 'Quantity Not Good cannot be more than ' . $maxQtyNotGood;
                                }
                            }

                            if ($maxQtyReject != null) {
                                if ($qtyReject > $maxQtyReject) {
                                    $maxErr = 'Quantity Reject cannot be more than ' . $maxQtyReject;
                                }
                            }

                            if ($maxQtyGoodDismantle != null) {
                                if ($qtyGoodDismantle > $maxQtyGoodDismantle) {
                                    $maxErr = 'Quantity Good Dismantle cannot be more than ' . $maxQtyGoodDismantle;
                                }
                            }

                            if ($maxQtyNotGoodDismantle != null) {
                                if ($qtyNotGoodDismantle > $maxQtyNotGoodDismantle) {
                                    $maxErr = 'Quantity Not Good Dismantle cannot be more than ' . $maxQtyNotGoodDismantle;
                                }
                            }



                            if ($maxErr != '') {
                                OutboundRepairDetailSn::deleteAll('id_outbound_repair_detail = ' . $id);
                                return $maxErr;
                            }

                            if (!$modelSn->save()) {
                                // OutboundRepairDetailSn::deleteAll('id_outbound_repair_detail = '.$id);
                                $error = $modelSn->getErrors();
                                $error['line'] = [$periksa . $row];
                                return Displayerror::pesan($modelSn->getErrors());
                            }
                        }
                        $row++;
                    }
//                    echo "$maxQtyGood = $qtyGood &
//                            $maxQtyNotGood = $qtyNotGood &
//                            $maxQtyReject = $qtyReject &
//                            $maxQtyGoodDismantle = $qtyGoodDismantle &
//                            $maxQtyNotGoodDismantle = $qtyNotGoodDismantle";
//                    exit();
// print_r($modelSn);exit();
                    if ((int) $maxQtyGood == (int) $qtyGood &&
                            (int) $maxQtyNotGood == (int) $qtyNotGood &&
                            (int) $maxQtyReject == (int) $qtyReject &&
                            (int) $maxQtyGoodDismantle == (int) $qtyGoodDismantle &&
                            (int) $maxQtyNotGoodDismantle == (int) $qtyNotGoodDismantle) {
                        $modelDetail->status_listing = 41;
                        $modelDetail->save();
                    } else {
                        $modelDetail->status_listing = 43;
                        $modelDetail->save();
                    }

                    $modelOutboundPoDetail = OutboundRepairDetail::find()->where(['id_outbound_repair' => $modelDetail->id_outbound_repair])->asArray()->all();
                    $cekStatus = 1;
                    foreach ($modelOutboundPoDetail as $key => $value) {
                        if ($value['status_listing'] != 41) {
                            $cekStatus++;
                        }
                    }

                    if ($cekStatus == 1) {
                        $modelOutbound = $this->findModel(\Yii::$app->session->get('idOutboundRepair'));
                        $modelOutbound->status_listing = 42;
                        $modelOutbound->save();
                    }

                    return 'success';
                } else {
                    echo "file korup";
                    exit();
                }
            } else {
                echo "file tidak ada";
                exit();
            }
        }

        return $this->render('@common/views/uploadform', [
                    'model' => $model,
        ]);
    }

    public function actionDownloadfile($id) {
        if ($id == 'templatewithmac') {
            $file = Yii::getAlias('@webroot') . '/Uploads/TemplateTagSNWithMacAddress.xlsx';
            $fileOut7 = Yii::getAlias('@webroot') . '/Uploads/TemplateTagSNWithMacAddress.xlsx';
        } else {
            $file = Yii::getAlias('@webroot') . '/Uploads/TemplateTagSN.xlsx';
            $fileOut7 = Yii::getAlias('@webroot') . '/Uploads/TemplateTagSN.xlsx';
        }

        if (file_exists($file)) {
            return Yii::$app->response->sendFile($fileOut7);
        } else {
            return $file;
            // throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing OutboundRepair model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OutboundRepair model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OutboundRepair the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = OutboundRepair::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
