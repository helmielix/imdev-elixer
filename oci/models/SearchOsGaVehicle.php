<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaVehicle;

/**
 * SearchOsGaVehicle represents the model behind the search form about `app\models\OsGaVehicle`.
 */
class SearchOsGaVehicle extends OsGaVehicle
{
    /**
     * @inheritdoc
     */
	 
	public $id_iko_wo, $id_osp_wo; 
	
    public function rules()
    {
        return [
            [['id', 'id_os_ga_vehicle_parameter', 'id_wo', 'vehicle', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['plate_number', 'stdk_number', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = OsGaVehicle::find();

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
            'id_wo' => $this->id_wo,
            'vehicle' => $this->vehicle,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_ga_vehicle.status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'plate_number', $this->plate_number])
            ->andFilterWhere(['like', 'stdk_number', $this->stdk_number])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
		
		
		
		 $query = OsGaVehicle::find();
		          $query->joinWith('idIkoWo',true,'FULL JOIN');
				  $query->andFilterWhere(['=','iko_work_order.status_listing', 5]);
				  $query->joinWith('idOspWo',true,'FULL JOIN')
	                    ->andFilterWhere(['=','osp_work_order.status_listing', 5]);
				      
		              
			
		$query->select([    'iko_work_order.id as id_iko_wo',
						    'osp_work_order.id as id_osp_wo',
							'os_ga_vehicle.status_listing',							
							'os_ga_vehicle.id_wo',
							'os_ga_vehicle.vehicle',
							'os_ga_vehicle.plate_number',
												
							
							]);
		 
				
		if($action == 'input') {
			
		   $query->andFilterWhere(['or',['=','os_ga_vehicle.status_listing', 1],['=','os_ga_vehicle.status_listing', 3],['=','os_ga_vehicle.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
				 
		} else if ($action == 'verify') {
			 
			
			$query->andFilterWhere(['or',['=','os_ga_vehicle.status_listing', 1],['=','os_ga_vehicle.status_listing', 4], ['=','os_ga_vehicle.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {
		     
			
			$query->andFilterWhere(['or',['=','os_ga_vehicle.status_listing', 4],['=','os_ga_vehicle.status_listing', 5]])
				 ->orderBy(['id' => SORT_DESC]);
		} else if ($action == 'overview') {
		
           
			$query ->orderBy(['id' => SORT_DESC]);
        }
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),



        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
		
		

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_os_ga_vehicle_parameter' => $this->id_os_ga_vehicle_parameter,
            'id_wo' => $this->id_wo,
            'vehicle' => $this->vehicle,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_ga_vehicle.status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'plate_number', $this->plate_number])
            ->andFilterWhere(['like', 'stdk_number', $this->stdk_number])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
	
}
}
