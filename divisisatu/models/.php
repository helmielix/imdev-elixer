<?php

namespace divisisatu\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionDisposal;

/**
 * searchInstructionDisposal represents the model behind the search form about `common\models\InstructionDisposal`.
 */
class searchInstructionDisposal extends InstructionDisposal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'status_listing', 'no_iom', 'warehouse', 'buyer', 'id_modul', 'id'], 'integer'],
            [['created_date', 'updated_date', 'target_implementation', 'revision_remark'], 'safe'],
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
        $query = InstructionDisposal::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'no_iom' => $this->no_iom,
            'warehouse' => $this->warehouse,
            'buyer' => $this->buyer,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'target_implementation' => $this->target_implementation,
            'id_modul' => $this->id_modul,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
