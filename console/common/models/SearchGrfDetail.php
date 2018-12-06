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
    public $qty_good_rec, $sn_type, $description, $id_instruction_grf;
    public function rules()
    {
        return [
            [['id', 'id_grf', 'qty_request','qty_good','qty_noot_good','qty_reject','qty_dismantle_good','qty_dismantle_ng','qty_good_rec','id_instruction_grf'], 'integer'],
            [['orafin_code', 'name','grouping','brand','type','warna','sn_type','im_code', 'description'], 'safe'],
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
        ->joinWith('idGrf.idInGrf.idInstructionGrfDetail')
				// ->joinWith('idOrafinCode.referenceSn')
        ->select([
              // 'master_item_im.name',
              // 'master_item_im.brand',
              // 'master_item_im.im_code',
              // 'master_item_im.warna',
              // 'master_item_im.type',
              // // 'master_item_im.orafin_code',
              // 'master_item_im.grouping',
              // 'master_item_im.sn_type',
              // // 'grf_detail.qty_request',  
              // 'reference.description',
              'grf_detail.id as id',
              'grf_detail.orafin_code',
              'grf_detail.qty_request',
              'instruction_grf_detail.id',
              'instruction_grf_detail.qty_good',
              'instruction_grf_detail.qty_noot_good',
              'instruction_grf_detail.qty_reject',
              'instruction_grf_detail.qty_dismantle_good',
              'instruction_grf_detail.qty_dismantle_ng',
              'instruction_grf_detail.qty_good_rec',
              'grf_detail.id_grf',
        ]);

        $query->andWhere(['grf_detail.id_grf' => $idGrf]);
		
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
            'qty_request' => $this->qty_request,
        ]);

        $query->andFilterWhere(['like', 'orafin_code', $this->orafin_code])
              ->andFilterWhere(['ilike', 'master_item_im.name', $this->name])
              ->andFilterWhere(['ilike', 'grouping', $this->grouping])
              ->andFilterWhere(['ilike', 'master_item_im.im_code', $this->im_code])
              // ->andFilterWhere(['ilike', 'master_item_im.name', $this->name])
              ->andFilterWhere(['ilike', 'master_item_im.brand', $this->brand])
              ->andFilterWhere(['ilike', 'master_item_im.warna', $this->warna]);

        return $dataProvider;
    }
}
