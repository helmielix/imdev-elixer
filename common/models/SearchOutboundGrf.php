<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundGrf;

/**
 * SearchOutboundGrf represents the model behind the search form about `common\models\OutboundGrf`.
 */
class SearchOutboundGrf extends OutboundGrf
{
    /**
     * @inheritdoc
     */
    public $name;
    public function rules()
    {
        return [
            [['id_instruction_grf', 'created_by', 'updated_by', 'status_listing', 'grf_type', 'id_division', 'id_region', 'pic', 'forwarder', 'id_modul', 'requestor', 'id_warehouse', 'status_return'], 'integer'],
            [['grf_number', 'wo_number', 'note', 'plate_number', 'driver', 'revision_remark', 'print_time', 'handover_time', 'surat_jalan_number', 'incoming_date', 'created_date', 'updated_date', 'file_attachment_1', 'file_attachment_2', 'purpose'], 'safe'],
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
    public function search($params,$id_modul, $action)
    {
        $query = OutboundGrf::find();
        $query->joinWith('idInstructionGrf.idGrf.idGrfDetail', true, 'FULL JOIN');
        $query->joinWith('outboundGrfDetails.idMasterItemImDetail.idMasterItemIm.referenceSn');
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
            'outbound_grf_detail.id_outbound_grf',
            'master_item_im.name',
            'master_item_im.im_code',
            'master_item_im.brand',
            'master_item_im.grouping',
            'master_item_im.type',
            'master_item_im.warna',
            'master_item_im.sn_type',
            'reference.description',
            'outbound_grf_detail.id_item_im',
            // 'master_item_im.name',
        ]);
        
        if($action == 'tagsn'){
            $query  ->andFilterWhere(['instruction_grf.status_listing' => 5])
                    ->andFilterWhere(['instruction_grf.id_modul' => $id_modul])
                    ->andWhere(['outbound_grf.status_listing' => null])
                    ->orFilterWhere(['and',['outbound_grf.id_modul' => $id_modul],['not in', 'outbound_grf.status_listing', [5, 25, 22]]]);
        }else if($action == 'printsj'){
            $query  ->andFilterWhere(['outbound_grf.status_listing' => [42, 2, 22, 25, 1]]);
            $query  ->andFilterWhere(['outbound_grf.id_modul' => $id_modul]);
        // add conditions that should always apply here
        }else if($action == 'grfmr'){
            $query  ->andFilterWhere(['outbound_grf.status_listing' => [25]]);

        // add conditions that should always apply here
        }else if($action == 'approve'){
            $query  ->andFilterWhere(['outbound_grf.status_listing' => [22, 25, 5]]);
        }
       
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
    
    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);
        
        $dataProvider->sort->attributes['grf'] = [
            'asc' => ['grf.grf_number' => SORT_ASC],
            'desc' => ['grf.grf_number' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->status_listing == 999) {
            $query->andFilterWhere(['instruction_grf.status_listing' => 5])
                ->andWhere(['outbound_grf.status_listing' => null]);
        }else {
            $query->andFilterWhere(['outbound_grf.status_listing' => $this->status_listing,]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_instruction_grf' => $this->id_instruction_grf,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'status_return' => $this->status_return,
            'grf_type' => $this->grf_type,
            'id_division' => $this->id_division,
            'id_region' => $this->id_region,
            'pic' => $this->pic,
            'forwarder' => $this->forwarder,
            'print_time' => $this->print_time,
            'handover_time' => $this->handover_time,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'requestor' => $this->requestor,
            'id_warehouse' => $this->id_warehouse,
        ]);

        $query->andFilterWhere(['like', 'grf.grf_number', $this->grf_number])
            ->andFilterWhere(['like', 'grf.wo_number', $this->wo_number])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'plate_number', $this->plate_number])
            ->andFilterWhere(['like', 'driver', $this->driver])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'surat_jalan_number', $this->surat_jalan_number])
            ->andFilterWhere(['like', 'file_attachment_1', $this->file_attachment_1])
            ->andFilterWhere(['like', 'file_attachment_2', $this->file_attachment_2])
            ->andFilterWhere(['like', 'purpose', $this->purpose]);

        return $dataProvider;
    }
}
