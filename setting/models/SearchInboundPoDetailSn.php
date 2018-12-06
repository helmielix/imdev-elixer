<?php

namespace setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use setting\models\InboundPoDetailSn;

/**
 * SearchInboundPoDetailSn represents the model behind the search form about `inbound\models\InboundPoDetailSn`.
 */
class SearchInboundPoDetailSn extends InboundPoDetailSn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_po_detail'], 'integer'],
            [['serial_number', 'mac_address'], 'safe'],
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
        $query = InboundPoDetailSn::find();

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
            'id_inbound_po_detail' => $this->id_inbound_po_detail,
        ]);

        $query->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'mac_address', $this->mac_address]);

        return $dataProvider;
    }
}
