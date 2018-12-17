<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsGaBiayaJalanOsp;

/**
 * SearchLogOsGaBiayaJalanOsp represents the model behind the search form about `app\models\LogOsGaBiayaJalanOsp`.
 */
class SearchLogOsGaBiayaJalanOsp extends LogOsGaBiayaJalanOsp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id_os_ga_vehicle_osp_detail', 'mobil_rental', 'car_rental_cost', 'parking_cost', 'toll_cost', 'created_by', 'updated_by', 'status_listing', 'fuel_cost'], 'integer'],
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
        $query = LogOsGaBiayaJalanOsp::find();
        $query->joinWith('idOsGaVehicleOspDetail.idOsGaVehicleOsp.idOspWo')
              ->select([
                        'log_os_ga_biaya_jalan_osp.idlog',
                        'log_os_ga_biaya_jalan_osp.status_listing',
                        'log_os_ga_biaya_jalan_osp.id_os_ga_vehicle_osp_detail',
                        'os_ga_vehicle_osp_detail.stdk_number',
                        'os_ga_vehicle_osp.id_osp_wo',
                        'osp_work_order.wo_number',
                        'os_ga_vehicle_osp_detail.id_os_ga_vehicle_parameter',
                      ]);

        // add conditions that should always apply here

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
            'idlog' => $this->idlog,
            'id_os_ga_vehicle_osp_detail' => $this->id_os_ga_vehicle_osp_detail,
            'mobil_rental' => $this->mobil_rental,
            'car_rental_cost' => $this->car_rental_cost,
            'parking_cost' => $this->parking_cost,
            'toll_cost' => $this->toll_cost,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'log_os_ga_biaya_jalan_osp.status_listing' => $this->status_listing,
            'fuel_cost' => $this->fuel_cost,
        ]);

        $query->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
                ->andFilterWhere(['like', 'os_ga_vehicle_osp_detail.stdk_number', $this->stdk_number])
                ->andFilterWhere(['like', 'os_ga_vehicle_parameter.vehicle_name', $this->mobil_rental])
                ->andFilterWhere(['ilike', 'osp_work_order.wo_number', $this->wo_number]);

        return $dataProvider;
    }
}
