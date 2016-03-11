<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.03.16
 * Time: 14:09
 */
namespace app\components;

use app\models\Tweet;
use app\models\TweetHashtag;
use Yii;
use yii\base\Component;

class TweetLastFinder extends Component{


    /**
     * @param int $count
     */
    public function lastTweetsFind($count){
        $tweetsForJSOM = [];
        $lastTweets = Tweet::find()
            ->byLastOnes($count)
            ->all();


        foreach($lastTweets as $tweet)
        {
            $tempHashtag = [];
            $findHashtags = TweetHashtag::find()
                ->byId($tweet->attributes['id'])
                ->all();
            foreach($findHashtags as $hashtag)
            {
                $tempHashtag[] = $hashtag->attributes['hashtag_text'];
            }
            $tweetsForJSOM[] =array_merge($tweet->attributes, array('hashtags' =>$tempHashtag));

        }
        $json = (json_encode($tweetsForJSOM));

        echo $json."\n";
    }

}