<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ParameterMasterItemDetail;

/**
 * SearchParameterMasterItemDetail represents the model behind the search form about `common\models\ParameterMasterItemDetail`.
 */
class SearchParameterMasterItemDetail extends ParameterMasterItemDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_item_parent', 'id_item_child', 'qty_item_child', 'status_listing'], 'integer'],
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
        $query = ParameterMasterItemDetail::find();

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
            'id_item_parent' => $this->id_item_parent,
            'id_item_child' => $this->id_item_child,
            'qty_item_child' => $this->qty_item_child,
            'status_listing' => $this->status_listing,
        ]);

        return $dataProvider;
    }

    public function searchByAction($params, $id)
    {
        $query = ParameterMasterItemDetail::find()->where(['id_parameter'=>$id]);

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
            'id_item_parent' => $this->id_item_parent,
            'id_item_child' => $this->id_item_child,
            'qty_item_child' => $this->qty_item_child,
            'status_listing' => $this->status_listing,
        ]);

        return $dataProvider;
    }
}
