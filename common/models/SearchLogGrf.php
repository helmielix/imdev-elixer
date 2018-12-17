<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogGrf;

/**
 * SearchGrf represents the model behind the search form about `common\models\Grf`.
 */
class SearchLogGrf extends LogGrf
{
    /**
     * @inheritdoc
     */
    public $description;
    public function rules()
    {
        return [
            [['idlog','id', 'grf_type', 'created_by', 'updated_by', 'status_listing', 'pic', 'id_region', 'id_division', 'status_return'], 'integer'],
            [['grf_number', 'wo_number', 'file_attachment_1', 'file_attachment_2','file_attachment_3','purpose', 'created_date', 'updated_date','grf_type_des','requestor'], 'safe'],
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
    

    public function search($params,  $action){
        $query = LogGrf::find();
        $query->select([ 
            'log_grf.idlog',
            'log_grf.id',
            'log_grf.grf_type',
            'log_grf.grf_number',
            'log_grf.wo_number',
            'log_grf.file_attachment_1',
            'log_grf.file_attachment_2',
            'log_grf.file_attachment_3',
            'log_grf.purpose',
            'log_grf.id_region',
            'log_grf.id_division',
            'log_grf.requestor as requestor',
            'log_grf.status_return',
            'log_grf.pic',
            'log_grf.id_modul',
            'log_grf.status_listing',

            ]);

        
        if($action == 'input'){
            $query  ->andFilterWhere(['grf.status_listing' => [1,2,3,6,7,39]]);
        }else if($action == 'verify'){
              $query->andFilterWhere(['or',['=','grf.status_listing', 1],['=','grf.status_listing', 4], ['=','grf.status_listing', 2]]);
        } else if ($action == 'approve'){
            $query->andFilterWhere(['or',['=','grf.status_listing', 4],['=','grf.status_listing', 5]]);
        }
        else if($action == 'inputothers'){
              $query->andFilterWhere(['or',['=','grf.status_listing', 1],['=','grf.status_listing', 3], ['=','grf.status_listing', 2]])
                    ->andFilterWhere(['source'=>'others']);
        }else if($action == 'verifyothers'){
              $query->andFilterWhere(['or',['=','grf.status_listing', 1],['=','grf.status_listing', 4], ['=','grf.status_listing', 2]])
              ->andFilterWhere(['source'=>'others']);
        }else if ($action == 'approveothers'){
            $query->andFilterWhere(['or',['=','grf.status_listing', 4],['=','grf.status_listing', 5]])
            ->andFilterWhere(['source'=>'others']);
        }else if($action == 'overview') {
            $query->andFilterWhere(['!=','grf.status_listing', 13])
            // ->andWhere(['in','id_warehouse',$idWarehouse])
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
            ;
        }else if ($action == 'logothers'){
            $query->andFilterWhere(['source'=>'others']);
            
        }else if ($action == 'log'){
            $query->andFilterWhere(['source'=>'ikr']);
            
        }
        
        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

    public function _search($params,  $query)
    {
        // $query = Grf::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]],
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idlog' => $this->idlog,
            'id' => $this->id,
            'grf_type' => $this->grf_type,
            'requestor' => $this->requestor,
            'created_by' => $this->created_by,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'log_grf.status_listing' => $this->status_listing,
            'status_return' => $this->status_return,
            'pic' => $this->pic,
            'id_region' => $this->id_region,
            'id_division' => $this->id_division,
        ]);

        $query->andFilterWhere(['ilike', 'grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'purpose', $this->purpose]);

        return $dataProvider;
    }
}
