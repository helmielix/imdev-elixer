<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\StockOpnameAdjustment;

/**
 * StockOpnameInternalAdjustmentSearch represents the model behind the search form about `divisitiga\models\StockOpnameAdjustment`.
 */
class StockOpnameInternalAdjustmentSearch extends StockOpnameAdjustment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_master_item_im', 'adj_good', 'adj_not_good', 'adj_reject', 'adj_dismantle_good', 'adj_dismantle_not_good', 'adj_dismantle_reject', 'id_stock_opname_internal_detail'], 'integer'],
            [['remarks', 'summary', 'file'], 'safe'],
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
        $query = StockOpnameAdjustment::find();

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
            'id_master_item_im' => $this->id_master_item_im,
            'adj_good' => $this->adj_good,
            'adj_not_good' => $this->adj_not_good,
            'adj_reject' => $this->adj_reject,
            'adj_dismantle_good' => $this->adj_dismantle_good,
            'adj_dismantle_not_good' => $this->adj_dismantle_not_good,
            'adj_dismantle_reject' => $this->adj_dismantle_reject,
            'id_stock_opname_internal_detail' => $this->id_stock_opname_internal_detail,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
