<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;

/**
 * This is the model class for table "instruction_disposal_im".
 *
 * @property integer $id
 * @property integer $id_disposal_am
 * @property string $created_date
 * @property string $updated_date
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property string $target_pelaksanaan
 *
 * @property InstructionDisposalDetailIm[] $instructionDisposalDetailIms
 * @property InstructionDisposal $idDisposalAm
 * @property User $createdBy
 * @property User $updatedBy
 */
class InstructionDisposalIm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $warehouse,$instruction_number,$no_iom,$buyer;
    public static function tableName()
    {
        return 'instruction_disposal_im';
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
            [['id', 'id_disposal_am', 'created_date', 'created_by', 'target_pelaksanaan','id_modul'], 'required'],
            [['id', 'id_disposal_am', 'created_by', 'updated_by', 'status_listing','id_modul','warehouse','instruction_number','no_iom','buyer'], 'integer'],
            [['created_date', 'updated_date', 'target_pelaksanaan'], 'safe'],
            [['id_disposal_am'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionDisposal::className(), 'targetAttribute' => ['id_disposal_am' => 'id']],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_disposal_am' => 'Id Disposal Am',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'target_pelaksanaan' => 'Target Pelaksanaan',
            'warehouse' => 'Warehouse',
            'buyer' => 'Buyer',
            'instruction_number' => 'Nomor Instruction AMD',
            'no_iom' => 'No Iom',
            'id_modul' => 'Id Modul',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionDisposalDetailIms()
    {
        return $this->hasMany(InstructionDisposalDetailIm::className(), ['id_disposal_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDisposalAm()
    {
        return $this->hasOne(InstructionDisposal::className(), ['id' => 'id_disposal_am']);
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
