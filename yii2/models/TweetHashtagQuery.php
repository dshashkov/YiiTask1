<?php

namespace app\models;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[TweetHashtag]].
 * @method Tweet[] all($db = null)
 * @method Tweet one($db = null)                                                                      
 * @see TweetHashtag
 */
class TweetHashtagQuery extends ActiveQuery
{

    public function byText($hashtagText)
    {
        return $this->where(['hashtag_text' => $hashtagText]);
    }

    public function byId($tweetID)
    {
        return $this->where(['tweet_id' => $tweetID]);
    }
}