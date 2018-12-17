<?php

namespace os\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IkoWorkOrder;

class SearchIkoWorkOrder extends IkoWorkOrder
{
    public $area, $material;

    public function rules()
    {
        return [
            [['wo_date', 'work_date', 'work_name', 'location', 'note', 'created_date', 'updated_date', 'wo_number', 'revision_remark', 'installation_date', 'area','total_personil','departure','team_leader'], 'safe'],
            [['id', 'status_team', 'status_tools', 'status_transport', 'status_material_need', 'status_grf', 'id_iko_itp_daily', 'created_by', 'updated_by', 'material'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	public function search($params)
    {
        $query = IkoWorkOrder::find();

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

	public function searchByAction($params, $action)
	{
		$query = IkoWorkOrder::find();

		if($action == 'input') {
            $query->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
				->select([  'iko_itp_daily.id as id_iko_itp_daily',
                            'area.id',
                            'iko_itp_daily.status_listing',
							'iko_work_order.work_date',
							'iko_work_order.work_name',
							'iko_work_order.location',
							'iko_work_order.status_listing',
							'iko_work_order.wo_date',
                            'iko_work_order.installation_date',
							'iko_work_order.wo_number',
							'iko_work_order.updated_date',
							'iko_work_order.id',])
                ->andFilterWhere(['=','iko_itp_daily.status_listing', 5])
                ->andFilterWhere(['in','iko_work_order.status_listing', [1,2,3,6,7]]);
        } else if ($action == 'verify') {
            $query->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
                ->andFilterWhere(['=','iko_work_order.status_tools', 1])
                ->andFilterWhere(['=','iko_work_order.status_material_need', 1])
                ->andFilterWhere(['=','iko_work_order.status_transport', 1])
                ->andFilterWhere(['or',['=','iko_work_order.status_listing', 1],['=','iko_work_order.status_listing', 4], ['=','iko_work_order.status_listing', 2]]);
        } else if ($action == 'approve') {
        	$query->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
                ->joinWith('ikoWoActual');
            $query->andFilterWhere(['=','iko_work_order.status_tools', 1])
                ->andFilterWhere(['=','iko_work_order.status_material_need', 1])
                ->andFilterWhere(['=','iko_work_order.status_transport', 1])
                ->andFilterWhere(['or',['=','iko_work_order.status_listing', 4],['=','iko_work_order.status_listing', 5]]);
            $query->andWhere(['iko_wo_actual.status_listing'=>null]);
        } else if ($action == 'overview') {
            $query->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
                ->select([  'iko_itp_daily.id as id_iko_itp_daily',
                            'area.id',
                            'iko_itp_daily.status_listing',
                            'iko_work_order.work_date',
                            'iko_work_order.work_name',
                            'iko_work_order.location',
                            'iko_work_order.status_listing',
                            'iko_work_order.wo_date',
                            'iko_work_order.installation_date',
                            'iko_work_order.created_date',
							'iko_work_order.updated_date',
                            'iko_work_order.wo_number',
                            'iko_work_order.id',])
                ->andFilterWhere(['=','iko_itp_daily.status_listing', 5])
                ->orderBy(['iko_work_order.created_date' => SORT_DESC]);
        } else if($action == 'inputwo') {
            $query->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
                ->select([  'iko_itp_daily.id as id_iko_itp_daily',
                            'area.id',
                            'iko_itp_daily.status_listing',
                            'iko_work_order.work_date',
                            'iko_work_order.work_name',
                            'iko_work_order.location',
                            'iko_work_order.status_listing',
                            'iko_work_order.wo_date',
                            'iko_work_order.installation_date',
                            'iko_work_order.wo_number',
                            'iko_work_order.updated_date',
                            'iko_work_order.id',])
                ->andFilterWhere(['=','iko_itp_daily.status_listing', 5])
                ->andFilterWhere(['in', 'iko_work_order.status_listing', [1,2,3,7]]);

		} else if ($action == 'inputvehicle') {
        	$query
			->joinWith('ikoWoActual',true,'FULL JOIN')
			// ->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
				->joinWith('idIkoTeamWo.idIkoTeam.ikoTeamMembers')
                ->joinWith('idIkoTeamWo.idlabor')
				->joinWith('ikoMaterialWos.idMaterial')
				->select([
				// 'iko_itp_daily.id as id_iko_itp_daily',
						// 'area.id',
						// 'iko_itp_daily.status_listing',
						'iko_work_order.work_date',
						'iko_work_order.work_name',
						'iko_work_order.location',
						'iko_work_order.status_listing',
						'iko_work_order.wo_date',
						'iko_work_order.installation_date',
						'iko_work_order.wo_number',
						'iko_work_order.updated_date',
						'iko_work_order.id',
						'iko_work_order.departure',
						'iko_team_wo.name as team_leader',
						// '(select iko_team.id from iko_work_order full join)'
						// 'iko_team.id'
						])
				  // ->andWhere(['not in','iko_work_order.id',$idIkoWo])
				  ->andFilterWhere(['=','iko_work_order.status_listing',5])
				  // ->andFilterWhere(['!=','iko_wo_actual.status_listings',5])
				  ->andWhere(['or', ['!=','iko_wo_actual.status_listing',5], ['iko_wo_actual.status_listing' => null]])
				  // -> orderBy('iko_work_order.id asc')
                  ;


	    }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

    public function searchByActionStatusGRF($params, $action)
    {
        $query = IkoWorkOrder::find()->joinWith('idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea');

        if($action == 'input') {
            $query->andFilterWhere(['=','iko_work_order.status_listing', 5])
                // ->andFilterWhere(['=','iko_work_order.status_im', 5])
                ->andFilterWhere(['not in','iko_work_order.status_grf' , [4, 5, 999]]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['=','iko_work_order.status_listing', 5])
                // ->andFilterWhere(['=','iko_work_order.status_im', 5])
                ->andFilterWhere(['or',['=','iko_work_order.status_grf', 1],['=','iko_work_order.status_grf', 4], ['=','iko_work_order.status_grf', 2]]);
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['=','iko_work_order.status_listing', 5])
                // ->andFilterWhere(['=','iko_work_order.status_im', 5])
                ->andFilterWhere(['or',['=','iko_work_order.status_grf', 4],['=','iko_work_order.status_grf', 5]]);
        }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }



	private function _search($params, $query) {

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['area'] = [
            'asc' => ['area.id' => SORT_ASC],
            'desc' => ['area.id' => SORT_DESC],
        ];

		$dataProvider->sort->attributes['team_leader'] = [
            'asc' => ['team_leader' => SORT_ASC],
            'desc' => ['team_leader' => SORT_DESC],
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
            'wo_date' => $this->wo_date,
            'date(iko_work_order.created_date)' => $this->created_date,
            'date(iko_work_order.updated_date)' => $this->updated_date,
            'id' => $this->id,
            'id_iko_itp_daily' => $this->id_iko_itp_daily,
            'iko_work_order.installation_date' => $this->installation_date,
			'iko_work_order.status_listing' => $this->status_listing,
			'iko_work_order.created_by' => $this->created_by,
			'iko_work_order.updated_by' => $this->updated_by,
            'status_team' => $this->status_team,
            'status_tools' => $this->status_tools,
            'status_transport' => $this->status_transport,
            'status_material_need' => $this->status_material_need,
            'status_grf' => $this->status_grf,
            'work_name' => $this->work_name,
            '(departure)' => $this->departure,
            '(material.id)' => $this->material,
        ]);

        if (is_numeric($this->total_personil)) {
            $total = $this->total_personil - 1;
            $query->groupBy('iko_work_order.work_date, iko_work_order.work_name, iko_work_order.location,
            iko_work_order.status_listing, iko_work_order.wo_date, iko_work_order.installation_date,
            iko_work_order.wo_number, iko_work_order.updated_date, iko_work_order.id, iko_team_wo.name');
            $query->having("count(iko_team_member.id_iko_team) = :count", [":count" => $total]);
        }

        $query->andFilterWhere(['ilike', 'work_date', $this->work_date])
            ->andFilterWhere(['ilike', 'iko_work_order.location', $this->location])
            ->andFilterWhere(['ilike', 'note', $this->note])
            ->andFilterWhere(['ilike', 'wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'iko_team_wo.name', $this->team_leader])
            ->andFilterWhere(['ilike', 'area.id', $this->area]);

        return $dataProvider;
	}
}
