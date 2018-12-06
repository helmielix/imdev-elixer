<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status_area".
 *
 * @property string $id_area
 * @property integer $status_area
 * @property string $color
 * @property string $condition
 * @property string $note
 * @property string $geometry
 */
class StatusArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_area'], 'integer'],
            [['color', 'condition', 'note', 'geometry'], 'string'],
            [['id_area'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_area' => 'Id Area',
            'status_area' => 'Status Area',
            'color' => 'Color',
            'condition' => 'Condition',
            'note' => 'Note',
            'geometry' => 'Geometry',
        ];
    }
}
