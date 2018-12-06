<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $role_name
 * @property string $create_by
 * @property string $create_date
 * @property string $approve_by
 * @property string $approve_date
 *
 * @property RoleAccess[] $roleAccesses
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'approve_date'], 'safe'],
            [['role_name', 'create_by', 'approve_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'approve_by' => 'Approve By',
            'approve_date' => 'Approve Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleAccesses()
    {
        return $this->hasMany(RoleAccess::className(), ['role_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleQuery(get_called_class());
    }
}
