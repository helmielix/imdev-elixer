<?php

namespace ap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ap\models\FinanceInvoiceDocument;

/**
 * SearchFinanceInvoiceDocument represents the model behind the search form about `ap\models\FinanceInvoiceDocument`.
 */
class SearchFinanceInvoiceDocument extends FinanceInvoiceDocument
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_finance_invoice'], 'integer'],
            [['document_name', 'document'], 'safe'],
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
    public function search($params,$idFinanceInvoice)
    {
        $query = FinanceInvoiceDocument::find()
		->joinWith('idFinanceInvoice')
		->select([
				'finance_invoice.id as id_finance_invoice',
				'finance_invoice_document.document_name',
				'finance_invoice_document.document',
			])
		->andFilterWhere(['=','finance_invoice.id',$idFinanceInvoice]);
		// ->all();

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
            'id_finance_invoice' => $this->id_finance_invoice,
        ]);

        $query->andFilterWhere(['ilike', 'document_name', $this->document_name])
            ->andFilterWhere(['ilike', 'document', $this->document]);

        return $dataProvider;
    }
}
