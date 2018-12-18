<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogInstructionGrf;

/**
 * SearchLogInstructionGrf represents the model behind the search form about `common\models\LogInstructionGrf`.
 */
class SearchLogInstructionGrf extends LogInstructionGrf
{
    /**
     * @inheritdoc
     */
    public $grf_type, $grf_number, $wo_number, $file_attacment_1, $file_attacment_2, $purpose, $id_region, $id_division, $requestor, $pic;
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing', 'id_modul', 'id_grf', 'id_warehouse', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date', 'note', 'date_of_return', 'revision_remark', 'grf_number', 'id_division', 'grf_type', 'wo_number', 'requestor'], 'safe'],
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
        $query = LogInstructionGrf::find();
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
            'log_instruction_grf.idlog',
            // 'instruction_grf.created_date',
            // 'instruction_grf.updated_date',
            // 'instruction_grf.status_listing',
            // 'division.nama',
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['grf_number'] = [
            'asc' => ['grf.grf_number' => SORT_ASC],
            'desc' => ['grf.grf_number' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['id_division'] = [
            'asc' => ['grf.id_division' => SORT_ASC],
            'desc' => ['grf.id_division' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['id_region'] = [
            'asc' => ['grf.id_region' => SORT_ASC],
            'desc' => ['grf.id_region' => SORT_DESC],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'incoming_date' => $this->incoming_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'id_modul' => $this->id_modul,
            'id_grf' => $this->id_grf,
            'id_warehouse' => $this->id_warehouse,
            'date_of_return' => $this->date_of_return,
            'status_return' => $this->status_return,
            'requestor' => $this->requestor,
            'grf_type' => $this->grf_type,
            'division.id' => $this->id_division,
            'grf.id_region' => $this->id_region,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['ilike', 'grf.grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'grf.wo_number', $this->wo_number])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
