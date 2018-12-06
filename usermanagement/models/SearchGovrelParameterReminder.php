<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GovrelParameterReminder;

/**
 * SearchGovrelParameterReminder represents the model behind the search form about `app\models\GovrelParameterReminder`.
 */
class SearchGovrelParameterReminder extends GovrelParameterReminder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_by', 'created_by', 'day'], 'integer'],
            [['created_date', 'updated_date', 'type'], 'safe'],
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
        $query = GovrelParameterReminder::find();

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
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
            'day' => $this->day,
        ]);
		
		 $query->andFilterWhere(['ilike', 'type', $this->type]);

        return $dataProvider;
    }
}
