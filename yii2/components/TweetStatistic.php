<?php
/**
 * This component used for build statistic by #hashtags
 * For statistic used dependence of #hashtags and dates of import tweets into Database
 *
 * @author Shashkov Denis
 * @date   20.03.16
 */

namespace app\components;

use app\models\Tweet;
use yii\base\Component;

class TweetStatistic extends Component
{
    /**
     * @param $dateAndTime
     *
     * @return array
     */
    public function getHashtagsStatisticByDate($dateAndTime)
    {
        $tweets = Tweet::find()
            ->byDate($dateAndTime)
            ->hashtagsViaJunctionTable()
            ->all();

        $hashtags = $this->getHashtags($tweets);

        return $this->prepareHashtagsStatistic($hashtags);
    }

    /**
     * @param Tweet[] $tweets
     *
     * @return array
     */
    private function getHashtags(array $tweets)
    {
        $hashtags = [];

        foreach ($tweets as $tweet) {
            foreach ($tweet->hashtagTexts as $hashtagText) {
                $hashtags[] = $hashtagText->attributes['text'];
            }
        }

        return $hashtags;
    }

    /**
     * @param array $hashtags
     *
     * @return array
     */
    private function prepareHashtagsStatistic(array $hashtags)
    {
        $statistic = array_count_values($hashtags);

        arsort($statistic);

        return $statistic;
    }
}