<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "inbound_po".
 *
 * @property int $id
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_date
 * @property string $updated_date
 * @property int $status_listing
 * @property int $id_modul
 * @property string $rr_number
 * @property string $no_sj
 * @property string $tgl_sj
 * @property string $waranty
 * @property string $po_number
 * @property string $supplier
 * @property string $pr_number
 * @property string $revision_remark
 *
 * @property Modul $modul
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property InboundPoDetail[] $inboundPoDetails
 */
class InboundPo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound_po';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'status_listing', 'id_modul'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'status_listing', 'id_modul'], 'integer'],
            [['created_date', 'updated_date', 'tgl_sj'], 'safe'],
            [['id_modul'], 'required'],
            [['revision_remark'], 'string'],
            [['rr_number'], 'string', 'max' => 30],
            [['no_sj', 'waranty', 'po_number', 'supplier', 'pr_number'], 'string', 'max' => 255],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'id_modul' => 'Id Modul',
            'rr_number' => 'Rr Number',
            'no_sj' => 'No Sj',
            'tgl_sj' => 'Tgl Sj',
            'waranty' => 'Waranty',
            'po_number' => 'Po Number',
            'supplier' => 'Supplier',
            'pr_number' => 'Pr Number',
            'revision_remark' => 'Revision Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModul()
    {
        return $this->hasOne(Modul::className(), ['id' => 'id_modul']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusListing()
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPoDetails()
    {
        return $this->hasMany(InboundPoDetail::className(), ['id_inbound_po' => 'id']);
    }
}
