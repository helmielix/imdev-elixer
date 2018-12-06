<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "temp_material".
 *
 * @property integer $id
 * @property string $type
 * @property integer $total
 * @property string $unit
 */
class TempMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'integer'],
            // [['type'], 'string', 'max' => 255],
            // [['unit'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'total' => 'Total',
            'unit' => 'Unit',
        ];
    }
}
