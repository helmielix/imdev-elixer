<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tools".
 *
 * @property integer $id
 * @property string $type
 * @property integer $total
 * @property string $unit
 *
 * @property IkoBorrowingTools[] $ikoBorrowingTools
 * @property IkoToolsUsage[] $ikoToolsUsages
 * @property IkoToolsWo[] $ikoToolsWos
 * @property OspBorrowingTools[] $ospBorrowingTools
 * @property OspToolsUsage[] $ospToolsUsages
 * @property OspToolsWo[] $ospToolsWos
 */
class Tools extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tools';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['unit'], 'string', 'max' => 20],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoBorrowingTools()
    {
        return $this->hasMany(IkoBorrowingTools::className(), ['id_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoToolsUsages()
    {
        return $this->hasMany(IkoToolsUsage::className(), ['id_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoToolsWos()
    {
        return $this->hasMany(IkoToolsWo::className(), ['id_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspBorrowingTools()
    {
        return $this->hasMany(OspBorrowingTools::className(), ['id_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspToolsUsages()
    {
        return $this->hasMany(OspToolsUsage::className(), ['id_tools' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspToolsWos()
    {
        return $this->hasMany(OspToolsWo::className(), ['id_tools' => 'id']);
    }
}
