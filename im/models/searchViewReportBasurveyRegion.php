<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ViewReportBasurveyRegion;

/**
 * searchViewReportBasurveyRegion represents the model behind the search form about `app\models\ViewReportBasurveyRegion`.
 */
class searchViewReportBasurveyRegion extends ViewReportBasurveyRegion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region'], 'safe'],
            [['qtyhppotential_sum', 'qtyhpsohopotential_sum'], 'integer'],
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
        $query = ViewReportBasurveyRegion::find();

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
            'qtyhppotential_sum' => $this->qtyhppotential_sum,
            'qtyhpsohopotential_sum' => $this->qtyhpsohopotential_sum,
        ]);

        $query->andFilterWhere(['like', 'region', $this->region]);

        return $dataProvider;
    }
}
