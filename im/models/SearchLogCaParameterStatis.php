<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCaParameterStatis;

/**
 * SearchLogCaParameterStatis represents the model behind the search form about `app\models\LogCaParameterStatis`.
 */
class SearchLogCaParameterStatis extends LogCaParameterStatis
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id'], 'integer'],
            [['property_area_type', 'house_type', 'avr_occupancy_rate', 'myr_population_hv', 'develop_mthd', 'access_to_sell', 'competitors', 'occupancy_use_dth'], 'safe'],
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
        $query = LogCaParameterStatis::find();

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
            'idlog' => $this->idlog,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'property_area_type', $this->property_area_type])
            ->andFilterWhere(['like', 'house_type', $this->house_type])
            ->andFilterWhere(['like', 'avr_occupancy_rate', $this->avr_occupancy_rate])
            ->andFilterWhere(['like', 'myr_population_hv', $this->myr_population_hv])
            ->andFilterWhere(['like', 'develop_mthd', $this->develop_mthd])
            ->andFilterWhere(['like', 'access_to_sell', $this->access_to_sell])
            ->andFilterWhere(['like', 'competitors', $this->competitors])
            ->andFilterWhere(['like', 'occupancy_use_dth', $this->occupancy_use_dth]);

        return $dataProvider;
    }
}
