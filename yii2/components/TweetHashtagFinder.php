<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.03.16
 * Time: 14:10
 */
namespace app\components;

use app\models\Hashtag;
use Yii;
use yii\base\Component;

class TweetHashtagFinder extends Component{

    /**
     * @param $hashtagForSearch
     * @throws \yii\base\InvalidConfigException
     */
    public function findTweetByHashtag($hashtagForSearch){
        $tweetsForShow = [];
        $hashtags = Hashtag::find()
            ->byHashtag($hashtagForSearch)
            ->all();

        foreach($hashtags as $hashtag)
        {
            foreach($hashtag->tweets as $tweet)
            {
                $tempHashtags = [];
                foreach($tweet->hashtagTexts as $hashtagText)
                {
                    $tempHashtags[] = $hashtagText->attributes['text'];
                }
                $tweetsForShow[] = array_merge($tweet->attributes,['hashtags' => $tempHashtags]);
            }
        }
        /** @var TweetShow $tweetShow */
        $tweetShow = Yii::$app->get('tweetshow');
        $tweetShow->showTweetsByHashtags($tweetsForShow,$hashtagForSearch);
    }
}