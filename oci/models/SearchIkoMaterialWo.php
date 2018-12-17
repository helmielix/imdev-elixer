<?php

namespace iko\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IkoMaterialWo;

class SearchIkoMaterialWo extends IkoMaterialWo
{   
    public $type, $area;

    public function rules()
    {
        return [
            [['needed', 'id_iko_wo', 'id', 'id_material'], 'integer'],
            [['uom','type', 'area'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = IkoMaterialWo::find();

        $dataProvider = $this->_search($params, $query); 

        return $dataProvider;
    }
    
    public function searchByIdIkoWorkOrder($params, $idIkoWorkOrder)
    {
        $query = IkoMaterialWo::find()->joinWith('idIkoWo.idIkoItpDaily.idIkoItpArea.idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea')
                ->joinWith('idMaterial',true,'FULL JOIN')
                ->select([  'material.id as id_material',
                            'area.id',
                            'iko_material_wo.id_iko_wo',
                            'iko_material_wo.id',
                            'iko_material_wo.id_material',
                            'iko_material_wo.uom',
                            'iko_material_wo.needed',
                            
                            'material.type']);
        
        $query->andWhere(['id_iko_wo'=>$idIkoWorkOrder]);

        $dataProvider = $this->_search($params, $query); 

        return $dataProvider;
    }
    
    private function _search($params, $query) {
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['type'] = [
            'asc' => ['"material"."type"' => SORT_ASC],
            'desc' => ['"material"."type"' => SORT_DESC],
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
            'needed' => $this->needed,
            'id_iko_wo' => $this->id_iko_wo,
            'id' => $this->id,
            'id_material' => $this->id_material,
        ]);

        $query->andFilterWhere(['ilike', 'uom', $this->uom])
                ->andFilterWhere(['ilike', 'material.type', $this->type])
                ->andFilterWhere(['ilike', 'area.id', $this->area]);

        return $dataProvider;
    }
}
