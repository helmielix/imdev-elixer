<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionProductionDetailSetItem;

/**
 * SearchInstructionProductionDetailSetItem represents the model behind the search form about `common\models\InstructionProductionDetailSetItem`.
 */
class SearchInstructionProductionDetailSetItem extends InstructionProductionDetailSetItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_instruction_production_detail', 'id_item_set', 'req_good', 'req_dis_good', 'req_good_recond', 'total'], 'integer'],
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
        $query = InstructionProductionDetailSetItem::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_instruction_production_detail' => $this->id_instruction_production_detail,
            'id_item_set' => $this->id_item_set,
            'req_good' => $this->req_good,
            'req_dis_good' => $this->req_dis_good,
            'req_good_recond' => $this->req_good_recond,
            'total' => $this->total,
        ]);

        return $dataProvider;
    }

    public function searchByParent($params, $id)
    {
        $query = InstructionProductionDetailSetItem::find()
        ->select([
            'master_item_im.im_code',
            'master_item_im.name',
            'master_item_im.brand',
            'master_item_im.sn_type',
            'master_item_im.uom',
            'instruction_production_detail_set_item.req_good',
            'instruction_production_detail_set_item.req_dis_good',
            'instruction_production_detail_set_item.req_good_recond',

        ])
        ->joinWith('idMasterItemIm')
        ->where(['id_instruction_production_detail'=>$id]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_instruction_production_detail' => $this->id_instruction_production_detail,
            'id_item_set' => $this->id_item_set,
            'req_good' => $this->req_good,
            'req_dis_good' => $this->req_dis_good,
            'req_good_recond' => $this->req_good_recond,
            'total' => $this->total,
        ]);

        return $dataProvider;
    }
}
