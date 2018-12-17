<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
// use common\models\StatusReference;
// use common\models\User;
/**
 * This is the model class for table "os_vendor_project_parameter".
 *
 * @property integer $id
 * @property string $project_name
 * @property string $others
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing_parameter
 * @property string $revision_remark
 * @property string $note
 *
 * @property OsVendorDocumentParameter[] $osVendorDocumentParameters
 * @property OsVendorPob[] $osVendorPobs
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsVendorProjectParameter extends \yii\db\ActiveRecord
{
    public $doc_req, $arrDocReq,$arr_doc_req;

    public static function tableName()
    {
        return 'os_vendor_project_parameter';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_name', 'status_listing_parameter'], 'required'],
            [['created_by', 'updated_by', 'status_listing_parameter'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark', 'note'], 'string'],
            [['project_name'], 'string', 'max' => 60],
            [['others'], 'string', 'max' => 255],
            [['project_name'], 'unique'],
            [['status_listing_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing_parameter' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['revision_remark'], 'required', 'on' => 'revise'],
            [['doc_req'], 'required', 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_name' => 'Project Name',
            'others' => 'Others',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing_parameter' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorDocumentParameters()
    {
        return $this->hasMany(OsVendorDocumentParameter::className(), ['id_os_vendor_project_parameter' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsVendorPobs()
    {
        return $this->hasMany(OsVendorPob::className(), ['id_os_vendor_project_parameter' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing_parameter']);
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
