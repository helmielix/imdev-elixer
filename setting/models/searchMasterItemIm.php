<?php

namespace setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use setting\models\MasterItemIm;

/**
 * searchMasterItemIm represents the model behind the search form about `setting\models\MasterItemIm`.
 */
class searchMasterItemIm extends MasterItemIm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['name', 'brand', 'warna', 'created_date', 'updated_date', 'im_code', 'orafin_code'], 'safe'],
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'warna', $this->warna])
            ->andFilterWhere(['like', 'im_code', $this->im_code])
            ->andFilterWhere(['like', 'orafin_code', $this->orafin_code]);

        return $dataProvider;
    }
}
