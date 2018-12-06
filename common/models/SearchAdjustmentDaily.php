<?php

namespace common\models;

// MASIH HARUS DIEDIT!!!
// SORT MUNGKIN MASIH BERMASALAH!!!

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchAdjusmentDaily represents the model behind the search form about `common\models\AdjustmentDaily`.
 */
class SearchAdjustmentDaily extends AdjustmentDaily
{
    //public $instruction_number, $target_pengiriman, $vendor_repair;
    public function rules()
    {
        return [
            [['status_listing'/*'id_instruction_repair', 'driver', 'created_by', 'updated_by', 'forwarder', 'id_modul', 'wh_destination', 'wh_origin'*/], 'integer'],
            [['no_sj', 'no_adj', 'plate_number', 'created_date', 'updated_date', 'revision_remark', 'instruction_number', 'target_pengiriman', 'vendor_repair'], 'safe'],
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


    public function search($params, $id_modul,$action){
        $query = SearchAdjustmentDaily::find();

        if ($action=="adjust") $query->andFilterWhere(['status_listing' => [1,48]]);
        else $query->andFilterWhere(['status_listing' => [1]]);

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['status_listing' => $this->status_listing]);
        $query->andFilterWhere(['ilike', 'no_adj', $this->no_adj])
            ->andFilterWhere(['ilike', 'no_sj', $this->no_sj]);

        // echo $query->createCommand()->getRawSql();
        /*->joinWith(['instructionRepair', 'instructionRepair.idVendor'], true, 'INNER JOIN');
        $query->select([
            'instruction_repair.instruction_number',
            'instruction_repair.vendor_repair',
            'instruction_repair.id as id_instruction_repair',
            'inbound_repair.status_listing',
            'inbound_repair.no_sj',
            'inbound_repair.tanggal_datang',
            'vendor.name',
        ]);*/

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['no_adj'] = [
            'asc' => ['adjustment_daily.no_adj' => SORT_ASC],
            'desc' => ['adjustment_daily.no_adj' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['no_sj'] = [
            'asc' => ['adjustment_daily.no_sj' => SORT_ASC],
            'desc' => ['adjustment_daily.no_sj' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
