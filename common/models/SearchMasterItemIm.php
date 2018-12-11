<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MasterItemIm;

/**
 * SearchMasterItemIm represents the model behind the search form about `common\models\MasterItemIm`.
 */
class SearchMasterItemIm extends MasterItemIm
{
    public $qty_request, $qty_good, $qty_noot_good, $qty_reject, $qty_dismantle_good, $qty_dismantle_ng, $qty_good_rec, $asset_barcode;
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status', 'type', 'qty_request', 'qty_good', 'qty_noot_good', 'qty_reject','qty_dismantle_good','qty_good_rec','asset_barcode'], 'integer'],
            [['sn_type','name', 'brand', 'created_date', 'updated_date', 'im_code', 'orafin_code', 'grouping', 'warna', 'orafin_code', 'name'], 'safe'],
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
        $query = MasterItemIm::find();

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	public function searchById($params, $id)
    {
        $query = MasterItemIm::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
        ]);
		
		$this->load($params);

        return $dataProvider;
    }
	
	public function searchByOrafinCode($params, $orafinCode, $idWarehouse)
    {
        $query = MasterItemIm::find()
        ->select([
            'master_item_im.im_code',
            'master_item_im.id',
            'master_item_im.grouping as grouping',
            'master_item_im.brand as brand',
            'master_item_im.warna as warna',
            'master_item_im.type as type',
            // 'master_item_im.req_good_qty as req_good_qty',

        ])
        ->where(['master_item_im.orafin_code'=>$orafinCode]);
        
		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function searchByItemDetail($params)
    {
        $query = MasterItemImDetail::find()->joinWith('idMasterItemIm')
        ->select([
            'master_item_im.im_code',
            'master_item_im.id as id_master_item_im',
            'master_item_im.grouping as grouping',
            'master_item_im.brand as brand',
            'master_item_im.warna as warna',
            'master_item_im.type as type',

            // 'master_item_im.req_good_qty as req_good_qty',

        ]);
        
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

     public function searchByAction($params, $orafinCode)
    {
        $query = GrfDetail::find()->joinWith('idOrafinCode.referenceSn')
        ->joinWith('idGrf.idInGrf.idInstructionGrfDetail')
        ->select([
            'master_item_im.im_code',
            'master_item_im.id',
            'master_item_im.grouping as grouping',
            'master_item_im.brand as brand',
            'master_item_im.warna as warna',
            'master_item_im.type as type',
            'master_item_im.name as name',
            'master_item_im.sn_type as sn_type',
            'reference.description as description',
            'grf_detail.qty_request',
            'instruction_grf_detail.qty_good',
            'instruction_grf_detail.qty_noot_good',
            'instruction_grf_detail.qty_reject',
            'instruction_grf_detail.qty_dismantle_good',
            'instruction_grf_detail.qty_dismantle_ng',
            'instruction_grf_detail.qty_good_rec',
            // 'master_item_im.type as type',
            // 'master_item_im.req_good_qty as req_good_qty',

        ])
        ->andWhere(['master_item_im.orafin_code'=>$orafinCode]);
        
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	public function searchByCreateDetailItem($params, $idwarehouse, $idMasterItemIm = null)
    {		
		$query = MasterItemIm::find()->joinWith('masterItemImDetails');
		$query->joinWith(['referenceWarna refwarna', 'referenceBrand refbrand', 'referenceType reftype', 'referenceGrouping refgrouping']);
		$query->select([
			'master_item_im_detail.id',
			'im_code',
			'name',
			'brand',
			'type',
			'warna',
			'sn_type',
			'master_item_im_detail.s_good',
			'master_item_im_detail.s_not_good',
			'master_item_im_detail.s_reject',
			'master_item_im_detail.s_good_dismantle',
            'master_item_im_detail.s_not_good_dismantle',
            // 'master_item_im_detail.s_good_for_recond',
			'master_item_im_detail.s_good_rec',
		]);
		
		if ($idMasterItemIm != null){
			$query->andWhere(['in' , 'master_item_im_detail.id', $idMasterItemIm]);
		}
		
		$query->andWhere(['master_item_im_detail.id_warehouse' => $idwarehouse]);
        
		// $dataProvider = $this->_search($params, $query);

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'master_item_im.sn_type' => $this->sn_type,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])            
            ->andFilterWhere(['ilike', 'im_code', $this->im_code])                                
            ->andFilterWhere(['ilike', 'referenceGrouping', $this->grouping])
           ->andFilterWhere(['=', 'brand', $this->brand])
            ->andFilterWhere(['=', 'warna', $this->warna])
            ->andFilterWhere(['ilike', 'grf_detail.qty_request', $this->qty_request])
            ->andFilterWhere(['ilike', 'inbound_grf_detail.qty_good', $this->qty_good]);            

        return $dataProvider;

        // return $dataProvider;
	}

    public function searchMasterOrafin($params, $orafinCode = null){
        
        $query = MasterItemIm::find()->select('distinct(orafin_code), name');
        
        if ($orafinCode != null){
            $query->andWhere(['not in' , 'orafin_code', $orafinCode]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort'=>false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'created_by' => $this->created_by,
        //     'updated_by' => $this->updated_by,
        //     'status' => $this->status,
        //     'created_date' => $this->created_date,
        //     'updated_date' => $this->updated_date,
        //     'sn_type' => $this->sn_type,
        // ]);

        $query->andFilterWhere(['ilike', 'orafin_code', $this->orafin_code])
            ->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
	
	public function _search($params, $query){
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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            // ->andFilterWhere(['ilike', 'refbrand.description', $this->brand])
            ->andFilterWhere(['ilike', 'im_code', $this->im_code])
            ->andFilterWhere(['ilike', 'orafin_code', $this->orafin_code])
            ->andFilterWhere(['=', 'grouping', $this->grouping])
            ->andFilterWhere(['=', 'brand', $this->brand])
            ->andFilterWhere(['=', 'warna', $this->warna])
            // ->andFilterWhere(['=', 'sn_type', $this->sn_type])
            ->andFilterWhere(['=', 'type', $this->type])
            // ->andFilterWhere(['ilike', 'refwarna.description', $this->warna])
            ->andFilterWhere(['ilike', 'grf_detail.qty_request', $this->qty_request])
            ->andFilterWhere(['ilike', 'inbound_grf_detail.qty_good', $this->qty_good]);
            // ->andFilterWhere(['ilike', 'grf_detail.qty_request', $this->qty_request]);
            // ->andFilterWhere(['ilike', 'grf_detail.qty_request', $this->qty_request]);

        return $dataProvider;
	}
}
