<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use os\models\DashOsNewTask;


class SearchDashOsNewTask extends DashOsNewTask
{
    public function rules()
    {
        return [
            [['task_date', 'table_source', 'note', 'task'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DashOsNewTask::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => array('pageSize' => 50),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'date(task_date)' => $this->task_date,
        ]);

        $query->andFilterWhere(['ilike', 'table_source', $this->table_source])
            ->andFilterWhere(['ilike', 'note', $this->note])
            ->andFilterWhere(['ilike', 'stdk', $this->stdk])
            ->andFilterWhere(['ilike', 'note', $this->task]);

        return $dataProvider;
    }
}
