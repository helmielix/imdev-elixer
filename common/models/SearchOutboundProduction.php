<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundProduction;

/**
 * SearchOutboundProduction represents the model behind the search form about `common\models\OutboundProduction`.
 */
class SearchOutboundProduction extends OutboundProduction
{
    public $instruction_number, $delivery_target_date, $wh_destination, $wh_origin, $id_modul;
    public function rules()
    {
        return [
            [['id_instruction_production', 'driver', 'created_by', 'status_listing', 'updated_by', 'forwarder', 'id_modul'], 'integer'],
            [['no_sj', 'plate_number', 'created_date', 'updated_date', 'revision_remark', 'instruction_number', 'delivery_target_date', 'wh_destination', 'wh_origin'], 'safe'],
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


    public function search($params, $id_modul, $action, $id_warehouse){
        $query = OutboundProduction::find();
		$query->joinWith('idInstructionProduction', true, 'FULL JOIN');
        // ->leftJoin('warehouse wori', 'instruction_production.wh_origin = wori.id')
        // ->leftJoin('warehouse wdest', 'instruction_production.wh_destination = wdest.id');
		$query->select([
			'instruction_production.instruction_number',
			// 'instruction_production.delivery_target_date',
			'instruction_production.id_warehouse',
			'instruction_production.id as id_instruction_production',
			'outbound_production.status_listing',
			'outbound_production.no_sj',
			'outbound_production.created_date',
			'outbound_production.updated_date',
		]);

		if($action == 'tagsn'){
			$query	->andFilterWhere(['instruction_production.status_listing' => 5])
					->andFilterWhere(['instruction_production.id_modul' => $id_modul])
					->andWhere(['outbound_production.status_listing' => null])
					->orFilterWhere(['and',['outbound_production.id_modul' => $id_modul],['not in', 'outbound_production.status_listing', [5, 25, 22]]])
					// ->andWhere(['instruction_production.wh_origin' => $id_warehouse])
					;
		}else if($action == 'printsj'){
			$query	->andFilterWhere(['outbound_production.status_listing' => [42, 2, 22, 25, 1]]);
			$query	->andFilterWhere(['outbound_production.id_modul' => $id_modul]);
			// $query	->andWhere(['instruction_production.wh_origin' => $id_warehouse]);
			
		}else if($action == 'approve'){
			$query	->andFilterWhere(['outbound_production.status_listing' => [22, 25]]);
			$query	->andFilterWhere(['outbound_production.id_modul' => $id_modul]);
			// $query	->andWhere(['instruction_production.wh_origin' => $id_warehouse]);
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
            'asc' => ['instruction_production.instruction_number' => SORT_ASC],
            'desc' => ['instruction_production.instruction_number' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['delivery_target_date'] = [
            'asc' => ['instruction_production.delivery_target_date' => SORT_ASC],
            'desc' => ['instruction_production.delivery_target_date' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['wh_destination'] = [
            'asc' => ['instruction_production.wh_destination' => SORT_ASC],
            'desc' => ['instruction_production.wh_destination' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['wh_origin'] = [
            'asc' => ['instruction_production.wh_origin' => SORT_ASC],
            'desc' => ['instruction_production.wh_origin' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		if ($this->status_listing == 999) {
            $query->andFilterWhere(['instruction_production.status_listing' => 5])
                ->andWhere(['outbound_production.status_listing' => null]);
        }else {
            $query->andFilterWhere(['outbound_production.status_listing' => $this->status_listing,]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_instruction_production' => $this->id_instruction_production,
            'driver' => $this->driver,
            'outbound_production.created_by' => $this->created_by,
            'outbound_production.updated_by' => $this->updated_by,
            'forwarder' => $this->forwarder,
            'date(outbound_production.created_date)' => $this->created_date,
            'date(outbound_production.updated_date)' => $this->updated_date,
            'date(delivery_target_date)' => $this->delivery_target_date,
            'outbound_production.id_modul' => $this->id_modul,
        ]);

        $query->andFilterWhere(['ilike', 'no_sj', $this->no_sj])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number])
            ->andFilterWhere(['ilike', 'instruction_number', $this->instruction_number])
            ->andFilterWhere(['ilike', 'wdest.nama_warehouse', $this->wh_destination])
            ->andFilterWhere(['ilike', 'wori.nama_warehouse', $this->wh_origin])
            ;

        return $dataProvider;
    }
}
