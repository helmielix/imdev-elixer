<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InstructionProduction;

/**
 * InstructionProductionSearch represents the model behind the search form of `divisitiga\models\InstructionProduction`.
 */
class InstructionProductionSearch extends InstructionProduction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'hasil_produksi', 'updated_by', 'created_by', 'id_warehouse', 'status_listing', 'id_modul', 'qty'], 'integer'],
            [['target_produksi', 'file_attachment', 'revision_remark', 'created_date', 'updated_date', 'instruction_number'], 'safe'],
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
        $query = InstructionProduction::find();

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
            'hasil_produksi' => $this->hasil_produksi,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
            'id_warehouse' => $this->id_warehouse,
            'status_listing' => $this->status_listing,
            'target_produksi' => $this->target_produksi,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['ilike', 'file_attachment', $this->file_attachment])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'instruction_number', $this->instruction_number]);

        return $dataProvider;
    }
}
