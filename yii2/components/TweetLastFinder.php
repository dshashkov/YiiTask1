<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.03.16
 * Time: 14:09
 */
namespace app\components;

use app\models\Tweet;
use Yii;
use yii\base\Component;

class TweetLastFinder extends Component{


    /**
     * @param int $count
     */
    public function lastTweetsFind($count){

        $tweetsForJSON = [];
        $lastTweets = Tweet::find()
            ->byLastOnes($count)
            ->all();


        foreach ($lastTweets as $lastTweet)
        {
            $tempHashtag = [];
            foreach($lastTweet->hashtagTexts as $hashtagText)
            {
                $tempHashtag[] = $hashtagText->attributes['text'];
            }
            $tweetsForJSON[] = array_merge($lastTweet->attributes, ['hashtag' => $tempHashtag]);
        }
        $json = (json_encode($tweetsForJSON));
        echo $json."\n";
    }

}