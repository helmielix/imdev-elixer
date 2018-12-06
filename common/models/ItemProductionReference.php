<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_production_reference".
 *
 * @property integer $id
 * @property integer $item_hasil
 * @property integer $item_bahan
 * @property integer $qty
 * @property string $orafin_name
 */
class ItemProductionReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_production_reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_hasil', 'item_bahan', 'qty'], 'integer'],
            [['orafin_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_hasil' => 'Item Hasil',
            'item_bahan' => 'Item Bahan',
            'qty' => 'Qty',
            'orafin_name' => 'Orafin Name',
        ];
    }
}
