<?php

namespace usermanagement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\District;

/**
 * DistrictSearch represents the model behind the search form about `app\models\District`.
 */
class SearchDistrict extends District
{
	public $city, $region;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'id_city','city','region'], 'safe'],
        ];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = District::find();

		$query->joinWith(['idCity.idRegion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => array('pageSize' => 10),
        ]);

		$dataProvider->sort->attributes['city'] = [
			'asc' => ['city.name' => SORT_ASC],
			'desc' => ['city.name' => SORT_DESC],
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
			'id_city' => $this->id_city,
        ]);

        $query->andFilterWhere(['Ilike', 'district.name', $this->name])
				->andFilterWhere(['Ilike', 'city.name', $this->city])
				->andFilterWhere(['Ilike', 'region.name', $this->region]);

        return $dataProvider;
    }
}
