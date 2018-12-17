<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaVehicleOspDetail;

/**
 * SearchOsGaVehicleOspDetail represents the model behind the search form about `app\models\OsGaVehicleOspDetail`.
 */
class SearchOsGaVehicleOspDetail extends OsGaVehicleOspDetail
{
	public $mobil_rental;
	
    public function rules()
    {
        return [
            [['id', 'id_os_ga_vehicle_parameter', 'id_os_ga_vehicle_osp', 'created_by', 'updated_by', 'id_os_ga_driver_parameter'], 'integer'],
            [['created_date', 'updated_date','mobil_rental'], 'safe'],
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
    public function search($params, $idOspWo)
    {
        $query = OsGaVehicleOspDetail::find()->where(['id_os_ga_vehicle_osp'=>$idOspWo]);

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
            'id' => $this->id,
            'id_os_ga_vehicle_parameter' => $this->id_os_ga_vehicle_parameter,
            'id_os_ga_vehicle_osp' => $this->id_os_ga_vehicle_osp,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'id_os_ga_driver_parameter' => $this->id_os_ga_driver_parameter,
        ]);

        $query->andFilterWhere(['like', 'stdk_number', $this->stdk_number]);

        return $dataProvider;
    }

	public function searchByBiayaJalan($params, $idOspWo, $stdk)
    {
        $query = OsGaVehicleOspDetail::find()
		->where(['and', ['id_os_ga_vehicle_osp'=>$idOspWo], ['stdk_number' => $stdk]])
		->joinWith('osGaBiayaJalanOsp')
		->select([
				'os_ga_vehicle_osp_detail.id',
				'os_ga_vehicle_osp_detail.id_os_ga_vehicle_osp',
				'os_ga_vehicle_osp_detail.id_os_ga_driver_parameter',
				'os_ga_vehicle_osp_detail.id_os_ga_vehicle_parameter',
				'os_ga_vehicle_osp_detail.stdk_number',
				'os_ga_biaya_jalan_osp.car_rental_cost',
				'os_ga_biaya_jalan_osp.parking_cost',
				'os_ga_biaya_jalan_osp.toll_cost',
		])
		;

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
            'id' => $this->id,
            'id_os_ga_vehicle_parameter' => $this->id_os_ga_vehicle_parameter,
            'id_os_ga_vehicle_osp' => $this->id_os_ga_vehicle_osp,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'id_os_ga_driver_parameter' => $this->id_os_ga_driver_parameter,
        ]);

        $query->andFilterWhere(['like', 'stdk_number', $this->stdk_number]);

        return $dataProvider;
    }
}
