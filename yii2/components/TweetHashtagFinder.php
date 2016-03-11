<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.03.16
 * Time: 14:10
 */
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Tweet;
use app\models\TweetHashtag;

class TweetHashtagFinder extends Component{

    /**
     * @param $hashtagForSearch
     * @throws \yii\base\InvalidConfigException
     */
    public function findTweetByHashtag($hashtagForSearch){
        $idForSearch = [];

        $tweetsHashtags = TweetHashtag::find()
            ->byText($hashtagForSearch)
            ->all();

        foreach($tweetsHashtags as $founded)
        {
            $idForSearch[]=(int)$founded->attributes['tweet_id'];
        }
        $tweetsByHashtag = Tweet::find()
            ->byId($idForSearch)
            ->all();

        $tweetsForShow = [];
        foreach ($tweetsByHashtag as $tweet)
        {
            $tempHashtag = [];
            $findHashtags = TweetHashtag::find()
                ->byId($tweet->attributes['id'])
                ->all();
            foreach($findHashtags as $hashtag)
            {
                $tempHashtag[] = $hashtag->attributes['hashtag_text'];
            }
            $tweetsForShow[] =array_merge($tweet->attributes, array('hashtags' =>$tempHashtag));
        }

        /** @var TweetShow $tweetShow */
        $tweetShow = Yii::$app->get('tweetshow');
        $tweetShow->showTweetsByHashtags($tweetsForShow,$hashtagForSearch);
    }
}