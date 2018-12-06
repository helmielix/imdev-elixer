<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundWhTransferDetailSn;

/**
 * OutboundWhTransferDetailSnSearch represents the model behind the search form of `divisitiga\models\OutboundWhTransferDetailSn`.
 */
class OutboundWhTransferDetailSnSearch extends OutboundWhTransferDetailSn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_wh_detail'], 'integer'],
            [['serial_number', 'mac_address', 'condition'], 'safe'],
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
        $query = OutboundWhTransferDetailSn::find();

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
            'id_outbound_wh_detail' => $this->id_outbound_wh_detail,
        ]);

        $query->andFilterWhere(['ilike', 'serial_number', $this->serial_number])
            ->andFilterWhere(['ilike', 'mac_address', $this->mac_address])
            ->andFilterWhere(['ilike', 'condition', $this->condition]);

        return $dataProvider;
    }
}
