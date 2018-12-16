<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundProductionDetail;

/**
 * SearchOutboundProductionDetail represents the model behind the search form about `common\models\OutboundProductionDetail`.
 */
class SearchOutboundProductionDetail extends OutboundProductionDetail
{
    /**
     * @inheritdoc
     */
	public $sn_type, $name, $brand ;
    public function rules()
    {
        return [
            [['id', 'id_outbound_production', 'sn_type',  ], 'integer'],
			[[ 'name', 'brand', 'id_item_im'], 'safe'],
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
        // $query = OutboundProductionDetail::find()->joinWith('idMasterItemImDetail.idMasterItemIm');
        $query = OutboundProductionDetail::find()->joinWith(['idParameterMasterItem.idMasterItemIm.referenceBrand']);

		$query->andWhere(['id_outbound_production' => $id]);

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
		$dataProvider->sort->attributes['name'] = [
            'asc' => ['master_item_im.name' => SORT_ASC],
            'desc' => ['master_item_im.name' => SORT_DESC],
        ];
		$dataProvider->sort->attributes['brand'] = [
            'asc' => ['master_item_im.brand' => SORT_ASC],
            'desc' => ['master_item_im.brand' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_outbound_production' => $this->id_outbound_production,
            // 'id_item_im' => $this->id_item_im,
            // 'status_listing' => $this->status_listing,
            // 'req_good' => $this->req_good,
            // 'req_not_good' => $this->req_not_good,
            // 'req_reject' => $this->req_reject,
            // 'req_good_dismantle' => $this->req_good_dismantle,
            // 'req_not_good_dismantle' => $this->req_not_good_dismantle,
            // 'master_item_im.sn_type' => $this->sn_type,
        ]);

		$query->andFilterWhere(['ilike' , 'master_item_im.im_code', $this->id_item_im]);
		// $query->andFilterWhere(['ilike' , 'master_item_im.name', $this->name]);
		// $query->andFilterWhere(['ilike' , 'reference.description', $this->brand]);


        return $dataProvider;
    }
}
