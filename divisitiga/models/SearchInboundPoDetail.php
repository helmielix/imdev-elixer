<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InboundPoDetail;

/**
 * SearchInboundPoDetail represents the model behind the search form about `inbound\models\InboundPoDetail`.
 */
class SearchInboundPoDetail extends InboundPoDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_po', 'id_item_im'], 'integer'],
            [['sn_type'], 'safe'],
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
        ]);

        $query->andFilterWhere(['like', 'sn_type', $this->sn_type]);

        return $dataProvider;
    }
}
