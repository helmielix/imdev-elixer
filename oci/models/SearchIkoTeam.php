<?php

namespace iko\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IkoTeam;

class SearchIkoTeam extends IkoTeam
{
    public function rules()
    {
        return [
            [['id', 'id_labor','status_team'], 'integer'],
            [['leader', 'created_date', 'updated_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = IkoTeam::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_labor' => $this->id_labor,
            'status_team' => $this->status_team,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
        ]);

        $query->andFilterWhere(['ilike', 'leader', $this->leader]);

        return $dataProvider;
    }
}
