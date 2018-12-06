<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchInstructionRepair extends InstructionRepair
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['instruction_number','delivery_target_date', 'file_attachment', 'created_date', 'updated_date','vendor_repair','target_pengiriman'], 'safe'],
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

    public function search($params, $id_modul, $action){
  		$query = InstructionRepair::find()->andWhere(['id_modul' => $id_modul]);
      $query->joinWith(['idVendor']);

  		if($action == 'input'){
  			$query	->andFilterWhere(['instruction_repair.status_listing' => [ 1,2,3,6,7 ]]);
  		}else if($action == 'approve'){
  			$query	->andFilterWhere(['instruction_repair.status_listing' => [ 1,5 ]]);
  		}

  		$dataProvider = $this->_search($params, $query);

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
            'instruction_number' => $this->instruction_number,
            // 'vendor_repair' => $this->vendor_repair,
            'target_pengiriman' => $this->target_pengiriman,
        ]);

        $query->andFilterWhere(['like', 'file_attachment', $this->file_attachment])
        ->andFilterWhere(['ilike', 'vendor.name', $this->vendor_repair]);

        return $dataProvider;
    }
}
