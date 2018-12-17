<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsVendorRegistVendor;

/**
 * SearchLogOsVendorRegistVendor represents the model behind the search form about `app\models\LogOsVendorRegistVendor`.
 */
class SearchLogOsVendorRegistVendor extends LogOsVendorRegistVendor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id', 'contract_type', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['company_name', 'scoop_of_business', 'address', 'phone_number', 'fax_number', 'email', 'contact_person', 'handphone_number', 'note', 'created_date', 'updated_date', 'revision_remark', 'file_attachment'], 'safe'],
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
        $query = LogOsVendorRegistVendor::find();

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
            'idlog' => $this->idlog,
            'id' => $this->id,
            'contract_type' => $this->contract_type,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'scoop_of_business', $this->scoop_of_business])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'fax_number', $this->fax_number])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'handphone_number', $this->handphone_number])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'file_attachment', $this->file_attachment]);

        return $dataProvider;
    }
}
