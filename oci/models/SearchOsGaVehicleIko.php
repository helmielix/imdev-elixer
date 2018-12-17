<?php
namespace os\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsGaVehicleIko;
/**
 * SearchOsGaVehicleIko represents the model behind the search form about `app\models\OsGaVehicleIko`.
 */
class SearchOsGaVehicleIko extends OsGaVehicleIko
{
    /**
     * @inheritdoc
     */
    public $id_iko_work_order, $vehicle_type, $plate_number, $stdk_number;
    public function rules()
    {
        return [
            [[ 'id_iko_wo', 'created_by', 'updated_by', 'status_listing','id_iko_work_order'], 'integer'],
            [['created_date', 'updated_date', 'revision_remark','wo_number','plate_number' ,'stdk_number', 'vehicle_type'], 'safe'],
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
        $query = OsGaVehicleIko::find();
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
            'id_iko_wo' => $this->id_iko_wo,
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
         $query = OsGaVehicleIko::find()->joinWith('idIkoWo.ikoWoActual',true,'FULL JOIN');
         $query->joinWith('osGaVehicleIkoDetails.idOsGaVehicleParameter.referenceVehicleType',true,'FULL JOIN');
        $query->select([    'iko_work_order.id as id_iko_wo',
                            'iko_work_order.wo_number',
                            // 'os_ga_vehicle_iko.id_iko_wo',
                            'os_ga_vehicle_iko.status_listing',
                            'os_ga_vehicle_iko.created_date',
                            'os_ga_vehicle_iko.created_by',
                            'os_ga_vehicle_iko.updated_by',
                            'os_ga_vehicle_iko.updated_date',
                            'os_ga_vehicle_iko.revision_remark',
                            ]);
        // $query->andFilterWhere(['os_ga_vehicle_iko.status_listing' => 1]);
        if($action == 'input') {
            $query ->andFilterWhere(['and',['=','iko_work_order.status_listing', 5],['!=','iko_wo_actual.status_listing', 5]])
                ->andWhere(['os_ga_vehicle_iko.status_listing' => null])
                ->orFilterWhere(['not in','os_ga_vehicle_iko.status_listing' , [4, 5]])
                 // ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC])
                 ;
        } else if ($action == 'verify') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_iko.status_listing', 1],['=','os_ga_vehicle_iko.status_listing', 4], ['=','os_ga_vehicle_iko.status_listing', 2]])
                 // ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC])
                 ;
        }
        else if ($action == 'approve') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_iko.status_listing', 4],['=','os_ga_vehicle_iko.status_listing', 5]])
                 // ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC])
                 ;
        } else if ($action == 'overview') {
            $query->andFilterWhere(['or',['=','os_ga_vehicle_iko.status_listing', 4],['=','os_ga_vehicle_iko.status_listing', 5],['=','os_ga_vehicle_iko.status_listing', 6],['=','os_ga_vehicle_iko.status_listing', 1],['=','os_ga_vehicle_iko.status_listing', 2],['=','os_ga_vehicle_iko.status_listing', 3]])
                 // ->orderBy(['os_ga_vehicle_iko.id_iko_wo' => SORT_DESC])
                 ;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),
        ]);
        $dataProvider->sort->attributes['wo_number'] = [
            'asc' => ['iko_work_order.wo_number' => SORT_ASC],
            'desc' => ['iko_work_order.wo_number' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // if (isset($this->vehicle_type)) {
        //     $query->andFilterWhere(['ilike','os_ga_vehicle_parameter.vehicle_type',$this->vehicle_type]);
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_iko_wo' => $this->id_iko_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_ga_vehicle_iko.status_listing' => $this->status_listing,
            // 'os_ga_vehicle_parameter.id' => $this->vehicle_type,
        ]);
        $query
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['=','reference.id',$this->vehicle_type])
            ->andFilterWhere(['ilike','os_ga_vehicle_parameter.plate_number',$this->plate_number])
            ->andFilterWhere(['ilike','os_ga_vehicle_iko_detail.stdk_number',$this->stdk_number])
            ->andFilterWhere(['ilike', 'iko_work_order.wo_number', $this->wo_number]);
        return $dataProvider;
}
public function searchByIdIkoWorkOrder($params, $idIkoWorkOrder)
    {
        $query = OsGaVehicleIko::find()
                ->select([
                            'os_ga_vehicle_iko.id_iko_wo',
                            'os_ga_vehicle_iko.status_listing',
                            'os_ga_vehicle_iko.created_date',
                            'os_ga_vehicle_iko.created_by',
                            'os_ga_vehicle_iko.updated_by',
                            'os_ga_vehicle_iko.updated_date',
                            'os_ga_vehicle_iko.revision_remark',
                            ]);
        $query->andWhere(['id_iko_wo'=>$idIkoWorkOrder]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_iko_wo'=>SORT_ASC]]
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
            'id_iko_wo' => $this->id_iko_wo,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'os_ga_vehicle_iko.status_listing' => $this->status_listing,
        ]);
        $query

            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);
        return $dataProvider;
    }
}
