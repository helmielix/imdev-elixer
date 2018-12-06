<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\MasterItem;

/**
 * MasterItemSearch represents the model behind the search form of `divisitiga\models\MasterItem`.
 */
class MasterItemSearch extends MasterItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'total', 's_good', 's_not_good', 's_reject'], 'integer'],
            [['unit'], 'safe'],
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
        $query = MasterItem::find();

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
            'type' => $this->type,
            'total' => $this->total,
            's_good' => $this->s_good,
            's_not_good' => $this->s_not_good,
            's_reject' => $this->s_reject,
        ]);

        $query->andFilterWhere(['ilike', 'unit', $this->unit]);

        return $dataProvider;
    }
}
