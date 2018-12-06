<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "odc".
 *
 * @property integer $id
 * @property string $oss_olt
 * @property string $type_olt
 * @property string $rw
 * @property string $kelurahan
 * @property string $village_id
 * @property string $odc_id
 * @property string $geom
 * @property string $layer
 * @property string $refname
 * @property string $odc_no
 * @property integer $homepass
 *
 * @property Olt $ossOlt
 * @property Odp[] $odps
 */
class Odc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'odc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['odc_id'], 'required'],
            [['geom'], 'string'],
            [['homepass'], 'integer'],
            [['oss_olt'], 'string', 'max' => 30],
            [['type_olt', 'refname'], 'string', 'max' => 50],
            [['rw'], 'string', 'max' => 3],
            [['kelurahan'], 'string', 'max' => 70],
            [['village_id'], 'string', 'max' => 6],
            [['odc_id', 'layer', 'odc_no'], 'string', 'max' => 15],
            [['oss_olt'], 'exist', 'skipOnError' => true, 'targetClass' => Olt::className(), 'targetAttribute' => ['oss_olt' => 'oss_olt']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oss_olt' => 'Oss Olt',
            'type_olt' => 'Type Olt',
            'rw' => 'Rw',
            'kelurahan' => 'Kelurahan',
            'village_id' => 'Village ID',
            'odc_id' => 'Odc ID',
            'geom' => 'Geom',
            'layer' => 'Layer',
            'refname' => 'Refname',
            'odc_no' => 'Odc No',
            'homepass' => 'Homepass',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOssOlt()
    {
        return $this->hasOne(Olt::className(), ['oss_olt' => 'oss_olt']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOdps()
    {
        return $this->hasMany(Odp::className(), ['id_odc' => 'odc_id']);
    }
}
