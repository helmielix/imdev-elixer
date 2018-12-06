<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundWhTransfer;

/**
 * OutboundWhTransferSearch represents the model behind the search form of `divisitiga\models\OutboundWhTransfer`.
 */
class OutboundWhTransferSearch extends OutboundWhTransfer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_instruction_wh', 'created_by', 'status_listing', 'updated_by', 'forwarder', 'id_modul'], 'integer'],
            [['driver', 'no_sj', 'plate_number', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = OutboundWhTransfer::find();

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
            'id_instruction_wh' => $this->id_instruction_wh,
            'created_by' => $this->created_by,
            'status_listing' => $this->status_listing,
            'updated_by' => $this->updated_by,
            'forwarder' => $this->forwarder,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
        ]);

        $query->andFilterWhere(['ilike', 'driver', $this->driver])
            ->andFilterWhere(['ilike', 'no_sj', $this->no_sj])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
