<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundGrfDetailSn;

/**
 * OutboundGrfDetailSnSearch represents the model behind the search form of `divisitiga\models\OutboundGrfDetailSn`.
 */
class OutboundGrfDetailSnSearch extends OutboundGrfDetailSn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_grf_detail', 'id_item_im', 'sn'], 'integer'],
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
        $query = OutboundGrfDetailSn::find();

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
            'id_outbound_grf_detail' => $this->id_outbound_grf_detail,
            'id_item_im' => $this->id_item_im,
            'sn' => $this->sn,
        ]);

        return $dataProvider;
    }
}
