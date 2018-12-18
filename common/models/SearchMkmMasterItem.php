<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MkmMasterItem;

/**
 * SearchMkmMasterItem represents the model behind the search form about `common\models\MkmMasterItem`.
 */
class SearchMkmMasterItem extends MkmMasterItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_code', 'item_desc', 'item_uom_code', 'item_uom_desc', 'inventory_item_flag', 'location_code', 'location', 'source_code', 'segment1', 'segment2', 'segment3', 'segment4', 'segment5', 'segment6'], 'safe'],
            [['location_id', 'organization_id', 'distribution_account_id', 'transaction_cost', 'prior_cost', 'expense_account'], 'integer'],
            [['new_cost'], 'number'],
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

    public function searchByCreateDetailItem($params, $idMasterItemIm = null)
    {       
        $query = MkmMasterItem::find();
        
        if ($idMasterItemIm != null){
            $query->andWhere(['in' , 'item_code', $idMasterItemIm]);
        }        
        
        // $dataProvider = $this->_search($params, $query);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20 ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions        

        $query->andFilterWhere(['ilike', 'item_desc', $this->item_desc])            
            ->andFilterWhere(['ilike', 'item_code', $this->item_code])            
            ->andFilterWhere(['ilike', 'item_uom_code', $this->item_uom_code]);            

        return $dataProvider;

        // return $dataProvider;
    }

    public function search($params)
    {
        $query = MkmMasterItem::find();

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
            'location_id' => $this->location_id,
            'organization_id' => $this->organization_id,
            'distribution_account_id' => $this->distribution_account_id,
            'transaction_cost' => $this->transaction_cost,
            'prior_cost' => $this->prior_cost,
            'new_cost' => $this->new_cost,
            'expense_account' => $this->expense_account,
        ]);

        $query->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'item_desc', $this->item_desc])
            ->andFilterWhere(['like', 'item_uom_code', $this->item_uom_code])
            ->andFilterWhere(['like', 'item_uom_desc', $this->item_uom_desc])
            ->andFilterWhere(['like', 'inventory_item_flag', $this->inventory_item_flag])
            ->andFilterWhere(['like', 'location_code', $this->location_code])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'source_code', $this->source_code])
            ->andFilterWhere(['like', 'segment1', $this->segment1])
            ->andFilterWhere(['like', 'segment2', $this->segment2])
            ->andFilterWhere(['like', 'segment3', $this->segment3])
            ->andFilterWhere(['like', 'segment4', $this->segment4])
            ->andFilterWhere(['like', 'segment5', $this->segment5])
            ->andFilterWhere(['like', 'segment6', $this->segment6]);

        return $dataProvider;
    }
}
