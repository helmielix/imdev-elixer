<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\LogInstructionWhTransfer;

/**
 * LogInstructionWhTransferSearch represents the model behind the search form of `divisitiga\models\LogInstructionWhTransfer`.
 */
class LogInstructionWhTransferSearch extends LogInstructionWhTransfer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog', 'created_by', 'updated_by', 'status_listing', 'wh_destination', 'wh_origin', 'id_modul', 'id'], 'integer'],
            [['instruction_number', 'delivery_target_date', 'file_attachment', 'created_date', 'updated_date', 'grf_number', 'revision_remark'], 'safe'],
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
        $query = LogInstructionWhTransfer::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'wh_destination' => $this->wh_destination,
            'delivery_target_date' => $this->delivery_target_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'wh_origin' => $this->wh_origin,
            'id_modul' => $this->id_modul,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'instruction_number', $this->instruction_number])
            ->andFilterWhere(['ilike', 'file_attachment', $this->file_attachment])
            ->andFilterWhere(['ilike', 'grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
