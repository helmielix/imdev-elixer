<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "equipment".
 *
 * @property int $id
 * @property string $type
 * @property int $total
 * @property string $unit
 * @property double $price
 * @property int $lifetime
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'lifetime'], 'default', 'value' => null],
            [['total', 'lifetime'], 'integer'],
            [['price'], 'number'],
            [['type'], 'string', 'max' => 50],
            [['unit'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'total' => 'Total',
            'unit' => 'Unit',
            'price' => 'Price',
            'lifetime' => 'Lifetime',
        ];
    }
}
