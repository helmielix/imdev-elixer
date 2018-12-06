<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CaIomAndCity;
use app\models\searchCITY;

class SearchCaIomandcity extends CaIomAndCity
{
	public $city, $region;
	
    public function rules()
    {
        return [
            [['id', 'id_city', 'id_ca_iom_area_expansion'], 'integer'],
			[['city', 'region'],'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
	public function search($params)
    {
        $query = CaIomAndCity::find();

        $dataProvider = $this->_search($params); 

        return $dataProvider;
    }
	
	public function searchByIom($params, $id)
    {
        $query = CaIomAndCity::find();
		$query->andFilterWhere(['=','id_ca_iom_area_expansion',$id]);
		$query->joinWith(['idCity.idRegion']);
		
        $dataProvider = $this->_search($params, $query); 

        return $dataProvider;
    }
	
	private function _search($params, $query) {
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'id_ca_iom_area_expansion' => $this->id_ca_iom_area_expansion,
        ]);
		
		$query->andFilterWhere(['Ilike', 'city.name', $this->city])
			  ->andFilterWhere(['Ilike', 'region.name', $this->city]);
			
		return $dataProvider;
	}
}
