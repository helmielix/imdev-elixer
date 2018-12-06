<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "adjusment_daily".
 *
 * @property integer $id_instruction_repair
 */
class AdjustmentDaily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //public $instruction_number, $target_pengiriman, $vendor, $wh_destination, $wh_origin, $grf_number;
    /**
     * @var UploadedFile
     */
    public $file;

    public static function tableName()
    {
        return 'adjustment_daily';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis_transaksi','no_sj'], 'required'],
            [['no_sj', 'no_adj', 'berita_acara', 'catatan','jenis_transaksi'], 'string'],
            [['file'], 'file', 'extensions' => 'pdf, txt', 'maxSize'=>1024*1024*5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_adjustment' => 'ID Adjustment',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'berita_acara' => 'Berita Acara',
            'file' => 'Berita Acara',
            'catatan' => 'Catatan',
            'id_modul' => 'ID Modul',
            'no_sj' => 'Nomor Surat Jalan',
            'no_adj' => 'No. Adjustment Daily',
            'jenis_transaksi' => 'Jenis Transaksi',
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
