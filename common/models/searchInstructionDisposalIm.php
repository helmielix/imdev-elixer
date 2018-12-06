<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionDisposalIm;

/**
 * searchInstructionDisposalIm represents the model behind the search form about `common\models\InstructionDisposalIm`.
 */
class searchInstructionDisposalIm extends InstructionDisposalIm
{
    /**
     * @inheritdoc
     */
    public $warehouse;
    public $instruction_number;
    public $no_iom; 
    public $buyer;
    public function rules()
    {
        return [
            [['id_disposal_am', 'created_by', 'updated_by', 'status_listing','id_modul'], 'integer'],
            [['created_date', 'updated_date', 'target_pelaksanaan','warehouse','instruction_number','no_iom','buyer'], 'safe'],
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
   public function search($params, $id_modul, $action){
        $query = InstructionDisposalIm::find();
        $query->joinWith('idDisposalAm', true, 'FULL JOIN');
        $query->select([
            'instruction_disposal.instruction_number',
            'instruction_disposal.no_iom',
            'instruction_disposal.warehouse',
            'instruction_disposal.buyer',
            'instruction_disposal.estimasi_disposal',
            'instruction_disposal.date_iom',
            'instruction_disposal.id as id_disposal_am',
            'instruction_disposal_im.status_listing',
            'instruction_disposal_im.created_date',
            'instruction_disposal_im.updated_date',
        ]);
        
        if($action == 'input'){
            $query  ->andFilterWhere(['instruction_disposal.status_listing' => 5])
                    ->andFilterWhere(['instruction_disposal.id_modul' => $id_modul])
                    ->andWhere(['instruction_disposal_im.status_listing' => null])
                    ->orFilterWhere(['and',['instruction_disposal_im.id_modul' => $id_modul],['not in', 'instruction_disposal_im.status_listing', [5]]])
                    ;
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
        
        // $dataProvider->sort->attributes['instruction_number'] = [
        //     'asc' => ['instruction_wh_transfer.instruction_number' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.instruction_number' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['delivery_target_date'] = [
        //     'asc' => ['instruction_wh_transfer.delivery_target_date' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.delivery_target_date' => SORT_DESC],
        // ];
        // $dataProvider->sort->attributes['wh_destination'] = [
        //     'asc' => ['instruction_wh_transfer.wh_destination' => SORT_ASC],
        //     'desc' => ['instruction_wh_transfer.wh_destination' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->status_listing == 999) {
            $query->andFilterWhere(['instruction_disposal.status_listing' => 5])
                ->andWhere(['instruction_disposal_im.status_listing' => null]);
        }else {
            $query->andFilterWhere(['instruction_disposal_im.status_listing' => $this->status_listing,]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_disposal_am' => $this->id_disposal_am,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status_listing' => $this->status_listing,
            'target_pelaksanaan' => $this->target_pelaksanaan,
            'warehouse' => $this->warehouse,
            'buyer' => $this->buyer,
            'instruction_number' => $this->instruction_number,
            'no_iom' => $this->no_iom,
            'id_modul' => $this->id_modul,
        ]);

        return $dataProvider;
    }
}
