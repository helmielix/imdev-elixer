<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\LogInboundPo;

/**
 * LogInboundPoSearch represents the model behind the search form of `divisitiga\models\LogInboundPo`.
 */
class LogInboundPoSearch extends LogInboundPo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog', 'id', 'created_by', 'updated_by', 'status_listing', 'id_modul'], 'integer'],
            [['rr_number', 'no_sj', 'tgl_sj', 'waranty', 'po_number', 'supplier', 'pr_number', 'revision_remark', 'updated_date', 'created_date'], 'safe'],
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
        $query = LogInboundPo::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'id_modul' => $this->id_modul,
            'tgl_sj' => $this->tgl_sj,
            'updated_date' => $this->updated_date,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['ilike', 'rr_number', $this->rr_number])
            ->andFilterWhere(['ilike', 'no_sj', $this->no_sj])
            ->andFilterWhere(['ilike', 'waranty', $this->waranty])
            ->andFilterWhere(['ilike', 'po_number', $this->po_number])
            ->andFilterWhere(['ilike', 'supplier', $this->supplier])
            ->andFilterWhere(['ilike', 'pr_number', $this->pr_number])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
