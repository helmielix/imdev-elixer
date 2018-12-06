<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogInboundPoDetail;

/**
 * SearchLogInboundPoDetail represents the model behind the search form about `common\models\LogInboundPoDetail`.
 */
class SearchLogInboundPoDetail extends LogInboundPoDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id', 'id_inbound_po', 'id_item_im', 'qty', 'status_listing', 'qty_good', 'qty_not_good', 'qty_reject', 'qty_rr'], 'integer'],
            [['orafin_code'], 'safe'],
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
        $query = LogInboundPoDetail::find();

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
            'id' => $this->id,
            'id_inbound_po' => $this->id_inbound_po,
            'id_item_im' => $this->id_item_im,
            'qty' => $this->qty,
            'status_listing' => $this->status_listing,
            'qty_good' => $this->qty_good,
            'qty_not_good' => $this->qty_not_good,
            'qty_reject' => $this->qty_reject,
            'qty_rr' => $this->qty_rr,
        ]);

        $query->andFilterWhere(['like', 'orafin_code', $this->orafin_code]);

        return $dataProvider;
    }
}
