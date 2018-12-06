<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property integer $id
 * @property string $name
 *
 * @property FinanceInvoice[] $financeInvoices
 * @property PlanningIkoBoqP[] $planningIkoBoqPs
 * @property PlanningOspBoqP[] $planningOspBoqPs
 * @property PplIkoBastRetention[] $pplIkoBastRetentions
 * @property PplIkoBastWork[] $pplIkoBastWorks
 * @property PplIkoBaut[] $pplIkoBauts
 * @property PplOspBastRetention[] $pplOspBastRetentions
 * @property PplOspBastWork[] $pplOspBastWorks
 * @property PplOspBaut[] $pplOspBauts
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Vendor ID',
            'name' => 'Vendor Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasMany(FinanceInvoice::className(), ['vendor_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningIkoBoqPs()
    {
        return $this->hasMany(PlanningIkoBoqP::className(), ['executor_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanningOspBoqPs()
    {
        return $this->hasMany(PlanningOspBoqP::className(), ['executor_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastRetentions()
    {
        return $this->hasMany(PplIkoBastRetention::className(), ['name_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBastWorks()
    {
        return $this->hasMany(PplIkoBastWork::className(), ['name_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoBauts()
    {
        return $this->hasMany(PplIkoBaut::className(), ['name_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastRetentions()
    {
        return $this->hasMany(PplOspBastRetention::className(), ['name_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBastWorks()
    {
        return $this->hasMany(PplOspBastWork::className(), ['name_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspBauts()
    {
        return $this->hasMany(PplOspBaut::className(), ['name_vendor' => 'id']);
    }
}
