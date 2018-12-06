<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionGrfDetail;

/**
 * SearchInstructionGrfDetail represents the model behind the search form about `common\models\InstructionGrfDetail`.
 */
class SearchInstructionGrfDetail extends InstructionGrfDetail
{
    /**
     * @inheritdoc
     */
    public $name, $brand, $warna, $sn_type;
    public function rules()
    {
        return [
            [['id', 'id_instruction_grf', 'qty_good', 'qty_noot_good', 'qty_reject', 'qty_dismantle_good', 'qty_dismantle_ng', 'qty_good_rec'], 'integer'],
            [['id_item_im', 'name', 'brand', 'warna', 'sn_type'], 'safe'],
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
        $query = InstructionGrfDetail::find();
        $query->joinWith('idInstructionGrf.idGrf.idGrfDetail.idOrafinCode');
        $query->select([
            'instruction_grf_detail.qty_good',
        ]);
        
        
        $query->andWhere(['id_instruction_grf' => $id]);

        // add conditions that should always apply here

            $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

  
    
    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort' => ['defaultOrder' => ['id'=>SORT_ASC]]
        ]);
        
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['master_item_im.name' => SORT_ASC],
            'desc' => ['master_item_im.name' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['brand'] = [
            'asc' => ['master_item_im.brand' => SORT_ASC],
            'desc' => ['master_item_im.brand' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['warna'] = [
            'asc' => ['master_item_im.warna' => SORT_ASC],
            'desc' => ['master_item_im.warna' => SORT_DESC],
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
            'id_instruction_grf' => $this->id_instruction_grf,
            'qty_good' => $this->qty_good,
            'qty_noot_good' => $this->qty_noot_good,
            'qty_reject' => $this->qty_reject,
            'qty_dismantle_good' => $this->qty_dismantle_good,
            'qty_dismantle_ng' => $this->qty_dismantle_ng,
            'qty_good_rec' => $this->qty_good_rec,
        ]);
        $query->andFilterWhere(['ilike', 'master_item_im.im_code', $this->id_item_im])
              ->andFilterWhere(['ilike', 'master_item_im.name', $this->name])
              ->andFilterWhere(['ilike', 'master_item_im.brand', $this->brand])
              ->andFilterWhere(['ilike', 'master_item_im.warna', $this->warna]);

        return $dataProvider;
    }
}
