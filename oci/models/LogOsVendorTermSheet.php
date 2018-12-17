<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_os_vendor_term_sheet".
 *
 * @property integer $idlog
 * @property integer $id_os_vendor_regist_vendor
 * @property string $pic_mkm
 * @property string $pic_vendor
 * @property string $term_sheet
 * @property string $pks
 * @property string $file_attachment
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property OsVendorRegistVendor $idOsVendorRegistVendor
 */
class LogOsVendorTermSheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $file,$id_os_vendor_regist, $vendor_name;
    public static function tableName()
    {
        return 'log_os_vendor_term_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_os_vendor_regist_vendor', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['pic_mkm'], 'string', 'max' => 16],
            [['pic_vendor', 'term_sheet', 'pks'], 'string', 'max' => 50],
            [['file_attachment'], 'string', 'max' => 255],
            [['id_os_vendor_regist_vendor'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorRegistVendor::className(), 'targetAttribute' => ['id_os_vendor_regist_vendor' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id_os_vendor_regist_vendor' => 'Id Os Vendor Regist Vendor',
            'pic_mkm' => 'Pic Mkm',
            'pic_vendor' => 'Pic Vendor',
            'term_sheet' => 'Term Sheet',
            'pks' => 'Pks',
            'file_attachment' => 'File Attachment',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicMkm()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'pic_mkm']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendorRegistration()
    {
        return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'id_os_vendor_regist_vendor']);
    }

	   public function getReferenceTermSheet()
    {
        return $this->hasOne(Reference::className(), ['id' => 'term_sheet']);
    }

	   public function getReferencePks()
    {
        return $this->hasOne(Reference::className(), ['id' => 'pks']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */



	/**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
