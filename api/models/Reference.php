<?php

namespace setting\models;

use Yii;

/**
 * This is the model class for table "reference".
 *
 * @property integer $id
 * @property integer $id_grouping
 * @property string $description
 * @property string $table_relation
 *
 * @property InstructionDisposal[] $instructionDisposals
 * @property OutboundGrf[] $outboundGrves
 * @property OutboundGrf[] $outboundGrves0
 * @property OutboundProduction[] $outboundProductions
 * @property OutboundWhTransfer[] $outboundWhTransfers
 */
class Reference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grouping'], 'required'],
            [['id_grouping'], 'integer'],
            [['table_relation'], 'string'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_grouping' => 'Id Grouping',
            'description' => 'Description',
            'table_relation' => 'Grouping',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionDisposals()
    {
        return $this->hasMany(InstructionDisposal::className(), ['buyer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrves()
    {
        return $this->hasMany(OutboundGrf::className(), ['grf_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrves0()
    {
        return $this->hasMany(OutboundGrf::className(), ['forwarder' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundProductions()
    {
        return $this->hasMany(OutboundProduction::className(), ['forwarder' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundWhTransfers()
    {
        return $this->hasMany(OutboundWhTransfer::className(), ['forwarder' => 'id']);
    }
}
