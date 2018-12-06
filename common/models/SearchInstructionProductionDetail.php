<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionProductionDetail;

/**
 * SearchInstructionProductionDetail represents the model behind the search form about `common\models\InstructionProductionDetail`.
 */
class SearchInstructionProductionDetail extends InstructionProductionDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_instruction_production', 'id_item_im', 'created_by', 'req_good', 'req_not_good', 'req_reject'], 'integer'],
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


    public function search($params, $id){
        $query = InstructionProductionDetail::find();
		// $query->select([
			// 'id_item_im'
		// ]);
		$query->andWhere(['id_instruction_production' => $id]);

		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
			'sort' => ['defaultOrder' => ['id'=>SORT_ASC]]
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
            'id_instruction_production' => $this->id_instruction_production,
            'id_item_im' => $this->id_item_im,
            'created_by' => $this->created_by,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'req_reject' => $this->req_reject,
        ]);

        return $dataProvider;
    }
}
