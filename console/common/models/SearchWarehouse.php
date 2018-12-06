<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Warehouse;
use common\models\UserWarehouse;

/**
 * SearchWarehouse represents the model behind the search form about `common\models\Warehouse`.
 */
class SearchWarehouse extends Warehouse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_region', 'id_divisi'], 'integer'],
            [['nama_warehouse', 'pic', 'alamat', 'note', 'id_user'], 'safe'],
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
	
	public function searchByUserwarehouse($params, $id_warehouse){
		$query = UserWarehouse::find()->joinWith('iduser');
		$query
		// ->andWhere(['id_user' => $id_user])
			  ->andWhere(['id_warehouse' => $id_warehouse]);
			  
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		
		$this->load($params);
		
		if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$query->andFilterWhere(['ilike', 'user.username', $this->id_user])
			;
		
		return $dataProvider;
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
        $query = Warehouse::find();

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
            'id_region' => $this->id_region,
            'id_divisi' => $this->id_divisi,
        ]);

        $query->andFilterWhere(['like', 'nama_warehouse', $this->nama_warehouse])
            ->andFilterWhere(['like', 'id_warehouse', $this->id_warehouse])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
