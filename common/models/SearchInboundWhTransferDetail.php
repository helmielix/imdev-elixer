<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundWhTransferDetail;

/**
 * SearchInboundWhTransferDetail represents the model behind the search form about `inbound\models\InboundWhTransferDetail`.
 */
class SearchInboundWhTransferDetail extends InboundWhTransferDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_wh', 'id_item_im'], 'integer'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $id)
    {
        // $query = InboundWhTransferDetail::find()->joinWith('idItemIm.idMasterItemIm');
        $query = InboundWhTransferDetail::find()->joinWith('idItemIm');

		$query->andWhere(['inbound_wh_transfer_detail.id' => $id]);

        // add conditions that should always apply here

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

	public function searchByAction($params, $idInboundWhTransfer)
    {
        $query = InboundWhTransferDetail::find()->andFilterWhere(['id_inbound_wh'=>$idInboundWhTransfer]);
                // ->joinWith('idOrafinRr',true,'FULL JOIN')
                // ->select([  'orafin_rr.id as id_orafin_rr',
							// 'orafin_rr.rr_number as rr_number',
                            // 'inbound_po.created_by',
                            // 'inbound_po.updated_by',
                            // 'inbound_po.created_date',
                            // 'inbound_po.updated_date',
                            // 'inbound_po.status_listing',
                            // ])


        // if($action == 'input') {
            // $query->andFilterWhere(['or',['=','inbound_po.status_listing', 1], ['=','inbound_po.status_listing', 2],['=','inbound_po.status_listing', 6]])
            // ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
        // }  else if ($action == 'approve') {
            // $query->andFilterWhere(['or',['=','inbound_po.status_listing', 4],['=','inbound_po.status_listing', 5]])
                // ->orderBy(['inbound_po.updated_date' => SORT_DESC]);
        // }

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }

	private function _search($params, $query) {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_inbound_wh' => $this->id_inbound_wh,

        ]);



        return $dataProvider;
    }
}
