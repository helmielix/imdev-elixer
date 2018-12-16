<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Grf;

/**
 * SearchGrf represents the model behind the search form about `common\models\Grf`.
 */
class SearchGrf extends Grf
{
    /**
     * @inheritdoc
     */
    public $description;
    public function rules()
    {
        return [
            [['id', 'grf_type', 'created_by', 'updated_by', 'status_listing', 'pic', 'id_region', 'id_division', 'status_return'], 'integer'],
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
        $query = Grf::find();
        $query->select([ 
            'grf.id',
            'grf.grf_type',
            'grf.grf_number',
            'grf.wo_number',
            'grf.file_attachment_1',
            'grf.file_attachment_2',
            'grf.file_attachment_3',
            'grf.purpose',
            'grf.id_region',
            'grf.id_division',
            'grf.requestor as requestor',
            'grf.status_return',
            'grf.pic',
            'grf.id_modul',
            'grf.status_listing',

            ]);

        
        if($action == 'input'){
            $query  ->andFilterWhere(['grf.status_listing' => [1,2,3,6,7,39]]);
        }else if($action == 'verify'){
              $query->andFilterWhere(['or',['=','grf.status_listing', 1],['=','grf.status_listing', 4], ['=','grf.status_listing', 2]]);
        } else if ($action == 'approve'){
            $query->andFilterWhere(['or',['=','grf.status_listing', 4],['=','grf.status_listing', 5]]);
        }
        else if($action == 'inputothers'){
             $query  ->andFilterWhere(['grf.status_listing' => [1,2,3,6,7,39]])
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
        }else if($action == 'overviewothers') {
            $query->andFilterWhere(['!=','grf.status_listing', 13])
                  ->andFilterWhere(['source'=>'others']);
            // ->andWhere(['in','id_warehouse',$idWarehouse])
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC])
            
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
            'id' => $this->id,
            'grf_type' => $this->grf_type,
            'requestor' => $this->requestor,
            'created_by' => $this->created_by,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'grf.status_listing' => $this->status_listing,
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
