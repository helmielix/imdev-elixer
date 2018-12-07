<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionDisposal;

/**
 * searchInstructionDisposal represents the model behind the search form about `common\models\InstructionDisposal`.
 */
class SearchInstructionDisposal extends InstructionDisposal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'status_listing', 'no_iom', 'id_warehouse', 'id'], 'integer'],
            [['created_date', 'updated_date', 'file_attachment', 'date_iom', 'revision_remark'], 'safe'],
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
    public function _search($params, $id_modul, $action){
        $query = InstructionDisposal::find();//->andWhere(['id_modul' => $id_modul]);
        
        if($action == 'input'){
            $query  ->andFilterWhere(['instruction_disposal.status_listing' => [ 1,2,3,6,7 ]]);
        }else if($action == 'approve'){
            $query  ->andFilterWhere(['instruction_disposal.status_listing' => [ 1,5 ]]);
        }
        
        $dataProvider = $this->search($params, $query);

        return $dataProvider;
    }
    
    public function search($params, $query)
    {        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
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
            'id_warehouse' => $this->id_warehouse,
            // 'buyer' => $this->buyer,
            // 'instruction_number' => $this->instruction_number,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            // 'target_implementation' => $this->target_implementation,
            'date_iom' => $this->date_iom,
            // 'estimasi_disposal' => $this->estimasi_disposal,
            // 'id_modul' => $this->id_modul,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
        ->andFilterWhere(['like', 'file_attachment', $this->file_attachment]);

        return $dataProvider;
    }
}
