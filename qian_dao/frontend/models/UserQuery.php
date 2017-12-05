<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[user]].
 *
 * @see user
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return user[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return user|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
