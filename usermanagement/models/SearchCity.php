<?php

namespace usermanagement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\City;

class SearchCity extends City
{
	public $province, $region;
	
    public function rules()
    {
        return [
            [['id', 'id_region'], 'integer'],
            [['name','region','province'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = City::find();

		$query->joinWith(['idRegion','idProvince']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		$dataProvider->sort->attributes['province'] = [
			'asc' => ['province.name' => SORT_ASC],
			'desc' => ['province.name' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['region'] = [
			'asc' => ['region.name' => SORT_ASC],
			'desc' => ['region.name' => SORT_DESC],
		];
		
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_region' => $this->id_region,
        ]);

        $query->andFilterWhere(['Ilike', 'city.name', $this->name]);
		$query->andFilterWhere(['Ilike', 'province.name', $this->province]);
		$query->andFilterWhere(['Ilike', 'region.name', $this->region]);

        return $dataProvider;
    }
}
