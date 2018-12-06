<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InstructionProductionDetail;

/**
 * InstructionProductionDetailSearch represents the model behind the search form of `divisitiga\models\InstructionProductionDetail`.
 */
class InstructionProductionDetailSearch extends InstructionProductionDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_instruction_production', 'id_item_im', 'created_by', 'req_good', 'req_not_good', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
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
        $query = InstructionProductionDetail::find();

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
            'id_instruction_production' => $this->id_instruction_production,
            'id_item_im' => $this->id_item_im,
            'created_by' => $this->created_by,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'req_reject' => $this->req_reject,
            'req_good_dismantle' => $this->req_good_dismantle,
            'req_not_good_dismantle' => $this->req_not_good_dismantle,
        ]);

        return $dataProvider;
    }
}
