<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchLogInstructionProduction extends LogInstructionProduction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog','id', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['delivery_target_date', 'file_attachment', 'created_date', 'updated_date'], 'safe'],
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

    public function search($params){
  		$query = LogInstructionProduction::find();

  		// if($action == 'input'){
  		// 	$query	->andFilterWhere(['instruction_production.status_listing' => [ 1,2,3,6,7 ]]);
  		// }else if($action == 'approve'){
  		// 	$query	->andFilterWhere(['instruction_production.status_listing' => [ 1,5 ]]);
  		// }

  		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
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
            // 'rr_number' => $this->rr_number,
            // 'rr_number' => $this->rr_number,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        return $dataProvider;
    }

    public function _search($params, $query)
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
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'file_attachment', $this->file_attachment]);

        return $dataProvider;
    }
}
