<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsOutsourceParameter;
use app\models\User;

/**
 * SearchOsOutsourceParameter represents the model behind the search form about `app\models\OsOutsourceParameter`.
 */
class SearchOsOutsourceParameter extends OsOutsourceParameter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_division', 'work_day', 'salary', 'allowance_special', 'cost_operational', 'cost_phone', 'allowance_shift', 'allowance_pph21', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['position', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
            [['adjustment', 'bpjs_tk', 'bpjs_kes', 'bpjs_jp', 'man_fee', 'ppn', 'pph_23'], 'number'],
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
        $query = OsOutsourceParameter::find();

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
            'id_division' => $this->id_division,
            'work_day' => $this->work_day,
            'salary' => $this->salary,
            'allowance_special' => $this->allowance_special,
            'cost_operational' => $this->cost_operational,
            'cost_phone' => $this->cost_phone,
            'allowance_shift' => $this->allowance_shift,
            'allowance_pph21' => $this->allowance_pph21,
            'adjustment' => $this->adjustment,
            'bpjs_tk' => $this->bpjs_tk,
            'bpjs_kes' => $this->bpjs_kes,
            'bpjs_jp' => $this->bpjs_jp,
            'man_fee' => $this->man_fee,
            'ppn' => $this->ppn,
            'pph_23' => $this->pph_23,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        if (isset($this->position)) {
            $this->position = explode(' - ',$this->position)[0];
        }

        $query->andFilterWhere(['ilike', 'position', $this->position])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }


	public function searchByAction($params, $action)
    {



		 $query = OsOutsourceParameter::find();

		if($action == 'input') {
			$query ->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 3],['=','status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {
			$query ->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 2],['=','status_listing', 5]])
				 ->orderBy(['id' => SORT_DESC]);
		}

		else if ($action == 'overview') {
			$query ->andFilterWhere(['or',['=','status_listing', 1],['=','status_listing', 3],['=','status_listing', 2],['=','status_listing', 4], ['=','status_listing', 5], ['=','status_listing', 6]])
				 ->orderBy(['id' => SORT_DESC]);
		}

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),



        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }



        // grid filtering conditions
      $query->andFilterWhere([
            'id' => $this->id,
            'id_division' => $this->id_division,
            'work_day' => $this->work_day,
            'salary' => $this->salary,
            'allowance_special' => $this->allowance_special,
            'cost_operational' => $this->cost_operational,
            'cost_phone' => $this->cost_phone,
            'allowance_shift' => $this->allowance_shift,
            'allowance_pph21' => $this->allowance_pph21,
            'adjustment' => $this->adjustment,
            'bpjs_tk' => $this->bpjs_tk,
            'bpjs_kes' => $this->bpjs_kes,
            'bpjs_jp' => $this->bpjs_jp,
            'man_fee' => $this->man_fee,
            'ppn' => $this->ppn,
            'pph_23' => $this->pph_23,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        if (isset($this->position)) {
            $this->position = explode(' - ',$this->position)[0];
        }
        
        $query->andFilterWhere(['ilike', 'position', $this->position])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
}
}
