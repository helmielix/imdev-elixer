<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogInstructionGrf;

/**
 * SearchLogInstructionGrf represents the model behind the search form about `common\models\LogInstructionGrf`.
 */
class SearchLogInstructionGrf extends LogInstructionGrf
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing', 'id_modul', 'id_grf', 'id_warehouse', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date', 'note', 'date_of_return', 'revision_remark'], 'safe'],
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
        $query = LogInstructionGrf::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'id_grf' => $this->id_grf,
            'id_warehouse' => $this->id_warehouse,
            'date_of_return' => $this->date_of_return,
            'status_return' => $this->status_return,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
