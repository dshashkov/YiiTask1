<?php

namespace app\models;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tweet]].
 * @method Tweet[] all($db = null)
 * @method Tweet one($db = null)
 * @see Tweet
 */
class TweetQuery extends ActiveQuery
{

    public  function byId($tweetID)
    {
        return $this->where(['id' => $tweetID]);
    }

    public function byLastOnes($count)
    {
        return $this->orderBy(['id' => SORT_DESC])
            ->limit($count);
    }

    public function byDate($date)
    {
        return $this->where(['like','date_imported',$date]);
    }
}