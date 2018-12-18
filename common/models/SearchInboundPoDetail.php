<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundPoDetail;

/**
 * SearchInboundPoDetail represents the model behind the search form about `inbound\models\InboundPoDetail`.
 */
class SearchInboundPoDetail extends InboundPoDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_po', 'id_item_im'], 'integer'],
            [['sn_type','im_code','qty_good','qty_not_good','qty_reject','qty','grouping','brand','warna','type','uom'], 'safe'],
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
        $query = InboundPoDetail::find();

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
            'id_inbound_po' => $this->id_inbound_po,
            'id_item_im' => $this->id_item_im,
        ]);

        $query->andFilterWhere(['like', 'sn_type', $this->sn_type]);

        return $dataProvider;
    }

    public function searchById($params, $id)
    {
        $query = InboundPoDetail::find()->joinWith('itemIm')
        ->select(['inbound_po_detail.qty','inbound_po_detail.qty_good','inbound_po_detail.qty_not_good','inbound_po_detail.qty_reject','inbound_po_detail.id_item_im','master_item_im.im_code'])->andFilterWhere(['inbound_po_detail.id'=>$id]);
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function searchByIdInbound($params, $id, $orafinCode)
    {
        $query = InboundPoDetail::find()->joinWith('itemIm')
        ->select([
            'inbound_po_detail.qty',
            'inbound_po_detail.qty_good',
            'inbound_po_detail.qty_not_good',
            'inbound_po_detail.qty_reject',
            'inbound_po_detail.id_item_im',
            'master_item_im.im_code',
            'master_item_im.grouping',
            'master_item_im.brand',
            'master_item_im.warna',
            'master_item_im.type',
            'master_item_im.uom',
        ])
        ->andWhere(['and',['inbound_po_detail.id_inbound_po'=>$id],['like','inbound_po_detail.orafin_code',$orafinCode]]);
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	public function searchByAction($params, $idInboundPo)
    {
        $query = InboundPoDetail::find()->joinWith('itemIm')
               ->andFilterWhere(['id_inbound_po'=>$idInboundPo]);
                // ->joinWith('idOrafinRr',true,'FULL JOIN')
                // ->select([  'orafin_rr.id as id_orafin_rr',
							// 'orafin_rr.rr_number as rr_number',
                            // 'inbound_po.created_by',
                            // 'inbound_po.updated_by',
                            // 'inbound_po.created_date',
                            // 'inbound_po.updated_date',
                            // 'inbound_po.status_listing',
                            // ])
							

        // if($action == 'input') {
            // $query->andFilterWhere(['or',['=','inbound_po.status_listing', 1], ['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 6]])
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
        // }  else if ($action == 'approve') {
            // $query->andFilterWhere(['or',['=','inbound_po.status_listing', 4],['=','inbound_po.status_listing', 5]])
                // ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
        // }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	private function _search($params, $query) {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize']],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

       

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_inbound_po' => $this->id_inbound_po,
            'qty'=> $this->qty,
            'qty_good'=> $this->qty_good,
            'qty_not_good'=> $this->qty_not_good,
            'qty_reject'=> $this->qty_reject,
            'grouping'=> $this->grouping,
            
        ]);

        $query->andFilterWhere(['ilike', 'im_code', $this->im_code])
        ->andFilterWhere(['=', 'brand', $this->brand])
        ->andFilterWhere(['=', 'warna', $this->warna])
        ->andFilterWhere(['=', 'master_item_im.uom', $this->uom])
        // ->andFilterWhere(['ilike', 'master_item_im.grouping', $this->grouping])
        ->andFilterWhere(['=', 'type', $this->type]);



        return $dataProvider;
    }
}
