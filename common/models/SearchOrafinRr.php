<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrafinRr;

/**
 * SearchOrafinRr represents the model behind the search form about `common\models\OrafinRr`.
 */
class SearchOrafinRr extends OrafinRr
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pr_number', 'po_number', 'status_listing'], 'integer'],
            [['supplier', 'rr_date', 'waranty', 'rr_number'], 'safe'],
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
        $query = OrafinRr::find();

        // add conditions that should always apply here

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
            'pr_number' => $this->pr_number,
            'po_number' => $this->po_number,
            'rr_date' => $this->rr_date,
            'waranty' => $this->waranty,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'supplier', $this->supplier])
            ->andFilterWhere(['like', 'rr_number', $this->rr_number]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $idOrafinRr)
    {
        $query = OrafinRr::find()->joinWith('prRr',true,'FULL JOIN')
		->select(['orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
				'orafin_view_mkm_pr_to_pay.rcv_no as rr_number'
				// 'orafin_view_mkm_pr_to_pay.item_desc as orafin_name'
		])
		->where(['=','orafin_rr.id',$idOrafinRr]);

       

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	private function _search($params, $query) {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
        ]);

        // $dataProvider->sort->attributes['area'] = [
            // 'asc' => ['area.id' => SORT_ASC],
            // 'desc' => ['area.id' => SORT_DESC],
        // ];

        // $dataProvider->sort->attributes['boq_number'] = [
            // 'asc' => ['planning_iko_boq_p.boq_number' => SORT_ASC],
            // 'desc' => ['planning_iko_boq_p.boq_number' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // if ($this->status_listing == 999) {
            // $query->andFilterWhere(['orafin_rr.status_listing' => 5]);
        // }else {
            // $query->andFilterWhere(['inbound_po.status_listing' => $this->status_listing]);
        // }

        // grid filtering conditions
        // $query->andFilterWhere([
            // 'id' => $this->id,
            // // 'rr_number' => $this->rr_number,
            // 'created_by' => $this->created_by,
            // 'updated_by' => $this->updated_by,
            // 'created_date' => $this->created_date,
            // 'updated_date' => $this->updated_date,
            // 'status_listing' => $this->status_listing,
        // ]);

        // $query->andFilterWhere(['ilike', 'pic_vendor', $this->pic_vendor])
            // ->andFilterWhere(['ilike', 'pic_iko', $this->pic_iko])
            // ->andFilterWhere(['ilike', 'grf_number', $this->grf_number])
            // ->andFilterWhere(['ilike', 'planning_iko_boq_p.boq_number', $this->boq_number])
            // ->andFilterWhere(['ilike', 'area.id', $this->area]);


        return $dataProvider;
    }
}
