<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "labor".
 *
 * @property string $nik
 * @property string $name
 * @property string $position
 *
 * @property FinanceInvoice[] $financeInvoices
 * @property FinanceRfp[] $financeRfps
 * @property IkoGrfVendor[] $ikoGrfVendors
 * @property IkoTeam[] $ikoTeams
 * @property OsOutsourcePersonil[] $osOutsourcePersonils
 * @property OspTeam[] $ospTeams
 * @property OspTeam[] $ospTeams0
 * @property PplIkoAtp[] $pplIkoAtps
 * @property PplIkoAtp[] $pplIkoAtps0
 * @property PplIkoAtp[] $pplIkoAtps1
 * @property PplIkoAtp[] $pplIkoAtps2
 * @property PplIkoAtp[] $pplIkoAtps3
 * @property PplIkoAtp[] $pplIkoAtps4
 * @property PplIkoAtp[] $pplIkoAtps5
 * @property PplOspAtp[] $pplOspAtps
 * @property PplOspAtp[] $pplOspAtps0
 * @property PplOspAtp[] $pplOspAtps1
 * @property PplOspAtp[] $pplOspAtps2
 * @property PplOspAtp[] $pplOspAtps3
 */
class Labor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'labor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik'], 'required'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'name' => 'Name',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasMany(FinanceInvoice::className(), ['pic_finance' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceRfps()
    {
        return $this->hasMany(FinanceRfp::className(), ['pic_finance' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoGrfVendors()
    {
        return $this->hasMany(IkoGrfVendor::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTeams()
    {
        return $this->hasMany(IkoTeam::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams()
    {
        return $this->hasMany(OspTeam::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTeams0()
    {
        return $this->hasMany(OspTeam::className(), ['id_labor' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps0()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_iko' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps1()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps2()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_planning' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps3()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_project_control' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps4()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_ikr' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplIkoAtps5()
    {
        return $this->hasMany(PplIkoAtp::className(), ['pic_ca' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_osp' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps0()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_planning' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps1()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_ospm' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps2()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_ca' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPplOspAtps3()
    {
        return $this->hasMany(PplOspAtp::className(), ['pic_project_control' => 'nik']);
    }
}
