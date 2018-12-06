<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Subdistrict;

class SearchSubdistrict extends Subdistrict
{
	public $region,$city,$district;
  
    public function rules()
    {
        return [
            [['id', 'zip_code'], 'integer'],
            [['name', 'id_district','district', 'region', 'city'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Subdistrict::find();

		$query->joinWith(['idDistrict.idCity.idRegion']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => array('pageSize' => 10),
        ]);

		$dataProvider->sort->attributes['region'] = [
			'asc' => ['region.name' => SORT_ASC],
			'desc' => ['region.name' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['city'] = [
			'asc' => ['city.name' => SORT_ASC],
			'desc' => ['city.name' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['district'] = [
			'asc' => ['district.name' => SORT_ASC],
			'desc' => ['district.name' => SORT_DESC],
		];
		
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
			'id_district' => $this->id_district,
			'zip_code' => $this->zip_code,
        ]);

        $query->andFilterWhere(['Ilike', 'subdistrict.name', $this->name])
				->andFilterWhere(['Ilike', 'region.name', $this->region])
				->andFilterWhere(['Ilike', 'city.name', $this->city])
				->andFilterWhere(['Ilike', 'district.name', $this->district]);

        return $dataProvider;
    }
}
