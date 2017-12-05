<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tel_b".
 *
 * @property string $id
 * @property string $username
 * @property integer $age
 * @property integer $sex
 * @property string $tel
 */
class TelB extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tel_b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'sex'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['tel'], 'string', 'max' => 20],
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
            'age' => 'Age',
            'sex' => 'Sex',
            'tel' => 'Tel',
        ];
    }
}
