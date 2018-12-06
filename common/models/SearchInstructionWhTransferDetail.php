<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstructionWhTransferDetail;

/**
 * SearchInstructionWhTransferDetail represents the model behind the search form about `common\models\InstructionWhTransferDetail`.
 */
class SearchInstructionWhTransferDetail extends InstructionWhTransferDetail
{
    /**
     * @inheritdoc
     */
	public $name, $brand, $warna, $sn_type;
    public function rules()
    {
        return [
            [['id', 'id_instruction_wh', 'created_by'], 'integer'],
			[['id_item_im', 'name', 'brand', 'warna', 'sn_type'], 'safe'],
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
        // $query = InstructionWhTransferDetail::find()->joinWith('idMasterItemIm');
        $query = InstructionWhTransferDetail::find()->joinWith('idMasterItemIm');
		$query->joinWith(['idMasterItemIm.referenceWarna refwarna', 'idMasterItemIm.referenceBrand refbrand', 'idMasterItemIm.referenceType reftype', 'idMasterItemIm.referenceGrouping refgrouping']);
		// $query->select([
			// 'id_item_im'
		// ]);
		$query->andWhere(['id_instruction_wh' => $id]);

		$dataProvider = $this->_search($params, $query);

        return $dataProvider;
	}

    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => ['pageSize' => Yii::$app->params['defaultPageSize'] ],
			'sort' => ['defaultOrder' => ['id'=>SORT_ASC]]
        ]);

		$dataProvider->sort->attributes['name'] = [
            'asc' => ['master_item_im.name' => SORT_ASC],
            'desc' => ['master_item_im.name' => SORT_DESC],
        ];

		$dataProvider->sort->attributes['brand'] = [
            'asc' => ['master_item_im.brand' => SORT_ASC],
            'desc' => ['master_item_im.brand' => SORT_DESC],
        ];

		$dataProvider->sort->attributes['warna'] = [
            'asc' => ['master_item_im.warna' => SORT_ASC],
            'desc' => ['master_item_im.warna' => SORT_DESC],
        ];

		$dataProvider->sort->attributes['sn_type'] = [
            'asc' => ['master_item_im.sn_type' => SORT_ASC],
            'desc' => ['master_item_im.sn_type' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_instruction_wh' => $this->id_instruction_wh,
            // 'master_item_im' => $this->id_item_im,
            'created_by' => $this->created_by,
            'master_item_im.sn_type' => $this->sn_type,
            'req_good' => $this->req_good,
            'req_not_good' => $this->req_not_good,
            'req_reject' => $this->req_reject,
			'req_good_dismantle' => $this->req_good_dismantle,
            'req_not_good_dismantle' => $this->req_not_good_dismantle,
        ]);

		$query->andFilterWhere(['ilike', 'master_item_im.im_code', $this->id_item_im])
			  ->andFilterWhere(['ilike', 'master_item_im.name', $this->name])
			  ->andFilterWhere(['ilike', 'refbrand.description', $this->brand])
			  ->andFilterWhere(['ilike', 'refwarna.description', $this->warna])
		;

        return $dataProvider;
    }
}
