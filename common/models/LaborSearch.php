<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\Labor;

/**
 * LaborSearch represents the model behind the search form of `divisitiga\models\Labor`.
 */
class LaborSearch extends Labor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nik'], 'integer'],
            [['nama', 'position'], 'safe'],
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
        $query = Labor::find();

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
            'nik' => $this->nik,
        ]);

        $query->andFilterWhere(['ilike', 'nama', $this->nama])
            ->andFilterWhere(['ilike', 'position', $this->position]);

        return $dataProvider;
    }
}
