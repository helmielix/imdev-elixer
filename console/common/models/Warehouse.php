<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property integer $id
 * @property string $nama_warehouse
 * @property string $table_relation
 *
 * @property InstructionDisposal[] $instructionDisposals
 * @property InstructionProduction[] $instructionProductions
 * @property InstructionRepair[] $instructionRepairs
 * @property InstructionWhTransfer[] $instructionWhTransfers
 * @property InstructionWhTransfer[] $instructionWhTransfers0
 * @property LogInstructionProduction[] $logInstructionProductions
 * @property LogInstructionRepair[] $logInstructionRepairs
 * @property LogInstructionWhTransfer[] $logInstructionWhTransfers
 * @property LogInstructionWhTransfer[] $logInstructionWhTransfers0
 * @property MasterItemImDetail[] $masterItemImDetails
 * @property StockOpnameInternal[] $stockOpnameInternals
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $id_user;
	 
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_warehouse'], 'required'],
            [['nama_warehouse'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_warehouse' => 'Nama Warehouse',
            'id_warehouse' => 'Nama Warehouse',
            'id_user' => 'Username',
			'pic' => 'PIC',
			'id_region' => 'Region',
			'id_divisi' => 'Divisi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionDisposals()
    {
        return $this->hasMany(InstructionDisposal::className(), ['warehouse' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionProductions()
    {
        return $this->hasMany(InstructionProduction::className(), ['id_warehouse' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionRepairs()
    {
        return $this->hasMany(InstructionRepair::className(), ['id_warehouse' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionWhTransfers()
    {
        return $this->hasMany(InstructionWhTransfer::className(), ['wh_destination' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionWhTransfers0()
    {
        return $this->hasMany(InstructionWhTransfer::className(), ['wh_origin' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogInstructionProductions()
    {
        return $this->hasMany(LogInstructionProduction::className(), ['id_warehouse' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogInstructionRepairs()
    {
        return $this->hasMany(LogInstructionRepair::className(), ['id_warehouse' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogInstructionWhTransfers()
    {
        return $this->hasMany(LogInstructionWhTransfer::className(), ['wh_destination' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogInstructionWhTransfers0()
    {
        return $this->hasMany(LogInstructionWhTransfer::className(), ['wh_origin' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterItemImDetails()
    {
        return $this->hasMany(MasterItemImDetail::className(), ['id_warehouse' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockOpnameInternals()
    {
        return $this->hasMany(StockOpnameInternal::className(), ['id_warehouse' => 'id']);
    }
}
