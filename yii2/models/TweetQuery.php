<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tweet]].
 * @method Tweet[] all($db = NULL)
 * @method Tweet one($db = NULL)
 *
 * @see Tweet
 */
class TweetQuery extends ActiveQuery
{
    /**
     * @param $count
     *
     * @return $this
     */
    public function byLastOnes($count)
    {
        return $this->orderBy(['id' => SORT_DESC])
            ->limit($count);
    }

    /**
     * @param $fromDateTime
     * @param $toDateTime
     *
     * @return $this
     */
    public function byDate($fromDateTime, $toDateTime)
    {
        return $this->andWhere(['between', 'date_imported', $fromDateTime, $toDateTime]);
    }

    /**
     * @return $this
     */
    public function hashtagsViaJunctionTable()
    {
        return $this->with('hashtagTexts');
    }
}