<?php

namespace logistik\controllers;

use Yii;
use common\models\InboundWhTransfer;
use common\models\LogInboundWhTransfer;
use common\models\InboundWhTransferDetail;
use common\models\InboundWhTransferDetailSn;
use common\models\SearchInboundWhTransfer;
use common\models\SearchLogInboundWhTransfer;
use common\models\SearchInboundWhTransferDetail;
use common\models\SearchInboundWhTransferDetailSn;

use common\models\OutboundWhTransfer;
use common\models\OutboundWhTransferDetail;
use common\models\OutboundWhTransferDetailSn;
use common\models\SearchOutboundWhTransfer;
use common\models\SearchOutboundWhTransferDetail;
use common\models\SearchOutboundWhTransferDetailSn;

use common\models\InstructionWhTransfer;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\UploadForm;
use common\models\MasterItemIm;
use common\models\MasterItemImDetail;
use common\models\MasterSn;
use common\models\LogMasterSn;
use common\models\UserWarehouse;
use common\models\Warehouse;

use common\widgets\Displayerror;
use common\widgets\Email;
use yii\helpers\Url;
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
     * Lists all InboundWhTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul, 'input', NULL, $arrIdWarehouse);

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

	public function actionIndexverify()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul, 'verify', NULL, $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndexapprove()
    {
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul, 'approve', NULL, $arrIdWarehouse);

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
		$arrIdWarehouse = $this->getIdWarehouse();
        $searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'tagsn', NULL, $arrIdWarehouse);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionIndextagsnapprove(){
		$arrIdWarehouse = $this->getIdWarehouse();
		$searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'tagsnapprove', NULL, $arrIdWarehouse);

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
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $id);

        // untuk data new received (50) arahkan ke action update
        $modelInbound = InboundWhTransfer::findOne($id);
        if($modelInbound !== null){
        	$modelInbound = 'update';
        }else{
        	$modelInbound = 'create';
        }

		return $this->render('viewoutbound', [
            'model' => $model,
            'modelInbound' => $modelInbound,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionViewinbound($id){
		$this->layout = 'blank';

		$model = $this->findModelJoinOutbound($id);
		$searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(),$this->id_modul,'viewinbounddetail', $id);

		return $this->render('view', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
	}

    public function actionViewtagsn($id)
    {
        $this->layout = 'blank';

		$searchModel = new SearchInboundWhTransfer();
        // $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams,'detail_sn', $id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'detail_sn', $id);
		// return print_r($dataProvider->models);
		$model = $this->findModelJoinOutbound($id);

		Yii::$app->session->set('idInboundWh',$id);

        return $this->render('viewtagsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }

	public function actionViewtagsnapprove($id)
    {
        $this->layout = 'blank';

		$model = InboundWhTransferDetail::find()->andWhere(['id_inbound_wh' => $id])->one();
		$searchModel = new SearchInboundWhTransferDetailSn();
        $dataProvider = $searchModel->searchByRetagsnapprove(Yii::$app->request->queryParams, $id);

		Yii::$app->session->set('idInboundWh',$id);

        return $this->render('retagsn', [
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

	public function actionViewreportverify($id){
		$this->layout = 'blank';
		$arrIdWarehouse = $this->getIdWarehouse();
		$searchModel = new SearchInboundWhTransfer();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul,'verifydetail', $id, $arrIdWarehouse);

		$model = $this->findModelJoinOutbound($id);

		Yii::$app->session->set('idInboundWh',$id);

        return $this->render('viewreport', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
	}

	public function actionViewreportapprove($id)
    {
		$this->layout = 'blank';
		$arrIdWarehouse = $this->getIdWarehouse();
		$searchModel = new SearchInboundWhTransfer();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->id_modul,'verifydetail', $id, $arrIdWarehouse);

		$model = $this->findModelJoinOutbound($id);

		Yii::$app->session->set('idInboundWh',$id);

        return $this->render('viewreport', [
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

	public function actionViewdetailsn($idInboundWhDetail)
    {
		// if($idInboundWhDetail == NULL){
			// $idInboundWhDetail = \Yii::$app->session->get('idInboundWhDetail');

		// }
		$this->layout = 'blank';

		$searchModel = new SearchInboundWhTransferDetailSn();
        $dataProvider = $searchModel->searchByAction(Yii::$app->request->queryParams, $idInboundWhDetail);


		$model = InboundWhTransferDetail::findOne($idInboundWhDetail);

		//Yii::$app->session->set('idInboundWh',$id);

        return $this->render('viewdetailsn', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
    }

	public function actionUploadsn($id, $idInboundWh) {
        $this->layout = 'blank';
        $model = new UploadForm();

        $model->scenario = 'xls';

        if (isset($_FILES['file']['size'])) {
            if($_FILES['file']['size'] != 0) {
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
                //InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.Yii::$app->session->get('idInboundWhDetail'));
                $row = 2;
                $periksa = "\nplease check on row ";
                $reqCol = [
                	'SERIAL_NUMBER' => '',
                	'MAC_ADDRESS' => '',
					'CONDITION' => '',
                ];

				// get max quantity based on detail
				$modelDetail = InboundWhTransferDetail::findOne($id);
				$maxQty = $modelDetail->qty;

				//get max quantity based on detail
				// $modelOutboundDetail = OutboundWhTransferDetail::findOne($id);
				$modelOutboundDetail = OutboundWhTransferDetail::find()->andWhere(['and',['id_item_im' => $modelDetail->id_item_im],['id_outbound_wh' => $modelDetail->id_inbound_wh]])->one();
				$maxQtyGood 			= $modelOutboundDetail->req_good;
				$maxQtyNotGood 			= $modelOutboundDetail->req_not_good;
				$maxQtyReject 			= $modelOutboundDetail->req_reject;
				$maxQtyDismantle 	    = $modelOutboundDetail->req_dismantle;
                $maxQtyRevocation       = $modelOutboundDetail->req_revocation;
                $maxQtyGoodRec          = $modelOutboundDetail->req_good_rec;
				$maxQtyGoodforRecond    = $modelOutboundDetail->req_good_for_recond;

				// prepare modelmasteritem
				$modelMasterItemDetail = MasterItemImDetail::find();

				// get quantity already upload
				$modelSn = InboundWhTransferDetailSn::find()->andWhere(['id_inbound_wh_detail' => $id]);
				$qtySn = $modelSn->count();
				$qtyGood 			= $modelSn->andWhere(['condition' => 'good'])->count();
				$qtyNotGood 		= $modelSn->andWhere(['condition' => 'not good'])->count();
				$qtyReject 			= $modelSn->andWhere(['condition' => 'reject'])->count();
				$qtyDismantle 	    = $modelSn->andWhere(['condition' => 'dismantle'])->count();
                $qtyRevocation      = $modelSn->andWhere(['condition' => 'revocation'])->count();
                $qtyGoodRec         = $modelSn->andWhere(['condition' => 'good recondition'])->count();
				$qtyGoodforRecond   = $modelSn->andWhere(['condition' => 'good for recondition'])->count();

				$newIdSn = [];
				$retagSn = 0;
                foreach ($datas as $key => $data) {
					// periksa setiap kolom yang wajib ada, hanya di awal row
                    if ($row == 2) {
                    	$missCol = array_diff_key($reqCol,$data);
                    	if (count($missCol) > 0) {
                    		return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                    	}
                    }

					if ($data['SERIAL_NUMBER'] == '' && $data['MAC_ADDRESS'] == '' && $data['CONDITION'] == '' ){
						continue;
					}
                    $model = new InboundWhTransferDetailSn();

                    $model->id_inbound_wh_detail = $id;
                    $model->serial_number = (string)$data['SERIAL_NUMBER'];
                    $model->mac_address = (string)$data['MAC_ADDRESS'];
					$model->condition = strtolower($data['CONDITION']);

					$qtySn++;
					if($qtySn > $maxQty){
						InboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
						return 'Quantity cannot be more than '. $maxQty;
					}

                    // update qty based on condition
					switch(strtolower($model->condition)){
						case 'good':
							$modelDetail->qty_good++;
							$qtyGood++;
						break;
						case 'not good':
							$modelDetail->qty_not_good++;
							$qtyNotGood++;
						break;
						case 'reject':
							$modelDetail->qty_reject++;
							$qtyReject++;
						break;
						case 'dismantle':
							$modelDetail->qty_dismantle++;
							$qtyDismantle++;
						break;
						case 'revocation':
							$modelDetail->qty_revocation++;
							$qtyRevocation++;
						break;
                        case 'good recondition':
                            $modelDetail->qty_good_rec++;
                            $qtyGoodRec++;
                        break;
                        case 'good for recondition':
                            $modelDetail->qty_good_for_recond++;
                            $qtyGoodforRecond++;
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

                    if ($qtyGoodRec > $maxQtyGoodRec){
                        $maxErr = 'Quantity Good Recondition cannot be more than '. $maxQtyGoodRec;
                    }

                    if ($qtyGoodforRecond > $maxQtyGoodforRecond){
                        $maxErr = 'Quantity Good for Recondition cannot be more than '. $maxQtyGoodforRecond;
                    }

					if ($maxErr != ''){
						// delete new data only
						InboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
						return $maxErr;
					}

                    // validasi SN / Mac
					$tocheck = [];
					if ( !is_string($model->serial_number) ) {
						// hanya ada Mac
						$tocheck = ['mac_address' => $model->mac_address];
					}else{
						$tocheck = ['serial_number' => $model->serial_number];
					}
					$cekSn = OutboundWhTransferDetailSn::find()->andWhere($tocheck)->exists();

					$modelstock = null;
                    $modelMasterSn = null;

					if (!$cekSn){
						$retagSn++;
						$model->status_retagsn = 1;
						$columnstock = 'qty_'.str_replace(' ', '_', $model->condition);
						$modelDetail->{$columnstock} -= 1;
					}else{
						// same SN, save qty
						$columnstock = 's_'.str_replace(' ', '_', $model->condition);
						$modelstock = $modelMasterItemDetail
							->andWhere(['id_warehouse' => $modelDetail->idInboundWh->idOutboundWh->idInstructionWh->wh_destination])
							->andWhere(['id_master_item_im' => $modelDetail->id_item_im])->one();
						if ( $modelstock === null ){
							$modelstock = new MasterItemImDetail();
							$modelstock->id_warehouse = $modelDetail->idInboundWh->idOutboundWh->idInstructionWh->wh_destination;
							$modelstock->id_master_item_im = $modelDetail->id_item_im;
						}
						// $modelstock->{$columnstock} += 1;
						// save dibawah

                        // simpan data di mastersn
    					$modelMasterSn = MasterSn::find()->andWhere($tocheck)
                            ->andWhere(['id_warehouse' => $modelDetail->idInboundWh->idOutboundWh->idInstructionWh->wh_origin]) // ambil masterSN dari wh asal
                            ->andWhere(['status' => 27])
                            ->one();
    					if ($modelMasterSn !== null){
                            $modelMasterSn->last_transaction = 'TAG SN INBOUND WH '
                                .$modelDetail->idInboundWh->idOutboundWh->idInstructionWh->whDestination->nama_warehouse;
                            $modelMasterSn->condition = $model->condition;
                            $modelMasterSn->id_warehouse = $modelDetail->idInboundWh->idOutboundWh->idInstructionWh->wh_destination;
    					}else{
                            // tidak ada di master SN
                            InboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
                            return 'Serial number: '.$model->serial_number.' dengan kondisi '.$data['CONDITION'].', tidak terdaftar dalam sistem';
                        }
                        // save dibawah
                        // save di submit
    					// simpan data di mastersn
					}
					// validasi SN / Mac

                    
                    if(!$model->save()) {
                        InboundWhTransferDetailSn::deleteAll(['id' => $newIdSn]);
                        $error = $model->getErrors();
                        $error['line'] = [$periksa.$row];
                        return Displayerror::pesan($model->getErrors());
                    }

                    // if ($modelstock != null){
                    if ($modelMasterSn != null){
						// $modelstock->save();
	                    $modelMasterSn->save();
						$this->createLogmastersn($modelMasterSn);
                    }

					$modelDetail->save();
					$newIdSn[] = $model->id;
                    $row++;
                }

				// cek if SN need re Tag SN
				if ( $retagSn > 0 ){
					return "Serial Number yang anda masukkan tidak ditemukan.\nSilahkan melakukan tagging SN kembali !";
				}

				if ( $maxQty == $qtySn ){
					$modelDetail->status_tagsn = 42; //tag inputted (tag sn sudah melakukan tugasnya, masih mungkin ada barang yang belum diterima)
				}else{
					$modelDetail->status_tagsn = 44; //tag sn belum selesai
				}

				$modelDetail->save();

				// $modelInboundWhTransferDetail = InboundWhTransferDetail::find()->andWhere(['id_inbound_wh' => $modelDetail->id_inbound_wh ])->asArray()->all();
				// $cekStatus = 1;
                //
				// foreach($modelInboundWhTransferDetail as $key => $value){
				// 	if ($value['status_tagsn'] != 41){
				// 		$cekStatus++;
				// 	}
				// }
                //
				// $modelInbound = $this->findModel($idInboundWh);
				// if ($cekStatus == 1){
				// 	$modelInbound->status_tagsn = 41;
				// }else{
				// 	$modelInbound->status_tagsn = 43;
				// }
				// $modelInbound->save();

                return 'success';
            }
        }
		// print_r($id);
		Yii::$app->session->set('id', $id);
		Yii::$app->session->set('idInboundWh', $idInboundWh);
        return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
    }

	public function actionQtycond($id){
		$this->layout = 'blank';

		$model = InboundWhTransferDetail::find()->andWhere(['inbound_wh_transfer_detail.id' => $id])->joinWith('idInboundWh.idOutboundWh.idInstructionWh')->one();

		// prepare modelmasteritem
		$modelMasterItemDetail = MasterItemImDetail::find();

		if ( Yii::$app->request->isPost ){
			$delta = Yii::$app->request->post('delta_qty');
			$qty_good 		     = Yii::$app->request->post('qty_good');
			$qty_not_good 	     = Yii::$app->request->post('qty_not_good');
			$qty_reject 	     = Yii::$app->request->post('qty_reject');
			$qty_dismantle 	     = Yii::$app->request->post('qty_dismantle');
            $qty_revocation      = Yii::$app->request->post('qty_revocation');
            $qty_good_rec        = Yii::$app->request->post('qty_good_rec');
			$qty_good_for_recond = Yii::$app->request->post('qty_good_for_recond');

			if ($delta < 0){
				return 'Qty is more than Delta';
			}else if ($delta == 0){
				$model->status_tagsn = 41; // uncompleted

			}

			$modelstock = $modelMasterItemDetail->andWhere(['and',['id_warehouse' => $model->idInboundWh->idOutboundWh->idInstructionWh->wh_destination],['id_master_item_im' => $model->id_item_im]])->one();
			// kurangi data sebelum qtycond
            if ($model->status_stock == 1) {
    			$modelstock->s_good	            -= $model->qty_good;
    			$modelstock->s_not_good	        -= $model->qty_not_good;
    			$modelstock->s_reject	        -= $model->qty_reject;
    			$modelstock->s_dismantle	    -= $model->qty_dismantle;
                $modelstock->s_revocation       -= $model->qty_revocation;
                $modelstock->s_good_rec         -= $model->qty_good_rec;
    			$modelstock->s_good_for_recond	-= $model->qty_good_for_recond;
            }

			$model->qty_good 		        = $qty_good;
			$model->qty_not_good 	        = $qty_not_good;
			$model->qty_reject 		        = $qty_reject;
			$model->qty_dismantle 	        = $qty_dismantle;
            $model->qty_revocation          = $qty_revocation;
            $model->qty_good_rec            = $qty_good_rec;
			$model->qty_good_for_recond 	= $qty_good_for_recond;

			// $modelOutboundDetail = OutboundWhTransferDetail::findOne($model->id_outbound_wh_detail);
			$modelOutboundDetail = OutboundWhTransferDetail::find()->andWhere(['and',['id_outbound_wh' => $model->id_inbound_wh],['id_item_im' => $model->id_item_im]])->one();
			$maxQtyGood 			= $modelOutboundDetail->req_good;
			$maxQtyNotGood 			= $modelOutboundDetail->req_not_good;
			$maxQtyReject 			= $modelOutboundDetail->req_reject;
			$maxQtyDismantle 	    = $modelOutboundDetail->req_dismantle;
            $maxQtyRevocation       = $modelOutboundDetail->req_revocation;
            $maxQtyGoodRec      = $modelOutboundDetail->req_good_rec;
			$maxQtyGoodforRecond    = $modelOutboundDetail->req_good_for_recond;

			$maxErr = '';
			if ($qty_good > $maxQtyGood){
				$maxErr = 'Quantity Good cannot be more than '. $maxQtyGood;
			}

			if ($qty_not_good > $maxQtyNotGood){
				$maxErr = 'Quantity Not Good cannot be more than '. $maxQtyNotGood;
			}

			if ($qty_reject > $maxQtyReject){
				$maxErr = 'Quantity Reject cannot be more than '. $maxQtyReject;
			}

			if ($qty_dismantle > $maxQtyDismantle){
				$maxErr = 'Quantity Dismantle cannot be more than '. $maxQtyDismantle;
			}

			if ($qty_revocation > $maxQtyRevocation){
				$maxErr = 'Quantity Revocation cannot be more than '. $maxQtyRevocation;
			}

            if ($qty_good_rec > $maxQtyGoodRec){
                $maxErr = 'Quantity Good Recondition cannot be more than '. $maxQtyGoodRec;
            }

            if ($qty_good_for_recond > $maxQtyGoodforRecond){
                $maxErr = 'Quantity Good for Recondition cannot be more than '. $maxQtyGoodforRecond;
            }

			if ($maxErr != ''){
				return $maxErr;
			}

            
			$model->save();

			// save stock
			$modelstock->s_good	+= $model->qty_good;
			$modelstock->s_not_good	+= $model->qty_not_good;
			$modelstock->s_reject	+= $model->qty_reject;
			$modelstock->s_dismantle	+= $model->qty_dismantle;
            $modelstock->s_revocation   += $model->qty_revocation;
            $modelstock->s_good_rec   += $model->qty_good_rec;
			$modelstock->s_good_for_recond	+= $model->qty_good_for_recond;

			// return var_dump($modelstock);
            // save di submit
			// $modelstock->save();

			// $modelInboundWhTransferDetail = InboundWhTransferDetail::find()->andWhere(['id_inbound_wh' => $model->id_inbound_wh ])->asArray()->all();
			// $cekStatus = 1;
            //
			// foreach($modelInboundWhTransferDetail as $key => $value){
			// 	if ($value['status_tagsn'] != 41){
			// 		$cekStatus++;
			// 	}
			// }
            //
			// $modelInbound = $this->findModel($model->id_inbound_wh);
			// if ($cekStatus == 1){
			// 	$modelInbound->status_tagsn = 41;
			// }else{
			// 	$modelInbound->status_tagsn = 43;
			// }
			// $modelInbound->save();

			return 'success';
		}

		$searchModel = new SearchInboundWhTransferDetail();
        $dataProvider = $searchModel->search(Yii::$app->request->QueryParams, $id);

		return $this->render('qtycond', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

    public function actionSubmitsn($id)
    {
        $modelInboundWhTransferDetail = InboundWhTransferDetail::find()->andWhere(['id_inbound_wh' => $id ])->all();        
        
        $arrTagsn = [];
        foreach($modelInboundWhTransferDetail as $key => $value){
            if ( !in_array($value->status_tagsn, $arrTagsn) ) {
                array_push($arrTagsn, $value->status_tagsn);
            }

            // save stock
            if ($value->idItemIm->sn_type == 1 && $value->status_stock == 0) {
                // SN
                $modelstock = null;
                foreach ($value->inboundWhTransferDetailSns as $detailsn) {
                    // detail SN
                    if ($detailsn->status_retagsn != 1) {
                        $columnstock = 's_'.str_replace(' ', '_', $detailsn->condition);
                        $modelstock = MasterItemImDetail::find()
                            ->andWhere(['id_warehouse' => $value->idInboundWh->idOutboundWh->idInstructionWh->wh_destination])
                            ->andWhere(['id_master_item_im' => $value->id_item_im])
                            ->one();
                        // return var_dump($modelstock);
                        if ( $modelstock === null ){
                            $modelstock = new MasterItemImDetail();
                            $modelstock->id_warehouse = $value->idInboundWh->idOutboundWh->idInstructionWh->wh_destination;
                            $modelstock->id_master_item_im = $value->id_item_im;
                        }
                        $modelstock->{$columnstock} += 1;

                        $value->status_stock = 1;

                        $modelstock->save();
                    }
                }                

            }else if($value->idItemIm->sn_type == 2 && $value->status_stock == 0){
                // NON SN
                $modelstock = MasterItemImDetail::find()
                    ->andWhere(['and',
                            ['id_warehouse' => $value->idInboundWh->idOutboundWh->idInstructionWh->wh_destination],
                            ['id_master_item_im' => $value->id_item_im]])
                    ->one();
                if ($modelstock !== null) {
                    // save stock
                    $modelstock->s_good             += $value->qty_good;
                    $modelstock->s_not_good         += $value->qty_not_good;
                    $modelstock->s_reject           += $value->qty_reject;
                    $modelstock->s_dismantle        += $value->qty_dismantle;
                    $modelstock->s_revocation       += $value->qty_revocation;
                    $modelstock->s_good_rec         += $value->qty_good_rec;
                    $modelstock->s_good_for_recond  += $value->qty_good_for_recond;

                    $modelstock->save();
                    if (($value->qty_good + $value->qty_not_good + $value->qty_reject + $value->qty_dismantle + $value->qty_revocation + $value->qty_good_rec + $value->qty_good_for_recond) > 0) {
                        $value->status_stock = 1;
                    }
                }
            }

            
            $value->save();
            //end foreach detail
        }

        $modelInbound = $this->findModel($id);
        if ( in_array(44, $arrTagsn) && count($arrTagsn) == 1) {
            // all 44 not registered
            $modelInbound->status_tagsn = 999;
        }elseif (in_array(42, $arrTagsn) && count($arrTagsn) == 1) {
            // all 42 tag inputted
            $modelInbound->status_tagsn = 41;
        }else{
            $modelInbound->status_tagsn = 43;
        }
        
        $modelInbound->save();

        return 'success';
    }

	public function actionSetsessiondetail(){
		if (Yii::$app->request->isPost){
			$data = Yii::$app->session->get('detailinbound');

			$id   = Yii::$app->request->post('id');
			$val  = Yii::$app->request->post('val');

			$data[$id] = $val;

			Yii::$app->session->set('detailinbound', $data);
			return var_dump($data);
		}
	}

    public function actionResetsn($idInboundWhDetail)
    {
		$model = InboundWhTransferDetail::find()->andWhere(['inbound_wh_transfer_detail.id' => $idInboundWhDetail])->joinWith('idInboundWh.idOutboundWh.idInstructionWh')->one();

		$modelMasterItemDetail = MasterItemImDetail::find()
		// ->andWhere(['id_warehouse' => $model->idInboundWh->idOutboundWh->idInstructionWh->wh_destination])
		;
		// menggunakan variable reference
        $where = ['and', ['id_warehouse' => $model->idInboundWh->idOutboundWh->idInstructionWh->wh_destination], ['id_master_item_im' => &$id_item_im]];

        // if ( $model->idItemIm->idMasterItemIm->sn_type != 2 ){
		if ( $model->idItemIm->sn_type != 2 ){
			$modeldetailSn = InboundWhTransferDetailSn::find()->andWhere(['id_inbound_wh_detail' => $idInboundWhDetail])->andWhere(['inbound_wh_transfer_detail_sn.status_retagsn' => null])->all();
			foreach ($modeldetailSn as $key => $modelSn){
                $id_item_im = $modelSn->idInboundWhDetail->id_item_im;
				$columnstock = 's_'.str_replace(' ', '_', $modelSn->condition);
				$modelstock = $modelMasterItemDetail->andWhere($where)->one();
				$modelstock->{$columnstock} -= 1;
				$modelstock->save();
			}

			// delete rest SN (SN that need approval)
			// InboundWhTransferDetailSn::deleteAll('id_inbound_wh_detail = '.$idInboundWhDetail);
            $modeldetailsn = InboundWhTransferDetailSn::find()->andWhere(['id_inbound_wh_detail' => $idInboundWhDetail])->all();
    		foreach($modeldetailsn as $modelsn){
    			if ( is_string($modelsn->serial_number) ){
    				$where = ['serial_number' => $modelsn->serial_number];
    			}else{
    				$where = ['mac_address' => $modelsn->mac_address];
    			}
    			$modelMasterSn = MasterSn::find()->andWhere($where)->andWhere(['status' => 27])->one();
    			if($modelMasterSn !== null){
	    			$modelMasterSn->last_transaction = $modelMasterSn->prev_last_transaction;
	    			$modelMasterSn->condition = $modelMasterSn->last_condition;
	    			$modelMasterSn->id_warehouse = $modelsn->idInboundWhDetail->idInboundWh->idOutboundWh->idInstructionWh->wh_origin;
	    			$modelMasterSn->save();
					$this->createLogmastersn($modelMasterSn);
    			}

    			$modelsn->delete();
    		}

		}else{
			//reset stock for Item who does not have SN
            $id_item_im = $model->id_item_im;
			$modelstock = $modelMasterItemDetail->andWhere($where)->one();
			$modelstock->s_good	-= $model->qty_good;
			$modelstock->s_not_good	-= $model->qty_not_good;
			$modelstock->s_reject	-= $model->qty_reject;
			$modelstock->s_dismantle	-= $model->qty_dismantle;
            $modelstock->s_revocation   -= $model->qty_revocation;
            $modelstock->s_good_rec   -= $model->qty_good_rec;
			$modelstock->s_good_for_recond	-= $model->qty_good_for_recond;

			$modelstock->save();

		}
		$model->qty_good			= 0;
		$model->qty_not_good		= 0;
		$model->qty_reject			= 0;
		$model->qty_dismantle		= 0;
        $model->qty_revocation      = 0;
        $model->qty_good_rec        = 0;
		$model->qty_good_for_recond	= 0;
        $model->status_tagsn        = 44;
		$model->status_stock		= 0;
		$model->save();

		$modelInboundWh = $this->findModel($model->id_inbound_wh);
		\Yii::$app->session->set('idInboundWh', $model->id_inbound_wh);

		$modelInboundWh->status_tagsn = 999;
		$modelInboundWh->save();

		return $this->actionViewtagsn($model->id_inbound_wh);
    }

	public function actionRetagsn($id){
		$this->layout = 'blank';
		$model = InboundWhTransferDetail::findOne($id);

		if (Yii::$app->request->isPost){
			$newsn  = Yii::$app->request->post('new_sn');
			$oldsn  = Yii::$app->request->post('old_sn');
			$imcode = Yii::$app->request->post('im_code');

			$countarr = count ($newsn);
			$retag = 0;

			foreach ($newsn as $key => $newsnvalue){
				if ( $oldsn[$key] == '' ){
					// SN lama kosong
					InboundWhTransferDetailSn::deleteAll(['serial_number' => $newsnvalue]);
				}else{
					$modelSn = InboundWhTransferDetailSn::find()->andWhere(['serial_number' => $newsnvalue])->one();
					$modelSn->old_serial_number = $oldsn[$key];
					$modelSn->new_id_item_im = $imcode[$key];
					$modelSn->save();
					$retag++;
				}
			}

			// update qty detail;
			$modelAllcondition = InboundWhTransferDetailSn::find()->select([new \yii\db\Expression('count(condition) as total_condition'), 'condition'])
					->andWhere(['id_inbound_wh_detail' => $id])
					->groupBy('condition')->all();
			foreach ($modelAllcondition as $modelCondition){
				switch ( $modelCondition->condition ){
					case 'good':
						$model->qty_good = $modelCondition->total_condition;
					break;
					case 'not good':
						$model->qty_not_good = $modelCondition->total_condition;
					break;
					case 'reject':
						$model->qty_reject = $modelCondition->total_condition;
					break;
					case 'dismantle':
						$model->qty_dismantle = $modelCondition->total_condition;
					break;
					case 'revocation':
						$model->qty_revocation = $modelCondition->total_condition;
					break;
                    case 'good recondition':
                        $model->qty_good_rec = $modelCondition->total_condition;
                    break;
                    case 'good for recondition':
                        $model->qty_good_for_recond = $modelCondition->total_condition;
                    break;
				}
				$model->save();
			}

			if ($retag > 0){
				$modelInbound = $this->findModel($model->id_inbound_wh);
				$modelInbound->status_retagsn = 46;
				$modelInbound->save();
			}


			return 'success';
		}

		$searchModel = new SearchInboundWhTransferDetailSn();
        $dataProvider = $searchModel->searchByRetagsn(Yii::$app->request->QueryParams, $id);

		return $this->render('retagsn', [
            'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionApproveretagsn($id){
		$model = $this->findModel($id);
        if($model->status_retagsn == 46){
            $model->status_retagsn = 5;

            if ( $model->validate()) {
				$this->createLog($model);

				$modelMasterItemDetail = MasterItemImDetail::find();

				$modeldetailSn = InboundWhTransferDetailSn::find()->joinWith('idInboundWhDetail.idInboundWh')
					->andWhere(['inbound_wh_transfer.id_outbound_wh' => $id])->andWhere(['is not', 'inbound_wh_transfer_detail_sn.status_retagsn', null])->all();
				foreach ($modeldetailSn as $key => $modelSn) {
					$modelSn->status_retagsn = null;
                    $columnstockdetail = 'qty_'.str_replace(' ', '_', $modelSn->condition);
					$columnstock = 's_'.str_replace(' ', '_', $modelSn->condition);
					$newcolumnstock = 'qty_'.str_replace(' ', '_', $modelSn->condition);
                    // return var_dump($modelSn->id_inbound_wh_detail);
					if ( $modelSn->new_id_item_im == null ){
						// hanya ganti SN

						$modelstock = $modelMasterItemDetail->andWhere(['id' => $modelSn->idInboundWhDetail->id_item_im])->one();
						$modelstock->{$columnstock} += 1;
						$modelstock->save();

					}else{
						// ganti item dan SN
						$modelinbounddetail = InboundWhTransferDetail::find()->andWhere(['id' => $modelSn->id_inbound_wh_detail])->one();
						$modelinbounddetail->qty -= 1;
						$modelinbounddetail->{$columnstockdetail} -= 1;
						$modelinbounddetail->save();
                        // TOLONG DIPERIKSA, KARENA ERROR DI BARIS 1042 (BEDA NAMA STOK) QTY JADI -1

						$modeloutbounddetail = OutboundWhTransferDetailSn::find()->andWhere(['serial_number' => $modelSn->old_serial_number])->one();
						$oldcondition = 's_'.str_replace(' ', '_', $modeloutbounddetail->condition);

						$modelstock = $modelMasterItemDetail->andWhere(['id' => $modelSn->idInboundWhDetail->id_item_im])->one();
						$modelstock->{$oldcondition} += 1; // mengembalikan stock SN lama ke gudang
						$modelstock->save();

						$modelnewstock = MasterItemImDetail::find()->andWhere(['id_master_item_im' => $modelSn->new_id_item_im])
								->andWhere(['id_warehouse' => $modelSn->idInboundWhDetail->idInboundWh->idOutboundWh->idInstructionWh->wh_origin])->one();
						$modelnewstock->{$columnstock} -= 1; // mengurangi stock SN baru dari gudang
						$modelnewstock->save();

						$modeldetail = new InboundWhTransferDetail();
						$modeldetail->id_inbound_wh = $modelinbounddetail->id_inbound_wh;
						$modeldetail->id_item_im = $modelnewstock->id;
						$modeldetail->qty = 1;
						$modeldetail->status_listing = 36;
						$modeldetail->status_tagsn = 42;
						$modeldetail->{$newcolumnstock} = 1;
						$modeldetail->save();

						$modelSn->id_inbound_wh_detail = $modeldetail->id;
						$modelSn->status_retagsn = null;

					}


					$modelSn->save();
				}

                $model->save();



				return 'success';
            } else {
                return Displayerror::pesan($model->getErrors());
            }
        }else{
            return 'Not valid for approve';
        }
	}

	public function actionApprove($id)
    {
		$model = InboundWhTransfer::find()->joinWith('inboundWhTransferDetails')
			->andWhere(['inbound_wh_transfer_detail.status_report' => 5])
			->andWhere(['inbound_wh_transfer.id_outbound_wh' => $id])
			->exists();

		if ( $model == true ){
			return 'Not valid for verify';
		}else{
			InboundWhTransferDetail::updateAll(['status_report' => 5], ['id_inbound_wh' => $id, 'status_report' => 4]);

			// update data Instruction
			$modelInstruction = InstructionWhTransfer::findOne($id);
			$modelInstruction->status_listing = 47; // report from wh
			$modelInstruction->save();            

			return 'success';

		}
    }

	public function actionVerify($id){
		$model = InboundWhTransfer::find()->joinWith('inboundWhTransferDetails')
			->andWhere(['inbound_wh_transfer_detail.status_report' => 4])
			->andWhere(['inbound_wh_transfer.id_outbound_wh' => $id])
			->exists();

		if ( $model == true ){
			return 'Not valid for verify';
		}else{
			InboundWhTransferDetail::updateAll(['status_report' => 4], ['id_inbound_wh' => $id, 'status_report' => 31]);


            $arrAuth = ['/inbound-wh-transfer/indexapprove'];
            $header = 'Alert Approval Inbound Warehouse Transfer';
            $subject = 'This document is waiting your approval. Please click this link document : '.Url::base(true).'/inbound-wh-transfer/indexapprove#viewreportapprove?id='.$model->id_outbound_wh.'&header=Detail_INBOUND_WH';
            Email::sendEmail($arrAuth,$header,$subject,$model->idOutboundWh->idInstructionWh->wh_destination);
			return 'success';

		}



	}

	public function actionReporttoic($id)
    {
        $model = $this->findModel($id);
		$data_im_code       = Yii::$app->request->post('im_code');
		$data_req_qty       = Yii::$app->request->post('req_qty');
		$rev_remark			= Yii::$app->request->post('InboundWhTransfer')['revision_remark'];

		if ($rev_remark == ''){
			return 'Revision remark can not be blank';
		}

		$model->status_listing = 31; // uncompleted
		$model->revision_remark = $rev_remark;

		foreach ($data_im_code as $key => $value){

			$values = explode(';',$value);

			$modelinbounddetail = InboundWhTransferDetail::findOne($values[2]);

			// cek semua semua qty sudah tag sn sudah tidak ada yang 44 (not registered)
			$modelcekdetail = InboundWhTransferDetail::find()->joinWith('idInboundWh')
				->andWhere(['inbound_wh_transfer.id_outbound_wh' => $id])
				->andWhere(['inbound_wh_transfer_detail.status_tagsn' => 44])->count();
			if( $modelcekdetail > 0 ){
				return 'Please do TAG SN to all item that already received before Report to IC';
			}

			// cek qty kirim
			$modeloutbounddetail = OutboundWhTransferDetail::find()
					->select([new \yii\db\Expression('req_good + req_not_good + req_reject + req_dismantle + req_revocation + req_good_rec + req_good_for_recond as req_good')])
					->andWhere(['id' => $values[3]])
					->one();

			if ( $modeloutbounddetail->req_good > $modelinbounddetail->qty  ){
				// ada delta
				$modelinbounddetail->status_report = 31;
				$modelinbounddetail->save();
			}

		}

		

		$model->save();

		return 'success';

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


	public function actionCreate($idOutboundWh)
    {    	
		// for status new received only, insert data to inbound table, then show form to user for change
		$this->layout = 'blank';

		$model = new InboundWhTransfer();        
		$model->id_outbound_wh = $idOutboundWh;
		$model->id_modul = 1;
		$model->status_listing = 52; // new received inbound

		// $model->save();
		if (!$model->save()){
			return Displayerror::pesan($model->getErrors());
		}

		// create detail
		$modelOutboundWhTransferDetail = OutboundWhTransferDetail::find()->andWhere(['id_outbound_wh' => $model->id_outbound_wh])->all();
		foreach($modelOutboundWhTransferDetail as $outbounddetail){
			// get new id_item_im based on wh_destination
			// $masterstock = MasterItemImDetail::find()->andWhere(['id_master_item_im' => $outbounddetail->idMasterItemImDetail->id_master_item_im])
			$masterstock = MasterItemImDetail::find()->andWhere(['id_master_item_im' => $outbounddetail->idMasterItemIm->id])
					->andWhere(['id_warehouse' => $outbounddetail->idOutboundWh->idInstructionWh->wh_destination])->one();

			if ( $masterstock === null ){
				$masterstock = new MasterItemImDetail();
				// $masterstock->id_master_item_im = $outbounddetail->idMasterItemImDetail->id_master_item_im;
				$masterstock->id_master_item_im = $outbounddetail->idMasterItemIm->id;
				$masterstock->id_warehouse = $outbounddetail->idOutboundWh->idInstructionWh->wh_destination;
				$masterstock->save();
			}

			$modelInboundWhTransferDetail = new InboundWhTransferDetail();
			$modelInboundWhTransferDetail->id_inbound_wh 		 = $model->id_outbound_wh;
			// $modelInboundWhTransferDetail->id_outbound_wh_detail = $outbounddetail->id;
			// $modelInboundWhTransferDetail->id_item_im 	 		 = $masterstock->id;
			$modelInboundWhTransferDetail->id_item_im 	 		 = $masterstock->id_master_item_im;
			$modelInboundWhTransferDetail->qty 	 		 		 = 0;
			$modelInboundWhTransferDetail->status_listing		 = 31; // uncompleted

			// $modelInboundWhTransferDetail->save();
			if (!$modelInboundWhTransferDetail->save()){
				return Displayerror::pesan($modelInboundWhTransferDetail->getErrors());
			}
		}

		Yii::$app->session->set('idInboundWhTransfer',$model->id_outbound_wh);
		$this->createLog($model);
		// send email here if needed

		$model = $this->findModelJoinOutbound($model->id_outbound_wh);
        $model->scenario = 'input_arrival';
		$searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'viewinbounddetail', $model->id_outbound_wh);

		return $this->render('create', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);

		return 'success';

    }

	public function actionCreatedetail($idOutboundWh = NULL)
    {
        $model = new InboundWhTransferDetail();

		if(Yii::$app->request->isPost){
			$data_arrival_date  = Yii::$app->request->post('arrival_date');
			$data_im_code       = Yii::$app->request->post('im_code');
			$data_req_qty       = Yii::$app->request->post('req_qty');

			$modelInbound = $this->findModel($idOutboundWh);
			// if(!isset($modelInbound->arrival_date))
			$modelInbound->arrival_date = $data_arrival_date;
			
			$allzero = true;

			if (count($data_im_code) == 0){
				return json_encode(['status' => 'success']);
			}

			foreach($data_im_code as $key => $value){
				if($data_req_qty[$key] == '' && $data_req_qty[$key] == 0){
					continue;
				}
				$values = explode(';',$value);

				$model = InboundWhTransferDetail::findOne($values[2]);
				$oldQty = $model->qty;
				$model->qty = ($data_req_qty[$key] == '') ? 0 : $data_req_qty[$key];
				
				if ($model->qty > 0){
					$allzero = false;
				}

				$ErrorSum = 0;
				$pesan = [];
				// cek if qty is less than already uploaded SN
				$modelcek = InboundWhTransferDetail::find()
					->select([new \yii\db\Expression('qty_good + qty_not_good + qty_reject + qty_dismantle + qty_revocation + qty_good_rec + qty_good_for_recond as qty_good')])
					->andWhere(['id_item_im' => $values[0]])->andWhere(['id_inbound_wh' => $idOutboundWh])->one();
				if ( $model->qty < $modelcek->qty_good ){
					$pesan[] = $model->getAttributeLabel('qty')." cannot be less than {$modelcek->qty_good}, for IM Code ".$values[1]."\nThis IM Code already do TAG SN";
					$ErrorSum = 1;
				}

				if ( $oldQty != $model->qty )
					$model->status_tagsn = 44; // reset to Not Registered if qty has changed

				$modelOutboundWhTransferDetail = OutboundWhTransferDetail::find()
					->select([new \yii\db\Expression('req_good + req_not_good + req_reject + req_dismantle + req_revocation + req_good_rec + req_good_for_recond as req_good')])
					->andWhere(['id' => $values[3]])
					// ->andWhere(['id_item_im' => $values[0]])
					// ->andWhere(['id_outbound_wh' => $idOutboundWh])
					->one();
				if($model->qty > $modelOutboundWhTransferDetail->req_good){
					$pesan[] = $model->getAttributeLabel('qty')." is more than Total qty for IM Code ".$values[1];
					$ErrorSum = 1;
				}else if ( $model->qty == $modelOutboundWhTransferDetail->req_good ){
					$model->status_listing = 36;
				}else{
					$model->status_listing = 31;
				}

				Yii::$app->session->remove('detailinbound');
				if ($ErrorSum == 1)
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => implode("\n",$pesan)]);
				
				if ($model->qty == 0 && $oldQty > 0){
					// raise allzero jika qty masih 0 (belum pernah berubah dari 0 dan diinput diform 0)
					$allzero = false;
					// continue;
				}

				if(!$model->save()){
					$error = $model->getErrors();
					$error[0] = ['for IM Code '.$values[1]];
					return json_encode(['status' => 'error', 'id' => $values[0], 'pesan' => Displayerror::pesan($error)]);
				}


			}

			// checking inbound if delta == 0
			$modelInboundCek = InboundWhTransfer::find()
				->select([new \yii\db\Expression('SUM(coalesce(req_good + req_not_good + req_reject + req_dismantle + req_revocation + req_good_rec + req_good_for_recond, 0) -
COALESCE(inbound_wh_transfer_detail.qty,0)) AS req_good, sum(COALESCE(inbound_wh_transfer_detail.qty,0)) as qty_good')])
				// ->joinWith('inboundWhTransferDetails.idItemIm.idMasterItemIm')
				->joinWith('inboundWhTransferDetails.idItemIm')
				->leftJoin('outbound_wh_transfer_detail', 'outbound_wh_transfer_detail.id_item_im = inbound_wh_transfer_detail.id_item_im and outbound_wh_transfer_detail.id_outbound_wh = inbound_wh_transfer_detail.id_inbound_wh')
				->andWhere(['id_inbound_wh' => $idOutboundWh])
				->one()
				;


			if ($modelInboundCek->req_good == 0){
				$modelInbound->status_listing = 1;
			}elseif ($modelInboundCek->qty_good == 0) {
				$modelInbound->status_listing = 52;
			}else{
				$modelInbound->status_listing = 31;
			}

			
			// if ($allzero){
			// 	// // jika semua masih 0 (tidak ada detail yg disimpan), hapus data inbound
			// 	// InboundWhTransferDetail::deleteAll(['id_inbound_wh' => $idOutboundWh]);
			// 	// InboundWhTransfer::deleteAll(['id_outbound_wh' => $idOutboundWh]);
			// 	// // return 'ini hapus';
			// 	// $modelInbound->delete();
			// }else{
			// 	if ($modelInboundCek->qty_good == 0){
			// 		// // semua qty dikembalikan menjadi 0, maka hapus semua data
			// 		// InboundWhTransferDetail::deleteAll(['id_inbound_wh' => $idOutboundWh]);
			// 		// InboundWhTransfer::deleteAll(['id_outbound_wh' => $idOutboundWh]);
			// 	}else{
					$modelInbound->save();
			// 	}
			// }

			return json_encode(['status' => 'success']);

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
			$data_arrival_date  = Yii::$app->request->post('arrival_date');
			$data_im_code       = Yii::$app->request->post('im_code');
			$data_req_qty       = Yii::$app->request->post('req_qty');

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
    	$this->layout = 'blank';

    	$model = $this->findModelJoinOutbound($idOutboundWh);
		$searchModel = new SearchInboundWhTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->id_modul,'viewinbounddetail', $idOutboundWh);

		return $this->render('create', [
            'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);

        $model = $this->findModel($idOutboundWh);

        if($idOutboundWh == NULL){
			$idOutboundWh = \Yii::$app->session->get('idOutboundWh');
		}
		
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
									'outbound_wh_transfer.plate_number',
									'outbound_wh_transfer.driver',
									'instruction_wh_transfer.wh_origin',
									'instruction_wh_transfer.wh_destination',
									'instruction_wh_transfer.instruction_number',
									'inbound_wh_transfer.status_listing',
									'inbound_wh_transfer.arrival_date',
									'inbound_wh_transfer.created_date',
									'inbound_wh_transfer.updated_date',
									'inbound_wh_transfer.revision_remark',
								])
								->joinWith('idOutboundWh.idInstructionWh')
								->andWhere(['id_outbound_wh' => $id])
								->one();
		return $model;
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
