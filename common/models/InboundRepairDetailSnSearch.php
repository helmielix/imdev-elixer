<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InboundWhTransferDetail;

/**
 * InboundWhTransferDetailSearch represents the model behind the search form of `divisitiga\models\InboundWhTransferDetail`.
 */
class InboundRepairDetailSnSearch extends InboundRepairDetailSn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
//        return [
//            [['id', 'id_inbound_wh', 'id_item_im', 'qty', 'status_listing'], 'integer'],
//            [['delta', 'orafin_code'], 'safe'],
//        ];
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
        $query = InboundRepairDetailSn::find()->joinWith(["item"]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_detail_sn' => $this->id_detail_sn,
            'id_barang' => $this->id_barang,
            'id_instruction_repair' => $this->id_instruction_repair,
        ]);

//        $query->andFilterWhere(['ilike', 'delta', $this->delta]);

        return $dataProvider;
    }
}
