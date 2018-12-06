<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OrafinRr;

/**
 * OrafinRrSearch represents the model behind the search form of `divisitiga\models\OrafinRr`.
 */
class OrafinRrSearch extends OrafinRr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pr_number', 'po_number', 'status_listing'], 'integer'],
            [['supplier', 'rr_date', 'waranty', 'rr_number'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = OrafinRr::find();

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
            'pr_number' => $this->pr_number,
            'po_number' => $this->po_number,
            'rr_date' => $this->rr_date,
            'waranty' => $this->waranty,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['ilike', 'supplier', $this->supplier])
            ->andFilterWhere(['ilike', 'rr_number', $this->rr_number]);

        return $dataProvider;
    }
}
