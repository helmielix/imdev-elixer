<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionDisposalDetail;

/**
 * searchInstructionDisposalDetail represents the model behind the search form about `common\models\InstructionDisposalDetail`.
 */
class searchInstructionDisposalDetail extends InstructionDisposalDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'qty', 'qty_konversi','id_instruction_disposal'], 'integer'],
            [['im_code','uom_sale', 'uom_old', 'uom_new','name_item', 'brand','uom', 'konversi', 'qty_total'], 'safe'],
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
    public function search($params,$id)
    {
        $query = InstructionDisposalDetail::find();


        $query->andWhere(['id_instruction_disposal' => $id]);

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
            'id_instruction_disposal' => $this->id_instruction_disposal,
            'im_code' => $this->im_code,
            'name' => $this->name,
            'brand' => $this->brand,
            'qty' => $this->qty,
            'uom_sale' => $this->uom_sale,
            'qty_konversi' => $this->qty_konversi,
            'uom_old' => $this->uom_old,
            'konversi' => $this->konversi,
            'uom_new' => $this->uom_new,
            'qty_total' => $this->qty_total,
            'uom' => $this->uom,

        ]);

        return $dataProvider;
    }
}
