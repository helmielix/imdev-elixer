<?php

namespace divisisatu\controllers;

use Yii;
use common\models\InstructionRepair;
use common\models\InstructionRepairDetail;
use common\models\MasterItemIm;
use common\models\SearchInstructionRepair;
use common\models\SearchInstructionRepairDetail;
use common\models\SearchMasterItemIm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\widgets\Displayerror;
use common\widgets\Numbertoroman;
use common\widgets\Email;

/**
 * InstructionRepair implements the CRUD actions for InstructionRepair model.
 */
class InstructionRepairController extends Controller {

    /**
     * @inheritdoc
     */
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
     * Lists all InstructionRepair models.
     * @return mixed
     */
    private function listIndex($action) {
        $searchModel = new SearchInstructionRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, $action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionIndex() {
        return $this->render('index', $this->listIndex('input'));
    }

    public function actionIndexapprove() {
        return $this->render('index', $this->listIndex('approve'));
    }

    public function actionIndexdetail() {
        //echo 'tes1';
        //echo Yii::$app->session->get('idInstRep');
        $model = $this->findModel(Yii::$app->session->get('idInstRep'));
        $this->layout = 'blank';
        $searchModel = new SearchInstructionRepairDetail();
        $req = array();
        if (!empty(Yii::$app->request->get())) {
            $req = Yii::$app->request->get();
        }
        if (!empty(Yii::$app->request->post())) {
            $req = Yii::$app->request->post();
        }
//        print_r($req);
        $dataProvider = $searchModel->searchdetail($req, Yii::$app->session->get('idInstRep'));

        return $this->render('indexdetail', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstructionRepair model.
     * @param integer $id
     * @return mixed
     */
    private function detailView($id) {
        $model = $this->findModel($id);

        $searchModel = new SearchInstructionRepairDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);

        Yii::$app->session->set('idInstRep', $model->id);

        return [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    private function detailView2($id) {
        $model = $this->findModel($id);

        $searchModel = new SearchInstructionRepairDetail();
        $dataProvider = $searchModel->searchdetail(Yii::$app->request->get(), $id);

        Yii::$app->session->set('idInstRep', $model->id);

        return [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionView($id) {
        // echo basename(Yii::$app->request->referrer);
        // $basename = explode('?', basename(Yii::$app->request->referrer));
        // if ($basename[0] == 'view'){
        // return $this->redirect(['index']);
        // // throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
        // }
        $this->layout = 'blank';
        //echo 'tes2';
        return $this->render('view', $this->detailView2($id));
    }

    public function actionViewapprove($id) {
        $this->layout = 'blank';
        return $this->render('view', $this->detailView($id));
    }

    /**
     * Creates a new InstructionRepair model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $lib = new Numbertoroman();
        $this->layout = 'blank';
        $model = new InstructionRepair();
        $model->id_modul = $this->id_modul;
        $iduser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : '5';
        $newidinst = InstructionRepair::find()->andWhere(['and', ['like', 'instruction_number', '%/' . date('Y'), false], ['id_modul' => $model->id_modul]])->count() + 1;
        $newidinstexist = InstructionRepair::find()->andWhere(['and', ['instruction_number' => $newidinst], ['id_modul' => $model->id_modul]])->exists();
        $newidinst++;
        $monthroman = $lib->convert(date('n'));
        $model->instruction_number = sprintf("%04d", $newidinst) . '/INST-IC1/REP/' . $monthroman . date('/Y');
        if ($model->load(Yii::$app->request->post())) {
            //echo "hello!";
            $model->instruction_number = sprintf("%04d", $newidinst) . '/INST-IC1/REP/' . $monthroman . date('/Y');
            $model->target_pengiriman = $_POST['InstructionRepair']['target_pengiriman'];
            $model->id_warehouse = $_POST['InstructionRepair']['id_warehouse'];
            $model->vendor_repair = $_POST['InstructionRepair']['vendor_repair'];
            $model->note = $_POST['InstructionRepair']['note'];

            $model->status_listing = 7;

            if (isset($_FILES['file'])) {
                //echo "file";
                if (isset($_FILES['file']['size'])) {
                    if ($_FILES['file']['size'] != 0) {
                        $model->file = $_FILES['file'];
                        // return print_r($_FILES['file']);
                        $filename = $_FILES['file']['name'];
                        $filepath = 'uploads/INST/DIVSATU/';
                    }
                }
            }
//            print_r($model);
            if (!$model->save()) {
                return Displayerror::pesan($model->getErrors());
            }

            Yii::$app->session->set('idInstRep', $model->id);


            return 'success';
        } else {
            Yii::$app->session->remove('idInstRep');
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InstructionRepair model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = 'blank';
        $model = $this->findModel($id);

        Yii::$app->session->set('idInstRep', $model->id);
//        if ($model->load(Yii::$app->request->post())) {
//
//            $filename = '';
//            if (isset($_FILES['file'])) {
//                if (isset($_FILES['file']['size'])) {
//                    if ($_FILES['file']['size'] != 0) {
//                        $model->file = $_FILES['file'];
//                        $filename = $_FILES['file']['name'];
//                        $filepath = 'uploads/INST/DIVSATU/';
//                        $model->file_attachment = $filepath . $model->id . '/' . $filename;
//                    }
//                }
//            }
//
//            if (!$model->save()) {
//                return Displayerror::pesan($model->getErrors());
//            }
//
//            if ($filename != '') {
//                move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
//            }
//
//            return 'success';
//        } 
        if ($model->load(Yii::$app->request->post())) {
            $model->target_pengiriman = $_POST['InstructionRepair']['target_pengiriman'];
            $model->id_warehouse = $_POST['InstructionRepair']['id_warehouse'];
            $model->vendor_repair = $_POST['InstructionRepair']['vendor_repair'];
            $model->note = $_POST['InstructionRepair']['note'];

            //echo 'model: ' . $model->status_listing;
            if ($model->status_listing != 3 && $model->status_listing != 1 && $model->status_listing != 2
                && $model->status_listing != 50) {
                $model->status_listing = 7;
            }

            if (isset($_FILES['file'])) {
                if (isset($_FILES['file']['size'])) {
                    if ($_FILES['file']['size'] != 0) {
                        $model->file = $_FILES['file'];
                        // return print_r($_FILES['file']);
                        $filename = $_FILES['file']['name'];
                        $filepath = 'uploads/INST/DIVSATU/';
                    }
                }
            }
//            print_r($model);
            if (!$model->save()) {
                return Displayerror::pesan($model->getErrors());
            }

            Yii::$app->session->set('idInstRep', $model->id);


            return 'success';
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreatedetail() {
//        $this->layout = 'blank';
        $id = Yii::$app->session->get('idInstRep');
//        var_dump(Yii::$app->request->isPost,Yii::$app->request->post('SearchMasterItemIm'),Yii::$app->request->post());exit();
        if (Yii::$app->request->isPost && (!array_key_exists('SearchMasterItemIm', Yii::$app->request->post()))) {

            $data_im_code = Yii::$app->request->post('im_code');
            $data_r_good = Yii::$app->request->post('rgood');
            $data_r_notgood = Yii::$app->request->post('rnotgood');
            $data_r_reject = Yii::$app->request->post('rreject');
//            var_dump($data_im_code);
// var_dump(Yii::$app->request->post(),$data_r_reject,$data_r_good,$data_im_code);exit();
            if (count($data_im_code) == 0) {
                return json_encode(['status' => 'success']);
            }
            $data_im_code = explode(",", $data_im_code[0]);
            $data_r_reject = explode(",", $data_r_reject[0]);
            $data_r_notgood = explode(",", $data_r_notgood[0]);
            foreach ($data_im_code as $key => $value) {
                // if($data_r_good[$key] == '')
                if (@$data_r_reject[$key] == '' && @$data_r_reject[$key] == 0 && @$data_r_notgood[$key] == '' && @$data_r_notgood[$key] == 0) {
                    continue;
                }
                $values = explode(';', $value);
//                print_r($data_r_reject[$key]);exit();

                $model = InstructionRepairDetail::find()->where(['id_item_im' => $values[0], 'id_instruction_repair' => $id])->one();
                if (!$model) {
                    $model = new InstructionRepairDetail();
                }
                $model->id_instruction_repair = $id;
                $model->id_item_im = $values[0];
                // $model->req_good			= ($data_r_good[$key] == '') ? 0 : $data_r_good[$key];
                $model->req_not_good = (@$data_r_notgood[$key] == '') ? $model->req_not_good + 0 : $model->req_not_good + @$data_r_notgood[$key];
                $model->req_reject = (@$data_r_reject[$key] == '') ? $model->req_reject + 0 : $model->req_reject + @$data_r_reject[$key];

                $modelMasterItem = MasterItemIm::findOne($values[0]);
                $overStock = 1;
                $pesan = [];
                // if($model->req_good > $modelMasterItem->s_good){
                // $pesan[] = $model->getAttributeLabel('req_good')." is more than Stock for IM Code ".$values[1];
                // $overStock = 0;
                // }
                if ($model->req_not_good > $modelMasterItem->s_not_good) {
                    $pesan[] = $model->getAttributeLabel('req_not_good') . " is more than Stock for IM Code " . $values[1];
                    $overStock = 0;
                }
                if ($model->req_reject > $modelMasterItem->s_reject) {
                    $pesan[] = $model->getAttributeLabel('req_reject') . " is more than Stock for IM Code " . $values[1];
                    $overStock = 0;
                }

                if ($overStock == 0)
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n", $pesan)]);
                $model->rem_reject = $modelMasterItem->s_reject - $model->req_reject;

                if (!$model->save()) {
                    $error = $model->getErrors();
                    $error[0] = ['for IM Code ' . $values[1]];
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
                }
            }

            return json_encode(['status' => 'success']);
            // return 'success';
        }

        $modelDetail = InstructionRepairDetail::find()->select(['id_item_im'])->andWhere(['id_instruction_repair' => $id])->all();
//        $idItemIm = ArrayHelper::map($modelDetail, 'id_item_im', 'id_item_im');

        $reqitem = ArrayHelper::map(InstructionRepairDetail::find()->andWhere(['id_instruction_repair' => $id])->all(), 'id_item_im', 'req_reject');
        $reqitemnotgood = ArrayHelper::map(InstructionRepairDetail::find()->andWhere(['id_instruction_repair' => $id])->all(), 'id_item_im', 'req_not_good');
        $searchModel = new SearchMasterItemIm();
//        $dataProvider = $searchModel->searchByCreateDetailItem(Yii::$app->request->post(), $idItemIm);
        $req = array();
        if (!empty(Yii::$app->request->post())) {
            $req = Yii::$app->request->post();
        }
        if (!empty(Yii::$app->request->get())) {
            $req = Yii::$app->request->get();
        }
        $dataProvider = $searchModel->searchByCreateDetailItem($req, null);
//        print_r(Yii::$app->request->post());
//        print_r($dataProvider);
        return $this->renderAjax('createdetail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modeldetail' => $modelDetail,
                    'reqItem' => $reqitem,
                    'reqItemNotGood' => $reqitemnotgood,
        ]);
    }

    public function actionUpdatedetail($idDetail) {
        $this->layout = 'blank';



//        if ($model->load(Yii::$app->request->post())) {
//            $model->rem_reject = $modelItem->s_reject - $model->req_reject;
//            $model->update();
//            if (!$model->save()) {
//                return Displayerror::pesan($model->getErrors());
//            }
//
//            return 'success';
//        } else {
//            return $this->render('_formdetail', [
//                        'model' => $model,
//                        'modelItem' => $modelItem,
//            ]);
//        }
        //awal
        if (Yii::$app->request->isPost && (!array_key_exists('SearchMasterItemIm', Yii::$app->request->post()))) {

            $data_im_code = Yii::$app->request->post('im_code');
            $data_r_good = Yii::$app->request->post('rgood');
            $data_r_notgood = Yii::$app->request->post('rnotgood');
            $data_r_reject = Yii::$app->request->post('rreject');

            if (count($data_im_code) == 0) {
                return json_encode(['status' => 'success']);
            }
            $data_im_code = explode(",", $data_im_code[0]);
            $data_r_reject = explode(",", $data_r_reject[0]);
            $data_r_notgood = explode(",", $data_r_notgood[0]);
            foreach ($data_im_code as $key => $value) {
                if (@$data_r_reject[$key] == '' && @$data_r_reject[$key] == 0 && @$data_r_notgood[$key] == '' && @$data_r_notgood[$key] == 0) {
                    continue;
                }
                $values = explode(';', $value);
                $model = InstructionRepairDetail::findOne($idDetail);
                $model->req_not_good = (@$data_r_notgood[$key] == '') ?  0 :  @$data_r_notgood[$key];
                $model->req_reject = (@$data_r_reject[$key] == '') ? 0 : @$data_r_reject[$key];

                $modelMasterItem = MasterItemIm::findOne($values[0]);
                $overStock = 1;
                $pesan = [];
                if ($model->req_not_good > $modelMasterItem->s_not_good) {
                    $pesan[] = $model->getAttributeLabel('req_not_good') . " is more than Stock for IM Code " . $values[1];
                    $overStock = 0;
                }
                if ($model->req_reject > $modelMasterItem->s_reject) {
                    $pesan[] = $model->getAttributeLabel('req_reject') . " is more than Stock for IM Code " . $values[1];
                    $overStock = 0;
                }

                if ($overStock == 0)
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n", $pesan)]);
                $model->rem_reject = $modelMasterItem->s_reject - $model->req_reject;

                if (!$model->save()) {
                    $error = $model->getErrors();
                    $error[0] = ['for IM Code ' . $values[1]];
                    return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
                }
            }

            return json_encode(['status' => 'success']);
        }
        $modelDetail = InstructionRepairDetail::findOne($idDetail);
        $reqitem = ArrayHelper::map(InstructionRepairDetail::find()->andWhere(['id' => $idDetail])->all(), 'id_item_im', 'req_reject');
        $reqitemnotgood = ArrayHelper::map(InstructionRepairDetail::find()->andWhere(['id' => $idDetail])->all(), 'id_item_im', 'req_not_good');
        $searchModel = new SearchMasterItemIm();
        $req = array();
        if (!empty(Yii::$app->request->post())) {
            $req = Yii::$app->request->post();
        }
        if (!empty(Yii::$app->request->get())) {
            $req = Yii::$app->request->get();
        }
        $dataProvider = $searchModel->searchByupdateDetailItem($req, $modelDetail->id_item_im);

        return $this->renderAjax('updatedetail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modeldetail' => $modelDetail,
                    'reqItem' => $reqitem,
                    'reqItemNotGood' => $reqitemnotgood,
                    'idDetail' => $idDetail,
        ]);
    }

    public function actionDeletedetail($id) {
        $this->layout = 'blank';
        $model = InstructionRepairDetail::findOne($id);
        $idRepair = $model->id_instruction_repair;
        $model->delete();
        //$modelItem = MasterItemIm::find()->andWhere(['id'=>$model->id_item_im])->one();
        // return 'success';
        $this->layout = 'blank';
        return $this->render('view', $this->detailView($idRepair));
    }

    public function actionSubmit($id) {
        $model = InstructionRepair::findOne($id);
        $modelDetail = InstructionRepairDetail::find()->andWhere(['id_instruction_repair' => $id])->count();
        if ($modelDetail > 0) {
            if ($model->status_listing == 2 || $model->status_listing == 3) {
                $model->status_listing = 2;
            } else if ($model->status_listing == 50) {
                $model->status_listing = 2;
            }
            else {
                $model->status_listing = 1;
            }
        } else {
            $model->status_listing = 7;
        }

        if (!$model->save()) {
            return Displayerror::pesan($model->getErrors());
        }

        Yii::$app->session->remove('idInstRep');
        return 'success';
    }

    public function actionApprove($id) {
        $model = $this->findModel($id);

        if ($model->status_listing == 1) {
            $model->status_listing = 5;

            if ($model->save()) {
                return 'success';
            }
        } else {
            return 'Not Valid for Approve';
        }
    }

    /**
     * Deletes an existing InstructionRepair model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        InstructionRepairDetail::deleteAll('id_instruction_repair = ' . $id);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InstructionRepair model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionRepair the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReviseinstruction($id) {
        $model = $this->findModel($id);
        // if ($model->load(Yii::$app->request->post())) {
        $model->revision_remark = $_POST['InstructionWhTransfer']['revision_remark'];
        $model->status_listing = 3;
        if ($model->update()) {
            return 'success';
        }
    }

    protected function findModel($id) {
        if (($model = InstructionRepair::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
