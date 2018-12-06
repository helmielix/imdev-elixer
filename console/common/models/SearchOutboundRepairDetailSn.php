<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundRepairDetailSn;

/**
 * SearchOutboundRepairDetailSn represents the model behind the search form about `common\models\OutboundRepairDetailSn`.
 */
class SearchOutboundRepairDetailSn extends OutboundRepairDetailSn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_repair_detail'], 'integer'],
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
    public function search($params, $idOutboundRepairDetail){
        $query = OutboundRepairDetailSn::find();
		$query->andWhere(['id_outbound_repair_detail' => $idOutboundRepairDetail]);
		
		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}
	
    public function _search($params, $query)
    {
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
            'id_outbound_repair_detail' => $this->id_outbound_repair_detail,
        ]);

        $query->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'mac_address', $this->mac_address])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        return $dataProvider;
    }
}
