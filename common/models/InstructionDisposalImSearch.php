<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\InstructionDisposalIm;

/**
 * InstructionDisposalImSearch represents the model behind the search form of `divisitiga\models\InstructionDisposalIm`.
 */
class InstructionDisposalImSearch extends InstructionDisposalIm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_disposal_am', 'created_by', 'updated_by', 'status_listing', 'id_modul'], 'integer'],
            [['created_date', 'updated_date', 'target_pelaksanaan'], 'safe'],
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
        $query = InstructionDisposalIm::find();

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
            'id_disposal_am' => $this->id_disposal_am,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'id_modul' => $this->id_modul,
            'target_pelaksanaan' => $this->target_pelaksanaan,
        ]);

        return $dataProvider;
    }
}
