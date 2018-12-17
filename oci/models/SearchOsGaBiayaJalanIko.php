<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaBiayaJalanIko;
use app\models\OsGaVehicleIko;
use app\models\IkoWoActual;
use app\models\OsGaVehicleIkoDetail;
use app\models\IkoWoActualStdk;
use yii\helpers\ArrayHelper;
/**
 * SearchOsGaBiayaJalanIko represents the model behind the search form about `app\models\OsGaBiayaJalanIko`.
 */
class SearchOsGaBiayaJalanIko extends OsGaBiayaJalanIko
{
    /**
     * @inheritdoc
     */

	public $id_vehicle_iko, $id_iko_wo, $id, $stdk_number, $status_listing_biaya_jalan;


    public function rules()
    {
        return [
            [['id_iko_wo','id_vehicle_iko', 'id_os_ga_vehicle_iko_detail', 'mobil_rental', 'car_rental_cost', 'parking_cost', 'toll_cost','fuel_cost', 'created_by', 'updated_by', 'status_listing_biaya_jalan'], 'integer'],
            [['created_date', 'updated_date', 'revision_remark', 'wo_number','stdk_number','vehicle_name'], 'safe'],
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
        $query = OsGaBiayaJalanIko::find();

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
		    'id_os_ga_vehicle_iko_detail' => $this->id_os_ga_vehicle_iko_detail,
			'id_vehicle_iko' => $this->id_vehicle_iko,
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
        $query = OsGaVehicleIko::find()
			->joinWith('idIkoWo.ikoWoActual',true,'FULL JOIN')
			->select(['iko_work_order.id as id_iko_wo',
						'os_ga_vehicle_iko.status_listing_detail',
						'os_ga_vehicle_iko.status_listing',
						'iko_work_order.wo_number',
													]);

        if($action == 'input') {

		     $query->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
			 // ->andWhere(['and',['iko_wo_actual.status_listing' => 5],['os_ga_vehicle_iko.status_listing' => 5],['not in','os_ga_vehicle_iko.status_listing_detail' , [4, 5]]])
              // ->orFilterWhere(['not in','os_ga_vehicle_iko.status_listing_detail' , [4, 5]])
			   
		} else if ($action == 'verify') {
			$query->andFilterWhere(['or',['=','os_ga_vehicle_iko.status_listing_detail', 1],['=','os_ga_vehicle_iko.status_listing_detail', 4], ['=','os_ga_vehicle_iko.status_listing_detail', 2]])
				->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
		}
		else if ($action == 'approve') {
			$query->andFilterWhere(['or',['=','os_ga_vehicle_iko.status_listing_detail', 4],['=','os_ga_vehicle_iko.status_listing_detail', 5]])
				->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
		} else if ($action == 'overview') {


			$query->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
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
            'id_iko_wo' => $this->id_iko_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_ga_vehicle_iko.status_listing' => $this->status_listing,
        ]);
        $query
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }

    public function searchByAction($params, $action)
    {
        $arrIdIkoWo =  ArrayHelper :: getColumn ( OsGaVehicleIkoDetail::find()->select(['id_os_ga_vehicle_iko'])->all(),'id_os_ga_vehicle_iko');
        $arrWoActualStdk =  ArrayHelper :: getColumn (IkoWoActualStdk::find()->select(['stdk_number'])->where(['in','id_iko_wo',array_filter($arrIdIkoWo)])->all(),'stdk_number');
        $query = OsGaVehicleIkoDetail::find()
            ->joinWith('idOsGaVehicleIko.idIkoWo.ikoWoActual',true,'FULL JOIN')
            ->joinWith('osGaBiayaJalanIko')
            ->joinWith('idOsGaVehicleParameter')
            ->select(['os_ga_vehicle_iko.id_iko_wo as id_os_ga_vehicle_iko',
                        'os_ga_vehicle_iko_detail.stdk_number',
                        'os_ga_vehicle_iko_detail.status_listing_biaya_jalan'   ,
                        'iko_work_order.wo_number',
                        'os_ga_vehicle_iko_detail.id_os_ga_vehicle_parameter',
                                                    ])
            ->andWhere(['in','os_ga_vehicle_iko_detail.stdk_number', $arrWoActualStdk]) ;
        if($action == 'input') {
             $query->andWhere(['and',['iko_wo_actual.status_listing' => 5],['os_ga_vehicle_iko.status_listing' => 5],['not in','os_ga_vehicle_iko_detail.status_listing_biaya_jalan' , [4, 5]]])
               ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_iko_detail.status_listing_biaya_jalan', 1],['=','os_ga_vehicle_iko_detail.status_listing_biaya_jalan', 4], ['=','os_ga_vehicle_iko_detail.status_listing_biaya_jalan', 2]])
                ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_iko_detail.status_listing_biaya_jalan', 4],['=','os_ga_vehicle_iko_detail.status_listing_biaya_jalan', 5]])
                ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
        } else if ($action == 'overview') {


            $query->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['wo_number'] = [
            'asc' => ['iko_work_order.wo_number' => SORT_ASC],
            'desc' => ['iko_work_order.wo_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['stdk_number'] = [
            'asc' => ['os_ga_vehicle_iko_detail.stdk_number' => SORT_ASC],
            'desc' => ['os_ga_vehicle_iko_detail.stdk_number' => SORT_DESC],
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
            // 'id_iko_wo' => $this->id_iko_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
			'os_ga_vehicle_parameter.vehicle_type' => $this->vehicle_name,
            'os_ga_vehicle_iko_detail.status_listing_biaya_jalan' => $this->status_listing_biaya_jalan,
        ]);
        $query
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'os_ga_vehicle_iko_detail.stdk_number', $this->stdk_number])
            // ->andFilterWhere(['like', 'os_ga_vehicle_parameter.vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['ilike', 'iko_work_order.wo_number', $this->wo_number]);

