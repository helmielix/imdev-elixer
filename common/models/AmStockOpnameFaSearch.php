<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AmStockOpnameFa;

/**
 * AmStockOpnameFaSearch represents the model behind the search form about `common\models\AmStockOpnameFa`.
 */
class AmStockOpnameFaSearch extends AmStockOpnameFa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_opname_number', 'id_warehouse', 'pic', 'cut_off_data', 'file', 'revision_remark', 'created_date', 'updated_date', 'sto_start_date', 'sto_end_date', 'time_cut_off_data'], 'safe'],
            [['status_listing', 'created_by', 'updated_by', 'id_modul'], 'integer'],
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
        $query = AmStockOpnameFa::find();

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
            'status_listing' => $this->status_listing,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'cut_off_data' => $this->cut_off_data,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'sto_start_date' => $this->sto_start_date,
            'sto_end_date' => $this->sto_end_date,
            'time_cut_off_data' => $this->time_cut_off_data,
        ]);

        $query->andFilterWhere(['like', 'stock_opname_number', $this->stock_opname_number])
            ->andFilterWhere(['like', 'id_warehouse', $this->id_warehouse])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
