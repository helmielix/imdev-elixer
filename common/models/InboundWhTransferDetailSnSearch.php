<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InboundWhTransferDetailSn;

/**
 * InboundWhTransferDetailSnSearch represents the model behind the search form of `divisitiga\models\InboundWhTransferDetailSn`.
 */
class InboundWhTransferDetailSnSearch extends InboundWhTransferDetailSn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_wh_detail'], 'integer'],
            [['mac_address', 'serial_number'], 'safe'],
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
        $query = InboundWhTransferDetailSn::find();

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
            'id_inbound_wh_detail' => $this->id_inbound_wh_detail,
        ]);

        $query->andFilterWhere(['ilike', 'mac_address', $this->mac_address])
            ->andFilterWhere(['ilike', 'serial_number', $this->serial_number]);

        return $dataProvider;
    }
}
