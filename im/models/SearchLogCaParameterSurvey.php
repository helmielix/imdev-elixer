<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCaParameterSurvey;

/**
 * SearchLogCaParameterSurvey represents the model behind the search form about `app\models\LogCaParameterSurvey`.
 */
class SearchLogCaParameterSurvey extends LogCaParameterSurvey
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id', 'id_ca_parameter', 'id_ca_ba_survey'], 'integer'],
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
        $query = LogCaParameterSurvey::find();

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
            'id_ca_parameter' => $this->id_ca_parameter,
            'id_ca_ba_survey' => $this->id_ca_ba_survey,
        ]);

        return $dataProvider;
    }
}
