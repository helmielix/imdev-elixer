<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsVendorPob;

/**
 * SearchLogOsVendorPob represents the model behind the search form about `app\models\LogOsVendorPob`.
 */
class SearchLogOsVendorPob extends LogOsVendorPob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'id', 'created_by', 'updated_by', 'status_listing', 'id_os_vendor_project_parameter'], 'integer'],
            [['pob_number', 'pob_date', 'created_date', 'updated_date', 'revision_remark', 'vendor_name'], 'safe'],
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
        $query = LogOsVendorPob::find()->joinWith('vendorName');

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
            // 'vendor_name' => $this->vendor_name,
            'pob_date' => $this->pob_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_vendor_pob.status_listing' => $this->status_listing,
            'id_os_vendor_project_parameter' => $this->id_os_vendor_project_parameter,
        ]);

        $query->andFilterWhere(['like', 'pob_number', $this->pob_number])
            ->andFilterWhere(['ilike', 'os_vendor_regist_vendor.company_name', $this->vendor_name])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
