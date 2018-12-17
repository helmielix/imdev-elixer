<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_ca_new_task".
 *
 * @property string $task_date
 * @property string $table_source
 * @property string $note
 * @property string $task
 */
class DashCaNewTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_ca_new_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_date'], 'safe'],
            [['note'], 'string'],
            [['table_source', 'task'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_date' => 'Task Date',
            'table_source' => 'Table Source',
            'note' => 'Note',
            'task' => 'Task',
        ];
    }
}
