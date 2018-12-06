<?php

namespace common\models;

// MASIH HARUS DIEDIT!!!
// SORT MUNGKIN MASIH BERMASALAH!!!

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchInboundRepair represents the model behind the search form about `common\models\InboundRepair`.
 */
class SearchInboundRepair extends InboundRepair
{
    public $instruction_number, $target_pengiriman, $vendor_repair;
    public function rules()
    {
        return [
            [['id_instruction_repair', 'driver', 'created_by', 'status_listing', 'tagging', 'updated_by', 'forwarder', 'id_modul', 'wh_destination', 'wh_origin'], 'integer'],
            [['no_sj', 'plate_number', 'created_date', 'updated_date', 'revision_remark', 'instruction_number', 'target_pengiriman', 'vendor_repair'], 'safe'],
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
        $query = InboundRepair::find();
		$query->joinWith(['instructionRepair', 'instructionRepair.idVendor'], true, 'INNER JOIN');
		$query->joinWith(['statusReference']);
        $query->select([
            'instruction_repair.instruction_number',
            'instruction_repair.vendor_repair',
            'instruction_repair.id as id_instruction_repair',
            'inbound_repair.status_listing',
            'inbound_repair.created_date',
            'inbound_repair.no_sj',
            'inbound_repair.tanggal_datang',
            'inbound_repair.tagging',
            'vendor.name',
            //'instruction_repair.target_pengiriman',
            // 'instruction_repair.wh_destination',
            //'inbound_repair.created_date',
            //'inbound_repair.updated_date',
        ]);
//         echo $query->createCommand()->getRawSql();
		
//		if($action == 'tagsn'){
//			$query->joinWith('taggingList', true, 'INNER JOIN');
//		}
		
		$dataProvider = $this->_search($params, $query, $action);

        return $dataProvider;
	}
	
    public function _search($params, $query, $action)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['created_date'=>SORT_DESC]]
        ]);
		
		$dataProvider->sort->attributes['instruction_number'] = [
            'asc' => ['instruction_repair.instruction_number' => SORT_ASC],
            'desc' => ['instruction_repair.instruction_number' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['tanggal_datang'] = [
            'asc' => ['inbound_repair.tanggal_datang' => SORT_ASC],
            'desc' => ['inbound_repair.tanggal_datang' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['no_sj'] = [
            'asc' => ['inbound_repair.no_sj' => SORT_ASC],
            'desc' => ['inbound_repair.no_sj' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['vendor'] = [
            'asc' => ['vendor.name' => SORT_ASC],
            'desc' => ['vendor.name' => SORT_DESC],
        ];


        /*$dataProvider->sort->attributes['wh_destination'] = [
            'asc' => ['instruction_repair.wh_destination' => SORT_ASC],
            'desc' => ['instruction_repair.wh_destination' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['wh_origin'] = [
            'asc' => ['instruction_repair.wh_origin' => SORT_ASC],
            'desc' => ['instruction_repair.wh_origin' => SORT_DESC],
        ];*/
        /*$dataProvider->sort->attributes['vendor_repair'] = [
            'asc' => ['instruction_repair.vendor_repair' => SORT_ASC],
            'desc' => ['instruction_repair.vendor_repair' => SORT_DESC],
        ];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		/*if ($this->status_listing == 999) {
            $query->andFilterWhere(['instruction_repair.status_listing' => 5])
                ->andWhere(['inbound_repair.status_listing' => null]);
        }else {
            $query->andFilterWhere(['inbound_repair.status_listing' => $this->status_listing,]);
        }*/

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id_instruction_repair' => $this->id_instruction_repair,
            'driver' => $this->driver,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'forwarder' => $this->forwarder,
            'date(created_date)' => $this->created_date,
            'date(updated_date)' => $this->updated_date,
            'date(target_pengiriman)' => $this->target_pengiriman,
            'id_modul' => $this->id_modul,
        ]);*/

        echo $this->status_listing;

        $query->andFilterWhere([
            'inbound_repair.status_listing' => $this->status_listing,
            'no_sj' => $this->no_sj,
            'tanggal_datang' => $this->tanggal_datang,
            'vendor' => $this->vendor,
        ]);

        /*$query->andFilterWhere(['ilike', 'no_sj', $this->no_sj])
            ->andFilterWhere(['ilike', 'plate_number', $this->plate_number]); */

        return $dataProvider;
    }
}
