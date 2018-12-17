<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_os_vendor".
 *
 * @property integer $id
 * @property string $project_type
 * @property integer $total
 */
class DashOsVendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_os_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'integer'],
            [['project_type'], 'string', 'max' => 255],
            [['project_type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_type' => 'Project Type',
            'total' => 'Total',
        ];
    }
}
