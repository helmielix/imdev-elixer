<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "odp".
 *
 * @property integer $id
 * @property string $id_odc
 * @property string $odc_splitter
 * @property integer $odc_port
 * @property string $core_odc
 * @property string $odp
 * @property string $type_boq
 * @property string $pon
 * @property string $olt
 * @property string $hub
 * @property string $hp_handle
 * @property string $material
 * @property string $geom
 * @property string $name
 *
 * @property Odc $idOdc
 * @property Subscriber[] $subscribers
 */
class Odp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'odp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['odc_port'], 'integer'],
            [['odp'], 'required'],
            [['geom'], 'string'],
            [['id_odc', 'core_odc', 'pon', 'olt', 'hub'], 'string', 'max' => 15],
            [['odc_splitter', 'type_boq', 'hp_handle', 'material'], 'string', 'max' => 10],
            [['odp', 'name'], 'string', 'max' => 20],
            [['id_odc'], 'exist', 'skipOnError' => true, 'targetClass' => Odc::className(), 'targetAttribute' => ['id_odc' => 'odc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_odc' => 'Id Odc',
            'odc_splitter' => 'Odc Splitter',
            'odc_port' => 'Odc Port',
            'core_odc' => 'Core Odc',
            'odp' => 'Odp',
            'type_boq' => 'Type Boq',
            'pon' => 'Pon',
            'olt' => 'Olt',
            'hub' => 'Hub',
            'hp_handle' => 'Hp Handle',
            'material' => 'Material',
            'geom' => 'Geom',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOdc()
    {
        return $this->hasOne(Odc::className(), ['odc_id' => 'id_odc']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribers()
    {
        return $this->hasMany(Subscriber::className(), ['no_fat' => 'odp']);
    }
}
