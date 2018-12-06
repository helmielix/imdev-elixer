<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OutboundGrf;

/**
 * OutboundGrfSearch represents the model behind the search form of `divisitiga\models\OutboundGrf`.
 */
class OutboundGrfSearch extends OutboundGrf
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing', 'grf_type', 'id_division', 'id_region', 'pic', 'forwarder', 'id_modul'], 'integer'],
            [['grf_number', 'wo_number', 'file', 'purpose', 'note', 'plate_number', 'driver', 'revision_remark', 'published_date', 'print_time', 'handover_time', 'surat_jalan_number', 'incoming_date', 'created_date', 'updated_date'], 'safe'],
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
        $query = OutboundGrf::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'grf_type' => $this->grf_type,
            'id_division' => $this->id_division,
            'id_region' => $this->id_region,
            'pic' => $this->pic,
            'forwarder' => $this->forwarder,
            'published_date' => $this->published_date,
            'print_time' => $this->print_time,
            'handover_time' => $this->handover_time,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
        ]);

        $query->andFilterWhere(['ilike', 'grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'file', $this->file])
            ->andFilterWhere(['ilike', 'purpose', $this->purpose])
            ->andFilterWhere(['ilike', 'note', $this->note])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number])
            ->andFilterWhere(['ilike', 'driver', $this->driver])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'surat_jalan_number', $this->surat_jalan_number]);

        return $dataProvider;
    }
}
