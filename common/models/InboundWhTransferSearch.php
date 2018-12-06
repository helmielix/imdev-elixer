<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InboundWhTransfer;

/**
 * InboundWhTransferSearch represents the model behind the search form of `divisitiga\models\InboundWhTransfer`.
 */
class InboundWhTransferSearch extends InboundWhTransfer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_outbound_wh', 'created_by', 'updated_by', 'status_listing', 'id_modul'], 'integer'],
            [['arrival_date', 'production_date', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = InboundWhTransfer::find();

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
            'id_outbound_wh' => $this->id_outbound_wh,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'arrival_date' => $this->arrival_date,
            'production_date' => $this->production_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
        ]);

        $query->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
