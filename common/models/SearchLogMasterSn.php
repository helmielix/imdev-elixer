<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MasterSn;

/**
 * SearchMasterSn represents the model behind the search form about `common\models\MasterSn`.
 */
class SearchLogMasterSn extends LogMasterSn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_warehouse'], 'integer'],
            [['serial_number', 'mac_address', 'created_date', 'last_transaction'], 'safe'],
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
        $query = MasterSn::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'id_warehouse' => $this->id_warehouse,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'mac_address', $this->mac_address])
            ->andFilterWhere(['like', 'last_transaction', $this->last_transaction]);

        return $dataProvider;
    }
}
