<?php

namespace setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use setting\models\Reference;

/**
 * searchReference represents the model behind the search form about `setting\models\Reference`.
 */
class searchReference extends Reference
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_grouping'], 'integer'],
            [['description', 'table_relation'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Reference::find();

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
            'id_grouping' => $this->id_grouping,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'table_relation', $this->table_relation]);

        return $dataProvider;
    }
}
