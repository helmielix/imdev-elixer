<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OspWorkOrder;


class SearchOspWorkOrder extends OspWorkOrder
{
    public $bas_work_type, $material;

    public function rules()
    {
        return [
            [['wo_date', 'work_name', 'prepared_by', 'implemented_by', 'passed_by', 'installation_date', 'wo_number', 'revision_remark', 'bas_work_type', 'location', 'note', 'created_date', 'updated_date','departure','team_leader','total_personil'], 'safe'],
            [['id', 'id_planning_osp_boq_p', 'created_by', 'updated_by', 'status_material_need', 'status_transport', 'status_team', 'status_tools', 'status_material_used', 'status_grf', 'wo_type', 'material'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OspWorkOrder::find();

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function searchByAction($params, $action)
    {
        $query = OspWorkOrder::find();

        if($action == 'input') {
            $query->joinWith('idPlanningOspBoqP.idPlanningOspBas',true,'FULL JOIN')
                ->andFilterWhere(['or',['=','osp_work_order.status_listing', 1],['=','osp_work_order.status_listing', 2], ['=','osp_work_order.status_listing', 3],['=','osp_work_order.status_listing', 6],['=','osp_work_order.status_listing', 7]]);
        } else if ($action == 'verify') {
            $query->joinWith('idPlanningOspBoqP.idPlanningOspBas')
                ->andFilterWhere(['=','osp_work_order.status_tools', 1])
                ->andFilterWhere(['=','osp_work_order.status_material_need', 1])
                ->andFilterWhere(['=','osp_work_order.status_transport', 1]);
               $query->andFilterWhere(['or',['=','osp_work_order.status_listing', 1],['=','osp_work_order.status_listing', 4], ['=','osp_work_order.status_listing', 2]]);
        }
        else if ($action == 'approve') {
            $query->joinWith('idPlanningOspBoqP.idPlanningOspBas')
                ->andFilterWhere(['=','osp_work_order.status_tools', 1])
                ->andFilterWhere(['=','osp_work_order.status_material_need', 1])
                ->andFilterWhere(['=','osp_work_order.status_transport', 1]);
            $query->andFilterWhere(['or',['=','osp_work_order.status_listing', 4],['=','osp_work_order.status_listing', 5]]);
            $query->joinWith('ospWoActual');
            $query->andWhere(['osp_wo_actual.status_listing'=>null]);
        } else if ($action == 'all') {
            $query ->joinWith('idPlanningOspBoqP.idPlanningOspBas');
        } else if ($action == 'detail') {
            $query ->joinWith('idPlanningOspBoqP.idPlanningOspBas')
                ->andFilterWhere(['or',['=','osp_work_order.status_listing', 1],['=','osp_work_order.status_listing', 2]]);
        }
		 else if ($action == 'inputvehicle') {
        	$query
			->joinWith('ospWoActual',true,'FULL JOIN')
			// ->joinWith('idOspItpDaily.idOspItpArea.idPlanningOspBoqP.idPlanningOspBasPlan.idCaBaSurvey.idArea')
				->joinWith('ospTeamWo.idOspTeam.ospTeamMembers')
				->joinWith('ospTeamWo.idlabor')
				->joinWith('ospMaterialWos.idMaterial')
				->select([
				// 'osp_itp_daily.id as id_osp_itp_daily',
						// 'area.id',
						// 'osp_itp_daily.status_listing',
						// 'osp_work_order.work_date',
						'osp_work_order.work_name',
						'osp_work_order.location',
						'osp_work_order.status_listing',
						'osp_work_order.wo_date',
						'osp_work_order.installation_date',
						'osp_work_order.wo_number',
						'osp_work_order.updated_date',
						'osp_work_order.id',
						'osp_work_order.departure',
						// 'osp_team_member.name as team_leader',
                        'labor.name as team_leader'
						// '(select osp_team.id from osp_work_order full join)'
						// 'osp_team.id'
						])
				  // ->andWhere(['not in','osp_work_order.id',$idOspWo])
				  ->andFilterWhere(['=','osp_work_order.status_listing',5])
				  // ->andFilterWhere(['!=','osp_wo_actual.status_listings',5])
				  ->andWhere(['or', ['!=','osp_wo_actual.status_listing',5], ['osp_wo_actual.status_listing' => null]])
				  // -> orderBy('osp_work_order.id asc')
                  ;


	    }



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['bas_work_type'] = [
            'asc' => ['planning_osp_bas.work_type' => SORT_ASC],
            'desc' => ['planning_osp_bas.work_type' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['team_leader'] = [
            'asc' => ['labor.name' => SORT_ASC],
            'desc' => ['labor.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['material'] = [
            'asc' => ['material.type' => SORT_ASC],
            'desc' => ['material.type' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->departure)) {
            $this->departure = str_replace('m','0',$this->departure);
            $this->departure = str_replace('s','0',$this->departure);
            $this->departure = str_replace('h','0',$this->departure);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'date(osp_work_order.wo_date)' => $this->wo_date,
            'osp_work_order.installation_date' => $this->installation_date,
            'date(osp_work_order.created_date)' => $this->created_date,
            'date(osp_work_order.updated_date)' => $this->updated_date,
            'osp_work_order.id' => $this->id,
            'osp_work_order.id_planning_osp_boq_p' => $this->id_planning_osp_boq_p,
			'osp_work_order.status_listing' => $this->status_listing,
			'osp_work_order.created_by' => $this->created_by,
			'osp_work_order.updated_by' => $this->updated_by,
			'osp_work_order.status_material_need' => $this->status_material_need,
			'osp_work_order.status_transport' => $this->status_transport,
			'osp_work_order.status_team' => $this->status_team,
			'osp_work_order.status_tools' => $this->status_tools,
			'osp_work_order.status_material_used' => $this->status_material_used,
			'osp_work_order.status_grf' => $this->status_grf,
            'osp_work_order.wo_type' => $this->wo_type,
			'(osp_work_order.departure)' => $this->departure,
			'(material.id)' => $this->material,
        ]);

        if (is_numeric($this->total_personil)) {
            $total = $this->total_personil - 1;
            $query->groupBy('osp_work_order.work_name, osp_work_order.location, osp_work_order.status_listing,
            osp_work_order.wo_date, osp_work_order.installation_date, osp_work_order.wo_number,
            osp_work_order.updated_date, osp_work_order.id, labor.name, osp_team_member.id_osp_team');
            $query->having("count(osp_team_member.id_osp_team) = :count", [":count" => $total]);
        }

        $query->andFilterWhere(['ilike', 'osp_work_order.work_name', $this->work_name])
            ->andFilterWhere(['ilike', 'osp_work_order.prepared_by', $this->prepared_by])
            ->andFilterWhere(['ilike', 'osp_work_order.implemented_by', $this->implemented_by])
            ->andFilterWhere(['ilike', 'osp_work_order.passed_by', $this->passed_by])
            ->andFilterWhere(['ilike', 'osp_work_order.wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'osp_work_order.revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'planning_osp_bas.location', $this->location])
            ->andFilterWhere(['=', 'planning_osp_bas.work_type', $this->bas_work_type])
			->andFilterWhere(['ilike', 'labor.name', $this->team_leader])
            ->andFilterWhere(['ilike', 'osp_work_order.note', $this->note]);

        return $dataProvider;
    }

	public function searchByActionStatusGRF($params, $action)
    {
        $query = OspWorkOrder::find();

        if($action == 'input') {
            $query->andFilterWhere(['=','osp_work_order.status_listing', 5])
                ->andFilterWhere(['in','osp_work_order.status_grf', [1,2,3]]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['=','osp_work_order.status_listing', 5])
                ->andFilterWhere(['or',['=','osp_work_order.status_grf', 1],['=','osp_work_order.status_grf', 4], ['=','osp_work_order.status_grf', 2]]);
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['=','osp_work_order.status_listing', 5])
                ->andFilterWhere(['or',['=','osp_work_order.status_grf', 4],['=','osp_work_order.status_grf', 5]]);
        }
		else if ($action == 'overview') {
            $query->andFilterWhere(['=','osp_work_order.status_listing', 5])
                ->andFilterWhere(['or',['=','osp_work_order.status_grf', 1],['=','osp_work_order.status_grf', 3],['=','osp_work_order.status_grf', 2],['=','osp_work_order.status_grf', 4],['=','osp_work_order.status_grf', 5],['=','osp_work_order.status_grf', 6]]);
        }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }



    private function _search($params, $query) {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

		$dataProvider->sort->attributes['team_leader'] = [
            'asc' => ['team_leader' => SORT_ASC],
            'desc' => ['team_leader' => SORT_DESC],
        ];



        // grid filtering conditions
        $query->andFilterWhere([
            'date(osp_work_order.wo_date)' => $this->wo_date,
            'osp_work_order.installation_date' => $this->installation_date,
            'date(osp_work_order.created_date)' => $this->created_date,
            'date(osp_work_order.updated_date)' => $this->updated_date,
            'osp_work_order.id' => $this->id,
            'osp_work_order.id_planning_osp_boq_p' => $this->id_planning_osp_boq_p,
			'osp_work_order.created_by' => $this->created_by,
			'osp_work_order.updated_by' => $this->updated_by,
			'osp_work_order.status_material_need' => $this->status_material_need,
			'osp_work_order.status_transport' => $this->status_transport,
			'osp_work_order.status_team' => $this->status_team,
			'osp_work_order.status_tools' => $this->status_tools,
			'osp_work_order.status_material_used' => $this->status_material_used,
			'osp_work_order.status_grf' => $this->status_grf,
			'osp_work_order.status_listing' => $this->status_listing

        ]);

        $query->andFilterWhere(['ilike', 'osp_work_order.work_name', $this->work_name])
            ->andFilterWhere(['ilike', 'osp_work_order.prepared_by', $this->prepared_by])
            ->andFilterWhere(['ilike', 'osp_work_order.implemented_by', $this->implemented_by])
            ->andFilterWhere(['ilike', 'osp_work_order.passed_by', $this->passed_by])
            ->andFilterWhere(['ilike', 'osp_work_order.status_listing', $this->status_listing])
            ->andFilterWhere(['ilike', 'osp_work_order.wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'osp_work_order.revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'osp_work_order.location', $this->location])
			->andFilterWhere(['ilike', 'osp_team_member.name', $this->team_leader])
            ->andFilterWhere(['ilike', 'osp_work_order.note', $this->note]);

        return $dataProvider;
    }
}
