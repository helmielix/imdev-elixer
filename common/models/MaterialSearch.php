<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\Material;

/**
 * MaterialSearch represents the model behind the search form of `divisitiga\models\Material`.
 */
class MaterialSearch extends Material
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'total', 'price'], 'integer'],
            [['type', 'unit', 'im_code', 'status_prod_detail', 'grf_id_product', 'status_grf_product'], 'safe'],
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
        $query = Material::find();

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
            'total' => $this->total,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['ilike', 'type', $this->type])
            ->andFilterWhere(['ilike', 'unit', $this->unit])
            ->andFilterWhere(['ilike', 'im_code', $this->im_code])
            ->andFilterWhere(['ilike', 'status_prod_detail', $this->status_prod_detail])
            ->andFilterWhere(['ilike', 'grf_id_product', $this->grf_id_product])
            ->andFilterWhere(['ilike', 'status_grf_product', $this->status_grf_product]);

        return $dataProvider;
    }
}
