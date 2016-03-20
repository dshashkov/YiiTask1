<?php

namespace app\models;


use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Hashtag]].
 * @method Hashtag[] all($db = null)
 * @method Hashtag one($db = null)
 * @see Hashtag
 */
class HashtagQuery extends ActiveQuery
{
    /**
     * @param string $hashtag
     * @return $this
     */
    public function byHashtag($hashtag)
    {
        return $this->andWhere(['text' => $hashtag]);
    }


    /**
     * @return $this
     */
    public function tweetsViaJunctionTable()
    {
        return $this->with('tweets');
    }
}