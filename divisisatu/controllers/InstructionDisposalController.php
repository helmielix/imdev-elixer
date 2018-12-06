<?php

namespace divisisatu\controllers;

use Yii;
use common\models\InstructionDisposal;
use common\models\InstructionDisposalDetail;
use common\models\searchInstructionDisposal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Displayerror;
use common\models\SearchInstructionDisposalDetail;
use common\models\SearchMasterItemIm;
use common\widgets\Numbertoroman;
use common\models\UploadForm;
use common\models\MasterItemIm;
// use common\models\SearchMasterItemIm;

/**
 * InstructionDisposalController implements the CRUD actions for InstructionDisposal model.
 */
class InstructionDisposalController extends Controller
{
	 const ERR_DUPLICATE_ITEM = "Item has been inputted, for the change please update.";
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
     * Lists all InstructionDisposal models.
     * @return mixed
     */
   public function actionIndex()
    {
        return $this->render('index', $this->listIndex('input'));
    }

    private function listIndex($action)
    {
        $searchModel = new searchInstructionDisposal();
        $dataProvider = $searchModel->_search(Yii::$app->request->post(), $this->id_modul, $action);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionIndexapprove()
    {
        return $this->render('index', $this->listIndex('approve'));
    }

    public function actionIndexdetail(){
        $this->layout = 'blank';
        $searchModel = new SearchInstructionDisposalDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->session->get('idInstWhTr'));
        $count = InstructionDisposalDetail::find()->andWhere(['id_instruction_disposal' => Yii::$app->session->get('idInstWhTr')])->count();
        Yii::$app->session->set('countGrfDetail', $count);

        return $this->render('indexdetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single InstructionDisposal model.
     * @param integer $id
     * @return mixed
     */
    private function detailView($id)
    {   
    $model = $this->findModel($id);
    
    $searchModel = new SearchInstructionDisposalDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $id);
    
    Yii::$app->session->set('idInstWhTr', $model->id);
    
        return [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function actionView($id){
    echo basename(Yii::$app->request->referrer);
    
    $basename = explode('?', basename(Yii::$app->request->referrer));
    if ($basename[0] == 'view'){
      return $this->redirect(['index']);
      // throw new \yii\web\HttpException(405, 'The requested Page could not be access.');
    }
    $this->layout = 'blank';
    return $this->render('view', $this->detailView($id));
  }

  public function actionViewapprove($id){
    $this->layout = 'blank';
    return $this->render('view', $this->detailView($id));
  }

    /**
     * Creates a new InstructionDisposal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'blank';
        $model = new InstructionDisposal();

        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = 'create';
            $model->id_modul = $this->id_modul;

            if ($model->load(Yii::$app->request->post())) {
            $newidinst = InstructionDisposal::find()->andWhere(['and',['like', 'instruction_number', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
            $newidinstexist = InstructionDisposal::find()->andWhere(['and',['instruction_number' => $newidinst],['id_modul' => $model->id_modul]])->exists();
            $newidinst++;
            
            $monthroman = Numbertoroman::convert(date('n'));
            
            $model->instruction_number = sprintf("%04d", $newidinst).'/INST-IC1/DSP/'.$monthroman.date('/Y');


            $newidinst1 = InstructionDisposal::find()->andWhere(['and',['like', 'no_iom', '%/'.date('Y'), false],['id_modul' => $model->id_modul]])->count() + 1;
            $newidinstexist = InstructionDisposal::find()->andWhere(['and',['no_iom' => $newidinst1],['id_modul' => $model->id_modul]])->exists();
            $newidinst1++;
            
            $monthroman = Numbertoroman::convert(date('n'));

            $model->no_iom = sprintf("%04d", $newidinst1).'/IOM/INT/DIV1/'.$monthroman.date('/Y');
            
            $model->status_listing = 1;

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
            // Yii::$app->session->set('idInstructionDisposal',$model->id);
            // return var_dump($model);
            
            if (!file_exists($filepath.$model->id.'/')) {
                mkdir($filepath.$model->id.'/', 0777, true);
            }
            move_uploaded_file($_FILES['file']['tmp_name'], $model->file_attachment);
            
            return 'success';
        } 
    } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //     return $this->redirect(['index', 'id' => $model->id]);

    /**
     * Updates an existing InstructionDisposal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

  // public function actionCreatedetail($id){
  //       $this->layout = 'blank';
        
  //       if (Yii::$app->request->isPost&& empty(Yii::$app->request->post('SearchMasterItemIm'))){
  //           $data_im_code   = Yii::$app->request->post('im_code');
  //           $data_r_good    = Yii::$app->request->post('rgood');
  //           // $data_r_notgood = Yii::$app->request->post('rnotgood');
  //           // $data_r_reject  = Yii::$app->request->post('rreject');
            
  //           $model = new InstructionDisposalDetail();
  //           foreach($data_im_code as $key => $value){
  //               if($data_r_good[$key] == '')
  //               // if($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '')
  //                   continue;
            
  //               $dataCreate[] = [
  //                   'id_instruction_disposal' => $id,
  //                   'created_by' => Yii::$app->user->identity->id,
  //                   'id_item_im'    => $value,
  //                   'req_good'  => $data_r_good[$key],
  //                   // 'req_not_good'   => $data_r_notgood[$key],
  //                   'req_not_good'  => 0,
  //                   // 'req_reject' => $data_r_reject[$key],
  //                   'req_reject'    => 0,
  //               ];
  //           }
  //           $detail = Yii::$app->db->createCommand()->batchInsert('instruction_disposal_detail', [
  //               'id_instruction_disposal',
  //               'created_by',
  //               'id_item_im',
  //               'req_good',
  //               'req_not_good',
  //               'req_reject',
  //           ], $dataCreate);
  //           try{
  //               $detail->execute();
                
  //               return 'success';
  //           }catch(\yii\db\Exception $e){
  //               return $e->getMessage();
  //           }
            
  //       }
        
  //       $searchModel = new SearchMasterItemIm();
  //       $dataProvider = $searchModel->search(Yii::$app->request->post());

  //       return $this->render('createdetail', [
  //           'searchModel' => $searchModel,
  //           'dataProvider' => $dataProvider,
  //       ]);
  //   }


    //  public function actionCreatedetail($id){
    //     $this->layout = 'blank';
        
    //     if (Yii::$app->request->isPost&& empty(Yii::$app->request->post('SearchMasterItemIm'))){
    //         $data_im_code   = Yii::$app->request->post('im_code');
    //         $data_r_good    = Yii::$app->request->post('rgood');
    //         // $data_r_notgood = Yii::$app->request->post('rnotgood');
    //         // $data_r_reject  = Yii::$app->request->post('rreject');
            
    //         $model = new InstructionDisposalDetail();
    //         foreach($data_im_code as $key => $value){
    //             if($data_r_good[$key] == '')
    //             // if($data_r_good[$key] == '' && $data_r_notgood[$key] == '' && $data_r_reject[$key] == '')
    //                 continue;
            
    //             $dataCreate[] = [
    //                 'id_instruction_disposal' => $id,
    //                 'created_by' => Yii::$app->user->identity->id,
    //                 'id_item_im'    => $value,
    //                 'req_good'  => $data_r_good[$key],
    //                 // 'req_not_good'   => $data_r_notgood[$key],
    //                 'req_not_good'  => 0,
    //                 // 'req_reject' => $data_r_reject[$key],
    //                 'req_reject'    => 0,
    //             ];
    //         }
    //         $detail = Yii::$app->db->createCommand()->batchInsert('instruction_disposal_detail', [
    //             'id_instruction_disposal',
    //             'created_by',
    //             'id_item_im',
    //             'req_good',
    //             'req_not_good',
    //             'req_reject',
    //         ], $dataCreate);
    //         try{
    //             $detail->execute();
                
    //             return 'success';
    //         }catch(\yii\db\Exception $e){
    //             return $e->getMessage();
    //         }
            
    //     }
        
    //     $searchModel = new SearchMasterItemIm();
    //     $dataProvider = $searchModel->search(Yii::$app->request->post());

    //     return $this->render('createdetail', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionUploaddetail($upload = 'append'){
        $this->layout = 'blank';
        $model = new UploadForm();
        $model->scenario = 'xls';
        Yii::$app->session->set('upload', $upload);

        if (isset($_FILES['file']['size'])) {
            if($_FILES['file']['size'] != 0) {
                Yii::$app->session->remove('countGrfDetail');
                $filename=('Uploads/'.$_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], 'Uploads/'.basename( $_FILES['file']['name']));
                $datas = \moonland\phpexcel\Excel::import($filename, [
                    'setFirstRecordAsKeys' => true,
                    // 'setIndexSheetByName' => true,
                ]);
                if (isset($datas[0][0])) {
                    $datas = $datas[0];
                }
                // NetproGrfDetail::deleteAll('id_netpro_grf = '.Yii::$app->session->get('idInstructionDisposal'));
                // save OLD data before insert a new one
                $oldIdDetail = InstructionDisposalDetail::find()->select('id')->andWhere(['id_instruction_disposal' => Yii::$app->session->get('idInstWhTr')])->all();
                $newiddetail = [];
                $row = 9;
                $periksa = "\nplease check on row ";
                $reqCol = [
                    'IM CODE' => '',
                    'Total Qty' => '',
                    'UOM Penjualan' => '',
                    'Qty Konversi' => '',
                    'UOM Lama' => '',
                    'Konversi' => '',
                    'UOM Baru' => '',
                    'Qty Total' => '',
                    'UOM' => '',


                ];
                $errorSum = '';
                $newmaterial = [];
                foreach ($datas as $data) {
                    // periksa setiap kolom yang wajib ada, hanya di awal row
                    if ($row == 9) {
                        $missCol = array_diff_key($reqCol,$data);
                        if (count($missCol) > 0) {
                            // NetproGrfDetail::deleteAll('id_netpro_grf = '.Yii::$app->session->get('idInstructionDisposal'));
                            return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                        }
                    }
                    if ($data['IM CODE'] == '' && $data['Total Qty'] == ''&& $data['UOM Penjualan'] == ''&& $data['Qty Konversi'] == ''&& $data['UOM Lama'] == ''&& $data['Konversi'] == ''&& $data['Uom Baru'] == ''&& $data['Qty Total'] == ''&& $data['Uom'] == '') {
                        continue;
                    }
                    $model = new InstructionDisposalDetail();
                    $modelInstructionDisposal = InstructionDisposal::findOne(Yii::$app->session->get('idInstWhTr'));

                    $model->id_instruction_disposal = Yii::$app->session->get('idInstWhTr');
                    $model->im_code = $this->findIdreference($data['IM CODE']);
                    // $model->material_requested = $model->needed;
                    $model->qty = $data['Total Qty'];
                    $model->uom_sale = $data['UOM Penjualan'];
                    $model->qty_konversi = $data['Qty Konversi'];
                    $model->uom_old = $data['UOM Lama'];
                    $model->konversi = $data['Konversi'];
                    $model->uom_new = $data['UOM Baru'];
                    $model->qty_total = $data['Qty Total'];
                    $model->uom = $data['UOM'];
                    // $model->used = $model->needed;
                    // $model->uom = $this->findIdreference($data['MATERIAL'], 'unit');

                    $cek = $this->cekMultiple(Yii::$app->session->get('idInstWhTr'), $model->im_code);

                    if ($cek !== null) {
                        // NetproGrfDetail::deleteAll('id_netpro_grf = '.Yii::$app->session->get('idInstructionDisposal'));
                        if (Yii::$app->session->get('upload') == 'replace' && $cek == self::ERR_DUPLICATE_ITEM) {
                            if (in_array($model->im_code, $newmaterial)){
                                $errorSum .= $cek.$periksa.$row."\n";
                            }else{
                                $newmaterial[] = $model->im_code;
                                $errorSum .= $cek.$periksa.$row."\n";
                            }
                        }else {
                            $errorSum .= $cek.$periksa.$row."\n";
                        }
                    }
                    // return $model->id_instruction_disposal;
                    
                    // return var_dump($model->im_code);

                    if(!$model->save() && $cek == null) {
                        // NetproGrfDetail::deleteAll('id_netpro_grf = '.Yii::$app->session->get('idInstructionDisposal'));
                        $error = $model->getErrors();
                        $error['line'] = [$periksa.$row];
                        $errorSum .= Displayerror::pesan($error)."\n";
                        
                    }
                    $newmaterial[] = $model->im_code;
                    array_push($newiddetail, $model->id);
                    $row++;
                }

                if (!empty($errorSum)) {
                    // delete all grf detail data based on id_netpro_grf and not in old data
                    InstructionDisposalDetail::deleteAll(['and', ['id_instruction_disposal' => Yii::$app->session->get('idInstWhTr')], ['id' => $newiddetail]]);
                    // NetproGrfDetail::deleteAll('id_netpro_grf = '.Yii::$app->session->get('idInstructionDisposal'));
                    return $errorSum;
                }else {
                    // there's no error
                    // check user confirmation about replace or append
                    if (Yii::$app->session->get('upload') == 'replace') {
                    // if ($upload == 'replace') {
                        InstructionDisposalDetail::deleteAll(['and', ['id_instruction_disposal' => Yii::$app->session->get('idInstWhTr')], ['id' => $oldIdDetail]]);
                    }
                }
                // $modelInstructionDisposal->status_netpro_grf_detail = 1;
                // $modelInstructionDisposal->status_listing = 1;
                $modelInstructionDisposal->save();
                // $this->createLog($modelInstructionDisposal);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $success = true;
                return 'success';
            }
        }
        $count = InstructionDisposalDetail::find()->andWhere(['id_instruction_disposal' => Yii::$app->session->get('idInstWhTr')])->count();
        Yii::$app->session->set('countGrfDetail', $count);
        return $this->render('@common/views/uploadformdisposal', [
            'model' => $model,
        ]);
    }

    protected function cekMultiple($id, $item)
    {
        // if (!is_numeric($item)) {
        //     return "Item is not register on system";
        // }
        $cek = InstructionDisposalDetail::find()
                ->andFilterWhere(['id_instruction_disposal' => $id])
                ->andFilterWhere(['im_code' => $item,])
                ->one();

        if ($cek !== null) {
            // return "Item has been inputted, for the change please update.";
            return self::ERR_DUPLICATE_ITEM;
        }else {
            return $cek;
        }
    }

    public function actionUpdate($id)
    {
         $this->layout = 'blank';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    } 

     protected function findIdreference($data, $col = 'id'){
        $data = explode(' (',$data);
        $id = MasterItemIm::find()->where(['im_code' => $data[0]])->one();
        if ($id !== null) {
            if ($col == 'name') {
                return $id->unit;
            }else {
                return $id->id;
            }
        }else {
            return $data;
        }
    }

    /**
     * Deletes an existing InstructionDisposal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
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
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InstructionDisposal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstructionDisposal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstructionDisposal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
