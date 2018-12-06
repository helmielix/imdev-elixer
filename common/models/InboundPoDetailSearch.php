<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InboundPoDetail;

/**
 * InboundPoDetailSearch represents the model behind the search form of `divisitiga\models\InboundPoDetail`.
 */
class InboundPoDetailSearch extends InboundPoDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_po', 'id_item_im', 'qty', 'status_listing'], 'integer'],
            [['orafin_code'], 'safe'],
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
        $query = InboundPoDetail::find();

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
            'id_inbound_po' => $this->id_inbound_po,
            'id_item_im' => $this->id_item_im,
            'qty' => $this->qty,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['ilike', 'orafin_code', $this->orafin_code]);

        return $dataProvider;
    }
}
