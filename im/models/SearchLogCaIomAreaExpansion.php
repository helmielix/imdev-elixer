<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCaIomAreaExpansion;

/**
 * SearchLogCaIomAreaExpansion represents the model behind the search form about `app\models\LogCaIomAreaExpansion`.
 */
class SearchLogCaIomAreaExpansion extends LogCaIomAreaExpansion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'created_by', 'updated_by', 'id', 'status'], 'integer'],
            [['subject', 'notes', 'no_iom_area_exp', 'created_date', 'updated_date', 'revision_remark', 'doc_file','updated_by'], 'safe'],
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
        $query = LogCaIomAreaExpansion::find();

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
            'idlog' => $this->idlog,
            'created_by' => $this->created_by,
            'date(created_date)' => $this->created_date,
            //'updated_by' => $this->updated_by,
            'date(updated_date)' => $this->updated_date,
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'subject', $this->subject])
            ->andFilterWhere(['ilike', 'notes', $this->notes])
            ->andFilterWhere(['ilike', 'no_iom_area_exp', $this->no_iom_area_exp])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'doc_file', $this->doc_file])
			->andFilterWhere(['ilike', 'updatedBy', $this->updated_by]);

        return $dataProvider;
    }

	public function searchByAction($params, $action)
    {
        $query = LogCaIomAreaExpansion::find();

		if($action == 'input') {
            $query->andFilterWhere(['or',['=','status', 7],['=','status', 1],['=','status', 3],['=','status', 2]]);
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
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
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
