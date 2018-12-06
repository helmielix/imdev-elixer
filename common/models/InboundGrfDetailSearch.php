<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InboundGrfDetail;

/**
 * InboundGrfDetailSearch represents the model behind the search form of `divisitiga\models\InboundGrfDetail`.
 */
class InboundGrfDetailSearch extends InboundGrfDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_grf', 'id_item_im', 'qty_return', 'status_item'], 'integer'],
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
        $query = InboundGrfDetail::find();

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
            'id_inbound_grf' => $this->id_inbound_grf,
            'id_item_im' => $this->id_item_im,
            'qty_return' => $this->qty_return,
            'status_item' => $this->status_item,
        ]);

        return $dataProvider;
    }
}
