<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionGrf;

/**
 * SearchInstructionGrf represents the model behind the search form about `common\models\InstructionGrf`.
 */
class SearchInstructionGrf extends InstructionGrf
{
    /**
     * @inheritdoc
     */
    public $grf_type, $grf_number, $wo_number, $file_attacment_1, $file_attacment_2, $purpose, $id_region, $id_division, $requestor, $pic;
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing','grf_type','pic', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date', 'note','grf_number','wo_number','id_division','requestor'], 'safe'],
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
    public function search($params, $id_modul, $action)
    {
        $query = InstructionGrf::find();
        $query->joinWith('idGrf.idDivision');
        // $query->joinWith('idGrf', true, 'FULL JOIN');
        $query->select([ 
            'grf.grf_type',
            'grf.grf_number',
            'grf.wo_number',
            'grf.file_attachment_1',
            'grf.file_attachment_2',
            'grf.file_attachment_3',
            'grf.purpose',
            'grf.id_region',
            'grf.id_division',
            'grf.requestor',
            'grf.status_return',
            'grf.status_listing',
            'grf.pic',
            'grf.id_modul',
            'grf.id as id',
            'instruction_grf.created_date',
            'instruction_grf.updated_date',
            'instruction_grf.status_listing',
            // 'division.nama',
        ]);

        if($action == 'input'){
            $query  ->andFilterWhere(['grf.status_listing' => 5])
                    ->andWhere(['instruction_grf.status_listing' => null])
                    ->orFilterWhere(['and',['instruction_grf.id_modul' => $id_modul],['not in', 'instruction_grf.status_listing', [5]]]);
        }else if($action == 'verify'){
            $query  ->andFilterWhere(['instruction_grf.status_listing' => [1,2,4 ]]);
        }else if($action == 'approve'){
            $query  ->andFilterWhere(['instruction_grf.status_listing' => [4,5 ]]);
        }else if($action == 'asset'){
            $query  ->andFilterWhere(['grf.grf_type' => [20]]);
            $query  ->andFilterWhere(['instruction_grf.status_listing' => [ 5 ]]);
        }else if($action == 'sn'){
            $query  ->andFilterWhere(['grf.grf_type' => [20,19]]);
            $query  ->andFilterWhere(['instruction_grf.status_listing' => [ 5 ]]);
        }
        // add conditions that should always apply here

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
        }
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        // $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

    

         public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);
        
        $dataProvider->sort->attributes['grf_number'] = [
            'asc' => ['grf.grf_number' => SORT_ASC],
            'desc' => ['grf.grf_number' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['id_division'] = [
            'asc' => ['grf.id_division' => SORT_ASC],
            'desc' => ['grf.id_division' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['grf_type'] = [
            'asc' => ['grf.grf_type' => SORT_ASC],
            'desc' => ['grf.grf_type' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['wo_number'] = [
            'asc' => ['grf.wo_number' => SORT_ASC],
            'desc' => ['grf.wo_number' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['requestor'] = [
            'asc' => ['grf.requestor' => SORT_ASC],
            'desc' => ['grf.requestor' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->status_listing == 999) {
            $query->andFilterWhere(['grf.status_listing' => 5])
                ->andWhere(['instruction_grf.status_listing' => null]);
        }else {
            $query->andFilterWhere(['instruction_grf.status_listing' => $this->status_listing]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'status_return' => $this->status_return,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'requestor' => $this->requestor,
            'grf_type' => $this->grf_type,
            'division.id' => $this->id_division,
        ]);

       $query->andFilterWhere(['ilike', 'grf.grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'grf.wo_number', $this->wo_number])
            ->andFilterWhere(['ilike', 'grf.purpose', $this->purpose])
            // ->andFilterWhere(['ilike', 'division.nama', $this->id_division])
            ;

        return $dataProvider;
    }
}
