<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundRepairNew;

/**
 * SearchInboundRepairNew represents the model behind the search form about `common\models\InboundRepairNew`.
 */
class SearchInboundRepairNew extends InboundRepairNew
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_repair', 'created_by', 'status_listing', 'updated_by', 'forwarder', 'id_modul', 'tagging'], 'integer'],
            [['driver', 'no_sj', 'plate_number', 'created_date', 'updated_date', 'revision_remark', 'tanggal_datang', 'file_attachment'], 'safe'],
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
        $query = InboundRepairNew::find();

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
            'id_instruction_repair' => $this->id_instruction_repair,
            'created_by' => $this->created_by,
            'status_listing' => $this->status_listing,
            'updated_by' => $this->updated_by,
            'forwarder' => $this->forwarder,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'tanggal_datang' => $this->tanggal_datang,
            'tagging' => $this->tagging,
        ]);

        $query->andFilterWhere(['like', 'driver', $this->driver])
            ->andFilterWhere(['like', 'no_sj', $this->no_sj])
            ->andFilterWhere(['like', 'plate_number', $this->plate_number])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'file_attachment', $this->file_attachment]);

        return $dataProvider;
    }
}
