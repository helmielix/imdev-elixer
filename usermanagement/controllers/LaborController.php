<?php

namespace usermanagement\controllers;

use Yii;
use app\models\Labor;
use app\models\LaborTemp;
use app\models\SearchLabor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\widgets\Displayerror;
/**
 * LaborController implements the CRUD actions for Labor model.
 */
class LaborController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all Labor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchLabor();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Labor model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Labor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Labor();
		$this->layout = 'blank';

		if (isset($_FILES['file']['size'])) {
			if($_FILES['file']['size'] != 0) {
				$filename=('uploads/'.$_FILES['file']['name']);
				move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.basename( $_FILES['file']['name']));
				$datas = \moonland\phpexcel\Excel::import($filename, [
					'setFirstRecordAsKeys' => true,
				]);
				if (isset($datas[0][0])) {
					$datas = $datas[0];
				}
				$row = 2;
				$periksa = "\nplease check on row ";
				$reqCol = [
					'NIK' => '',
					'NAME' => '',
					'POSITION' => '',
					'DIVISION' => '',

				];
				foreach ($datas as $data) {
					// periksa setiap kolom yang wajib ada, hanya di awal row
					if ($row == 2) {
						$missCol = array_diff_key($reqCol,$data);
						if (count($missCol) > 0) {
							return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
						}
					}
					$model = new LaborTemp();
					$model->nik = (string) $data['NIK'];
					$model->name = (string) $data['NAME'];
					$model->position = (string) $data['POSITION'];
					$model->division = (string) $data['DIVISION'];


					if(!$model->save()) {
						$error = $model->getErrors();
						$error['line'] = [$periksa.$row];
						return Displayerror::pesan($error);
					}
					$row++;
				}
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

				$success = true;
				
				Yii::$app->db->createCommand("select _upsert_labor();")->query();
				return 'success';
			}

		}else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUploaddetail() {
        $this->layout = 'blank';
        $model = new UploadForm();

        if (isset($_FILES['file']['size'])) {
            if($_FILES['file']['size'] != 0) {
                $filename=('uploads/'.$this->locationPath.$_FILES['file']['name']);
                move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$this->locationPath.basename( $_FILES['file']['name']));
                $datas = \moonland\phpexcel\Excel::import($filename, [
                    'setFirstRecordAsKeys' => true,
                ]);
                if (isset($datas[0][0])) {
                    $datas = $datas[0];
                }
                PlanningIkoBoqBDetail::deleteAll('id_planning_iko_boq_b = '.Yii::$app->session->get('idIkoRfa'));
                $row = 2;
                $periksa = "\nplease check on row ";
                $reqCol = [
                	'ITEM_TYPE' => '',
                	'ITEM' => '',
                	'NOTE' => '',
                	'VOLUME' => '',
                	'UNIT' => '',

                ];
                foreach ($datas as $data) {
                    // periksa setiap kolom yang wajib ada, hanya di awal row
                    if ($row == 2) {
                    	$missCol = array_diff_key($reqCol,$data);
                    	if (count($missCol) > 0) {
                            PlanningIkoBoqBDetail::deleteAll('id_planning_iko_boq_b = '.Yii::$app->session->get('idIkoRfa'));
                    		return "Column ".implode(array_keys($missCol), ", ")." is not exist in XLS File";
                    	}
                    }
                    $model = new PlanningIkoBoqBDetail();
                    $modelPlanningIkoBoqB = PlanningIkoBoqB::findOne(Yii::$app->session->get('idIkoRfa'));

                    $model->id_planning_iko_boq_b = Yii::$app->session->get('idIkoRfa');
                    $model->item_type = $this->findIdreference($data['ITEM_TYPE']);
                    $model->item = $this->findIdreference($data['ITEM']);
                    $model->note = $data['NOTE'];
                    $model->volume = $data['VOLUME'];
                    $model->unit = $this->findIdreference($data['UNIT']);


                    if(!$model->save()) {
                        PlanningIkoBoqBDetail::deleteAll('id_planning_iko_boq_b = '.Yii::$app->session->get('idIkoRfa'));
                        $error = $model->getErrors();
                        $error['line'] = [$periksa.$row];
                        return Displayerror::pesan($error);
                    }
                    $row++;
                }
                $modelPlanningIkoBoqB->status_boq_b_detail = 1;
                $modelPlanningIkoBoqB->save();
				$this->createLog($modelPlanningIkoBoqP);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $success = true;
                return 'success';
            }

        }
        return $this->render('@common/views/uploadform', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Labor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nik]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Labor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDownloadfile($id, $modul = null, $relation = true) {
		$request = Yii::$app->request;
        // returns all parameters
        $params = $request->bodyParams;
        $lok = '';

		if ($id == 'templateLabor') {
            $file = Yii::getAlias('@webroot') . '/uploads/labor_upload_template.xls';
            if (file_exists($file)) {
                return Yii::$app->response->sendFile($file);
            }else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }else if ($modul) {
            $basepath = Yii::getAlias('@'.$modul) .'/web/';
        }else {
            $basepath = Yii::getAlias('@webroot') . '/';
        }

        $model = $this->findModel($id);

        $path = ArrayHelper::getValue($model, $params['data'], 'Unknown');

        // if ($params['path'] === 'true') {
            // $lok = 'CA/IOM/'.$id.'/';
        // }

        $file = $basepath.$lok.$path;
		//return $file;
        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        } else {
            // echo $file;
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}

    /**
     * Finds the Labor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Labor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Labor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
