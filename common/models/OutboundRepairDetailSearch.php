<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundRepairDetail;

/**
 * OutboundRepairDetailSearch represents the model behind the search form of `divisitiga\models\OutboundRepairDetail`.
 */
class OutboundRepairDetailSearch extends OutboundRepairDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_repair', 'id_item_im', 'req_good', 'req_not_good', 'status_listing', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
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
        $query = OutboundRepairDetail::find();

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
            'id_outbound_repair' => $this->id_outbound_repair,
            'id_item_im' => $this->id_item_im,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'status_listing' => $this->status_listing,
            'req_reject' => $this->req_reject,
            'req_good_dismantle' => $this->req_good_dismantle,
            'req_not_good_dismantle' => $this->req_not_good_dismantle,
        ]);

        return $dataProvider;
    }
}
