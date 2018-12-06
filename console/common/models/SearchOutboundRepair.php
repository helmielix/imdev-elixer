<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundRepair;

/**
 * SearchOutboundRepair represents the model behind the search form about `common\models\OutboundRepair`.
 */
class SearchOutboundRepair extends OutboundRepair
{
    public $instruction_number, $target_pengiriman, $wh_destination, $wh_origin;
    public function rules()
    {
        return [
            [['id_instruction_repair', 'driver', 'created_by', 'status_listing', 'updated_by', 'forwarder', 'id_modul', 'wh_destination', 'wh_origin'], 'integer'],
            [['no_sj', 'plate_number', 'created_date', 'updated_date', 'revision_remark', 'instruction_number', 'target_pengiriman'], 'safe'],
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

    
    public function search($params, $id_modul, $action){
        $query = OutboundRepair::find();
		$query->joinWith('idInstructionRepair', true, 'FULL JOIN');
		$query->select([
			'instruction_repair.instruction_number',
			'instruction_repair.target_pengiriman',
			// 'instruction_repair.wh_destination',
			'instruction_repair.id as id_instruction_repair',
			'outbound_repair.status_listing',
			'outbound_repair.no_sj',
			'outbound_repair.created_date',
			'outbound_repair.updated_date',
		]);
		
		if($action == 'tagsn'){
			$query	->andFilterWhere(['instruction_repair.status_listing' => 5])
					->andFilterWhere(['instruction_repair.id_modul' => $id_modul])
					->andWhere(['outbound_repair.status_listing' => null])
					->orFilterWhere(['and',['outbound_repair.id_modul' => $id_modul],['not in', 'outbound_repair.status_listing', [5]]])
					;
		}else if($action == 'printsj'){
			$query	->andFilterWhere(['outbound_repair.status_listing' => [42, 3, 22, 25]]);
			$query	->andFilterWhere(['outbound_repair.id_modul' => $id_modul]);
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
		
		$dataProvider->sort->attributes['instruction_number'] = [
            'asc' => ['instruction_repair.instruction_number' => SORT_ASC],
            'desc' => ['instruction_repair.instruction_number' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['target_pengiriman'] = [
            'asc' => ['instruction_repair.target_pengiriman' => SORT_ASC],
            'desc' => ['instruction_repair.target_pengiriman' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['wh_destination'] = [
            'asc' => ['instruction_repair.wh_destination' => SORT_ASC],
            'desc' => ['instruction_repair.wh_destination' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['wh_origin'] = [
            'asc' => ['instruction_repair.wh_origin' => SORT_ASC],
            'desc' => ['instruction_repair.wh_origin' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		if ($this->status_listing == 999) {
            $query->andFilterWhere(['instruction_repair.status_listing' => 5])
                ->andWhere(['outbound_repair.status_listing' => null]);
        }else {
            $query->andFilterWhere(['outbound_repair.status_listing' => $this->status_listing,]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_instruction_repair' => $this->id_instruction_repair,
            'driver' => $this->driver,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'forwarder' => $this->forwarder,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'date(target_pengiriman)' => $this->target_pengiriman,
            'id_modul' => $this->id_modul,
        ]);

        $query->andFilterWhere(['ilike', 'no_sj', $this->no_sj])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number]);

        return $dataProvider;
    }
}
