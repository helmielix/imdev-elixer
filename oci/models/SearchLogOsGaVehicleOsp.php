<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsGaVehicleOsp;
/**
 * SearchOsGaVehicleOsp represents the model behind the search form about `app\models\OsGaVehicleOsp`.
 */
class SearchLogOsGaVehicleOsp extends LogOsGaVehicleOsp
{
    /**
     * @inheritdoc
     */
    public $id_osp_work_order, $vehicle_type, $plate_number, $stdk_number;
    public function rules()
    {
        return [
            [[ 'id_osp_wo', 'created_by', 'updated_by', 'status_listing','id_osp_work_order'], 'integer'],
            [['created_date', 'updated_date', 'revision_remark','wo_number', 'stdk_number', 'vehicle_type', 'plate_number'], 'safe'],
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
        $query = LogOsGaVehicleOsp::find();
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
            'id_osp_wo' => $this->id_osp_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
        ]);
        $query

            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);
        return $dataProvider;
    }
    public function searchByAction($params, $action)
    {
         $query = LogOsGaVehicleOsp::find()->joinWith('idOspWo.ospWoActual',true,'FULL JOIN');
        $query->select([    'osp_work_order.id as id_osp_wo',
                            'osp_work_order.wo_number',
                            // 'os_ga_vehicle_osp.id_osp_wo',
                            'log_os_ga_vehicle_osp.status_listing',
                            'log_os_ga_vehicle_osp.created_date',
                            'log_os_ga_vehicle_osp.created_by',
                            'log_os_ga_vehicle_osp.updated_by',
                            'log_os_ga_vehicle_osp.updated_date',
                            'log_os_ga_vehicle_osp.revision_remark',
                            'log_os_ga_vehicle_osp.idlog',
                            ]);
        if($action == 'input') {
            $query ->andFilterWhere(['and',['=','osp_work_order.status_listing', 5],['!=','osp_wo_actual.status_listing', 5]]) 
                ->andWhere(['os_ga_vehicle_osp.status_listing' => null])
                ->orFilterWhere(['not in','os_ga_vehicle_osp.status_listing' , [4, 5]])
                 ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_osp.status_listing', 1],['=','os_ga_vehicle_osp.status_listing', 4], ['=','os_ga_vehicle_osp.status_listing', 2]])
                 ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_osp.status_listing', 4],['=','os_ga_vehicle_osp.status_listing', 5]])
                 ->orderBy(['os_ga_vehicle_osp.id_osp_wo' => SORT_DESC]);
        } else if ($action == 'log') {
            $query->andFilterWhere(['or',['=','log_os_ga_vehicle_osp.status_listing', 1],['=','log_os_ga_vehicle_osp.status_listing', 2],['=','log_os_ga_vehicle_osp.status_listing', 3],['=','log_os_ga_vehicle_osp.status_listing', 4],['=','log_os_ga_vehicle_osp.status_listing', 5],['=','log_os_ga_vehicle_osp.status_listing', 6],['=','log_os_ga_vehicle_osp.status_listing', 13]]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),
        ]);
        $dataProvider->sort->attributes['wo_number'] = [
            'asc' => ['osp_work_order.wo_number' => SORT_ASC],
            'desc' => ['osp_work_order.wo_number' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id_osp_wo' => $this->id_osp_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'log_os_ga_vehicle_osp.status_listing' => $this->status_listing,
        ]);
        $query
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['ilike', 'osp_work_order.wo_number', $this->wo_number]);
        return $dataProvider;
}
public function searchByIdOspWorkOrder($params, $idOspWorkOrder)
    {
        $query = LogOsGaVehicleOsp::find()
                ->select([
                            'log_os_ga_vehicle_osp.id_osp_wo',
                            'log_os_ga_vehicle_osp.status_listing',
                            'log_os_ga_vehicle_osp.created_date',
                            'log_os_ga_vehicle_osp.created_by',
                            'log_os_ga_vehicle_osp.updated_by',
                            'log_os_ga_vehicle_osp.updated_date',
                            'log_os_ga_vehicle_osp.revision_remark',
                            ]);
        $query->andWhere(['id_osp_wo'=>$idOspWorkOrder]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_osp_wo'=>SORT_ASC]]
        ]);
       // $dataProvider->sort->attributes['type'] = [
       //     'asc' => ['"tools"."type"' => SORT_ASC],
       //     'desc' => ['"tools"."type"' => SORT_DESC],
       // ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
       // grid filtering conditions
        $query->andFilterWhere([
            'id_osp_wo' => $this->id_osp_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'log_os_ga_vehicle_osp.status_listing' => $this->status_listing,
        ]);
        $query

            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);
        return $dataProvider;
    }
}
