<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "adjusment".
 *
 * @property int $id_disposal_surat_jalan
 * @property int $created_by
 * @property int $updated_by
 * @property int $status_listing
 * @property string $created_date
 * @property string $updated_date
 * @property string $berita_acara
 * @property string $note
 * @property int $id_modul
 *
 * @property Modul $modul
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class Adjusment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjusment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_disposal_surat_jalan', 'created_by', 'created_date', 'berita_acara', 'id_modul'], 'required'],
            [['id_disposal_surat_jalan', 'created_by', 'updated_by', 'status_listing', 'id_modul'], 'default', 'value' => null],
            [['id_disposal_surat_jalan', 'created_by', 'updated_by', 'status_listing', 'id_modul'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['berita_acara', 'note'], 'string', 'max' => 255],
            [['id_disposal_surat_jalan'], 'unique'],
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
            'id_disposal_surat_jalan' => 'Id Disposal Surat Jalan',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'berita_acara' => 'Berita Acara',
            'note' => 'Note',
            'id_modul' => 'Id Modul',
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
}
