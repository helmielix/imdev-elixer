<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property string $id_warehouse
 * @property string $warehouse_name
 * @property integer $id_region
 *
 * @property Region $idRegion
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'warehouse';
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
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['id_region' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'id_region']);
    }
}
