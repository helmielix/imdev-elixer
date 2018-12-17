<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "os_vendor_legal_parameter".
 *
 * @property integer $id
 * @property integer $id_vendor_regist_vendor
 * @property integer $id_reference
 *
 * @property OsVendorRegistVendor $idVendorRegistVendor
 * @property Reference $idReference
 */
class OsVendorLegalParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_vendor_legal_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendor_regist_vendor', 'id_reference'], 'required'],
            [['id_vendor_regist_vendor', 'id_reference'], 'integer'],
            [['id_vendor_regist_vendor'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorRegistVendor::className(), 'targetAttribute' => ['id_vendor_regist_vendor' => 'id']],
            [['id_reference'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['id_reference' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vendor_regist_vendor' => 'Id Vendor Regist Vendor',
            'id_reference' => 'Id Reference',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendorRegistVendor()
    {
        return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'id_vendor_regist_vendor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdReference()
    {
        return $this->hasOne(Reference::className(), ['id' => 'id_reference']);
    }
}
