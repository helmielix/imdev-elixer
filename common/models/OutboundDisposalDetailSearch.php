<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundDisposalDetail;

/**
 * OutboundDisposalDetailSearch represents the model behind the search form of `divisitiga\models\OutboundDisposalDetail`.
 */
class OutboundDisposalDetailSearch extends OutboundDisposalDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_disposal', 'id_item_im', 'qty', 'sn'], 'integer'],
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
        $query = OutboundDisposalDetail::find();

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
            'id_outbound_disposal' => $this->id_outbound_disposal,
            'id_item_im' => $this->id_item_im,
            'qty' => $this->qty,
            'sn' => $this->sn,
        ]);

        return $dataProvider;
    }
}
