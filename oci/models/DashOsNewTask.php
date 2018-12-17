<?php

namespace os\models;

use Yii;

/**
 * This is the model class for table "dash_os_new_task".
 *
 * @property string $task_date
 * @property string $table_source
 * @property string $task
 * @property string $note
 * @property integer $id
 */
class DashOsNewTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_os_new_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_date', 'table_source', 'task', 'note', 'stdk'], 'string'],
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
            'task' => 'Task',
            'note' => 'Note',
            'id' => 'ID',
        ];
    }
}
