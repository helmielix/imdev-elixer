<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CaIomAreaExpansion;

class SearchCaIomAreaExpansion extends CaIomAreaExpansion
{
    public function rules()
    {
        return [
            [['status', 'subject', 'notes', 'no_iom_area_exp', 'created_by', 'created_date', 'updated_by', 'updated_date', 'revision_remark'], 'safe'],
            [['id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CaIomAreaExpansion::find();

        $dataProvider = $this->_search($params, $query); 

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
        $query = CaIomAreaExpansion::find();

		if($action == 'input') {
            $query->andFilterWhere(['or',['=','status', 7],['=','status', 1],['=','status', 3],['=','status', 2],['=','status', 6]]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['=','status', 1],['=','status', 4], ['=','status', 2]]);
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['or',['=','status', 4],['=','status', 5]]);
        }
		
        $dataProvider = $this->_search($params, $query); 

        return $dataProvider;
    }
	
	private function _search($params, $query) {
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['updated_date'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'id' => $this->id,
			'status' => $this->status,
            
        ]);

        $query->andFilterWhere(['ilike', 'subject', $this->subject])
            ->andFilterWhere(['ilike', 'notes', $this->notes])
            ->andFilterWhere(['ilike', 'no_iom_area_exp', $this->no_iom_area_exp])
            ->andFilterWhere(['ilike', 'created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'updated_by', $this->updated_by])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);
			
		return $dataProvider;
	}
}
