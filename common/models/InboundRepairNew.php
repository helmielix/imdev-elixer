<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_repair".
 *
 * @property integer $id_instruction_repair
 * @property string $driver
 * @property integer $created_by
 * @property integer $status_listing
 * @property integer $updated_by
 * @property integer $forwarder
 * @property string $no_sj
 * @property string $plate_number
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property integer $id_modul
 * @property string $tanggal_datang
 * @property integer $tagging
 * @property string $file_attachment
 */
class InboundRepairNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_repair';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_repair'], 'required'],
            [['id_instruction_repair', 'created_by', 'status_listing', 'updated_by', 'forwarder', 'id_modul', 'tagging'], 'integer'],
            [['created_date', 'updated_date', 'tanggal_datang'], 'safe'],
            [['revision_remark', 'file_attachment'], 'string'],
            [['driver'], 'string', 'max' => 50],
            [['no_sj'], 'string', 'max' => 55],
            [['plate_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_instruction_repair' => Yii::t('app', 'Id Instruction Repair'),
            'driver' => Yii::t('app', 'Driver'),
            'created_by' => Yii::t('app', 'Created By'),
            'status_listing' => Yii::t('app', 'Status Listing'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'forwarder' => Yii::t('app', 'Forwarder'),
            'no_sj' => Yii::t('app', 'No Sj'),
            'plate_number' => Yii::t('app', 'Plate Number'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'revision_remark' => Yii::t('app', 'Revision Remark'),
            'id_modul' => Yii::t('app', 'Id Modul'),
            'tanggal_datang' => Yii::t('app', 'Tanggal Datang'),
            'tagging' => Yii::t('app', 'Tagging'),
            'file_attachment' => Yii::t('app', 'File Attachment'),
        ];
    }
}
