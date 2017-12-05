<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "demo".
 *
 * @property string $id
 * @property string $username
 * @property string $default
 * @property integer $t_id
 * @property string $option
 * @property integer $required
 * @property integer $v_id
 * @property string $length
 */
class Demo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_id', 'required', 'v_id'], 'integer'],
            [['username', 'length'], 'string', 'max' => 30],
            [['default', 'option'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'default' => 'Default',
            't_id' => 'T ID',
            'option' => 'Option',
            'required' => 'Required',
            'v_id' => 'V ID',
            'length' => 'Length',
        ];
    }
}
