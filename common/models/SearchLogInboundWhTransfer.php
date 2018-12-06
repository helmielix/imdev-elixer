<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundWhTransfer;

/**
 * SearchInboundWhTransfer represents the model behind the search form about `common\models\InboundWhTransfer`.
 */
class SearchLogInboundWhTransfer extends LogInboundWhTransfer
{
    public $instruction_number, $delivery_target_date, $wh_destination;
    public function rules()
    {
        return [
            [['idlog','id_outbound_wh', 'created_by', 'status_listing', 'updated_by',  'id_modul', 'wh_destination'], 'integer'],
            [['no_sj', 'plate_number','revision_remark', 'instruction_number', 'delivery_target_date', 'wh_origin'], 'safe'],
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

    
    public function search($params, $id_modul, $id = NULL){
        $query = LogInboundWhTransfer::find();
		
		// if($action == 'input'){
		// 	$query->joinWith('idOutboundWh.idInstructionWh.whOrigin', true, 'FULL JOIN');
		// 	$query->select([
		// 		'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
		// 		'outbound_wh_transfer.no_sj as no_sj',
		// 		'instruction_wh_transfer.wh_origin as wh_origin',
		// 		'inbound_wh_transfer.status_listing',
		// 		'inbound_wh_transfer.arrival_date',
		// 		'inbound_wh_transfer.created_date',
		// 		'inbound_wh_transfer.updated_date',
		// 	]);
		// 	$query	->andFilterWhere(['outbound_wh_transfer.status_listing' => 5])
		// 			->andFilterWhere(['outbound_wh_transfer.id_modul' => $id_modul])
		// 			->andWhere(['inbound_wh_transfer.status_listing' => null])
		// 			->orFilterWhere(['and',['inbound_wh_transfer.id_modul' => $id_modul],['not in', 'inbound_wh_transfer.status_listing', [5,42]]])
		// 			;
					
		// }if($action == 'detail'){
		// 	$query  ->joinWith('idOutboundWh.outboundWhTransferDetails.idMasterItemIm', true, 'FULL JOIN')
		// 			->select([
		// 				'outbound_wh_transfer_detail.id_item_im',
		// 				'outbound_wh_transfer_detail.req_good',
		// 				'master_item_im.name as item_name',
		// 				'master_item_im.im_code',
		// 				'master_item_im.brand',
		// 				'master_item_im.grouping',
		// 				'master_item_im.orafin_code',
						
		// 			])
		// 			->andWhere(['outbound_wh_transfer_detail.id_outbound_wh' => $id]);
		// }
		
		// else if ($action == 'tagsn') {
		// 	$query->joinWith('idOutboundWh.idInstructionWh', true, 'FULL JOIN');
		// 	$query->select([
		// 		'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
		// 		'outbound_wh_transfer.no_sj',
		// 		'instruction_wh_transfer.wh_origin',
		// 		'inbound_wh_transfer.status_listing',
		// 		'inbound_wh_transfer.created_date',
		// 		'inbound_wh_transfer.updated_date',
		// 	]);
  //           $query->andFilterWhere(['or',['=','inbound_wh_transfer.status_listing', 5],['=','inbound_wh_transfer.status_listing', 42]])
  //               ->orderBy(['inbound_wh_transfer.updated_date' => SORT_DESC]);
		// 		$dataProvider = $this->_search($params, $query);
  //       }
		// else if ($action == 'approve') {
		// 	$query->joinWith('idOutboundWh.idInstructionWh', true, 'FULL JOIN');
		// 	$query->select([
		// 		'outbound_wh_transfer.id_instruction_wh as id_outbound_wh',
		// 		'outbound_wh_transfer.no_sj',
		// 		'instruction_wh_transfer.wh_origin',
		// 		'inbound_wh_transfer.status_listing',
		// 		'inbound_wh_transfer.created_date',
		// 		'inbound_wh_transfer.updated_date',
		// 	]);
  //           $query->andFilterWhere(['or',['=','inbound_wh_transfer.status_listing', 5],['=','inbound_wh_transfer.status_listing', 1]])
  //               ->orderBy(['inbound_wh_transfer.updated_date' => SORT_DESC]);
		// 		$dataProvider = $this->_search($params, $query);
  //       } else if ($action == 'detail_sn') {
  //           $query->joinWith('inboundWhTransferDetails.idItemIm')
		// 		->select([
		// 			'master_item_im.im_code as im_code',
		// 			'inbound_wh_transfer_detail.qty',
		// 			// 'inbound_wh_transfer.id_outbound_wh',
		// 			'inbound_wh_transfer_detail.id as id_inbound_detail',
		// 			'inbound_wh_transfer_detail.id_inbound_wh as id_inbound_wh',
		// 			'inbound_wh_transfer_detail.status_listing as status_listing',
		// 			'master_item_im.name as item_name',
		// 			'master_item_im.grouping',
		// 			'master_item_im.sn_type',
					
		// 		])
		// 		->andFilterWhere(['=','inbound_wh_transfer_detail.id_inbound_wh',$id]);
		// 		$dataProvider = $this->_search($params, $query, $action);
  //       } 
		// else if($action == 'printsj'){
		// 	$query	->andFilterWhere(['outbound_wh_transfer.status_listing' => [ 1, 42 ]]);
		// 	$query	->andFilterWhere(['outbound_wh_transfer.id_modul' => $id_modul]);
		// }
		
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
		

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		// if ($this->status_listing == 999) {
            // $query->andFilterWhere(['instruction_wh_transfer.status_listing' => 5])
                // ->andWhere(['outbound_wh_transfer.status_listing' => null]);
        // }else {
            // $query->andFilterWhere(['outbound_wh_transfer.status_listing' => $this->status_listing,]);
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'driver' => $this->driver,
            // 'created_by' => $this->created_by,
            // 'updated_by' => $this->updated_by,
            // 'forwarder' => $this->forwarder,
            'date(arrival_date)' => $this->arrival_date,
            // 'date(updated_date)' => $this->updated_date,
            // 'id_modul' => $this->id_modul,
        ]);

        $query->andFilterWhere(['ilike', 'outbound_wh_transfer.no_sj', $this->no_sj])
            ->andFilterWhere(['ilike', 'warehouse.nama_warehouse', $this->wh_origin]);

        return $dataProvider;
    }
}
