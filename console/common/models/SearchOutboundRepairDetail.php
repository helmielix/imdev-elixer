<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundRepairDetail;

/**
 * SearchOutboundRepairDetail represents the model behind the search form about `common\models\OutboundRepairDetail`.
 */
class SearchOutboundRepairDetail extends OutboundRepairDetail
{
    /**
     * @inheritdoc
     */
	public $sn_type;
    public function rules()
    {
        return [
            [['id', 'id_outbound_repair', 'id_item_im', 'req_good', 'req_not_good', 'status_listing', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
			[['sn_type'], 'safe'],
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

    
    public function search($params, $id){
        $query = OutboundRepairDetail::find()->joinWith('idMasterItemIm');
		
		$query->andWhere(['id_outbound_repair' => $id]);
		
		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}
	
    public function _search($params, $query)
    {
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
		
		$dataProvider->sort->attributes['sn_type'] = [
            'asc' => ['master_item_im.sn_type' => SORT_ASC],
            'desc' => ['master_item_im.sn_type' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_outbound_repair' => $this->id_outbound_repair,
            'id_item_im' => $this->id_item_im,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'status_listing' => $this->status_listing,
            'req_reject' => $this->req_reject,
            'req_good_dismantle' => $this->req_good_dismantle,
            'req_not_good_dismantle' => $this->req_not_good_dismantle,
        ]);
		

        return $dataProvider;
    }
}
