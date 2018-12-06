<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundWhTransferDetail;

/**
 * OutboundWhTransferDetailSearch represents the model behind the search form of `divisitiga\models\OutboundWhTransferDetail`.
 */
class OutboundWhTransferDetailSearch extends OutboundWhTransferDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_wh', 'id_item_im', 'req_good', 'req_not_good', 'status_listing', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
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
        $query = OutboundWhTransferDetail::find();

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
            'id_outbound_wh' => $this->id_outbound_wh,
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
