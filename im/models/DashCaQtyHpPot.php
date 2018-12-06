<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_ca_qty_hp_pot".
 *
 * @property string $region
 * @property integer $quantity_hp_potential
 * @property integer $quantity_soho_potential
 */
class DashCaQtyHpPot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_ca_qty_hp_pot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity_hp_potential', 'quantity_soho_potential'], 'integer'],
            [['region'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region' => 'Region',
            'quantity_hp_potential' => 'Quantity Hp Potential',
            'quantity_soho_potential' => 'Quantity Soho Potential',
        ];
    }
}
