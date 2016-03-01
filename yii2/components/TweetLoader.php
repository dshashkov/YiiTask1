<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 26.02.16
 * Time: 20:57
 */
namespace app\components;

use Yii;
use yii\base\Component;
use TwitterOAuth\TwitterOAuth;

class TweetLoader extends Component{

    public $tweetConfig;

    /**
     * @param string $search
     * @return TweetStructure
     * @throws \yii\base\InvalidConfigException
     */
    public function getPopularTweets($search = 'popular')
    {
        $tweetParams = [
            'q' => $search,
            'count' => 10,
            'result_type' => 'popular'
        ];
        $tweet = new TwitterOAuth($this->tweetConfig);

        /**
         * @var TweetStructure $tweets
         */
        $unpreparedTweets = $tweet->get('search/tweets', $tweetParams);

        $tweets = \Yii::createObject([
            'class' => TweetStructure::className(),
        ],[$unpreparedTweets]);

        return $tweets;
    }
}