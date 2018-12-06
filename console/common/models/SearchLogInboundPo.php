<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogInboundPo;
use common\models\OrafinRr;

/**
 * SearchInboundPo represents the model behind the search form about `inbound\models\InboundPo`.
 */
class SearchLogInboundPo extends LogInboundPo
{
	
    public function rules()
    {
        return [
            [['idlog','id',  'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_date', 'updated_date','pr_number','po_number','supplier','tgl_sj','rr_number'], 'safe'],
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
        $query = LogInboundPo::find()
         ->select([
                // 'log_busdev_pks.id_cdm_pnl',
                'log_inbound_po.idlog',
                'log_inbound_po.id',
                'log_inbound_po.created_by',
                'log_inbound_po.updated_by',
                'log_inbound_po.status_listing',
                'log_inbound_po.id_modul',
                'log_inbound_po.rr_number',
                'log_inbound_po.no_sj',
                'log_inbound_po.tgl_sj',
                'log_inbound_po.waranty',
                'log_inbound_po.po_number',                               
                'log_inbound_po.supplier',                               
                'log_inbound_po.pr_number',                               
                'log_inbound_po.revision_remark',                               
                'log_inbound_po.updated_date',                               
                'log_inbound_po.created_date',                               
        ]);


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
	
	public function searchByAction($params, $action, $param = NULL)
    {
        $query = LogInboundPo::find()
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
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 1],['=','inbound_po.status_listing', 7], ['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 3]])
            ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
			$dataProvider = $this->_search($params, $query);
        }if($action == 'approve') {
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 1],['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 5]])
            ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
			$dataProvider = $this->_search($params, $query);
        } else if ($action == 'tagsn') {
            $query->andFilterWhere(['or',['=','inbound_po.status_listing', 5],['=','inbound_po.status_listing', 42]])
                ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
				$dataProvider = $this->_search($params, $query);
        } else if ($action == 'detail_sn') {
            $query->joinWith('inboundPoDetails.itemIm')
				->select([
					'master_item_im.im_code as im_code',
					'log_inbound_po_detail.qty',
					'log_inbound_po_detail.id as id_inbound_detail',
					'log_inbound_po_detail.id_inbound_po as id_inbound_po',
					'log_inbound_po_detail.status_listing as status_listing',
					'master_item_im.name as item_name',
					'master_item_im.grouping',
                    'master_item_im.sn_type',
                    'master_item_im.brand',
					'master_item_im.warna',
					
				])
				->andFilterWhere(['=','log_inbound_po_detail.idlog_inbound_po',$param])
                ->orderBy(['id_inbound_detail' => SORT_ASC]);
				$dataProvider = $this->_search($params, $query, $action);
        } else if ($action == 'detail') {
            $query->joinWith('orafinPrToPay')
				// ->joinWith('inboundPoDetails')
				->select([
					'inbound_po.id as id_inbound',
					'orafin_view_mkm_pr_to_pay.pr_item_code as orafin_code',
					'orafin_view_mkm_pr_to_pay.pr_item_description as orafin_name',
					'orafin_view_mkm_pr_to_pay.rcv_quantity_received as qty',
					'inbound_po.rr_number',
					// 'inbound_po_detail.id as id_detail'
				])
				->andFilterWhere(['=','inbound_po.id',$param]);
                // ->orderBy(['inbound_po.id' => SORT_ASC]);
				$dataProvider = $this->_search($params, $query);
        }
		
			
        

        return $dataProvider;
    }
	
	private function _search($params, $query, $action = NULL) {

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

        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'rr_number' => $this->rr_number,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
			'date(tgl_sj)' => $this->tgl_sj,
			//'status_listing' => $this->status_listing,
        ]);
		
		if($action=='detail_sn'){
			$query->andFilterWhere([
				
				'inbound_po_detail.status_listing' => $this->status_listing,
			]);
		}else{
			$query->andFilterWhere([
				'status_listing' => $this->status_listing,
			]);
		}

		
        $query->andFilterWhere(['ilike', 'rr_number', $this->rr_number])
            ->andFilterWhere(['ilike', 'po_number', $this->po_number])
            ->andFilterWhere(['ilike', 'supplier', $this->supplier])
            ->andFilterWhere(['ilike', 'pr_number', $this->pr_number]);


        return $dataProvider;
    }
}
