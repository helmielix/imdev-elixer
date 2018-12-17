<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsVendorRegistVendor;

/**
 * SearchOsVendorRegistVendor represents the model behind the search form about `app\models\OsVendorRegistVendor`.
 */
class SearchOsVendorRegistVendor extends OsVendorRegistVendor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','contract_type', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['company_name', 'scoop_of_business', 'address', 'phone_number', 'fax_number', 'email', 'contact_person', 'handphone_number', 'note', 'created_date', 'updated_date', 'revision_remark', 'legal_document'], 'safe'],
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
        $query = OsVendorRegistVendor::find();

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
            'contract_type' => $this->contract_type,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
			'legal_document' => $this->legal_document,
        ]);

        $query->andFilterWhere(['ilike', 'company_name', $this->company_name])
            ->andFilterWhere(['ilike', 'scoop_of_business', $this->scoop_of_business])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'phone_number', $this->phone_number])
            ->andFilterWhere(['ilike', 'fax_number', $this->fax_number])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'contact_person', $this->contact_person])
            ->andFilterWhere(['ilike', 'handphone_number', $this->handphone_number])
			->andFilterWhere(['ilike', 'legal_document', $this->legal_document])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }

	public function searchByAction($params, $action)
    {


		 $query = OsVendorRegistVendor::find();


		if($action == 'input') {

		   $query->andFilterWhere(['or',['=','os_vendor_regist_vendor.status_listing', 1],['=','os_vendor_regist_vendor.status_listing', 3],['=','os_vendor_regist_vendor.status_listing', 2],['=','os_vendor_regist_vendor.status_listing', 6]])
				 ->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'verify') {


			$query->andFilterWhere(['or',['=','os_vendor_regist_vendor.status_listing', 1],['=','os_vendor_regist_vendor.status_listing', 4], ['=','os_vendor_regist_vendor.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {


			$query->andFilterWhere(['or',['=','os_vendor_regist_vendor.status_listing', 4],['=','os_vendor_regist_vendor.status_listing', 5]])->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'overview') {


			// $query ->orderBy(['id' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),



        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }



         // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contract_type' => $this->contract_type,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
			'legal_document' => $this->legal_document,
        ]);

        $query->andFilterWhere(['ilike', 'company_name', $this->company_name])
            ->andFilterWhere(['ilike', 'scoop_of_business', $this->scoop_of_business])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'phone_number', $this->phone_number])
            ->andFilterWhere(['ilike', 'fax_number', $this->fax_number])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'contact_person', $this->contact_person])
            ->andFilterWhere(['ilike', 'handphone_number', $this->handphone_number])
			->andFilterWhere(['ilike', 'legal_document', $this->legal_document])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;

}
}
