<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsOutsourceFormSalary;

/**
 * SearchOsOutsourceFormSalary represents the model behind the search form about `app\models\OsOutsourceFormSalary`.
 */
class SearchOsOutsourceFormSalary extends OsOutsourceFormSalary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_city', 'id_division', 'month', 'year', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['report_finger_print', 'created_date', 'updated_date', 'revision_remark'], 'safe'],
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
    public function searchByAction($params, $action)
    {
        $query = OsOutsourceFormSalary::find()
               ->select(['os_outsource_form_salary.id',
                       'os_outsource_form_salary.created_by',
                       'os_outsource_form_salary.created_date',
                       'os_outsource_form_salary.updated_date',
                       'os_outsource_form_salary.updated_by',
                       'os_outsource_form_salary.status_listing',
                       'os_outsource_form_salary.month',
                       'os_outsource_form_salary.year',
                       'os_outsource_form_salary.id_division',
                       'os_outsource_form_salary.id_city',
               ]);

       if($action == 'input') {
          $query->andFilterWhere(['not in', 'os_outsource_form_salary.status_listing', [4,5]]);

       } else if ($action == 'verify') {
           $query->andFilterWhere(['os_outsource_form_salary.status_listing' => [1,2,4]]);
       }
       else if ($action == 'approve') {
           $query->andFilterWhere(['os_outsource_form_salary.status_listing' => [4, 5]]);

       } else if ($action == 'overview') {

           // $query ->orderBy(['os_outsource_form_salary.id' => SORT_DESC]);
       }
       $dataProvider = $this->_search($params, $query);

       return $dataProvider;
    }

    public function search($params)
    {
        $query = OsOutsourceFormSalary::find();

        // add conditions that should always apply here
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function _search($params, $query)
    {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]]
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
            'id_city' => $this->id_city,
            'id_division' => $this->id_division,
            'month' => $this->month,
            'year' => $this->year,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);

        $query->andFilterWhere(['ilike', 'report_finger_print', $this->report_finger_print])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
