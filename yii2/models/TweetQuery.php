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
     * @param $count
     * @return $this
     */
    public function byLastOnes($count)
    {
        return $this->orderBy(['id' => SORT_DESC])
            ->limit($count);
    }


    /**
     * @param $date
     * @return $this
     */
    public function byDate($date)
    {
        return $this->andWhere(['<','date_imported', $date]);
    }


    /**
     * @return $this
     */
    public function hashtagsViaJunctionTable()
    {
        return $this->with('hashtagTexts');
    }
}