<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Homepass;

/**
 * SearchHomepass represents the model behind the search form about `app\models\Homepass`.
 */
class SearchHomepass extends Homepass
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ca_ba_survey', 'id_govrel_ba_distribution', 'id_planning_iko_bas_plan', 'kodepos'], 'integer'],
            [['status_ca', 'potency_type', 'iom_type', 'status_govrel', 'status_iko', 'home_number', 'hp_type', 'status', 'streetname'], 'safe'],
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
        $query = Homepass::find();

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
            'id_ca_ba_survey' => $this->id_ca_ba_survey,
            'id_govrel_ba_distribution' => $this->id_govrel_ba_distribution,
            'id_planning_iko_bas_plan' => $this->id_planning_iko_bas_plan,
            'kodepos' => $this->kodepos,
			'status_ca' => $this->status_ca,
			'status_govrel' => $this->status_govrel,
			'status' => $this->status,
			'status_iko' => $this->status_iko,
        ]);

        $query->andFilterWhere(['like', 'potency_type', $this->potency_type])
            ->andFilterWhere(['like', 'iom_type', $this->iom_type])
            ->andFilterWhere(['like', 'home_number', $this->home_number])
            ->andFilterWhere(['like', 'hp_type', $this->hp_type])
            ->andFilterWhere(['like', 'streetname', $this->streetname]);

        return $dataProvider;
    }
}
