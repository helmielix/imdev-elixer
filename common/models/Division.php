<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "division".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property LogOutboundGrf[] $logOutboundGrves
 * @property OutboundGrf[] $outboundGrves
 * @property User[] $users
 */
class Division extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogOutboundGrves()
    {
        return $this->hasMany(LogOutboundGrf::className(), ['id_division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrves()
    {
        return $this->hasMany(OutboundGrf::className(), ['id_division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_division' => 'id']);
    }
}
