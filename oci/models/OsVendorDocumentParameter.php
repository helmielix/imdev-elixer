<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "os_vendor_document_parameter".
 *
 * @property integer $id
 * @property integer $id_os_vendor_project_parameter
 * @property integer $id_reference
 *
 * @property OsVendorProjectParameter $idOsVendorProjectParameter
 * @property Reference $idReference
 */
class OsVendorDocumentParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_vendor_document_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_os_vendor_project_parameter', 'id_reference'], 'required'],
            [['id_os_vendor_project_parameter', 'id_reference'], 'integer'],
            [['id_os_vendor_project_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorProjectParameter::className(), 'targetAttribute' => ['id_os_vendor_project_parameter' => 'id']],
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
            'id_os_vendor_project_parameter' => 'Id Os Vendor Project Parameter',
            'id_reference' => 'Id Reference',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsVendorProjectParameter()
    {
        return $this->hasOne(OsVendorProjectParameter::className(), ['id' => 'id_os_vendor_project_parameter']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdReference()
    {
        return $this->hasOne(Reference::className(), ['id' => 'id_reference']);
    }
}
