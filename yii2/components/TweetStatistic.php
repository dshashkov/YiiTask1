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
     * @param string $toDateTime
     * @param string $fromDateTime
     *
     * @return array
     */
    public function getHashtagsStatistic($fromDateTime, $toDateTime)
    {
        $tweets   = $this->getTweets($fromDateTime, $toDateTime);
        $hashtags = $this->getHashtags($tweets);

        return $this->prepareStatistic($hashtags);
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
     * @param array $array
     *
     * @return array
     */
    private function prepareStatistic(array $array)
    {
        $statistic = array_count_values($array);

        arsort($statistic);

        return $statistic;
    }

    /**
     * @param $fromDateTime
     * @param $toDateTime
     *
     * @return Tweet[]
     */
    private function getTweets($fromDateTime, $toDateTime)
    {
        $tweets = Tweet::find()
            ->byDate($fromDateTime, $toDateTime)
            ->hashtagsViaJunctionTable()
            ->all();

        return $tweets;
    }
}