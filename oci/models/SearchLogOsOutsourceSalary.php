<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsOutsourceSalary;

/**
 * SearchOsOutsourceSalary represents the model behind the search form about `app\models\OsOutsourceSalary`.
 */
class SearchLogOsOutsourceSalary extends LogOsOutsourceSalary
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
        $query = LogOsOutsourceSalary::find();

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
	
	 
	
	public function searchByAction($params, $action)
    {
		
			
		 $query = LogOsOutsourceSalary::find()
		         ->joinWith('idOsOutsourcePersonil.idOsOutsourceParameter',true,'FULL JOIN')
                ->select(['log_os_outsource_salary.id',
                        'log_os_outsource_salary.id_os_outsource_personil',
                        'log_os_outsource_salary.report_finger_print',
                        'log_os_outsource_salary.overtime',
                        'log_os_outsource_salary.created_by',
                        'log_os_outsource_salary.created_date',
                        'log_os_outsource_salary.updated_date',
                        'log_os_outsource_salary.updated_by',
                        'log_os_outsource_salary.status_listing',
                        'log_os_outsource_salary.revision_remark',
                        'log_os_outsource_salary.total_gaji',
                        'log_os_outsource_salary.total',
                        'log_os_outsource_salary.total_invoice',
                        'log_os_outsource_salary.pph21',
                        'log_os_outsource_salary.work_day',
                        'log_os_outsource_salary.month',
                        'log_os_outsource_salary.year',
                        'os_outsource_parameter.id_division',
                        'os_outsource_personil.id_city',
                ])
                 ;
				 
		 
		
		if($action == 'input') {
			
		   $query->andFilterWhere(['or',['=','log_os_outsource_salary.status_listing', 1],['=','log_os_outsource_salary.status_listing', 3],['=','log_os_outsource_salary.status_listing', 2],['=','log_os_outsource_salary.status_listing', 7]])
				 ->orderBy(['id' => SORT_DESC]);
				 
		} else if ($action == 'verify') {
			 
			$query->andFilterWhere(['or',['=','log_os_outsource_salary.status_listing', 1],['=','log_os_outsource_salary.status_listing', 4], ['=','log_os_outsource_salary.status_listing', 2]])
				 ->orderBy(['log_os_outsource_salary.id' => SORT_DESC]);
		}
		else if ($action == 'approve') {
		     
			
			$query ->andWhere(['or',['=','log_os_outsource_salary.status_listing', 4],['=','log_os_outsource_salary.status_listing', 5]])
				 ->orderBy(['log_os_outsource_salary.id' => SORT_DESC]);
		} else if ($action == 'overview') {
		
           
			$query ->orderBy(['log_os_outsource_salary.id' => SORT_DESC]);
        }
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),



        ]);

	   $dataProvider->sort->attributes['id_division'] = [
            'asc' => ['"id_division"' => SORT_ASC],
            'desc' =>['"id_division"' => SORT_DESC],
        ];
		
		
		$dataProvider->sort->attributes['id_city'] = [
            'asc' => ['."id_city"' => SORT_ASC],
            'desc' =>['"id_city"' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
		

        // grid filtering conditions
        $query->andFilterWhere([
            'log_os_outsource_salary.id' => $this->id,
            'month' => $this->month,
            'year' => $this->year,
            'id_os_outsource_personil' => $this->id_os_outsource_personil,
            'overtime' => $this->overtime,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'log_os_outsource_salary.status_listing' => $this->status_listing,
			'os_outsource_parameter.id_division' => $this->id_division,
			'os_outsource_personil.id_city' => $this->id_city,
        ]);

        $query->andFilterWhere(['like', 'report_finger_print', $this->report_finger_print])
              ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
}
}
