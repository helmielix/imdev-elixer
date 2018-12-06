<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AREA;

/**
 * AreaSearch represents the model behind the search form about `app\models\AREA`.
 */
class AreaSearch extends AREA
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['ID', 'OWNER'], 'safe'],
           [['ID_SUBDISTRICT'], 'integer'],
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
        $query = AREA::find();

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
           'ID_SUBDISTRICT' => $this->ID_SUBDISTRICT,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
			  ->andFilterWhere(['like', 'OWNER', $this->OWNER]);

        return $dataProvider;
    }
}
