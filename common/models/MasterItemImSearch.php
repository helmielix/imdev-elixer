<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\MasterItemIm;

/**
 * MasterItemImSearch represents the model behind the search form of `divisitiga\models\MasterItemIm`.
 */
class MasterItemImSearch extends MasterItemIm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status', 'sn_type', 'stock_qty', 's_good', 's_not_good', 's_reject'], 'integer'],
            [['name', 'brand', 'created_date', 'updated_date', 'im_code', 'orafin_code', 'grouping', 'warna', 'type'], 'safe'],
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
        $query = MasterItemIm::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'sn_type' => $this->sn_type,
            'stock_qty' => $this->stock_qty,
            's_good' => $this->s_good,
            's_not_good' => $this->s_not_good,
            's_reject' => $this->s_reject,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'brand', $this->brand])
            ->andFilterWhere(['ilike', 'im_code', $this->im_code])
            ->andFilterWhere(['ilike', 'orafin_code', $this->orafin_code])
            ->andFilterWhere(['ilike', 'grouping', $this->grouping])
            ->andFilterWhere(['ilike', 'warna', $this->warna])
            ->andFilterWhere(['ilike', 'type', $this->type]);

        return $dataProvider;
    }
}
