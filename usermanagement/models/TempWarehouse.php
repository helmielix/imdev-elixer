<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "temp_warehouse".
 *
 * @property string $id_warehouse
 * @property string $warehouse_name
 * @property integer $id_region
 */
class TempWarehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_warehouse'], 'required'],
            [['id_region'], 'integer'],
            [['id_warehouse'], 'string', 'max' => 30],
            [['warehouse_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_warehouse' => 'Id Warehouse',
            'warehouse_name' => 'Warehouse Name',
            'id_region' => 'Id Region',
        ];
    }
}
