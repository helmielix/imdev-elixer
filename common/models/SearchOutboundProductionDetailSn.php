<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutboundWhTransferDetailSn;

/**
 * SearchOutboundWhTransferDetailSn represents the model behind the search form about `common\models\OutboundWhTransferDetailSn`.
 */
class SearchOutboundWhTransferDetailSn extends OutboundWhTransferDetailSn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_outbound_pro_detail', 'condition'], 'integer'],
            [['serial_number', 'mac_address'], 'safe'],
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
    public function search($params, $idOutboundProDetail){
        $query = OutboundWhTransferDetailSn::find();
		$query->andWhere(['id_outbound_pro_detail' => $idOutboundProDetail]);
		
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
		
		switch ($this->condition){
			case 1: //good
				$query->andFilterWhere(['condition' => 'good']);
			break;
			case 2: //not good
				$query->andFilterWhere(['condition' => 'not good']);
			break;
			case 3: //reject
				$query->andFilterWhere(['condition' => 'reject']);
			break;
			case 4: //good dismantle
				$query->andFilterWhere(['condition' => 'good dismantle']);
			break;
			case 5: //not good dismantle
				$query->andFilterWhere(['condition' => 'not good dismantle']);
			break;
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_outbound_pro_detail' => $this->id_outbound_pro_detail,
        ]);

        $query->andFilterWhere(['ilike', 'serial_number', $this->serial_number])
            ->andFilterWhere(['ilike', 'mac_address', $this->mac_address])
            // ->andFilterWhere(['ilike', 'condition', $this->condition])
			;
	
        return $dataProvider;
    }
}
