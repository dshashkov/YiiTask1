<?php
/**
 * Created by PhpStorm.
 * User: voksiv
 * Date: 11.03.16
 * Time: 4:13
 */

namespace app\models;

use yii\db\ActiveQuery;

/**
 * Class TweetQuery
 * @package app\models
 * @method Tweet[] all($db = null)
 * @method Tweet one($db = null)
 */
class TweetQuery extends ActiveQuery
{
    public function byId($ids)
    {
        return $this->where(['id' => $ids]);
    }
}