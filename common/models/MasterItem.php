<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "master_item".
 *
 * @property int $id
 * @property int $type
 * @property string $unit
 * @property int $total
 * @property int $s_good
 * @property int $s_not_good
 * @property int $s_reject
 */
class MasterItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'unit', 'total', 's_good', 's_not_good', 's_reject'], 'required'],
            [['type', 'total', 's_good', 's_not_good', 's_reject'], 'default', 'value' => null],
            [['type', 'total', 's_good', 's_not_good', 's_reject'], 'integer'],
            [['unit'], 'string', 'max' => 255],
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
            'unit' => 'Unit',
            'total' => 'Total',
            's_good' => 'S Good',
            's_not_good' => 'S Not Good',
            's_reject' => 'S Reject',
        ];
    }
}
