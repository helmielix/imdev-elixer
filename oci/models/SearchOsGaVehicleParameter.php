<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaVehicleParameter;

/**
 * SearchOsGaVehicleParameter represents the model behind the search form about `app\models\OsGaVehicleParameter`.
 */
class SearchOsGaVehicleParameter extends OsGaVehicleParameter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['vehicle_name', 'plate_number', 'vehicle_type', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = OsGaVehicleParameter::find();

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
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['like', 'plate_number', $this->plate_number])
            ->andFilterWhere(['like', 'vehicle_type', $this->vehicle_type])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
		
		
		
		 $query = OsGaVehicleParameter::find();
		
		if($action == 'input') {
			$query ->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 3],['=','status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {
			$query ->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 2],['=','status_listing', 5]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		
		else if ($action == 'overview') {
			$query ->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 3],['=','status_listing', 2],['=','status_listing', 4], ['=','status_listing', 5], ['=','status_listing', 6]])
				 ->orderBy(['id' => SORT_DESC]);
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
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
			'vehicle_type'=> $this->vehicle_type
        ]);

        $query->andFilterWhere(['like', 'vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number])
            // ->andFilterWhere(['like', 'vehicle_type', $this->vehicle_type])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
	
}
}
