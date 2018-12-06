<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionRepairDetail;

/**
 * SearchInstructionRepairDetail represents the model behind the search form about `common\models\InstructionRepairDetail`.
 */
class SearchInstructionRepairDetail extends InstructionRepairDetail
{
    /**
     * @inheritdoc
     */
    // public $name;
    public function rules()
    {
        return [
            [['id', 'id_instruction_repair', 'id_item_im', 'created_by', 'req_good', 'req_not_good', 'req_reject','rem_reject'], 'integer'],
            // [['name'], 'safe'],
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
        $query = InstructionRepairDetail::find();
		// $query->select([
			// 'id_item_im'
		// ]);
		$query->andWhere(['id_instruction_repair' => $id]);
        // $query->joinWith(['idMasterItemIm']);

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
            'id_instruction_repair' => $this->id_instruction_repair,
            'id_item_im' => $this->id_item_im,
            'created_by' => $this->created_by,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'req_reject' => $this->req_reject,
            'rem_reject' => $this->rem_reject,
        ]);

        // $query->andFilterWhere(['like', 'master_item_im.name', $this->name]);

        return $dataProvider;
    }
}
