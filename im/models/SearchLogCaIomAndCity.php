<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCaIomAndCity;

/**
 * SearchLogCaIomAndCity represents the model behind the search form about `app\models\LogCaIomAndCity`.
 */
class SearchLogCaIomAndCity extends LogCaIomAndCity
{
    /**
     * @inheritdoc
     */
	 
	public $city, $region;
	 
    public function rules()
    {
        return [
            [['idlog', 'id', 'id_city', 'id_ca_iom_area_expansion'], 'integer'],
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
        $query = LogCaIomAndCity::find();
		
		// $query->andFilterWhere(['=','id_ca_iom_area_expansion',$id]);
		// $query->joinWith(['idCity.idRegion']);
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
            'idlog' => $this->idlog,
            'id' => $this->id,
            'id_city' => $this->id_city,
            'id_ca_iom_area_expansion' => $this->id_ca_iom_area_expansion,
        ]);

        return $dataProvider;
    }
	
	public function searchByIom($params, $id)
    {
        $query = LogCaIomAndCity::find();
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
