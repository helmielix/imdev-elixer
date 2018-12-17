<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsOutsourceSalary;

/**
 * SearchOsOutsourceSalary represents the model behind the search form about `app\models\OsOutsourceSalary`.
 */
class SearchOsOutsourceSalary extends OsOutsourceSalary
{
    /**
     * @inheritdoc
     */
	 public $id_division, $id_city;


    public function rules()
    {
        return [
            [['id', 'month', 'year', 'id_os_outsource_personil', 'overtime', 'created_by', 'updated_by', 'status_listing', 'id_division', 'id_city'], 'integer'],
            [['report_finger_print', 'created_date', 'updated_date', 'revision_remark', 'id_city','id_division'], 'safe'],
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
        $query = OsOutsourceSalary::find();

        // add conditions that should always apply here

		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

	public function searchByDetailsalary($params, $idOsOutsourceFormSalary)
	{
		$query = OsOutsourceSalary::find();

		$query->andFilterWhere(['id_os_outsource_form_salary' => $idOsOutsourceFormSalary]);

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

	public function searchByAction($params, $action)
    {


		 $query = OsOutsourceSalary::find()
		         ->joinWith('idOsOutsourcePersonil.idOsOutsourceParameter',true,'FULL JOIN')
                ->select(['os_outsource_salary.id',
                        'os_outsource_salary.id_os_outsource_personil',
                        'os_outsource_salary.report_finger_print',
                        'os_outsource_salary.overtime',
                        'os_outsource_salary.created_by',
                        'os_outsource_salary.created_date',
                        'os_outsource_salary.updated_date',
                        'os_outsource_salary.updated_by',
                        'os_outsource_salary.status_listing',
                        'os_outsource_salary.revision_remark',
                        'os_outsource_salary.total_gaji',
                        'os_outsource_salary.total',
                        'os_outsource_salary.total_invoice',
                        'os_outsource_salary.pph21',
                        'os_outsource_salary.work_day',
                        'os_outsource_salary.month',
                        'os_outsource_salary.year',
                        'os_outsource_parameter.id_division',
                        'os_outsource_personil.id_city',
                ])
                 ;



		if($action == 'input') {

		   $query->andFilterWhere(['or',['=','os_outsource_salary.status_listing', 1],['=','os_outsource_salary.status_listing', 3],['=','os_outsource_salary.status_listing', 2],['=','os_outsource_salary.status_listing', 7]])
				 ->orderBy(['id' => SORT_DESC]);

		} else if ($action == 'verify') {

			$query->andFilterWhere(['or',['=','os_outsource_salary.status_listing', 1],['=','os_outsource_salary.status_listing', 4], ['=','os_outsource_salary.status_listing', 2]])
				 ->orderBy(['os_outsource_salary.id' => SORT_DESC]);
		}
		else if ($action == 'approve') {


			$query ->andWhere(['or',['=','os_outsource_salary.status_listing', 4],['=','os_outsource_salary.status_listing', 5]])
				 ->orderBy(['os_outsource_salary.id' => SORT_DESC]);
		} else if ($action == 'overview') {


			$query ->orderBy(['os_outsource_salary.id' => SORT_DESC]);
        }

		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

	public function _search($params, $query)
	{
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
            'month' => $this->month,
            'year' => $this->year,
            'id_os_outsource_personil' => $this->id_os_outsource_personil,
            'overtime' => $this->overtime,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
			'idOsOutsourcePersonil.idOsOutsourceParameter.id_division' => $this->id_division,
			'idOsOutsourcePersonil.idOsOutsourceParameter.id_city' => $this->id_city,


        ]);

        $query->andFilterWhere(['like', 'report_finger_print', $this->report_finger_print])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
	}
}
