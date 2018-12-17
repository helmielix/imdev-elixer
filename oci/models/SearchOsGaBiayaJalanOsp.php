<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaBiayaJalanOsp;
use app\models\OsGaVehicleOsp;
use app\models\OspWoActual;
use app\models\OsGaVehicleOspDetail;
use app\models\OspWoActualStdk;
use yii\helpers\ArrayHelper;
/**
 * SearchOsGaBiayaJalanOsp represents the model behind the search form about `app\models\OsGaBiayaJalanOsp`.
 */
class SearchOsGaBiayaJalanOsp extends OsGaBiayaJalanOsp
{
    /**
     * @inheritdoc
     */

	public $id_vehicle_osp, $id_osp_wo, $id, $stdk_number, $status_listing_biaya_jalan, $mobil_rental;


    public function rules()
    {
        return [
            [['id_osp_wo','id_vehicle_osp', 'id_os_ga_vehicle_osp_detail', 'mobil_rental', 'car_rental_cost', 'parking_cost', 'toll_cost','fuel_cost', 'created_by', 'updated_by', 'status_listing_biaya_jalan'], 'integer'],
            [['created_date', 'updated_date', 'revision_remark', 'wo_number','stdk_number','vehicle_name','mobil_rental'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OsGaBiayaJalanOsp::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
		    'id_os_ga_vehicle_osp_detail' => $this->id_os_ga_vehicle_osp_detail,
			'id_vehicle_osp' => $this->id_vehicle_osp,
			'mobil_rental' => $this->mobil_rental,
            'car_rental_cost' => $this->car_rental_cost,
            'parking_cost' => $this->parking_cost,
            'toll_cost' => $this->toll_cost,
			'fuel_cost' => $this->fuel_cost,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }

	public function _searchByAction($params, $action)
    {
        $query = OsGaVehicleOsp::find()
			->joinWith('idOspWo.ospWoActual',true,'FULL JOIN')
			->select(['osp_work_order.id as id_osp_wo',
						'os_ga_vehicle_osp.status_listing_detail',
						'os_ga_vehicle_osp.status_listing',
						'osp_work_order.wo_number',
													]);

        if($action == 'input') {

		     $query
			 ->andWhere(['and',['osp_wo_actual.status_listing' => 5],['os_ga_vehicle_osp.status_listing' => 5],['not in','os_ga_vehicle_osp.status_listing_detail' , [4, 5]]])
              // ->orFilterWhere(['not in','os_ga_vehicle_osp.status_listing_detail' , [4, 5]])
			   ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
		} else if ($action == 'verify') {
			$query->andFilterWhere(['or',['=','os_ga_vehicle_osp.status_listing_detail', 1],['=','os_ga_vehicle_osp.status_listing_detail', 4], ['=','os_ga_vehicle_osp.status_listing_detail', 2]])
				->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
		}
		else if ($action == 'approve') {
			$query->andFilterWhere(['or',['=','os_ga_vehicle_osp.status_listing_detail', 4],['=','os_ga_vehicle_osp.status_listing_detail', 5]])
				->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
		} else if ($action == 'overview') {


			$query->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_osp_wo' => $this->id_osp_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_ga_vehicle_osp.status_listing' => $this->status_listing,
        ]);
        $query
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }

    public function searchByAction($params, $action)
    {
        $arrIdOspWo =  ArrayHelper :: getColumn ( OsGaVehicleOspDetail::find()->select(['id_os_ga_vehicle_osp'])->all(),'id_os_ga_vehicle_osp');
        $arrWoActualStdk =  ArrayHelper :: getColumn (OspWoActualStdk::find()->select(['stdk_number'])->where(['in','id_osp_wo',array_filter($arrIdOspWo)])->all(),'stdk_number');
        $query = OsGaVehicleOspDetail::find()
            ->joinWith('idOsGaVehicleOsp.idOspWo.ospWoActual',true,'FULL JOIN')
            ->joinWith('osGaBiayaJalanOsp')
            ->joinWith('idOsGaVehicleParameter')
            ->select(['os_ga_vehicle_osp.id_osp_wo as id_os_ga_vehicle_osp',
                        'os_ga_vehicle_osp_detail.stdk_number',
                        'os_ga_vehicle_osp_detail.status_listing_biaya_jalan'   ,
                        'osp_work_order.wo_number',
                        'os_ga_vehicle_osp_detail.id_os_ga_vehicle_parameter',
                                                    ])
            ->andWhere(['in','os_ga_vehicle_osp_detail.stdk_number', $arrWoActualStdk]) ;
        if($action == 'input') {
             $query->andWhere(['and',['osp_wo_actual.status_listing' => 5],['os_ga_vehicle_osp.status_listing' => 5],['not in','os_ga_vehicle_osp_detail.status_listing_biaya_jalan' , [4, 5]]])
               ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_osp_detail.status_listing_biaya_jalan', 1],['=','os_ga_vehicle_osp_detail.status_listing_biaya_jalan', 4], ['=','os_ga_vehicle_osp_detail.status_listing_biaya_jalan', 2]])
                ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_osp_detail.status_listing_biaya_jalan', 4],['=','os_ga_vehicle_osp_detail.status_listing_biaya_jalan', 5]])
                ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        } else if ($action == 'overview') {


            $query->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['wo_number'] = [
            'asc' => ['osp_work_order.wo_number' => SORT_ASC],
            'desc' => ['osp_work_order.wo_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['stdk_number'] = [
            'asc' => ['os_ga_vehicle_osp_detail.stdk_number' => SORT_ASC],
            'desc' => ['os_ga_vehicle_osp_detail.stdk_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['vehicle_name'] = [
            'asc' => ['os_ga_vehicle_parameter.vehicle_name' => SORT_ASC],
            'desc' => ['os_ga_vehicle_parameter.vehicle_name' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id_osp_wo' => $this->id_osp_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
			'os_ga_vehicle_parameter.vehicle_type' => $this->vehicle_name,
            'os_ga_vehicle_osp_detail.status_listing_biaya_jalan' => $this->status_listing_biaya_jalan,
        ]);
        $query
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'os_ga_vehicle_osp_detail.stdk_number', $this->stdk_number])
            // ->andFilterWhere(['ilike', 'os_ga_vehicle_parameter.vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['ilike', 'osp_work_order.wo_number', $this->wo_number]);

        return $dataProvider;
    }

	public function searchByVehicleDetail($params, $idOsGaVehicleOsp)
    {
		$modelWoActual = OspWoActual::findOne($idOsGaVehicleOsp);
		$arrStdkNumber = explode(",",$modelWoActual->stdk_number);
		$query = OsGaVehicleOspDetail::find()
		->where(['id_os_ga_vehicle_osp'=>$idOsGaVehicleOsp])
		// ->joinWith('idOsGaVehicleOsp.idOspWo.ospWoActual')
		->andFilterWhere(['in','os_ga_vehicle_osp_detail.stdk_number',$arrStdkNumber])

		;

		// $query
			// ->select([    'os_ga_vehicle_osp.id_osp_wo AS id_vehicle_osp',
	                  // // 'osp_wo_actual.id_osp_wo AS id_osp_wo',
					  // // 'os_ga_biaya_jalan_osp.mobil_rental AS mobil_rental',
					  // // 'os_ga_biaya_jalan_osp.car_rental_cost AS car_rental_cost',
					  // // 'os_ga_biaya_jalan_osp.parking_cost AS parking_cost',
					  // // 'os_ga_biaya_jalan_osp.fuel_cost AS  fuel_cost',
					  // // 'os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail AS id_os_ga_vehicle_osp_detail',
					  // // 'os_ga_biaya_jalan_osp.status_listing AS status_listing',
			// ])
			// ->from('os_ga_biaya_jalan_osp')
			// ->join('FULL JOIN', 'os_ga_vehicle_osp', 'os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail = os_ga_vehicle_osp.id_osp_wo')
			// ->join('LEFT JOIN', 'osp_wo_actual', 'os_ga_vehicle_osp.id_osp_wo = osp_wo_actual.id_osp_wo');

		// if($action == 'input') {



		     // $query ->andWhere(['os_ga_biaya_jalan_osp.status_listing' => null])
              // ->orFilterWhere(['not in','os_ga_biaya_jalan_osp.status_listing' , [4, 5]])
			   // ->orderBy(['os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail' => SORT_DESC]);

		// } else if ($action == 'verify') {


			// $query->andFilterWhere(['or',['=','os_ga_biaya_jalan_osp.status_listing', 1],['=','os_ga_biaya_jalan_osp.status_listing', 4], ['=','os_ga_biaya_jalan_osp.status_listing', 2]])
				// ->orderBy(['os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail' => SORT_DESC]);
		// }
		// else if ($action == 'approve') {


			// $query->andFilterWhere(['or',['=','os_ga_biaya_jalan_osp.status_listing', 4],['=','os_ga_biaya_jalan_osp.status_listing', 5]])
				// ->orderBy(['os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail' => SORT_DESC]);

		// } else if ($action == 'overview') {


			// $query->orderBy(['os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail' => SORT_DESC]);
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),



        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }



        // grid filtering conditions
        // $query->andFilterWhere([
            // 'id' => $this->id,
            // 'id_os_ga_vehicle_parameter' => $this->id_os_ga_vehicle_parameter,
            // 'id_os_ga_vehicle_osp' => $this->id_os_ga_vehicle_osp,
            // 'created_by' => $this->created_by,
            // 'created_date' => $this->created_date,
            // 'updated_by' => $this->updated_by,
            // 'updated_date' => $this->updated_date,
            // 'id_os_ga_driver_parameter' => $this->id_os_ga_driver_parameter,
        // ]);

        // $query->andFilterWhere(['like', 'stdk_number', $this->stdk_number]);

        return $dataProvider;
	}
}
