<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\TempOutboundGrfDetail;

/**
 * TempOutboundGrfDetailSearch represents the model behind the search form of `divisitiga\models\TempOutboundGrfDetail`.
 */
class TempOutboundGrfDetailSearch extends TempOutboundGrfDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_grf', 'id_item_im', 'qty_req', 'qty_req_good', 'qty_req_not_good', 'qty_req_reject', 'status_item'], 'integer'],
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
        $query = TempOutboundGrfDetail::find();

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
            'id_outbound_grf' => $this->id_outbound_grf,
            'id_item_im' => $this->id_item_im,
            'qty_req' => $this->qty_req,
            'qty_req_good' => $this->qty_req_good,
            'qty_req_not_good' => $this->qty_req_not_good,
            'qty_req_reject' => $this->qty_req_reject,
            'status_item' => $this->status_item,
        ]);

        return $dataProvider;
    }
}
