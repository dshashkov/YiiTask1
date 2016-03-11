<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.03.16
 * Time: 16:46
 */
namespace app\components;

use app\models\Tweet;
use app\models\TweetHashtag;
use yii\base\Component;


class TweetStatistic extends Component{

    /**
     * @param string $dateForSearch
     * @return array
     */
    public function statisticByDate($dateForSearch)
    {
        $hashtagFounded = [];

        $tweets = Tweet::find()
            ->byDate($dateForSearch)
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
    private function hashtagStatistic($hashtags){
        $statistic = array_count_values($hashtags);
        arsort($statistic);
        return $statistic;
    }
}