<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GrfDetail;

/**
 * SearchGrfDetail represents the model behind the search form about `common\models\GrfDetail`.
 */
class SearchGrfDetail extends GrfDetail
{
    /**
     * @inheritdoc
     */
    public $qty_good_rec, $sn_type, $description, $id_instruction_grf, $item_desc, $item_uom_code;
    public function rules()
    {
        return [
            [['id', 'id_grf', 'qty_request','qty_good','qty_not_good','qty_reject','qty_dismantle_good','qty_dismantle_ng','qty_revocation','qty_good_rec','qty_good_for_recond','id_instruction_grf'], 'integer'],
            [['orafin_code', 'name','grouping','brand','type','warna','sn_type','im_code', 'description','item_desc', 'item_uom_code'], 'safe'],
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
    public function search($params, $idGrf)
    {
        $query = GrfDetail::find()
        // ->joinWith('idGrf.idInGrf.idInstructionGrfDetail')
        ->joinWith('idGrf')
				->joinWith('idItemCode')
        ->select([
              'grf_detail.id as id',
              'grf_detail.orafin_code',
              'grf_detail.qty_request',
              // 'instruction_grf_detail.id',
              // 'instruction_grf_detail.qty_good',
              // 'instruction_grf_detail.qty_not_good',
              // 'instruction_grf_detail.qty_reject',
              // 'instruction_grf_detail.qty_dismantle_good',
              // 'instruction_grf_detail.qty_revocation',
              // 'instruction_grf_detail.qty_good_rec',
              'grf_detail.id_grf',
              // 'mkm_master_item.item_desc',
        ]);

        $query->andWhere(['grf_detail.id_grf' => $idGrf]);
		    // $query->leftJoin('mkm_master_item', 'mkm_master_item.item_code = grf_detail.orafin_code');
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
        }

    public function searchByGrfDetail($params, $idGrf)
    {
        $query = GrfDetail::find()
        ->joinWith('idGrf')
        ->joinWith('idItemCode')
        ->select([
              'grf_detail.id as id',
              'grf_detail.orafin_code',
              'grf_detail.qty_request',
              // 'master_item_im.name',
              // 'instruction_grf_detail.id',
              // 'instruction_grf_detail.qty_good',
              // 'instruction_grf_detail.qty_not_good',
              // 'instruction_grf_detail.qty_reject',
              // 'instruction_grf_detail.qty_dismantle',
              // 'instruction_grf_detail.qty_revocation',
              // 'instruction_grf_detail.qty_good_rec',
              // 'instruction_grf_detail.qty_good_for_recond',
              'grf_detail.id_grf',
              'mkm_master_item.item_desc',
        ]);

        $query->andWhere(['grf_detail.id_grf' => $idGrf]);
        // $query->leftJoin('mkm_master_item', 'mkm_master_item.item_code = grf_detail.orafin_code');
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

  
    
      public function _search($params, $query)
      {

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['master_item_im.name' => SORT_ASC],
            'desc' => ['master_item_im.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['grouping'] = [
            'asc' => ['master_item_im.grouping' => SORT_ASC],
            'desc' => ['master_item_im.grouping' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['sn_type'] = [
            'asc' => ['master_item_im.sn_type' => SORT_ASC],
            'desc' => ['master_item_im.sn_type' => SORT_DESC],
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
            'grf_detail.id_grf' => $this->id_grf,
            'grf_detail.qty_request' => $this->qty_request,
        ]);

        $query->andFilterWhere(['ilike', 'grf_detail.orafin_code', $this->orafin_code])
              ->andFilterWhere(['ilike', 'master_item_im.name', $this->name])
              ->andFilterWhere(['ilike', 'mkm_master_item.item_desc', $this->item_desc])
              ->andFilterWhere(['ilike', 'mkm_master_item.item_uom_code', $this->item_uom_code])
              ->andFilterWhere(['=', 'master_item_im.grouping', $this->grouping])
              ->andFilterWhere(['ilike', 'master_item_im.im_code', $this->im_code])
              
              ->andFilterWhere(['=', 'master_item_im.brand', $this->brand])
              ->andFilterWhere(['=', 'master_item_im.sn_type', $this->sn_type])
              ->andFilterWhere(['=', 'master_item_im.warna', $this->warna]);

        return $dataProvider;
      }
}
