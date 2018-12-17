<?php

namespace ap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ap\models\FinanceInvoice;

/**
 * SearchInvoice represents the model behind the search form about `ap\models\Invoice`.
 */
class SearchFinanceInvoice extends FinanceInvoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_os_vendor_pob', 'percentage', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['invoice_number', 'order_number', 'invoice_date', 'invoice_due_date', 'invoice_type', 'pic_vendor', 'pic_vendor_position', 'revision_remark', 'upload_invoice', 'pic_finance', 'created_date', 'updated_date'], 'safe'],
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
        $query = FinanceInvoice::find();

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
            'id_os_vendor_pob' => $this->id_os_vendor_pob,
            'invoice_date' => $this->invoice_date,
            'invoice_due_date' => $this->invoice_due_date,
            'percentage' => $this->percentage,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'invoice_type', $this->invoice_type])
            ->andFilterWhere(['like', 'pic_vendor', $this->pic_vendor])
            ->andFilterWhere(['like', 'pic_vendor_position', $this->pic_vendor_position])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'upload_invoice', $this->upload_invoice])
            ->andFilterWhere(['like', 'pic_finance', $this->pic_finance]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
        $query = FinanceInvoice::find();
		
		if($action == 'input') {
			
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['status_listing' => 1],['status_listing' => 4], ['status_listing' => 2]]);
        } else if ($action == 'approve') {
            $query->andFilterWhere(['or',['status_listing' => 4],['status_listing' => 5]]);
        }  else if ($action == 'overview') {
            $query->andFilterWhere(['in','status_listing',[1,2,3,4,5,6,7]]);
        }

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
            'id_os_vendor_pob' => $this->id_os_vendor_pob,
            'invoice_date' => $this->invoice_date,
            'invoice_due_date' => $this->invoice_due_date,
            'percentage' => $this->percentage,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['ilike', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['ilike', 'order_number', $this->order_number])
            ->andFilterWhere(['ilike', 'invoice_type', $this->invoice_type])
            ->andFilterWhere(['ilike', 'pic_vendor', $this->pic_vendor])
            ->andFilterWhere(['ilike', 'pic_vendor_position', $this->pic_vendor_position])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'upload_invoice', $this->upload_invoice])
            ->andFilterWhere(['ilike', 'pic_finance', $this->pic_finance]);

        return $dataProvider;
    }
}
