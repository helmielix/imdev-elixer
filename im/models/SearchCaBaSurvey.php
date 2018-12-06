<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CaBaSurvey;
use app\models\PplIkoAtp;

/**
 * SearchCaBaSurvey represents the model behind the search form about `app\models\CaBaSurvey`.
 */
class SearchCaBaSurvey extends CaBaSurvey
{
    public $city, $district, $subdistrict, $status_area;
    
	public function rules()
    {
        return [
            [['id_area', 'notes', 'survey_date', 'created_by', 'created_date', 'updated_by', 'updated_date', 'status_presurvey','status_listing', 'status_iom', 'iom_type', 'potency_type', 'no_iom', 'avr_occupancy_rate', 'geom', 'property_area_type', 'house_type', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'location_description', 'pic_survey', 'contact_survey', 'pic_iom_special', 'revision_remark'], 'safe'],
            [['qty_hp_pot', 'id', 'qty_soho_pot'], 'integer'],
			[['file','city','district','subdistrict','area, status_area'],'safe']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CaBaSurvey::find();

		$query->joinWith(['idArea.idSubdistrict.idDistrict.idCity'])->orderBy(['status_listing'=>SORT_ASC]);
		
        $dataProvider = $this->_search($params, $query); 

        return $dataProvider;
    }
	
	public function searchByAction($params, $action)
    {
        $query = CaBaSurvey::find();

		$query->joinWith(['idArea.idSubdistrict.idDistrict.idCity']);
		
		// Pre Survey Actions
		if($action == 'input_presurvey') {
            $query->andFilterWhere(['or',['status_presurvey' => 7],['status_presurvey' => 1],['status_presurvey' => 3],['status_presurvey'=> 2],['status_presurvey'=> 6]]);
        } else if ($action == 'verify_presurvey') {
            $query->andFilterWhere(['or',['status_presurvey' => 1],['status_presurvey' => 4], ['status_presurvey' => 2]]);
			$query->andFilterWhere(['=','status_listing' , 999]);
        } else if ($action == 'approve_presurvey') {
            $query->andFilterWhere(['or',['status_presurvey' => 4],['status_presurvey' => 5]]);
			$query->andFilterWhere(['=','status_listing' , 999]);
        } else if ($action == 'overview_presurvey') {
            $query->andFilterWhere(['in','status_listing' , [7,1]]);
        } 
		
		// BA Survey Actions
		else 
		if($action == 'input') {
            $query->andFilterWhere(['or',['status_listing' => 1],['status_listing' => 3],['status_listing'=> 2],['status_listing'=> 29],['status_listing'=> 28],['status_listing'=> 999],['status_listing'=> 6]]);
			$query->andFilterWhere(['=','status_presurvey' , 5]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['status_listing' => 1],['status_listing' => 4], ['status_listing' => 2]]);
        } else if ($action == 'approve') {
			$query->joinWith(['planningIkoBasPlan']);
            $query->andFilterWhere(['or',['ca_ba_survey.status_listing' => 4],['ca_ba_survey.status_listing' => 5]])
					->andWhere(['planning_iko_bas_plan.status_listing' => null]);
        }  
		
		
		// IOM Rollout Actions
		else if ($action == 'input_iom') {
			$query->joinWith(['planningIkoBasPlan.idPlanningIkoBoqP.govrelBaDistribution']);
			$query
				->andFilterWhere(['or',['=','status_iom', 999],['=','status_iom', 1],['=','status_iom', 3],['=','status_iom', 2],['status_iom'=> 6]])
				->andFilterWhere(['govrel_ba_distribution.status_listing' => 5])
				->andFilterWhere(['govrel_ba_distribution.permit_result' => 26]);
				//->andFilterWhere(['planning_iko_bas_plan.status_listing' => 5])->all();
		} else if ($action == 'verify_iom') {
            $query->andFilterWhere(['or',
					['status_iom' => 1],
					['status_iom' => 4],
					['status_iom' => 2]]);
        } else if ($action == 'approve_iom') {
			$query->andFilterWhere(['or',
					['status_iom' => 4],
					['status_iom' => 5]]);
		}
		
        $dataProvider = $this->_search($params, $query); 
		
        return $dataProvider;
    }
	
	public function searchByActionInvitation($params, $action)
    {
        $query = PplIkoAtp::find();
        if ($action == 'invitation') {
            $query->joinWith('idPlanningIkoBoqB', true, 'FULL JOIN')
            ->select([
                'planning_iko_boq_b.boq_number',
                'planning_iko_boq_b.location',
                'ppl_iko_atp.status_schedule',
                'ppl_iko_atp.id_planning_iko_boq_b',
                'ppl_iko_atp.date_atp',
                'ppl_iko_atp.created_by',
                'ppl_iko_atp.created_date',
            ])
            ->andFilterWhere(['ppl_iko_atp.status_schedule' => 1]);
        }
        $dataProvider = $this->_searchInvitation($params, $query);

        return $dataProvider;
    }
	
