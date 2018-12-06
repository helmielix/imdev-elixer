<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundWhTransfer;

/**
 * SearchInboundWhTransfer represents the model behind the search form about `common\models\InboundWhTransfer`.
 */
class SearchInboundWhTransfer extends InboundWhTransfer
{
    public $instruction_number, $delivery_target_date, $wh_destination, $delta, $status_report, $id_inbound_detail;
    public function rules()
    {
        return [
            [['id_outbound_wh', 'created_by', 'status_listing', 'updated_by',  'id_modul', 'wh_destination', 'sn_type', 'qty_detail', 'delta', 'req_qty', 'status_tagsn', 'qty_good', 'qty_not_good', 'qty_reject', 'qty_good_dismantle', 'qty_not_good_dismantle', 'status_retagsn', 'status_report', 'id_inbound_detail'], 'integer'],
            [['no_sj', 'plate_number','revision_remark', 'instruction_number', 'delivery_target_date', 'wh_origin',
			'item_name', 'im_code', 'brand', 'arrival_date'], 'safe'],
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


    public function search($params, $id_modul, $action, $id = NULL, $id_warehouse = NULL){
        $query = InboundWhTransfer::find();

		if($action == 'input'){
			// #
			$query->joinWith('idOutboundWh.idInstructionWh.whOrigin', true, 'FULL JOIN');
			$query->select([
				'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
				'outbound_wh_transfer.no_sj as no_sj',
				'instruction_wh_transfer.wh_origin as wh_origin',
				'inbound_wh_transfer.status_listing',
				'inbound_wh_transfer.arrival_date',
				'inbound_wh_transfer.created_date',
				'inbound_wh_transfer.updated_date',
			]);
			$query	->andFilterWhere(['outbound_wh_transfer.status_listing' => 25])
					->andFilterWhere(['outbound_wh_transfer.id_modul' => $id_modul])
					->andWhere(['inbound_wh_transfer.status_listing' => null])
					->orFilterWhere(['and',['inbound_wh_transfer.id_modul' => $id_modul],['not in', 'inbound_wh_transfer.status_listing', [5,42]]])
					->andWhere(['instruction_wh_transfer.wh_destination' => $id_warehouse])
					;

		}else if($action == 'detail'){
			// #
			$query  ->joinWith('idOutboundWh.outboundWhTransferDetails.idMasterItemIm', true, 'FULL JOIN')
					->select([
						'outbound_wh_transfer_detail.id_item_im',
						'outbound_wh_transfer_detail.req_good',
						'master_item_im.name as item_name',
						'master_item_im.im_code',
						'master_item_im.brand',
						'master_item_im.grouping',
						'master_item_im.orafin_code',

					])
					->andWhere(['outbound_wh_transfer_detail.id_outbound_wh' => $id]);
		}else if ($action == 'viewinbounddetail'){
			// #
			// $query	->joinWith('inboundWhTransferDetails.idItemIm.idMasterItemIm')
			$query	->joinWith('inboundWhTransferDetails.idItemIm.referenceBrand')
					// ->joinWith('inboundWhTransferDetails.idOutboundWhDetail')
					->joinWith('inboundWhTransferDetails')
					->leftJoin('outbound_wh_transfer_detail', 'outbound_wh_transfer_detail.id_item_im = inbound_wh_transfer_detail.id_item_im and outbound_wh_transfer_detail.id_outbound_wh = inbound_wh_transfer_detail.id_inbound_wh')
					;
			$query->select([
				'master_item_im.name as item_name',
				'master_item_im.im_code',
				'reference.description as brand',
				'master_item_im.sn_type',
				'inbound_wh_transfer_detail.id as id_detail',
				'inbound_wh_transfer_detail.id_item_im',
				'inbound_wh_transfer_detail.qty as qty_detail',
				'inbound_wh_transfer_detail.status_listing',
				// 'inbound_wh_transfer_detail.id_outbound_wh_detail',
				'outbound_wh_transfer_detail.id as id_outbound_wh_detail',
				new \yii\db\Expression('req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle as req_qty'),
			]);

			$query->andFilterWhere(['outbound_wh_transfer_detail.id_outbound_wh' => $id]);

		} else if ($action == 'tagsn') {
			// #
			$query->joinWith('idOutboundWh.idInstructionWh.whOrigin', true, 'FULL JOIN');
			$query->select([
				'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
				'outbound_wh_transfer.no_sj',
				'instruction_wh_transfer.wh_origin',
				'inbound_wh_transfer.status_listing',
				'inbound_wh_transfer.arrival_date',
				'inbound_wh_transfer.status_tagsn',
				'inbound_wh_transfer.created_date',
				'inbound_wh_transfer.updated_date',
			]);
            $query->andFilterWhere(['inbound_wh_transfer.status_listing' => [1, 41, 5  ] ])
					->andFilterWhere(['inbound_wh_transfer.status_tagsn' => [999, 41, 1, 43] ])
					->andWhere(['instruction_wh_transfer.wh_destination' => $id_warehouse ])
                // ->orderBy(['inbound_wh_transfer.updated_date' => SORT_DESC])
				;
				$dataProvider = $this->_search($params, $query);
		} else if ($action == 'tagsnapprove') {
			// #
			$query->joinWith('idOutboundWh.idInstructionWh');
			$query->select([
				'outbound_wh_transfer.no_sj',
				'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
				'instruction_wh_transfer.wh_origin',
				'inbound_wh_transfer.status_listing',
				'inbound_wh_transfer.status_tagsn',
				'inbound_wh_transfer.status_retagsn',
				'inbound_wh_transfer.created_date',
				'inbound_wh_transfer.updated_date',
			]);
            $query->andFilterWhere(['inbound_wh_transfer.status_retagsn' => [46, 5] ])
				  ->andWhere(['instruction_wh_transfer.wh_destination' => $id_warehouse ])
				;
        }
		else if ($action == 'approve') {
			// #
			$query->joinWith('idOutboundWh.idInstructionWh.whOrigin');
			$query->joinWith('inboundWhTransferDetails');
			$query->select([
					'inbound_wh_transfer_detail.status_report',
					'inbound_wh_transfer.id_outbound_wh',
					'outbound_wh_transfer.no_sj',
					'inbound_wh_transfer.arrival_date',
					'instruction_wh_transfer.wh_origin',

				]);
			$query->andFilterWhere(['inbound_wh_transfer_detail.status_report' => [4, 5] ]);
			$query->andFilterWhere(['inbound_wh_transfer.id_modul' => $id_modul]);
			$query->andFilterWhere(['instruction_wh_transfer.wh_destination' => $id_warehouse]);
			$query->groupBy('inbound_wh_transfer.id_outbound_wh, outbound_wh_transfer.no_sj, instruction_wh_transfer.wh_origin, inbound_wh_transfer_detail.status_report');


			// $query->joinWith('idOutboundWh.idInstructionWh', true, 'FULL JOIN');
			// $query->select([
				// 'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
				// 'outbound_wh_transfer.no_sj',
				// 'instruction_wh_transfer.wh_origin',
				// 'inbound_wh_transfer.status_listing',
				// 'inbound_wh_transfer.created_date',
				// 'inbound_wh_transfer.updated_date',
			// ]);
            // $query->andFilterWhere(['or',['=','inbound_wh_transfer.status_listing', 5],['=','inbound_wh_transfer.status_listing', 1]])
                // ->orderBy(['inbound_wh_transfer.updated_date' => SORT_DESC]);
				// $dataProvider = $this->_search($params, $query);

        } else if ($action == 'detail_sn') {
			// #
            // $query->joinWith('inboundWhTransferDetails.idItemIm.idMasterItemIm')
            $query->joinWith('inboundWhTransferDetails.idItemIm.referenceBrand')
				->select([
					'inbound_wh_transfer_detail.qty as qty_detail',
					'inbound_wh_transfer_detail.id as id_inbound_detail',
					'inbound_wh_transfer_detail.id_inbound_wh as id_inbound_wh',
					'inbound_wh_transfer_detail.status_listing as status_listing',
					'inbound_wh_transfer_detail.status_tagsn as status_tagsn',
					'inbound_wh_transfer_detail.qty_good',
					'inbound_wh_transfer_detail.qty_not_good',
					'inbound_wh_transfer_detail.qty_reject',
					'inbound_wh_transfer_detail.qty_good_dismantle',
					'inbound_wh_transfer_detail.qty_not_good_dismantle',
					'master_item_im.name as item_name',
					'master_item_im.im_code',
					// 'master_item_im.brand',
					'reference.description as brand',
					'master_item_im.sn_type',

					new \yii\db\Expression("case when (select count(*) from inbound_wh_transfer_detail_sn where inbound_wh_transfer_detail_sn.id_inbound_wh_detail = inbound_wh_transfer_detail.id and status_retagsn is not null) > 0 then 'Need Approval' else '' end as status_sn_need_approve"),

				])
				->andFilterWhere(['=','inbound_wh_transfer_detail.id_inbound_wh',$id]);
				$dataProvider = $this->_search($params, $query, $action);
        }
		else if($action == 'verify'){
			// #
			$query->joinWith('idOutboundWh.idInstructionWh.whOrigin');
			$query->joinWith('inboundWhTransferDetails');
			$query->select([
					'inbound_wh_transfer_detail.status_report',
					'inbound_wh_transfer.id_outbound_wh',
					'outbound_wh_transfer.no_sj',
					'inbound_wh_transfer.arrival_date',
					'instruction_wh_transfer.wh_origin',

				]);
			$query->andFilterWhere(['inbound_wh_transfer_detail.status_report' => [31,4] ]);
			$query->andFilterWhere(['inbound_wh_transfer.id_modul' => $id_modul]);
			$query->andWhere(['instruction_wh_transfer.wh_destination' => $id_warehouse]);
			$query->groupBy('inbound_wh_transfer.id_outbound_wh, outbound_wh_transfer.no_sj, instruction_wh_transfer.wh_origin, inbound_wh_transfer_detail.status_report');

		}
		else if($action == 'verifydetail'){
			// #
			$query->joinWith('idOutboundWh.idInstructionWh');
			// $query->joinWith('inboundWhTransferDetails.idItemIm.idMasterItemIm')
			$query->joinWith('inboundWhTransferDetails.idItemIm')
				// ->leftJoin('outbound_wh_transfer_detail', 'outbound_wh_transfer_detail.id = inbound_wh_transfer_detail.id_outbound_wh_detail');
				->leftJoin('outbound_wh_transfer_detail', 'outbound_wh_transfer_detail.id_outbound_wh = inbound_wh_transfer_detail.id_inbound_wh and outbound_wh_transfer_detail.id_item_im = inbound_wh_transfer_detail.id_item_im');
			$query->select([
					'master_item_im.name as item_name',
					'master_item_im.im_code',
					'master_item_im.brand',
					'master_item_im.sn_type',
					'inbound_wh_transfer_detail.qty as qty_detail',
					'inbound_wh_transfer_detail.status_report',
					'inbound_wh_transfer_detail.id as id_inbound_detail',
					// 'inbound_wh_transfer_detail.id_outbound_wh_detail',
					'outbound_wh_transfer_detail.id as id_outbound_wh_detail',
					'inbound_wh_transfer_detail.id_inbound_wh',
					new \yii\db\Expression("req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle as req_qty"),
					new \yii\db\Expression("(req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle) - inbound_wh_transfer_detail.qty as delta"),

				]);
			$query->andFilterWhere(['not in','inbound_wh_transfer_detail.status_report', [999, 36] ]);
			$query->andFilterWhere(['inbound_wh_transfer.id_modul' => $id_modul]);
			$query->andFilterWhere(['inbound_wh_transfer.id_outbound_wh' => $id]);
			$query->andWhere(['instruction_wh_transfer.wh_destination' => $id_warehouse]);


		}

		// $query	->andFilterWhere(['inbound_wh_transfer.id_modul' => $id_modul]);

		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
			// 'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);

		$dataProvider->sort->attributes['no_sj'] = [
            'asc' => ['outbound_wh_transfer.no_sj' => SORT_ASC],
            'desc' => ['outbound_wh_transfer.no_sj' => SORT_DESC],
        ];

		$dataProvider->sort->attributes['wh_origin'] = [
            'asc' => ['instruction_wh_transfer.wh_origin' => SORT_ASC],
            'desc' => ['instruction_wh_transfer.wh_origin' => SORT_DESC],
        ];

		$dataProvider->sort->attributes['item_name'] = [
            'asc' => ['master_item_im.name' => SORT_ASC],
            'desc' => ['master_item_im.name' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['im_code'] = [
            'asc' => ['master_item_im.im_code' => SORT_ASC],
            'desc' => ['master_item_im.im_code' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['brand'] = [
            'asc' => ['master_item_im.brand' => SORT_ASC],
            'desc' => ['master_item_im.brand' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['sn_type'] = [
            'asc' => ['master_item_im.sn_type' => SORT_ASC],
            'desc' => ['master_item_im.sn_type' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['req_qty'] = [
            'asc' => ['(req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle)' => SORT_ASC],
            'desc' => ['(req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle)' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['qty_detail'] = [
            'asc' => ['inbound_wh_transfer_detail.qty' => SORT_ASC],
            'desc' => ['inbound_wh_transfer_detail.qty' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['qty_good'] = [
            'asc' => ['inbound_wh_transfer_detail.qty_good' => SORT_ASC],
            'desc' => ['inbound_wh_transfer_detail.qty_good' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['qty_not_good'] = [
            'asc' => ['inbound_wh_transfer_detail.qty_not_good' => SORT_ASC],
            'desc' => ['inbound_wh_transfer_detail.qty_not_good' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['qty_reject'] = [
            'asc' => ['inbound_wh_transfer_detail.qty_reject' => SORT_ASC],
            'desc' => ['inbound_wh_transfer_detail.qty_reject' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['qty_good_dismantle'] = [
            'asc' => ['inbound_wh_transfer_detail.qty_good_dismantle' => SORT_ASC],
            'desc' => ['inbound_wh_transfer_detail.qty_good_dismantle' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['qty_not_good_dismantle'] = [
            'asc' => ['inbound_wh_transfer_detail.qty_not_good_dismantle' => SORT_ASC],
            'desc' => ['inbound_wh_transfer_detail.qty_not_good_dismantle' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['delta'] = [
            'asc' => ['((req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle) - inbound_wh_transfer_detail.qty)' => SORT_ASC],
            'desc' => ['((req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle) - inbound_wh_transfer_detail.qty)' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['status_sn_need_approve'] = [
            'asc' => ['status_sn_need_approve' => SORT_DESC],
            'desc' => ['status_sn_need_approve' => SORT_ASC],
        ];

		$dataProvider->sort->attributes['status_report'] = [
            'asc' => ['inbound_wh_transfer_detail.status_report' => SORT_DESC],
            'desc' => ['inbound_wh_transfer_detail.status_report' => SORT_ASC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		if ( is_numeric($this->delta) ){
			$query->andFilterWhere(['((req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle) - inbound_wh_transfer_detail.qty)' => $this->delta]);
		}

		if ( isset($this->delta) ) {
            $query->andFilterWhere(['inbound_wh_transfer_detail.status_listing' => $this->status_listing]);
        }else {
            if ( $this->status_listing == 999 ){
                $query	->andFilterWhere(['outbound_wh_transfer.status_listing' => 25])
    					->andWhere(['inbound_wh_transfer.status_listing' => null]);
            }else{
                $query->andFilterWhere(['inbound_wh_transfer.status_listing' => $this->status_listing,]);
            }
        }

		if ( isset($this->im_code) ){
			$query->andFilterWhere(['inbound_wh_transfer_detail.status_tagsn' => $this->status_tagsn]);
		}else{
			$query->andFilterWhere(['inbound_wh_transfer.status_tagsn' => $this->status_tagsn,]);
		}

        // grid filtering conditions
        $query->andFilterWhere([
            // 'driver' => $this->driver,
            // 'created_by' => $this->created_by,
            // 'updated_by' => $this->updated_by,
            // 'forwarder' => $this->forwarder,
            'date(inbound_wh_transfer.arrival_date)' => $this->arrival_date,
            'warehouse.id' => $this->wh_origin,
            'status_retagsn' => $this->status_retagsn,
            'inbound_wh_transfer_detail.status_report' => $this->status_report,
            'master_item_im.sn_type' => $this->sn_type,
            '(req_good + req_not_good + req_reject + req_good_dismantle + req_not_good_dismantle)' => $this->req_qty,
            'inbound_wh_transfer_detail.qty' => $this->qty_detail,
            // 'date(updated_date)' => $this->updated_date,
            // 'id_modul' => $this->id_modul,
			'qty_good' => $this->qty_good,
			'qty_not_good' => $this->qty_not_good,
			'qty_reject' => $this->qty_reject,
			'qty_good_dismantle' => $this->qty_good_dismantle,
			'qty_not_good_dismantle' => $this->qty_not_good_dismantle,
        ]);

        $query->andFilterWhere(['ilike', 'outbound_wh_transfer.no_sj', $this->no_sj])
            // ->andFilterWhere(['ilike', 'warehouse.nama_warehouse', $this->wh_origin])
            ->andFilterWhere(['ilike', 'master_item_im.name', $this->item_name])
            ->andFilterWhere(['ilike', 'master_item_im.im_code', $this->im_code])
            ->andFilterWhere(['ilike', 'reference.description', $this->brand])
			;

        return $dataProvider;
    }
}
