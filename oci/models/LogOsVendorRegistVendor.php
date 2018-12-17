<?php

namespace app\models;

use Yii;
// use common\models\StatusReference;
// use common\models\StatusReference;
// use common\models\Reference;


/**
 * This is the model class for table "log_os_vendor_regist_vendor".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $contract_type
 * @property string $company_name
 * @property string $scoop_of_business
 * @property string $address
 * @property string $phone_number
 * @property string $fax_number
 * @property string $email
 * @property string $contact_person
 * @property string $handphone_number
 * @property string $note
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 * @property string $file_attachment
 */
class LogOsVendorRegistVendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_os_vendor_regist_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contract_type', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['note', 'revision_remark'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['company_name'], 'string', 'max' => 100],
            [['scoop_of_business', 'file_attachment'], 'string', 'max' => 255],
            [['address', 'email', 'contact_person'], 'string', 'max' => 50],
			
            [['phone_number', 'handphone_number'], 'string', 'max' => 15],
            [['fax_number'], 'string', 'max' => 20],
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
            'contract_type' => 'Contract Type',
            'company_name' => 'Company Name',
            'scoop_of_business' => 'Scoop Of Business',
            'address' => 'Address',
            'phone_number' => 'Phone Number',
            'fax_number' => 'Fax Number',
            'email' => 'Email',
            'contact_person' => 'Contact Person',
            'handphone_number' => 'Handphone Number',
            'note' => 'Note',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'file_attachment' => 'File Attachment',
        ];
    }
	
	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
	
	public function getLegalDocument()
    {
        return $this->hasOne(Reference::className(), ['id' => 'legal_document']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceContractType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'contract_type']);
    }
}
