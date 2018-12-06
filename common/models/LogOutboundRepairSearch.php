<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\LogOutboundRepair;

/**
 * LogOutboundRepairSearch represents the model behind the search form of `divisitiga\models\LogOutboundRepair`.
 */
class LogOutboundRepairSearch extends LogOutboundRepair
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog', 'id_instruction_repair', 'created_by', 'updated_by', 'status_listing', 'forwarder', 'id_modul'], 'integer'],
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
        $query = LogOutboundRepair::find();

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
            'id_instruction_repair' => $this->id_instruction_repair,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
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
