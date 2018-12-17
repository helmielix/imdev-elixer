<?php

namespace iko\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IkoTeamMember;

class SearchIkoTeamMember extends IkoTeamMember
{
    public function rules()
    {
        return [
            [['id', 'nik','id_iko_team'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = IkoTeamMember::find();

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
            'nik' => $this->nik,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'id_iko_team', $this->id_iko_team]);

        return $dataProvider;
    }

    public function searchByIdteam($params,$idteam)
    {
        $query = IkoTeamMember::find()
                ->andFilterWhere(['=','id_iko_team',$idteam]);

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
            'nik' => $this->nik,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'id_iko_team', $this->id_iko_team]);

        return $dataProvider;
    }
}
