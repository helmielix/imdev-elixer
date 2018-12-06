<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\StockOpnameInternal;

/**
 * StockOpnameInternalSearch represents the model behind the search form of `divisitiga\models\StockOpnameInternal`.
 */
class StockOpnameInternalSearch extends StockOpnameInternal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_listing', 'created_by', 'updated_by', 'id_warehouse', 'pic',  'id_modul'], 'integer'],
            [['cut_off_data_date', 'sto_date', 'file', 'revision_remark', 'created_date', 'updated_date', 'cut_off_data_time', 'start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = StockOpnameInternal::find();

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
            'status_listing' => $this->status_listing,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'id_warehouse' => $this->id_warehouse,
            'pic' => $this->pic,
            'stock_opname_number' => $this->stock_opname_number,
            'cut_off_data_date' => $this->cut_off_data_date,
            'sto_date' => $this->sto_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'cut_off_data_time' => $this->cut_off_data_time,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['ilike', 'file', $this->file])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
