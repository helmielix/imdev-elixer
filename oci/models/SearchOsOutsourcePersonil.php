<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsOutsourcePersonil;
use app\models\User;

/**
 * SearchOsOutsoucePersonil represents the model behind the search form about `app\models\OsOutsourcePersonil`.
 */
class SearchOsOutsourcePersonil extends OsOutsourcePersonil
{
    /**
     * @inheritdoc
     */

	public $overtime, $pph21, $position, $division, $id_division;

    public function rules()
    {
        return [
            [['id', 'id_vendor', 'gender', 'religion', 'marital_status', 'id_os_outsource_parameter', 'created_by', 'updated_by', 'status_listing','education', 'id_city', 'id_division'], 'integer'],
            [['name','employee_number', 'birth_place', 'birth_date', 'address', 'ktp', 'phone', 'no_bpjs_kes', 'no_bpjs_tk', 'join_date', 'contract_start', 'contract_end', 'id_labor', 'attachment', 'note', 'created_date', 'updated_date', 'revision_remark',
			'overtime','pph21', 'position','division'], 'safe'],
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
        $query = OsOutsourcePersonil::find()
		         ->joinWith('idOsOutsourceParameter',true,'FULL JOIN');

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }


	public function searchByAction($params, $action)
    {
		$query = OsOutsourcePersonil::find()
		          ->joinWith('idOsOutsourceParameter',true,'FULL JOIN');

		if($action == 'input') {
			$query->andFilterWhere(['not in','os_outsource_personil.status_listing', [4,5]]);

		} else if ($action == 'verify') {
			$query->andFilterWhere(['or',['=','os_outsource_personil.status_listing', 1],['=','os_outsource_personil.status_listing', 4], ['=','os_outsource_personil.status_listing', 2]]);

		} else if ($action == 'approve') {
			$query->andFilterWhere(['or',['=','os_outsource_personil.status_listing', 4],['=','os_outsource_personil.status_listing', 5]]);

		} else if ($action == 'overview') {
			$query->andFilterWhere(['or',['=','os_outsource_personil.status_listing', 1],['=','os_outsource_personil.status_listing', 2],['=','os_outsource_personil.status_listing', 3],['=','os_outsource_personil.status_listing', 4],['=','os_outsource_personil.status_listing', 5],['=','os_outsource_personil.status_listing', 6]]);
        }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;

	}


	public function searchByIdDivisionIdRegion($params, $idpersonil)
	{
        $query = OsOutsourcePersonil::find()
		         ->joinWith('idOsOutsourceParameter',true,'FULL JOIN');

		if (count($idpersonil) == 0) {
			$idpersonil = 0;
		}
		$query->andFilterWhere(['os_outsource_personil.id' => $idpersonil]);

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

	public function searchByIdDivisionIdRegionCntSalary($params,$idDivision, $idCity, $month)

    {
        $query = OsOutsourcePersonil::find()
		         ->joinWith('idOsOutsourceParameter',true,'FULL JOIN')
				 ->joinWith('idOsOutsourceSalary',true,'FULL JOIN');

        $query->andFilterWhere(['os_outsource_parameter.id_division' => $idDivision]);

		$query->andFilterWhere(['os_outsource_personil.id_city' => $idCity]);

		$query->andFilterWhere(['os_outsource_salary.month' => $month]);

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;

	}

	private function _search($params, $query) {

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['updated_date'=>SORT_DESC]]
        ]);

		$dataProvider->sort->attributes['position'] = [
			'asc' => ['os_outsource_parameter.position' => SORT_ASC],
			'desc' => ['os_outsource_parameter.position' => SORT_DESC],
		];

		$dataProvider->sort->attributes['id_division'] = [
			'asc' => ['os_outsource_parameter.id_division' => SORT_ASC],
			'desc' => ['os_outsource_parameter.id_division' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_vendor' => $this->id_vendor,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'marital_status' => $this->marital_status,
            'join_date' => $this->join_date,
            'contract_start' => $this->contract_start,
            'contract_end' => $this->contract_end,
            'id_os_outsource_parameter' => $this->id_os_outsource_parameter,
            'created_by' => $this->created_by,
            'Date(created_date)' => $this->created_date,
            'updated_by' => $this->updated_by,
            'Date(updated_date)' => $this->updated_date,
            'os_outsource_personil.status_listing' => $this->status_listing,
			'education' => $this->education,
			'id_city' => $this->id_city,
			'overtime' => $this->overtime,
			'pph21' => $this->pph21,
			'os_outsource_parameter.id_division' => $this->id_division,
			'os_outsource_parameter.id' => $this->position,

        ]);

        $query->andFilterWhere(['ilike', 'employee_number', $this->employee_number])
            ->andFilterWhere(['ilike', 'birth_place', $this->birth_place])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'ktp', $this->ktp])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'no_bpjs_kes', $this->no_bpjs_kes])
            ->andFilterWhere(['ilike', 'no_bpjs_tk', $this->no_bpjs_tk])
            ->andFilterWhere(['ilike', 'id_labor', $this->id_labor])
            ->andFilterWhere(['ilike', 'attachment', $this->attachment])
            ->andFilterWhere(['ilike', 'note', $this->note])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
			->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
	}
}
