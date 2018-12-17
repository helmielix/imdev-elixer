<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsVendorProjectParameter;

/**
 * SearchOsVendorProjectParameter represents the model behind the search form about `app\models\OsVendorProjectParameter`.
 */
class SearchOsVendorProjectParameter extends OsVendorProjectParameter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing_parameter'], 'integer'],
            [['project_name', 'others', 'created_date', 'updated_date', 'revision_remark', 'note'], 'safe'],
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
        $query = OsVendorProjectParameter::find();

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
            'status_listing_parameter' => $this->status_listing_parameter,
        ]);

        $query->andFilterWhere(['like', 'project_name', $this->project_name])
            ->andFilterWhere(['like', 'others', $this->others])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }

	public function searchByAction($params, $action)
    {
        $query = OsVendorProjectParameter::find();

		if($action == 'input') {
            $query->andWhere(['not in','os_vendor_project_parameter.status_listing_parameter' , [4, 5]]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['status_listing_parameter' => 1],['status_listing_parameter' => 4], ['status_listing_parameter' => 2]]);;
        } else if ($action == 'approve') {
            $query->andFilterWhere(['or',['status_listing_parameter' => 1],['status_listing_parameter' => 5]]);
        } else if ($action == 'overview') {
            $query->andFilterWhere(['in','status_listing_parameter' , [7,1]]);
        }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

	public function _search($params, $query)
    {
        // $query = OsVendorProjectParameter::find();

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
            'updated_by' => $this->updated_by,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'status_listing_parameter' => $this->status_listing_parameter,
        ]);

        $query->andFilterWhere(['ilike', 'project_name', $this->project_name])
            ->andFilterWhere(['ilike', 'others', $this->others])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'note', $this->note]);

        return $dataProvider;
    }
}
