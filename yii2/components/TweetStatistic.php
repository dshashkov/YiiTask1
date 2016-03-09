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
    public function statisticByDate($dateForSearch){
        $tweetsID= [];

        $tweets = Tweet::find()
            ->where(['like','date_imported',$dateForSearch])
            ->all();

        foreach($tweets as $key)
        {
            $tweetsID[] = $key->attributes['id'];
        }


       return $this->hashtagStatistic(
           $this->findAllHashtags($tweetsID)
       );
    }

    /**
     * @param $tweetsID
     * @return array
     */
    private function findAllHashtags ($tweetsID){

        $hashtagsFounded =[];

        $hashtags = TweetHashtag::find()
            ->where(['tweet_id' => $tweetsID])
            ->all();
        foreach($hashtags as $key)
        {
            $hashtagsFounded[] = $key->attributes['hashtag_text'];
        }
        return  $hashtagsFounded;
    }

    private function hashtagStatistic($hashtags){
        $statistic = array_count_values($hashtags);
        arsort($statistic);
        return $statistic;
    }
}