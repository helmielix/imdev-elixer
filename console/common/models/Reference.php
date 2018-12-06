<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reference".
 *
 * @property integer $id
 * @property string $description
 *
 * @property CaBaSurvey[] $caBaSurveys
 * @property CaBaSurvey[] $caBaSurveys0
 * @property CaBaSurvey[] $caBaSurveys1
 * @property IkoProblem[] $ikoProblems
 * @property IkoProblem[] $ikoProblems0
 * @property IkoWorkOrder[] $ikoWorkOrders
 * @property OspProblem[] $ospProblems
 * @property OspProblem[] $ospProblems0
 * @property OspWorkOrder[] $ospWorkOrders
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans
 * @property PlanningIkoBasPlan[] $planningIkoBasPlans0
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails0
 * @property PlanningIkoBoqBDetail[] $planningIkoBoqBDetails1
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails0
 * @property PlanningIkoBoqPDetail[] $planningIkoBoqPDetails1
 * @property PlanningOspBas[] $planningOspBas
 * @property PlanningOspBoqB[] $planningOspBoqBs
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails0
 * @property PlanningOspBoqBDetail[] $planningOspBoqBDetails1
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails0
 * @property PlanningOspBoqPDetail[] $planningOspBoqPDetails1
 */
class Reference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_relation', 'description'], 'required'],
            [['id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['description'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys()
    {
        return $this->hasMany(CaBaSurvey::className(), ['iom_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys0()
    {
        return $this->hasMany(CaBaSurvey::className(), ['property_area_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys1()
    {
        return $this->hasMany(CaBaSurvey::className(), ['house_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems()
    {
        return $this->hasMany(IkoProblem::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems0()
    {
        return $this->hasMany(IkoProblem::className(), ['level_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoWorkOrders()
    {
        return $this->hasMany(IkoWorkOrder::className(), ['work_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems()
    {
        return $this->hasMany(OspProblem::className(), ['type_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems0()
    {
        return $this->hasMany(OspProblem::className(), ['level_problem' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspWorkOrders()
    {
        return $this->hasMany(OspWorkOrder::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBasPlans0()
    {
        return $this->hasMany(PlanningIkoBasPlan::className(), ['project_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails0()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqBDetails1()
    {
        return $this->hasMany(PlanningIkoBoqBDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails0()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPDetails1()
    {
        return $this->hasMany(PlanningIkoBoqPDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBas()
    {
        return $this->hasMany(PlanningOspBas::className(), ['work_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBs()
    {
        return $this->hasMany(PlanningOspBoqB::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails0()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqBDetails1()
    {
        return $this->hasMany(PlanningOspBoqBDetail::className(), ['unit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['executor_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails0()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPDetails1()
    {
        return $this->hasMany(PlanningOspBoqPDetail::className(), ['unit' => 'id']);
    }
}
