<?php

namespace usermanagement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GovrelParameterPicProblem;

/**
 * GovrelparameterpicproblemSearch represents the model behind the search form about `app\models\GovrelParameterPicProblem`.
 */
class SearchGovrelParameterPicProblem extends GovrelParameterPicProblem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_par'], 'integer'],
            [['name','status_listing'], 'safe'],
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
        $query = GovrelParameterPicProblem::find();

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
			'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
			
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
		      ->andFilterWhere(['=', 'created_by', $this->created_by])
		       ->andFilterWhere(['=', 'updated_by', $this->updated_by])
		      ->andFilterWhere(['=', 'status_listing', $this->status_listing]); 


        return $dataProvider;
    }
	
	
		
     public function searchByAction($params, $action)
    {
		if($action == 'input') {
			$query = GovrelParameterPicProblem::find()
				->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 3],['=','status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {
			$query = GovrelParameterPicProblem::find()
					->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 5]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		
		else if ($action == 'overview') {
			$query = GovrelParameterPicProblem::find()
					->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 3],['=','status_listing', 2],['=','status_listing', 4], ['=','status_listing', 5], ['=','status_listing', 6]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		
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
			'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
		      ->andFilterWhere(['=', 'created_by', $this->created_by])
		       ->andFilterWhere(['=', 'updated_by', $this->updated_by])
		      ->andFilterWhere(['=', 'status_listing', $this->status_listing])
			  ->andFilterWhere(['=', 'status_par', $this->status_par]); 


        return $dataProvider;
    }
}
