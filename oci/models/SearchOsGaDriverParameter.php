<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaDriverParameter;

/**
 * SearchOsGaDriverParameter represents the model behind the search form about `app\models\OsGaDriverParameter`.
 */
class SearchOsGaDriverParameter extends OsGaDriverParameter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'driver_status', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['driver_name', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = OsGaDriverParameter::find();

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
            'driver_status' => $this->driver_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
			'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'driver_name', $this->driver_name]);
		$query->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
		
		
		
		 $query = OsGaDriverParameter::find();
		
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
            'driver_status' => $this->driver_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
			'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['ilike', 'driver_name', $this->driver_name]);
		$query->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
}
}
