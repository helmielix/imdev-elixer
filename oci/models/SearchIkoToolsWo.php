<?php

namespace iko\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IkoToolsWo;

class SearchIkoToolsWo extends IkoToolsWo
{
    public $type, $area;

    public function rules()
    {
        return [
            [['id', 'id_iko_wo', 'id_tools', 'needed'], 'integer'],
            [['type', 'area'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = IkoToolsWo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_iko_wo' => $this->id_iko_wo,
            'id_tools' => $this->id_tools,
            'needed' => $this->needed,
        ]);

        return $dataProvider;
    }

    public function searchByIdIkoWorkOrder($params, $idIkoWorkOrder)
    {
        $query = IkoToolsWo::find()->joinWith('idIkoWo.idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
                ->joinWith('idTools',true,'FULL JOIN')
                ->select([  'tools.id as id_tools',
                            'area.id',
                            'iko_tools_wo.id_iko_wo',
                            'iko_tools_wo.id',
                            'iko_tools_wo.id_tools',
                            'iko_tools_wo.needed',
                            'tools.type',
                        ]);
        
        $query->andWhere(['id_iko_wo'=>$idIkoWorkOrder]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['type'] = [
            'asc' => ['"tools"."type"' => SORT_ASC],
            'desc' => ['"tools"."type"' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['area'] = [
            'asc' => ['area.id' => SORT_ASC],
            'desc' => ['area.id' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_iko_wo' => $this->id_iko_wo,
            'id_tools' => $this->id_tools,
            'needed' => $this->needed,
        ]);

        $query->andFilterWhere(['ilike', 'tools.type', $this->type])
                ->andFilterWhere(['ilike', 'area.id', $this->area]);

        return $dataProvider;
    }
}
