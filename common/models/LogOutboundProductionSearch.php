<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\LogOutboundProduction;

/**
 * LogOutboundProductionSearch represents the model behind the search form of `divisitiga\models\LogOutboundProduction`.
 */
class LogOutboundProductionSearch extends LogOutboundProduction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog', 'id_instruction_production', 'created_by', 'updated_by', 'status_listing', 'forwarder'], 'integer'],
            [['created_date', 'updated_date', 'revision_remark', 'no_surat_jalan', 'plate_number', 'driver', 'file_attachment'], 'safe'],
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
        $query = LogOutboundProduction::find();

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
            'idlog' => $this->idlog,
            'id_instruction_production' => $this->id_instruction_production,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'forwarder' => $this->forwarder,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'no_surat_jalan', $this->no_surat_jalan])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number])
            ->andFilterWhere(['ilike', 'driver', $this->driver])
            ->andFilterWhere(['ilike', 'file_attachment', $this->file_attachment]);

        return $dataProvider;
    }
}
