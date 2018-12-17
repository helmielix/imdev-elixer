<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsVendorPobDetail;

/**
 * SearchOsVendorSpkDetail represents the model behind the search form about `app\models\OsVendorSpkDetail`.
 */
class SearchOsVendorPobDetail extends OsVendorPobDetail
{
    /**
     * @inheritdoc
     */

	public $subtotal, $subtotal_material_service, $VAT10, $total;

    public function rules()
    {
        return [
            [['id',  'created_by', 'updated_by'], 'integer'],
            [['note', 'created_date', 'updated_date', 'po_number', 'pr_number'], 'safe'],
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
        $query = OsVendorPobDetail::find();

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
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
		      ->andFilterWhere(['like', 'po_number', $this->po_number])
			   ->andFilterWhere(['like', 'pr_number', $this->pr_number])
			  // ->andFilterWhere(['like', 'status_listing', $this->status_listing])
		      // ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
			  ;

        return $dataProvider;
    }

	public function searchByAction($params, $action)
    {


		 $query = OsVendorPobDetail::find();


		if($action == 'input') {

		   // $query->andFilterWhere(['or',['=','os_vendor_pob_detail.status_listing', 1],['=','os_vendor_pob_detail.status_listing', 3],['=','os_vendor_pob_detail.status_listing', 2]])
			// 	 ->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'verify') {


			$query->andFilterWhere(['or',['=','os_vendor_pob_detail.status_listing', 1],['=','os_vendor_pob_detail.status_listing', 4], ['=','os_vendor_pob_detail.status_listing', 2]])
				 ->orderBy(['id' => SORT_DESC]);
		}
		else if ($action == 'approve') {


			$query->andFilterWhere(['or',['=','os_vendor_pob_detail.status_listing', 4],['=','os_vendor_pob_detail.status_listing', 5]])->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'overview') {


			$query ->orderBy(['id' => SORT_DESC]);
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
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
		      ->andFilterWhere(['like', 'po_number', $this->po_number])
			   ->andFilterWhere(['like', 'pr_number', $this->pr_number])
			  // ->andFilterWhere(['like', 'status_listing', $this->status_listing])
		      // ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
			  ;


        return $dataProvider;
}

public function searchByIdVendorPobDetail($params, $idVendorPob)
    {


		 $query = OsVendorPobDetail::find()->where(['id_os_vendor_pob'=>$idVendorPob]);




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
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
		      ->andFilterWhere(['like', 'po_number', $this->po_number])
			  ->andFilterWhere(['like', 'pr_number', $this->pr_number])
			  // ->andFilterWhere(['like', 'status_listing', $this->status_listing])
		      // ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
			  ;


        return $dataProvider;
}
}
