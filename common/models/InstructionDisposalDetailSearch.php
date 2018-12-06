<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InstructionDisposalDetail;

/**
 * InstructionDisposalDetailSearch represents the model behind the search form of `divisitiga\models\InstructionDisposalDetail`.
 */
class InstructionDisposalDetailSearch extends InstructionDisposalDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'qty', 'qty_konversi', 'id_instruction_disposal'], 'integer'],
            [['uom', 'uom_old', 'uom_new', 'uom_sale', 'im_code', 'qty_total', 'konversi'], 'safe'],
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
        $query = InstructionDisposalDetail::find();

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
            'qty' => $this->qty,
            'qty_konversi' => $this->qty_konversi,
            'id_instruction_disposal' => $this->id_instruction_disposal,
        ]);

        $query->andFilterWhere(['ilike', 'uom', $this->uom])
            ->andFilterWhere(['ilike', 'uom_old', $this->uom_old])
            ->andFilterWhere(['ilike', 'uom_new', $this->uom_new])
            ->andFilterWhere(['ilike', 'uom_sale', $this->uom_sale])
            ->andFilterWhere(['ilike', 'im_code', $this->im_code])
            ->andFilterWhere(['ilike', 'qty_total', $this->qty_total])
            ->andFilterWhere(['ilike', 'konversi', $this->konversi]);

        return $dataProvider;
    }
}
