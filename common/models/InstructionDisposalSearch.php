<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InstructionDisposal;

/**
 * InstructionDisposalSearch represents the model behind the search form of `divisitiga\models\InstructionDisposal`.
 */
class InstructionDisposalSearch extends InstructionDisposal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'status_listing', 'warehouse', 'buyer', 'id_modul', 'id'], 'integer'],
            [['created_date', 'updated_date', 'target_implementation', 'revision_remark', 'file_attachment', 'instruction_number', 'estimasi_disposal', 'date_iom', 'no_iom'], 'safe'],
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
        $query = InstructionDisposal::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'warehouse' => $this->warehouse,
            'buyer' => $this->buyer,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'target_implementation' => $this->target_implementation,
            'id_modul' => $this->id_modul,
            'id' => $this->id,
            'estimasi_disposal' => $this->estimasi_disposal,
            'date_iom' => $this->date_iom,
        ]);

        $query->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'file_attachment', $this->file_attachment])
            ->andFilterWhere(['ilike', 'instruction_number', $this->instruction_number])
            ->andFilterWhere(['ilike', 'no_iom', $this->no_iom]);

        return $dataProvider;
    }
}
