<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundGrf;

/**
 * SearchInboundGrf represents the model behind the search form about `common\models\InboundGrf`.
 */
class SearchInboundGrf extends InboundGrf
{
    /**
     * @inheritdoc
     */
    public $grf_type, $grf_number, $wo_number, $file_attacment_1, $file_attacment_2, $purpose, $id_region, $id_division, $requestor, $pic;
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing','grf_type','pic', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date', 'note','grf_number','wo_number','id_division'], 'safe'],
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
    public function search($params, $id_modul, $action)
    {
        $query = InboundGrf::find();
        // $query->joinWith('idGrf.idDivision');
       $query->joinWith('idOutboundGrf.idInstructionGrf.idGrf.idGrfDetail', true, 'FULL JOIN');
        $query->select([
            'grf.grf_number',
            'grf.wo_number',
            'grf.grf_type',
            'grf.requestor',
            'grf.file_attachment_1',
            'grf.file_attachment_2',
            'grf.purpose',
            'grf.id_region',
            'grf.id_division',
            'grf.id_modul',
            'grf.id_warehouse',
            'grf.pic',
            'grf_detail.id',
            'grf_detail.qty_request',
            'grf_detail.status_return',
            'grf_detail.qty_return',
            'grf_detail.orafin_code',
            'instruction_grf.id as id_instruction_grf',
            'instruction_grf.incoming_date',
            'instruction_grf.note',
            'outbound_grf.status_listing',
            'outbound_grf.status_return',
            'outbound_grf.created_date',
            'outbound_grf.updated_date',
            // 'outbound_grf_detail.id_outbound_grf',
            // 'master_item_im.name',
            // 'master_item_im.im_code',
            // 'master_item_im.brand',
            // 'master_item_im.grouping',
            // 'master_item_im.type',
            // 'master_item_im.warna',
            // 'master_item_im.sn_type',
            // 'reference.description',
            // 'outbound_grf_detail.id_item_im',
            // 'master_item_im.name',
        ]);

        if($action == 'ikr'){
            $query  ->andFilterWhere(['outbound_grf.status_listing' => 25])
                    ->andFilterWhere(['grf.grf_type' => 20])
                    ->andFilterWhere(['outbound_grf.id_modul' => $id_modul])
                    ->andWhere(['inbound_grf.status_listing' => null])
                    ->orFilterWhere(['and',['inbound_grf.id_modul' => $id_modul],['not in', 'inbound_grf.status_listing', [5, 25, 22]]])
                    ;
        }if($action == 'regikr'){
            $query  ->andFilterWhere(['outbound_grf.status_listing' => 25])
                    ->andFilterWhere(['grf.grf_type' => 19])
                    ->andFilterWhere(['outbound_grf.id_modul' => $id_modul])
                    ->andWhere(['inbound_grf.status_listing' => null])
                    ->orFilterWhere(['and',['inbound_grf.id_modul' => $id_modul],['not in', 'inbound_grf.status_listing', [5, 25, 22]]])
                    ;
        }
        // add conditions that should always apply here

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
        }
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        // $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

    

         public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);
        
        // $dataProvider->sort->attributes['instruction_number'] = [
        //     'asc' => ['instruction_wh_transfer.instruction_number' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.instruction_number' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['delivery_target_date'] = [
        //     'asc' => ['instruction_wh_transfer.delivery_target_date' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.delivery_target_date' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['wh_destination'] = [
        //     'asc' => ['instruction_wh_transfer.wh_destination' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.wh_destination' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['wh_origin'] = [
        //     'asc' => ['instruction_wh_transfer.wh_origin' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.wh_origin' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->status_listing == 999) {
            $query->andFilterWhere(['grf.status_listing' => 5])
                ->andWhere(['inbound_grf.status_listing' => null]);
        }else {
            $query->andFilterWhere(['inbound_grf.status_listing' => $this->status_listing,]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'status_return' => $this->status_return,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

       $query->andFilterWhere(['ilike', 'grf.grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'grf.wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'grf.purpose', $this->purpose])
            ->andFilterWhere(['ilike', 'division.nama', $this->id_division]);

        return $dataProvider;
    }
}
