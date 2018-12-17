<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundWhTransferDetail;

/**
 * SearchOutboundWhTransferDetail represents the model behind the search form about `common\models\OutboundWhTransferDetail`.
 */
class SearchOutboundWhTransferDetail extends OutboundWhTransferDetail
{
    /**
     * @inheritdoc
     */
	public $sn_type, $name, $brand;
    public function rules()
    {
        return [
            [['id', 'id_outbound_wh', 'sn_type', 'req_good', 'req_not_good', 'status_listing', 'req_reject', 'req_dismantle', 'req_revocation', 'req_good_rec', 'req_good_for_recond'], 'integer'],
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
        // $query = OutboundWhTransferDetail::find()->joinWith('idMasterItemImDetail.idMasterItemIm');
        $query = OutboundWhTransferDetail::find()->joinWith(['idMasterItemIm.referenceBrand']);

		$query->andWhere(['id_outbound_wh' => $id]);

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
            'id_outbound_wh' => $this->id_outbound_wh,
            // 'id_item_im' => $this->id_item_im,
            'status_listing' => $this->status_listing,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'req_reject' => $this->req_reject,
            'req_dismantle' => $this->req_dismantle,
            'req_revocation' => $this->req_revocation,
            'req_good_rec' => $this->req_good_rec,
            'req_good_for_recond' => $this->req_good_for_recond,
            'master_item_im.sn_type' => $this->sn_type,
        ]);

		$query->andFilterWhere(['ilike' , 'master_item_im.im_code', $this->id_item_im]);
		$query->andFilterWhere(['ilike' , 'master_item_im.name', $this->name]);
		$query->andFilterWhere(['ilike' , 'reference.description', $this->brand]);


        return $dataProvider;
    }
}
