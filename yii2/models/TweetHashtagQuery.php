<?php
/**
 * Created by PhpStorm.
 * User: voksiv
 * Date: 11.03.16
 * Time: 4:00
 */

namespace app\models;


use yii\db\ActiveQuery;

/**
 * Class TweetHashtagQuery
 * @package app\models
 * @method TweetHashtag[] all($db = null)
 * @method TweetHashtag one($db = null)
 */
class TweetHashtagQuery extends ActiveQuery
{
    /**
     * @param string $text
     * @return $this
     */
    public function byText($text)
    {
        return $this->where(['hashtag_text' => $text]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->where(['tweet_id' => $id]);
    }

}