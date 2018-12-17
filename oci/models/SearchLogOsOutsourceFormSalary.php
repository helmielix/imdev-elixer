<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsOutsourceFormSalary;

/**
 * SearchLogOsOutsourceFormSalary represents the model behind the search form about `app\models\LogOsOutsourceFormSalary`.
 */
class SearchLogOsOutsourceFormSalary extends LogOsOutsourceFormSalary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id', 'id_city', 'id_division', 'month', 'year', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['report_finger_print', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
        $query = LogOsOutsourceFormSalary::find();

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
            'id_city' => $this->id_city,
            'id_division' => $this->id_division,
            'month' => $this->month,
            'year' => $this->year,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'report_finger_print', $this->report_finger_print])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
