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

    /**
     * @param $tweetID
     * @return $this
     */
    public  function byId($tweetID)
    {
        return $this->where(['id' => $tweetID]);
    }

    /**
     * @param $count
     * @return $this
     */
    public function byLastOnes($count)
    {
        return $this->orderBy(['id' => SORT_DESC])
            ->with('tweetHashtags')
            ->limit($count);
    }

    /**
     * @param $date
     * @return $this
     */
    public function byDate($date)
    {
        return $this->where(['like','date_imported',$date])
            ->with('tweetHashtags');
    }

}