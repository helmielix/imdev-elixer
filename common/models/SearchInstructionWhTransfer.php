<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchInstructionWhTransfer extends InstructionWhTransfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status_listing','updated_by'], 'integer'],
            [['delivery_target_date', 'file_attachment', 'created_date', 'updated_date', 'grf_number', 'instruction_number', 'wh_destination', 'wh_origin'], 'safe'],
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
		$query = InstructionWhTransfer::find()->andWhere(['instruction_wh_transfer.id_modul' => $id_modul])
			->leftJoin('warehouse wori', 'instruction_wh_transfer.wh_origin = wori.id')
			->leftJoin('warehouse wdest', 'instruction_wh_transfer.wh_destination = wdest.id');
		// $query->joinWith('whDestination');
		// $query->joinWith('whOrigin');
		
		if($action == 'input'){
			$query	->andFilterWhere(['instruction_wh_transfer.status_listing' => [ 1,2,3,6,7, 47 ]]);
		}else if($action == 'approve'){
			$query	->andFilterWhere(['instruction_wh_transfer.status_listing' => [ 1,2,5 ]]);
			$query	->joinWith('outboundWhTransfer');
			$query	->andWhere(['outbound_wh_transfer.status_listing' => null]);
		}else if($action == 'overview'){
            $query  ->andFilterWhere(['not in','instruction_wh_transfer.status_listing' , [ 13 ]]);
        }
		
		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}
	
    public function _search($params, $query)
    {        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
            'sort'=> [
                    'attributes' => [
                        'status_listing',
                        'instruction_number',
                        'delivery_target_date',
                        'wh_origin',
                        'wh_destination',
                        'created_date',                        
                        'updated_date'  ,
                        'updated_by'  ,
                    ],
                    'defaultOrder' => ['created_date'=>SORT_DESC]
                ],			
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
            'created_by' => $this->created_by,
            'instruction_wh_transfer.updated_by' => $this->updated_by,
            'instruction_wh_transfer.status_listing' => $this->status_listing,
            // 'wh_destination' => $this->wh_destination,
            'date(delivery_target_date)' => $this->delivery_target_date,
            'date(instruction_wh_transfer.created_date)' => $this->created_date,
            'date(instruction_wh_transfer.updated_date)' => $this->updated_date,
            // 'wh_origin' => $this->wh_origin,
        ]);

        $query->andFilterWhere(['like', 'file_attachment', $this->file_attachment])
            ->andFilterWhere(['ilike', 'grf_number', $this->grf_number])
            ->andFilterWhere(['ilike', 'instruction_number', $this->instruction_number])
            ->andFilterWhere(['ilike', 'wdest.nama_warehouse', $this->wh_destination])
            ->andFilterWhere(['ilike', 'wori.nama_warehouse', $this->wh_origin])
			;

        return $dataProvider;
    }
}
