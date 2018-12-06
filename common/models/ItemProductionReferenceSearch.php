<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\ItemProductionReference;

/**
 * ItemProductionReferenceSearch represents the model behind the search form of `divisitiga\models\ItemProductionReference`.
 */
class ItemProductionReferenceSearch extends ItemProductionReference
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'item_hasil', 'item_bahan', 'qty'], 'integer'],
            [['orafin_name', 'item_hasil_name'], 'safe'],
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
        $query = ItemProductionReference::find();

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
            'item_hasil' => $this->item_hasil,
            'item_bahan' => $this->item_bahan,
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['ilike', 'orafin_name', $this->orafin_name])
            ->andFilterWhere(['ilike', 'item_hasil_name', $this->item_hasil_name]);

        return $dataProvider;
    }
}
