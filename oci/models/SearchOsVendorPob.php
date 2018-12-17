<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsVendorPob;

/**
 * SearchOsVendorSpk represents the model behind the search form about `app\models\OsVendorSpk`.
 */
class SearchOsVendorPob extends OsVendorPob
{
    /**
     * @inheritdoc
     */

	public $address, $phone, $email, $fax;

    public function rules()
    {
        return [
            [['id', 'id_os_vendor_project_parameter',  'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['pob_number', 'pob_date', 'created_date', 'updated_date', 'revision_remark', 'address', 'phone', 'email', 'fax', 'id_os_vendor_project_parameter', 'vendor_name'], 'safe'],
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
        $query = OsVendorPob::find();

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
            'id_os_vendor_project_parameter' => $this->id_os_vendor_project_parameter,
            // 'currency' => $this->currency,
            'vendor_name' => $this->vendor_name,
            'pob_date' => $this->pob_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'pob_number', $this->pob_number])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
			 ->andFilterWhere(['like', 'address', $this->address])
			  ->andFilterWhere(['like', 'phone', $this->phone])
			   ->andFilterWhere(['like', 'email', $this->email])
			    ->andFilterWhere(['like', 'fax', $this->fax]);

        return $dataProvider;
    }

	public function searchByAction($params, $action)
    {


		 $query = OsVendorPob::find()->joinWith('vendorName');


		if($action == 'input') {

		   $query->andFilterWhere(['or',['=','os_vendor_pob.status_listing', 1],['=','os_vendor_pob.status_listing', 3],['=','os_vendor_pob.status_listing', 2],['=','os_vendor_pob.status_listing', 6]])
				 ->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'verify') {


			$query->andFilterWhere(['or',['=','os_vendor_pob.status_listing', 1],['=','os_vendor_pob.status_listing', 4], ['=','os_vendor_pob.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {


			$query->andFilterWhere(['or',['=','os_vendor_pob.status_listing', 4],['=','os_vendor_pob.status_listing', 5]])->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'overview') {


			$query ->orderBy(['id' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),



        ]);

		$dataProvider->sort->attributes['id_os_vendor_project_parameter'] = [
            'asc' => ['"id_os_vendor_project_parameter"' => SORT_ASC],
            'desc' => ['"id_os_vendor_project_parameter"' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


  // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_os_vendor_project_parameter' => $this->id_os_vendor_project_parameter,
            // 'currency' => $this->currency,
            // 'os_vendor_regist_vendor.company_name' => $this->vendor_name,
            'pob_date' => $this->pob_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'log_os_vendor_pob.status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['like', 'pob_number', $this->pob_number])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
			->andFilterWhere(['like', 'address', $this->address])
			->andFilterWhere(['ilike', 'os_vendor_regist_vendor.company_name', $this->vendor_name,])
			  ->andFilterWhere(['like', 'phone', $this->phone])
			   ->andFilterWhere(['like', 'email', $this->email])
			    ->andFilterWhere(['like', 'fax', $this->fax]);

        return $dataProvider;
}


}