	private function _searchInvitation($params, $query) {

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ppl_iko_atp.id_planning_iko_boq_b' => $this->id_planning_iko_boq_b,
            'date(ppl_iko_atp.created_date)' => $this->created_date,
            'date(ppl_iko_atp.updated_date)' => $this->updated_date,
			'ppl_iko_atp.created_by' => $this->created_by,
			'ppl_iko_atp.updated_by' => $this->updated_by,
			'ppl_iko_atp.pic_osp' => $this->pic_osp,
			'ppl_iko_atp.pic_iko' => $this->pic_iko,
			'ppl_iko_atp.pic_ospm' => $this->pic_ospm,
			'ppl_iko_atp.pic_ikr' => $this->pic_ikr,
			'ppl_iko_atp.pic_planning' => $this->pic_planning,
			'ppl_iko_atp.pic_ca' => $this->pic_ca,
			'ppl_iko_atp.pic_project_control' => $this->pic_project_control,
			'ppl_iko_atp.date_atp' => $this->date_atp,
            'ppl_iko_atp.status_listing' => $this->status_listing,
			'ppl_iko_atp.status_schedule' => $this->status_schedule,
        ]);

        $query->andFilterWhere(['ilike', 'ppl_iko_atp.created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'ppl_iko_atp.updated_by', $this->updated_by])
            ->andFilterWhere(['ilike', 'ppl_iko_atp.revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'ppl_iko_atp.file_civil', $this->file_civil])
			->andFilterWhere(['ilike', 'ppl_iko_atp.file_electric_fat', $this->file_electric_fat])
			->andFilterWhere(['ilike', 'ppl_iko_atp.file_electric_odc', $this->file_electric_odc])
			->andFilterWhere(['ilike', 'ppl_iko_atp.file_electric_olt', $this->file_electric_olt])
			->andFilterWhere(['ilike', 'ppl_iko_atp.file_balap', $this->file_balap]);

        return $dataProvider;
    }
	
	private function _search($params, $query) {
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['updated_date'=>SORT_DESC]]
        ]);
		
		$dataProvider->sort->attributes['city'] = [
			'asc' => ['city.name' => SORT_ASC],
			'desc' => ['city.name' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['district'] = [
			'asc' => ['district.name' => SORT_ASC],
			'desc' => ['district.name' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['subdistrict'] = [
			'asc' => ['subdistrict.name' => SORT_ASC],
			'desc' => ['subdistrict.name' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['status_area'] = [
			'asc' => ['status_area.name' => SORT_ASC],
			'desc' => ['status_area.name' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'qty_hp_pot' => $this->qty_hp_pot,
            'ca_ba_survey.survey_date' => $this->survey_date,
            'date(created_date)' => $this->created_date,
            'date(ca_ba_survey.updated_date)' => $this->updated_date,
            'id' => $this->id,
            'qty_soho_pot' => $this->qty_soho_pot,
            'status_presurvey' => $this->status_presurvey,
            'ca_ba_survey.status_listing' => $this->status_listing,
            'status_iom' => $this->status_iom,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ]);

        $query->andFilterWhere(['ilike', 'id_area', $this->id_area])
            ->andFilterWhere(['ilike', 'notes', $this->notes])
            ->andFilterWhere(['ilike', 'iom_type', $this->iom_type])
            ->andFilterWhere(['ilike', 'potency_type', $this->potency_type])
            ->andFilterWhere(['ilike', 'no_iom', $this->no_iom])
            ->andFilterWhere(['ilike', 'avr_occupancy_rate', $this->avr_occupancy_rate])
            ->andFilterWhere(['ilike', 'geom', $this->geom])
            ->andFilterWhere(['ilike', 'property_area_type', $this->property_area_type])
            ->andFilterWhere(['ilike', 'house_type', $this->house_type])
            ->andFilterWhere(['ilike', 'myr_population_hv', $this->myr_population_hv])
            ->andFilterWhere(['ilike', 'dev_method', $this->dev_method])
            ->andFilterWhere(['ilike', 'access_to_sell', $this->access_to_sell])
            ->andFilterWhere(['ilike', 'occupancy_use_dth', $this->occupancy_use_dth])
            ->andFilterWhere(['ilike', 'competitors', $this->competitors])
            ->andFilterWhere(['ilike', 'location_description', $this->location_description])
            ->andFilterWhere(['ilike', 'pic_survey', $this->pic_survey])
            ->andFilterWhere(['ilike', 'contact_survey', $this->contact_survey])
            ->andFilterWhere(['ilike', 'pic_iom_special', $this->pic_iom_special])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'city.name', $this->city])
            ->andFilterWhere(['ilike', 'district.name', $this->district])
            ->andFilterWhere(['ilike', 'subdistrict.name', $this->subdistrict])
            ->andFilterWhere(['ilike', 'status_area.name', $this->status_area]);

        return $dataProvider;
	}
}
