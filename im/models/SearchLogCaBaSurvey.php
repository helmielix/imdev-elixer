<?php

namespace ca\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogCaBaSurvey;

/**
 * SearchLogCaBaSurvey represents the model behind the search form about `app\models\LogCaBaSurvey`.
 */
class SearchLogCaBaSurvey extends LogCaBaSurvey
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog', 'qty_hp_pot', 'created_by', 'updated_by', 'status_listing', 'status_iom', 'iom_type', 'id', 'property_area_type', 'house_type', 'qty_soho_pot', 'status_presurvey'], 'integer'],
            [['id_area', 'notes', 'survey_date', 'created_date', 'updated_date', 'potency_type', 'no_iom', 'avr_occupancy_rate', 'myr_population_hv', 'dev_method', 'access_to_sell', 'occupancy_use_dth', 'competitors', 'location_description', 'pic_survey', 'contact_survey', 'pic_iom_special', 'revision_remark', 'doc_file', 'iom_file', 'xls_file', 'geom', 'pdf_file'], 'safe'],
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
        $query = LogCaBaSurvey::find();

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
            'idlog' => $this->idlog,
            'qty_hp_pot' => $this->qty_hp_pot,
            'survey_date' => $this->survey_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'status_listing' => $this->status_listing,
            'status_iom' => $this->status_iom,
            'iom_type' => $this->iom_type,
            'id' => $this->id,
            'property_area_type' => $this->property_area_type,
            'house_type' => $this->house_type,
            'qty_soho_pot' => $this->qty_soho_pot,
            'status_presurvey' => $this->status_presurvey,
        ]);

        $query->andFilterWhere(['like', 'id_area', $this->id_area])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'potency_type', $this->potency_type])
            ->andFilterWhere(['like', 'no_iom', $this->no_iom])
            ->andFilterWhere(['like', 'avr_occupancy_rate', $this->avr_occupancy_rate])
            ->andFilterWhere(['like', 'myr_population_hv', $this->myr_population_hv])
            ->andFilterWhere(['like', 'dev_method', $this->dev_method])
            ->andFilterWhere(['like', 'access_to_sell', $this->access_to_sell])
            ->andFilterWhere(['like', 'occupancy_use_dth', $this->occupancy_use_dth])
            ->andFilterWhere(['like', 'competitors', $this->competitors])
            ->andFilterWhere(['like', 'location_description', $this->location_description])
            ->andFilterWhere(['like', 'pic_survey', $this->pic_survey])
            ->andFilterWhere(['like', 'contact_survey', $this->contact_survey])
            ->andFilterWhere(['like', 'pic_iom_special', $this->pic_iom_special])
            ->andFilterWhere(['like', 'revision_remark', $this->revision_remark])
            ->andFilterWhere(['like', 'doc_file', $this->doc_file])
            ->andFilterWhere(['like', 'iom_file', $this->iom_file])
            ->andFilterWhere(['like', 'xls_file', $this->xls_file])
            ->andFilterWhere(['like', 'geom', $this->geom])
            ->andFilterWhere(['like', 'pdf_file', $this->pdf_file]);

        return $dataProvider;
    }
}
