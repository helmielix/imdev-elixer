<?php

namespace divisisatu\controllers;

use common\models\OutboundRepair;
use common\models\OutboundWhTransfer;
use common\models\Warehouse;
use common\models\AdjustmentDaily;
use common\models\InboundRepair;
use common\models\SearchAdjustmentDaily;
use common\models\TanggalDatangForm;
use common\models\LoginForm;
use common\models\SearchInboundRepairDetail;
use Yii;
use common\models\InboundPo;
use common\models\LogInboundPo;
use common\models\SearchInboundPo;
use common\models\SearchLogInboundPo;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\SearchInboundRepair;
use common\models\OrafinViewMkmPrToPay;
use common\models\MasterItemIm;
use common\models\SearchMasterItemIm;
use common\models\UploadForm;
use common\models\InboundRepairDetail;
use common\models\InboundPoDetail;
use common\models\InboundPoDetailSn;
use common\models\SearchInboundPoDetailSn;
use common\models\SearchInboundPoDetail;

/**
 * InboundPoController implements the CRUD actions for InboundPo model.
 */
class AdjustmentDailyController extends Controller {

    private $id_modul = 1;

    /**
     * @inheritdoc
     */
    /* Cari tahu apakah benar delete POST */
    public function behaviors() {
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
     * Lists all InboundPo models.
     * @return mixed
     */
    public function actionIndex($action = NULL,$id=null) {
        $searchModel = new SearchAdjustmentDaily();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'input');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexadjust($action = NULL,$id=null) {
        if (isset($action) && $action == 'adjust') {
            $adjustStatus = AdjustmentDaily::findOne(['id_adjustment' => $id]);
            $adjustStatus->status_listing = 48;
            $adjustStatus->save();

        }

        $searchModel = new SearchAdjustmentDaily();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'adjust');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function getNewID() {
        $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bulan = $array_bulan[date('n')];
        $newidinst = AdjustmentDaily::find()->where(['like', 'no_adj', '%/' . date('Y'), false])->count() + 1;
        switch ($newidinst) {
            case $newidinst < 10:
                $ret = '00' . $newidinst . '/Adj-JKT/Div1/' . $bulan . '/' . date('Y');
                break;
            case $newidinst < 100:
                $ret = '0' . $newidinst . '/Adj-JKT/Div1/' . $bulan . '/' . date('Y');
                break;
            case $newidinst < 1000:
                $ret = $newidinst . '/Adj-JKT/Div1/' . $bulan . '/' . date('Y');
                break;
            default: $ret = '001/Adj-JKT/Div1/' . $bulan . '/' . date('Y');
                break;
        }
        return $ret;
    }

// CONTROLLER
    public function actionNosj() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
        //var_dump($_POST);exit();
            switch ($id) {
                case "warehouse_transfer":
                    $list = \common\models\OutboundWhTransfer::findAll(['adjusted' => false]);
                    break;
                case "repair":
                    $list = \common\models\OutboundRepair::findAll(['adjusted' => false])/*->asArray()->all()*/;
                    break;
                case "disposal":
                    $list = \divisitiga\models\OutboundDisposal::find()->asArray()->all();
                    break;
                case "peminjaman":
                    //belum ada tabelnya
                    $list = \divisitiga\models\OutboundGrf::find()->asArray()->all();
                    break;
                case "grf":
                    $list = \divisitiga\models\OutboundGrf::find()->asArray()->all();
                    break;
                case "recondition":
                    //belum ada tabelnya
                    $list = \divisitiga\models\OutboundRepair::find()->asArray()->all();
                    break;

                default:
                    break;
            }

            $existing='';
            $selected = null;
            if (!empty($_POST['depdrop_params'])) {
                $params = $_POST['depdrop_params'];
                $existing = $params[0];
            }
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['no_sj'], 'name' => $account['no_sj']];
                    if ($existing == $account['no_sj']) {
                        $selected = $account['no_sj'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                //echo Json::encode(['test' => $_POST['depdrop_parents']]);
                return;
            }
        }
        //echo Json::encode(['test' => $_POST['depdrop_parents']]);
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionCreate() {
        //echo 'tes';
        $model = new AdjustmentDaily();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //var_dump( Yii::$app->request->post('AdjustmentDaily')['no_sj'],$_POST['AdjustmentDaily']['no_sj']);exit();
            $no_sj = Yii::$app->request->post('AdjustmentDaily')['no_sj'];
            $model->no_adj = $this->getNewID();
            $model->no_sj = $no_sj;
            $model->status_listing = 1;
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->berita_acara = $model->file->baseName . '.' . $model->file->extension;
            $model->save();
            $model->file->saveAs('Uploads/' . $model->file->baseName . '.' . $model->file->extension);

            if (Yii::$app->request->post('AdjustmentDaily')['jenis_transaksi']=='repair') {
                $outboundRepair = new OutboundRepair();
                $outboundRepair::find()->where(['no_sj' => $no_sj]);
                $outboundRepair->adjusted = true;
                $outboundRepair->save();
            } else if (Yii::$app->request->post('AdjustmentDaily')['jenis_transaksi']=='warehouse_transfer') {
                $whTransfer = new OutboundWhTransfer();
                $whTransfer::find()->where(['no_sj' => $no_sj]);
                $whTransfer->adjusted = true;
                $whTransfer->save();
            }

            $searchModel = new SearchAdjustmentDaily();
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->id_modul, 'input');

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->layout = 'blank';

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionView() {
        $model = AdjustmentDaily::find()->where(['id_adjustment' => Yii::$app->request->get('id')])->one();

        $this->layout = 'blank';

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id) {
        $media = AdjustmentDaily::findOne(['id_adjustment' => $id]);
        header('Content-Type:' . pathinfo('Uploads/' . $media->berita_acara, PATHINFO_EXTENSION));
        header('Content-Disposition: attachment; filename=' . $media->berita_acara);
        return readfile('Uploads/' . $media->berita_acara);
    }

}
