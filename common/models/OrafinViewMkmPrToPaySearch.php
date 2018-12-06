<?php

namespace divisitiga\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use divisitiga\models\OrafinViewMkmPrToPay;

/**
 * OrafinViewMkmPrToPaySearch represents the model behind the search form of `divisitiga\models\OrafinViewMkmPrToPay`.
 */
class OrafinViewMkmPrToPaySearch extends OrafinViewMkmPrToPay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pr_currency_amount', 'rcv_quantity_received', 'inv_amount', 'po_price', 'po_header_id', 'po_line_id', 'ship_to_location_id', 'po_line_location_id', 'po_distribution_id', 'rcv_transaction_id', 'rcv_shipment_line_id', 'po_release_id', 'item_id', 'po_line_num'], 'integer'],
            [['po_num', 'pr_num', 'pr_creation_date', 'pr_item_description', 'po_uom', 'pr_desc', 'pr_status', 'po_status', 'rcv_no', 'inv_no', 'po_date', 'rcv_date', 'rcv_receiver', 'po_supplier', 'pr_item_code', 'po_vendor_site_code', 'accrual_account', 'po_item_description'], 'safe'],
            [['pr_quantity', 'po_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = OrafinViewMkmPrToPay::find();

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
            'pr_creation_date' => $this->pr_creation_date,
            'pr_quantity' => $this->pr_quantity,
            'po_amount' => $this->po_amount,
            'pr_currency_amount' => $this->pr_currency_amount,
            'rcv_quantity_received' => $this->rcv_quantity_received,
            'inv_amount' => $this->inv_amount,
            'po_date' => $this->po_date,
            'rcv_date' => $this->rcv_date,
            'po_price' => $this->po_price,
            'po_header_id' => $this->po_header_id,
            'po_line_id' => $this->po_line_id,
            'ship_to_location_id' => $this->ship_to_location_id,
            'po_line_location_id' => $this->po_line_location_id,
            'po_distribution_id' => $this->po_distribution_id,
            'rcv_transaction_id' => $this->rcv_transaction_id,
            'rcv_shipment_line_id' => $this->rcv_shipment_line_id,
            'po_release_id' => $this->po_release_id,
            'item_id' => $this->item_id,
            'po_line_num' => $this->po_line_num,
        ]);

        $query->andFilterWhere(['ilike', 'po_num', $this->po_num])
            ->andFilterWhere(['ilike', 'pr_num', $this->pr_num])
            ->andFilterWhere(['ilike', 'pr_item_description', $this->pr_item_description])
            ->andFilterWhere(['ilike', 'po_uom', $this->po_uom])
            ->andFilterWhere(['ilike', 'pr_desc', $this->pr_desc])
            ->andFilterWhere(['ilike', 'pr_status', $this->pr_status])
            ->andFilterWhere(['ilike', 'po_status', $this->po_status])
            ->andFilterWhere(['ilike', 'rcv_no', $this->rcv_no])
            ->andFilterWhere(['ilike', 'inv_no', $this->inv_no])
            ->andFilterWhere(['ilike', 'rcv_receiver', $this->rcv_receiver])
            ->andFilterWhere(['ilike', 'po_supplier', $this->po_supplier])
            ->andFilterWhere(['ilike', 'pr_item_code', $this->pr_item_code])
            ->andFilterWhere(['ilike', 'po_vendor_site_code', $this->po_vendor_site_code])
            ->andFilterWhere(['ilike', 'accrual_account', $this->accrual_account])
            ->andFilterWhere(['ilike', 'po_item_description', $this->po_item_description]);

        return $dataProvider;
    }
}
