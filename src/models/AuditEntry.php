<?php

namespace mehulpatel\mod\audit\models;

use Yii;

/**
 * This is the model class for table "tbl_audit_entry".
 *
 * @property int $id
 * @property string $user_id
 * @property int $model_id
 * @property string $model_name
 * @property string $operation
 * @property string $field_name
 * @property string $old_value
 * @property string $new_value
 * @property string $timestamp
 * @property string $ip
 */
class AuditEntry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_entry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp', 'model_name', 'model_id', 'operation', 'field_name', 'old_value', 'new_value', 'user_id', 'ip'], 'required'],
            [['old_value', 'new_value'], 'string'],
            [['timestamp', 'model_name', 'model_id', 'operation', 'field_name', 'user_id', 'ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'model_id' => Yii::t('app', 'Model Id'),
            'model_name' => Yii::t('app', 'Model Name'),
            'operation' => Yii::t('app', 'Action'),
            'field_name' => Yii::t('app', 'Updated Field Name'),
            'old_value' => Yii::t('app', 'Old Value'),
            'new_value' => Yii::t('app', 'New Value'),
            'timestamp' => Yii::t('app','Timestamp'),
            'ip' => Yii::t('app', 'IP Address'),
        ];
    }
}
