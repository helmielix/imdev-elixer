<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundPo;
use common\models\OrafinRr;

/**
 * SearchInboundPo represents the model behind the search form about `inbound\models\InboundPo`.
 * ini perubahan baru testing baru sekali Ajah
 */
class SearchInboundPo extends InboundPo
{
    public $nama_warehouse;
    public function rules()
    {
        return [
            [['id',  'created_by', 'updated_by', 'status_listing', 'verified_by'], 'integer'],
            [['created_date', 'updated_date','pr_number','po_number','supplier','tgl_sj','rr_number', 'item_name','im_code','brand','warna','grouping','qty_rr','qty','qty_good','qty_not_good','qty_reject','orafin_name','orafin_code','sn_type','id_inbound', 'type','id_warehouse','uom'], 'safe'],
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
    
    public function searchByAction($params, $action, $param = NULL, $idWarehouse = NULL)
    {
        $query = InboundPo::find()
                // ->joinWith('idOrafinRr',true,'FULL JOIN')
                // ->select([  'orafin_rr.id as id_orafin_rr',
                            // 'orafin_rr.rr_number as rr_number',
                            // 'inbound_po.created_by',
                            // 'inbound_po.updated_by',
                            // 'inbound_po.created_date',
                            // 'inbound_po.updated_date',
                            // 'inbound_po.status_listing',
                            // ])
                            ;

        if($action == 'input') {
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 1],['=','inbound_po.status_listing', 7], ['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 3],['=','inbound_po.status_listing', 43]])
             ->leftJoin('warehouse', 'warehouse.id = inbound_po.id_warehouse')
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
            ;
            $dataProvider = $this->_search($params, $query);
        }else if($action == 'verify') {
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 1],['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 4]])
            ->leftJoin('warehouse', 'warehouse.id = inbound_po.id_warehouse')
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
            ;
            $dataProvider = $this->_search($params, $query);
        }else if($action == 'approve') {
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 5],['=','inbound_po.status_listing', 4],])
            ->andWhere(['in','inbound_po.id_warehouse',$idWarehouse])
            ->leftJoin('warehouse', 'warehouse.id = inbound_po.id_warehouse')
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
            ;
            $dataProvider = $this->_search($params, $query);
        }else if($action == 'overview') {
            $query->andFilterWhere(['!=','inbound_po.status_listing', 13])
            ->andWhere(['in','inbound_po.id_warehouse',$idWarehouse])
            ->leftJoin('warehouse', 'warehouse.id = inbound_po.id_warehouse')
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
            ;
            $dataProvider = $this->_search($params, $query);
        } else if ($action == 'tagsn') {
            $query->andFilterWhere(['in','inbound_po.status_listing' ,[5,35,42,48]])
                ->andWhere(['in','inbound_po.id_warehouse',$idWarehouse])
                ->leftJoin('warehouse', 'warehouse.id = inbound_po.id_warehouse')
                // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
                ;
                $dataProvider = $this->_search($params, $query);
        } else if ($action == 'detail_sn') {
            $query->joinWith('inboundPoDetails.itemIm')
                ->select([
                    'master_item_im.im_code as im_code',
                    'inbound_po_detail.qty',
                    'inbound_po_detail.qty_good',
                    'inbound_po_detail.qty_not_good',
                    'inbound_po_detail.qty_reject',
                    'inbound_po_detail.id as id_inbound_detail',
                    'inbound_po_detail.id_inbound_po as id_inbound_po',
                    'inbound_po_detail.status_listing as status_listing',
                    'master_item_im.name as item_name',
                    
                    'master_item_im.grouping',
                    'master_item_im.sn_type',
                    'master_item_im.brand',
                    'master_item_im.warna',
                    'master_item_im.type',
                    'master_item_im.uom',
                    
                ])
                ->andFilterWhere(['=','inbound_po_detail.id_inbound_po',$param])
                ->orderBy(['id_inbound_detail' => SORT_ASC]);
                $dataProvider = $this->_search($params, $query, $action);
        } else if ($action == 'detail') {
            $query->joinWith('inboundPoDetails.itemIm')
                // ->joinWith('inboundPoDetails.ItemIm')
                ->select([
                    
                    'master_item_im.orafin_code as orafin_code',
                    'inbound_po.id as id_inbound',
                    'master_item_im.name as orafin_name',
                    'master_item_im.orafin_code as orafin_code',
                    // 'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
                    'inbound_po.rr_number',
                    'master_item_im.grouping as grouping',
                    // 'master_item_im.uom',
                    'master_item_im.uom as uom',
                    // 'inbound_po_detail.id as id_inbound_po_detail',
                    'inbound_po_detail.qty_rr',

                ])
                
                ->andFilterWhere(['=','inbound_po.id',$param])
                ->groupBy(['inbound_po.id','inbound_po_detail.id_inbound_po','inbound_po_detail.orafin_code','master_item_im.name','master_item_im.orafin_code','inbound_po_detail.qty_rr','master_item_im.sn_type','inbound_po.rr_number','master_item_im.grouping','master_item_im.uom']);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize']],
                ]);

                $this->load($params);

                if (!$this->validate()) {
                    return $dataProvider;
                }

                $query->andFilterWhere([
                    'orafin_view_mkm_pr_to_pay.rcv_quantity_received' => $this->qty,
                    'inbound_po_detail.qty_rr' => $this->qty_rr,
                    'master_item_im.sn_type' => $this->sn_type,
                    'inbound_po.id' => $this->id_inbound,
                ]);
                // $query->andFilterWhere(['ilike', 'orafin_view_mkm_pr_to_pay.pr_item_description', $this->orafin_name])
                $query->andFilterWhere(['ilike', 'master_item_im.name', $this->orafin_name])
                // ->andFilterWhere(['ilike', 'orafin_view_mkm_pr_to_pay.pr_item_code', $this->orafin_code])
                ->andFilterWhere(['ilike', 'master_item_im.orafin_code', $this->orafin_code])
                ->andFilterWhere(['=', 'master_item_im.uom', $this->uom])
                ->andFilterWhere(['=', 'master_item_im.grouping', $this->grouping]);
                return $dataProvider;
        }else if ($action == 'indexdetail') {
            $query->joinWith('orafinPrToPay')
                // ->joinWith('inboundPoDetails.ItemIm')
                ->select([
                    // 'distinct(master_item_im.orafin_code) as orafin_code',
                    new \yii\db\Expression('distinct on (orafin_view_mkm_pr_to_pay.pr_item_code) orafin_view_mkm_pr_to_pay.pr_item_code'),
                    'inbound_po.id as id_inbound',
                    'orafin_view_mkm_pr_to_pay.pr_item_description as orafin_name',
                    'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
                    'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
                    'orafin_view_mkm_pr_to_pay.rcv_no as rr_number',
                    // 'orafin_view_mkm_pr_to_pay.grouping as grouping',
                    // 'orafin_view_mkm_pr_to_pay.id as id_item_im',
                    // 'inbound_po_detail.id as id_inbound_po_detail',

                ])
                // ->leftJoin('master_item_im', 'OrafinViewMkmPrToPay.id = master_item_im.uom ')
                ->leftJoin('master_item_im', 'master_item_im.orafin_code = orafin_view_mkm_pr_to_pay.pr_item_code')
                ->andFilterWhere(['=','inbound_po.id',$param]);
                // ->groupBy(['inbound_po.orafin_code']);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize']],
                ]);

                $this->load($params);

                if (!$this->validate()) {
                    return $dataProvider;
                }

                $query->andFilterWhere([
                    'orafin_view_mkm_pr_to_pay.rcv_quantity_received' => $this->qty,
                ]);
                $query->andFilterWhere(['ilike', 'orafin_view_mkm_pr_to_pay.pr_item_description', $this->orafin_name])
                ->andFilterWhere(['ilike', 'orafin_view_mkm_pr_to_pay.pr_item_code', $this->orafin_code])
                ->andFilterWhere(['=', 'master_item_im.grouping', $this->grouping])
                ->andFilterWhere(['=', 'master_item_im.uom', $this->uom])
                ->andFilterWhere(['=', 'sn_type', $this->sn_type]);
                return $dataProvider;
        }
        
            
        

        return $dataProvider;
    }
    
    private function _search($params, $query, $action = NULL) {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize']],
            // 'sort'=> [
            //         'attributes' => [
            //             'status_listing',
            //             'rr_number',
            //             'po_number',
            //             'pr_number',
            //             'tgl_sj',
            //             'supplier',
            //             'inbound_po.updated_date'  ,
            //         ],
            //         'defaultOrder' => ['updated_date'=>SORT_DESC]
            //     ],
        ]);

        if($action!='detail_sn'){
            $dataProvider->sort->defaultOrder['updated_date'] = SORT_DESC;
        }else{
            $dataProvider->sort->attributes = [
                // 'item_name',
            ];
        }
        
        // $dataProvider->sort->attributes['COLUMN'] = [
            // 'asc' => ['TABLE.COLUMN' => SORT_ASC],
            // 'desc' => ['TABLE.COLUMN' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'rr_number' => $this->rr_number,
            'created_by' => $this->created_by,
            'verified_by' => $this->verified_by,
            'approved_by' => $this->approved_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'date(tgl_sj)' => $this->tgl_sj,
            //'status_listing' => $this->status_listing,
        ]);
        
        if($action=='detail_sn'){
            $query->andFilterWhere([
                
                'inbound_po_detail.status_listing' => $this->status_listing,
                'qty'=> $this->qty,
                'qty_good'=> $this->qty_good,
                'qty_not_good'=> $this->qty_not_good,
                'qty_reject'=> $this->qty_reject,
            ]);
        }else{
            if($this->status_listing == 999){
                $query->andFilterWhere(['in','inbound_po.status_listing' ,[5]]);
            }else{
                $query->andFilterWhere([
                    'status_listing' => $this->status_listing,
                ]);
            }
        }

        
        $query->andFilterWhere(['ilike', 'rr_number', $this->rr_number])
            ->andFilterWhere(['ilike', 'po_number', $this->po_number])
            ->andFilterWhere(['ilike', 'nama_warehouse', $this->id_warehouse])
            ->andFilterWhere(['ilike', 'supplier', $this->supplier])
            ->andFilterWhere(['ilike', 'master_item_im.name', $this->item_name])
            ->andFilterWhere(['ilike', 'im_code', $this->im_code])
            ->andFilterWhere(['=', 'brand', $this->brand])
            ->andFilterWhere(['=', 'warna', $this->warna])
            ->andFilterWhere(['=', 'grouping', $this->grouping])
            ->andFilterWhere(['=', 'type', $this->type])
            ->andFilterWhere(['=', 'uom', $this->uom])
            
            ->andFilterWhere(['ilike', 'pr_number', $this->pr_number]);


        return $dataProvider;
    }
}