        return $dataProvider;
    }

	public function searchByVehicleDetail($params, $idOsGaVehicleIko)
    {
		$modelWoActual = IkoWoActual::findOne($idOsGaVehicleIko);
		$arrStdkNumber = explode(",",$modelWoActual->stdk_number);
		$query = OsGaVehicleIkoDetail::find()
		->where(['id_os_ga_vehicle_iko'=>$idOsGaVehicleIko])
		// ->joinWith('idOsGaVehicleIko.idIkoWo.ikoWoActual')
		->andFilterWhere(['in','os_ga_vehicle_iko_detail.stdk_number',$arrStdkNumber])

		;

		// $query
			// ->select([    'os_ga_vehicle_iko.id_iko_wo AS id_vehicle_iko',
	                  // // 'iko_wo_actual.id_iko_wo AS id_iko_wo',
					  // // 'os_ga_biaya_jalan_iko.mobil_rental AS mobil_rental',
					  // // 'os_ga_biaya_jalan_iko.car_rental_cost AS car_rental_cost',
					  // // 'os_ga_biaya_jalan_iko.parking_cost AS parking_cost',
					  // // 'os_ga_biaya_jalan_iko.fuel_cost AS  fuel_cost',
					  // // 'os_ga_biaya_jalan_iko.id_os_ga_vehicle_iko_detail AS id_os_ga_vehicle_iko_detail',
					  // // 'os_ga_biaya_jalan_iko.status_listing AS status_listing',
			// ])
			// ->from('os_ga_biaya_jalan_iko')
			// ->join('FULL JOIN', 'os_ga_vehicle_iko', 'os_ga_biaya_jalan_iko.id_os_ga_vehicle_iko_detail = os_ga_vehicle_iko.id_iko_wo')
			// ->join('LEFT JOIN', 'iko_wo_actual', 'os_ga_vehicle_iko.id_iko_wo = iko_wo_actual.id_iko_wo');

		// if($action == 'input') {



		     // $query ->andWhere(['os_ga_biaya_jalan_iko.status_listing' => null])
              // ->orFilterWhere(['not in','os_ga_biaya_jalan_iko.status_listing' , [4, 5]])
			   // ->orderBy(['os_ga_biaya_jalan_iko.id_os_ga_vehicle_iko_detail' => SORT_DESC]);

		// } else if ($action == 'verify') {


			// $query->andFilterWhere(['or',['=','os_ga_biaya_jalan_iko.status_listing', 1],['=','os_ga_biaya_jalan_iko.status_listing', 4], ['=','os_ga_biaya_jalan_iko.status_listing', 2]])
				// ->orderBy(['os_ga_biaya_jalan_iko.id_os_ga_vehicle_iko_detail' => SORT_DESC]);
		// }
		// else if ($action == 'approve') {


			// $query->andFilterWhere(['or',['=','os_ga_biaya_jalan_iko.status_listing', 4],['=','os_ga_biaya_jalan_iko.status_listing', 5]])
				// ->orderBy(['os_ga_biaya_jalan_iko.id_os_ga_vehicle_iko_detail' => SORT_DESC]);

		// } else if ($action == 'overview') {


			// $query->orderBy(['os_ga_biaya_jalan_iko.id_os_ga_vehicle_iko_detail' => SORT_DESC]);
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
            // 'id_os_ga_vehicle_iko' => $this->id_os_ga_vehicle_iko,
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
