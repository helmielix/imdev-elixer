<?php

namespace inbound\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use inbound\models\InboundPo;
use common\models\OrafinRr;

/**
 * SearchInboundPo represents the model behind the search form about `inbound\models\InboundPo`.
 */
class SearchInboundPo extends InboundPo
{
   
	
    public function rules()
    {
        return [
            [['id',  'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
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
        $query = InboundPo::find();

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
	
	public function searchByAction($params, $action)
    {
        $query = InboundPo::find()
                ->joinWith('idOrafinRr',true,'FULL JOIN')
                ->select([  'orafin_rr.id as id_orafin_rr',
							'orafin_rr.rr_number as rr_number',
                            'inbound_po.created_by',
                            'inbound_po.updated_by',
                            'inbound_po.created_date',
                            'inbound_po.updated_date',
                            'inbound_po.status_listing',
                            ]);

        if($action == 'input') {
            $query->andFilterWhere(['or',['=','orafin_rr.status_listing', 5],['=','inbound_po.status_listing', 1], ['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 6]])
            ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
        }  else if ($action == 'approve') {
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 4],['=','inbound_po.status_listing', 5]])
                ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
        }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	private function _search($params, $query) {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

        if ($this->status_listing == 999) {
            $query->andFilterWhere(['orafin_rr.status_listing' => 5]);
        }else {
            $query->andFilterWhere(['inbound_po.status_listing' => $this->status_listing]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'rr_number' => $this->rr_number,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        // $query->andFilterWhere(['ilike', 'pic_vendor', $this->pic_vendor])
            // ->andFilterWhere(['ilike', 'pic_iko', $this->pic_iko])
            // ->andFilterWhere(['ilike', 'grf_number', $this->grf_number])
            // ->andFilterWhere(['ilike', 'planning_iko_boq_p.boq_number', $this->boq_number])
            // ->andFilterWhere(['ilike', 'area.id', $this->area]);


        return $dataProvider;
    }
}
