<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "labor".
 *
 * @property integer $nik
 * @property string $nama
 * @property string $position
 *
 * @property Grf[] $grves
 * @property LogOutboundGrf[] $logOutboundGrves
 * @property OutboundGrf[] $outboundGrves
 * @property StockOpnameInternal[] $stockOpnameInternals
 */
class LaborForo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'labor';
    }

    public static function getDb()
    {
        return Yii::$app->get('dbforo');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position'], 'required'],
            [['name', 'position'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'nama' => 'Nama',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrves()
    {
        return $this->hasMany(Grf::className(), ['pic' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOutboundGrves()
    {
        return $this->hasMany(LogOutboundGrf::className(), ['pic' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrves()
    {
        return $this->hasMany(OutboundGrf::className(), ['pic' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockOpnameInternals()
    {
        return $this->hasMany(StockOpnameInternal::className(), ['pic' => 'nik']);
    }
}
