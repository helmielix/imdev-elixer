<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_os_vendor_pob".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $vendor_name
 * @property string $pob_number
 * @property string $pob_date
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 * @property integer $id_os_vendor_project_parameter
 *
 * @property OsVendorProjectParameter $idOsVendorProjectParameter
 */
class LogOsVendorPob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_os_vendor_pob';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vendor_name', 'created_by', 'updated_by', 'status_listing', 'id_os_vendor_project_parameter'], 'integer'],
            [['pob_date', 'created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['pob_number'], 'string', 'max' => 50],
            [['id_os_vendor_project_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorProjectParameter::className(), 'targetAttribute' => ['id_os_vendor_project_parameter' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id' => 'ID',
            'vendor_name' => 'Vendor Name',
            'pob_number' => 'PO Blanket Number',
            'pob_date' => 'Pob Date',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'id_os_vendor_project_parameter' => 'Project Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getVendorName()
   {
       return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'vendor_name']);
   }

   public function getIdVendorRegistVendor()
   {
       return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'vendor_name']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getReferenceProjectType()
   {
       return $this->hasOne(OsVendorProjectParameter::className(), ['id' => 'id_os_vendor_project_parameter']);
   }

   /**
    * @return \yii\db\ActiveQuerys
    */
   // public function getReferenceCurrency()
   // {
       // return $this->hasOne(Reference::className(), ['id' => 'currency']);
   // }

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
