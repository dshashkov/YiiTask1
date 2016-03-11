<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Hashtag]].
 * @method Hashtag[] all($db = null)
 * @method Hashtag one($db = null)
 * @see Hashtag
 */
class HashtagQuery extends \yii\db\ActiveQuery
{

    /**
     * @param $hashtag
     * @return $this
     */
    public function byHashtag($hashtag)
    {
        return $this->where(['text' => $hashtag])
        ->with('tweets');
    }
}