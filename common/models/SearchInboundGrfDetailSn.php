<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundGrfDetailSn;

/**
 * SearchInboundGrfDetailSn represents the model behind the search form about `common\models\InboundGrfDetailSn`.
 */
class SearchInboundGrfDetailSn extends InboundGrfDetailSn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_grf_detail', 'sn','created_by', 'updated_by', 'status_listing','grf_type','pic'], 'integer'],
             [[ 'created_date', 'updated_date', 'grf_number','wo_number','id_division'], 'safe'],
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
        $query = InboundGrfDetailSn::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
    }
        public function searchByAction($params, $id_modul, $action)
        {
        $query = InboundGrfDetailSn::find();
        // $query->joinWith('idGrf.idDivision');
        $query->joinWith('idInboundGrfDetail.idInboundGrf.idGrf.idGrfDetail.idOrafinCode', true,'FULL JOIN');
        $query->select([ 
            'inbound_grf_detail. id as id_inbound_grf_detail',
            'grf.grf_type',
            'grf.grf_number',
            'grf.wo_number',
            'grf.file_attachment_1',
            'grf.file_attachment_2',
            'grf.purpose',
            'grf.id_region',
            'grf.id_division',
            'grf.requestor',
            'grf.pic',
            'grf.id_modul',
            // 'grf.id as id',
            'inbound_grf.created_date',
            'inbound_grf.updated_date',
            'inbound_grf.status_listing',
            // 'division.nama',
        ]);

        if($action == 'sn'){
            $query  ->andFilterWhere(['grf.grf_type' => [20,19]]);
            $query  ->andFilterWhere(['inbound_grf.status_listing' => [ 5 ]]);
        }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
        }

         public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->status_listing == 999) {
            $query->andFilterWhere(['grf.status_listing' => 5])
                ->andWhere(['inbound_grf.status_listing' => null]);
        }else {
            $query->andFilterWhere(['inbound_grf.status_listing' => $this->status_listing,]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

       $query->andFilterWhere(['ilike', 'grf.grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'grf.wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'grf.purpose', $this->purpose])
            ->andFilterWhere(['ilike', 'division.nama', $this->id_division]);

        return $dataProvider;
    }
}
