<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InboundWhTransferDetailSn;

/**
 * SearchInboundWhTransferDetailSn represents the model behind the search form about `inbound\models\InboundWhTransferDetailSn`.
 */
class SearchInboundWhTransferDetailSn extends InboundWhTransferDetailSn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_wh_detail'], 'integer'],
            [['serial_number', 'mac_address', 'condition'], 'safe'],
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
        $query = InboundWhTransferDetailSn::find();

        // add conditions that should always apply here

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_inbound_wh_detail' => $this->id_inbound_wh_detail,
        ]);

        $query->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'mac_address', $this->mac_address]);

        return $dataProvider;
    }
	
	public function searchByAction($params, $idInboundWhTransferDetail = NULL)
    {
        $query = InboundWhTransferDetailSn::find()->where(['id_inbound_wh_detail'=>$idInboundWhTransferDetail]);


        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	public function searchByRetagsn($params, $idInboundWhTransferDetail)
    {
        $query = InboundWhTransferDetailSn::find()->where(['id_inbound_wh_detail'=>$idInboundWhTransferDetail])->andWhere(['status_retagsn' => 1]);

        $dataProvider = $this->_search($params, $query);

        return $dataProvider;
    }
	
	public function searchByRetagsnapprove($params, $idInboundWhTransfer)
    {
        $query = InboundWhTransferDetailSn::find()
			->joinWith('idInboundWhDetail.idInboundWh')
			->andFilterWhere(['inbound_wh_transfer_detail.id_inbound_wh'=>$idInboundWhTransfer])
			->andWhere(['is not','inbound_wh_transfer_detail_sn.status_retagsn', null]);

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
            'id_inbound_wh_detail' => $this->id_inbound_wh_detail,
        ]);

        $query->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'mac_address', $this->mac_address])
            ->andFilterWhere(['=', 'condition', strtolower($this->condition)]);


        return $dataProvider;
    }
}
