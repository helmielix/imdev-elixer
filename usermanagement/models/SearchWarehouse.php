<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Warehouse;

/**
 * SearchWarehouse represents the model behind the search form about `app\models\Warehouse`.
 */
class SearchWarehouse extends Warehouse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_warehouse', 'warehouse_name', 'id_region'], 'safe'],
            // [['id_region'], 'integer'],
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
        $query = Warehouse::find()->joinWith('idRegion');

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
            // 'id_region' => $this->id_region,
        ]);

        $query->andFilterWhere(['ilike', 'id_warehouse', $this->id_warehouse])
            ->andFilterWhere(['ilike', 'region.name', $this->id_region])
            ->andFilterWhere(['ilike', 'warehouse_name', $this->warehouse_name]);

        return $dataProvider;
    }
}
