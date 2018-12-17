<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogOsVendorTermSheet;

/**
 * SearchLogOsVendorTermSheet represents the model behind the search form about `app\models\LogOsVendorTermSheet`.
 */
class SearchLogOsVendorTermSheet extends LogOsVendorTermSheet
{
    /**
     * @inheritdoc
     */
     public $vendor_name;
    public function rules()
    {
        return [
            [['idlog', 'id_os_vendor_regist_vendor', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['pic_mkm', 'pic_vendor', 'term_sheet', 'pks', 'file_attachment', 'created_date', 'updated_date', 'revision_remark','vendor_name'], 'safe'],
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
        $query = LogOsVendorTermSheet::find();
        $query->joinWith('picMkm');
        $query->joinWith('idVendorRegistration')
              ->andFilterWhere(['=','os_vendor_regist_vendor.status_listing', 5]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['vendor_name'] = [
			'asc' => ['os_vendor_regist_vendor.company_name' => SORT_ASC],
			'desc' => ['os_vendor_regist_vendor.company_name' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
       		'id_os_vendor_regist_vendor' => $this->id_os_vendor_regist_vendor,
            'created_by' => $this->created_by,
            'date(created_date)' => $this->created_date,
			'date(updated_date)' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'os_vendor_term_sheet.status_listing' => $this->status_listing,
        ]);
        $query->andFilterWhere(['ilike', 'labor.name', $this->pic_mkm])
            ->andFilterWhere(['ilike', 'pic_vendor', $this->pic_vendor])
            ->andFilterWhere(['ilike', 'term_sheet', $this->term_sheet])
            ->andFilterWhere(['ilike', 'pks', $this->pks])
            ->andFilterWhere(['ilike', 'file_attachment', $this->file_attachment])
			 ->andFilterWhere(['ilike', 'os_vendor_regist_vendor.company_name', $this->vendor_name])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);

        return $dataProvider;
    }
}
