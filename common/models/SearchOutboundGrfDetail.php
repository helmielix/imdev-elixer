<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundGrfDetail;

/**
 * SearchoutboundGrfDetail represents the model behind the search form about `common\models\outboundGrfDetail`.
 */
class SearchOutboundGrfDetail extends outboundGrfDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_grf', 'qty_good', 'qty_noot_good', 'qty_reject', 'qty_dismantle_good', 'status_item', 'qty_dismantle_ng', 'qty_good_rec', 'asset_barcode', 'qty_request', 'qty_return'], 'integer'],
            [['im_code', 'name', 'brand', 'type', 'warna','description', 'sn_type'],'safe'],
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
    public function search($params, $id)
    {
        $query = OutboundGrfDetail::find();
        $query->joinWith('idGrfDetail.idOrafinCode.referenceSn');
        // $query->joinWith('idOutboundGrf.idInstructionGrf.idInstructionGrfDetail');
         $query->select([ 
            'distinct(master_item_im.im_code)',
            'master_item_im.name',
            'master_item_im.brand',
            'master_item_im.type',
            'master_item_im.warna',
            'master_item_im.grouping',
            'reference.description',
            'grf_detail.qty_request',
            'grf_detail.id as id_grf_detail',
            'outbound_grf_detail.id_outbound_grf as id_instruction_grf',
            'outbound_grf_detail.status_listing',
            'outbound_grf_detail.id_outbound_grf',
            // 'outbound_grf_detail.id as id',
            'outbound_grf_detail.qty_good',
            'outbound_grf_detail.qty_noot_good',
            'outbound_grf_detail.qty_reject',
            'outbound_grf_detail.qty_dismantle_good',
            'outbound_grf_detail.qty_dismantle_ng',
            'outbound_grf_detail.qty_good_rec',

         ]);
         $query->andWhere(['id_outbound_grf' => $id]);

        // add conditions that should always apply here

        
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function _search($params, $query)
    {
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
        
        $dataProvider->sort->attributes['sn_type'] = [
            'asc' => ['master_item_im.sn_type' => SORT_ASC],
            'desc' => ['master_item_im.sn_type' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['master_item_im.name' => SORT_ASC],
            'desc' => ['master_item_im.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['brand'] = [
            'asc' => ['master_item_im.brand' => SORT_ASC],
            'desc' => ['master_item_im.brand' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_outbound_grf' => $this->id_outbound_grf,
            'qty_good' => $this->qty_good,
            'qty_noot_good' => $this->qty_noot_good,
            'qty_reject' => $this->qty_reject,
            'qty_dismantle_good' => $this->qty_dismantle_good,
            'status_item' => $this->status_item,
            'qty_dismantle_ng' => $this->qty_dismantle_ng,
            'qty_good_rec' => $this->qty_good_rec,
            'asset_barcode' => $this->asset_barcode,
            'instruction_grf_detail.qty_request' => $this->qty_request,
        ]);

        $query->andFilterWhere(['like', 'master_item_im.im_code', $this->im_code])
            ->andFilterWhere(['like', 'master_item_im.name', $this->name])
            ->andFilterWhere(['like', 'master_item_im.brand', $this->brand])
            ->andFilterWhere(['like', 'master_item_im.type', $this->type])
            ->andFilterWhere(['like', 'master_item_im.warna', $this->warna])
            ->andFilterWhere(['like', 'reference.description', $this->sn_type]);
           

        return $dataProvider;
    }
}
