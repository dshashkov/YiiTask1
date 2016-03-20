<?php
/**
 * This component used for build statistic by #hashtags
 * For statistic used dependence of #hashtags and dates of import tweets into Database
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

namespace app\components;


use app\models\Tweet;
use yii\base\Component;

class TweetStatistic extends Component
{
    /**
     * @param $dateAndTimeForSearch
     * @return array
     */
    public function statisticByDate($dateAndTimeForSearch)
    {
        $hashtagFounded = [];

        $tweets = Tweet::find()
            ->byDate($dateAndTimeForSearch)
            ->hashtagsViaJunctionTable()
            ->all();

        foreach ($tweets as $tweet) {
            foreach ($tweet->hashtagTexts as $hashtagText) {
                $hashtagFounded[] = $hashtagText->attributes['text'];
            }
        }

        return $this->hashtagStatistic($hashtagFounded);
    }


    /**
     * @param $hashtags
     * @return array
     */
    private function hashtagStatistic($hashtags)
    {
        $statistic = array_count_values($hashtags);

        arsort($statistic);

        return $statistic;
    }
}