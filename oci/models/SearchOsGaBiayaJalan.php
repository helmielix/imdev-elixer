<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaBiayaJalan;

/**
 * SearchOsGaBiayaJalan represents the model behind the search form about `app\models\OsGaBiayaJalan`.
 */
class SearchOsGaBiayaJalan extends OsGaBiayaJalan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mobil_rental', 'id_division', 'id_wo_actual', 'car_rental_cost', 'parking_cost', 'toll_cost', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = OsGaBiayaJalan::find();

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
            'mobil_rental' => $this->mobil_rental,
            'id_division' => $this->id_division,
            'id_wo_actual' => $this->id_wo_actual,
            'car_rental_cost' => $this->car_rental_cost,
            'parking_cost' => $this->parking_cost,
            'toll_cost' => $this->toll_cost,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
		
		
		
		 $query = OsGaBiayaJalan::find();
		          $query->joinWith('idIkoWoActual',true,'FULL JOIN');
				  $query->andFilterWhere(['=','iko_wo_actual.status_listing', 5]);
				  $query->joinWith('idOspWoActual',true,'FULL JOIN')
	                    ->andFilterWhere(['=','osp_wo_actual.status_listing', 5]);
		              
			
		$query->select([    'iko_wo_actual.id_iko_wo',
						    'osp_wo_actual.id_osp_wo',
							'os_ga_biaya_jalan.mobil_rental',							
							'os_ga_biaya_jalan.id_division',
							'os_ga_biaya_jalan.id_wo_actual',
							'os_ga_biaya_jalan.car_rental_cost',
												
							
							]);
							
					
		 
				
		if($action == 'input') {
			
		   $query->andFilterWhere(['or',['=','os_ga_biaya_jalan.status_listing', 1],['=','os_ga_biaya_jalan.status_listing', 3],['=','os_ga_biaya_jalan.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
				 
		} else if ($action == 'verify') {
			 
			
			$query->andFilterWhere(['or',['=','os_ga_biaya_jalan.status_listing', 1],['=','os_ga_biaya_jalan.status_listing', 4], ['=','os_ga_biaya_jalan.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {
		     
			
			$query->andFilterWhere(['or',['=','os_ga_biaya_jalan.status_listing', 4],['=','os_ga_biaya_jalan.status_listing', 5]])
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
            'mobil_rental' => $this->mobil_rental,
            'id_division' => $this->id_division,
            'id_wo_actual' => $this->id_wo_actual,
            'car_rental_cost' => $this->car_rental_cost,
            'parking_cost' => $this->parking_cost,
            'toll_cost' => $this->toll_cost,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
	
}
}
