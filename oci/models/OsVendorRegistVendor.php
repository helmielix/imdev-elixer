<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_vendor_regist_vendor".
 *
 * @property integer $id
 * @property integer $legal_document
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
 *
 * @property Reference $legalDocument
 * @property Reference $contractType
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property OsVendorSpk[] $osVendorSpks
 * @property OsVendorTermSheet[] $osVendorTermSheets
 */
class OsVendorRegistVendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

	public $file, $legal_document;

    public static function tableName()
    {
        return 'os_vendor_regist_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_type', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['note', 'revision_remark'], 'string'],
            [['company_name','address', 'phone_number', 'status_listing', 'email', 'contact_person'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['company_name'], 'string', 'max' => 100],
			[['phone_number','handphone_number','fax_number'], 'match', 'pattern' => '/^[0-9\+\-]*$/'],
            [['scoop_of_business'], 'string', 'max' => 255],
            [['address', 'email', 'contact_person'], 'string', 'max' => 50],
            [['phone_number', 'handphone_number'], 'string', 'max' => 15],
            [['fax_number'], 'string', 'max' => 20],
			['email','email'],
			[['file'], 'file',  'extensions' => 'pdf', 'maxSize'=>1024*1024*5],
            [['legal_document', 'contract_type'],'required', 'on'=>'update'],
			
            //[['legal_document'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => //['legal_document' => 'id']],
            [['contract_type'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['contract_type' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
			 // [['phone_number','handphone_number','fax_number'], 'compare', 'type' => 'number']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legal_document' => 'Legal Document',
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
			'legal_document' => 'Legal Document',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalDocument()
    {
        return $this->hasMany(OsVendorLegalParameter::className(), ['id_vendor_regist_vendor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceContractType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'contract_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */


    /**
     * @return \yii\db\ActiveQuery
     */


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorSpks()
    {
        return $this->hasMany(OsVendorSpk::className(), ['vendor_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorTermSheets()
    {
        return $this->hasMany(OsVendorTermSheet::className(), ['vendor_name' => 'id']);
    }

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



	public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

}
