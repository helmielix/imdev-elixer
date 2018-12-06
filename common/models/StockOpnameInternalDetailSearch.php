<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\StockOpnameInternalDetail;

/**
 * StockOpnameInternalDetailSearch represents the model behind the search form of `divisitiga\models\StockOpnameInternalDetail`.
 */
class StockOpnameInternalDetailSearch extends StockOpnameInternalDetail {

    public $orafin_code;
    public $im_code;
    public $name;
    public $brand;
    public $grouping;
    public $sn_type;
    public $type;
    public $adj_good;
    public $adj_not_good;
    public $adj_reject;
    public $adj_dismantle_good;
    public $adj_dismantle_not_good;
    public $adj_dismantle_reject;
    public $summary;
    public $file;
    public $remarks;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'id_stock_opname_internal', 'id_item_im', 'f_good', 'f_not_good', 'f_reject', 'd_good', 'd_not_good', 'd_reject'], 'integer'],
            [['orafin_code','im_code','name','brand','grouping','sn_type','type','adj_good','adj_not_good','adj_reject','adj_dismantle_good','adj_dismantle_not_good','adj_dismantle_reject','summary','file','remarks'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params, $id = "") {
          $query = StockOpnameInternalDetail::find()->joinWith(['idItemIm','stockOpnameAdjustments'])->addSelect('stock_opname_internal_detail.*,adj_good,adj_not_good,adj_reject,adj_dismantle_good,adj_dismantle_not_good,adj_dismantle_reject,remarks,summary,file');
      
//        $query = StockOpnameInternalDetail::find()->joinWith(['idItemIm'])
//                ->leftJoin('publicstock_opname_adjustment', 'stock_opname_internal_detail.id = stock_opname_adjustment.id_stock_opname_internal_detail AND stock_opname_internal_detail.id_item_im=stock_opname_adjustment.id_master_item_im');
//
//        $query->select('stock_opname_internal_detail.*,adj_good,adj_not_good,adj_reject,adj_dismantle_good,adj_dismantle_not_good,adj_dismantle_reject,remarks,summary,file');
//                echo $query->createCommand()->getRawSql();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $parent = $this->id_stock_opname_internal;
        if ($id != "") {
            $parent = $id;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_stock_opname_internal' => $parent,
            'id_item_im' => $this->id_item_im,
            'f_good' => $this->f_good,
            'f_not_good' => $this->f_not_good,
            'f_reject' => $this->f_reject,
            'd_good' => $this->d_good,
            'd_not_good' => $this->d_not_good,
            'd_reject' => $this->d_reject,
            'master_item_im.orafin_code' => $this->orafin_code,
            'master_item_im.im_code' => $this->im_code,
            'master_item_im.name' => $this->name,
            'master_item_im.brand' => $this->brand,
            'master_item_im.grouping' => $this->grouping,
            'master_item_im.sn_type' => $this->sn_type,
            'master_item_im.type' => $this->type,
            'stock_opname_adjustment.adj_good' => $this->adj_good,
            'stock_opname_adjustment.adj_not_good' => $this->adj_not_good,
            'stock_opname_adjustment.adj_reject' => $this->adj_reject,
            'stock_opname_adjustment.adj_dismantle_good' => $this->adj_dismantle_good,
            'stock_opname_adjustment.adj_dismantle_not_good' => $this->adj_dismantle_not_good,
            'stock_opname_adjustment.adj_dismantle_reject' => $this->adj_dismantle_reject,
        ]);

        return $dataProvider;
    }

}
