<?php
/**
 * This component used for finding last tweets which imported to Database
 * Count of tweets according to received $count
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

namespace app\components;


use app\models\Tweet;
use Yii;
use yii\base\Component;

class TweetLastFinder extends Component
{
    /**
     * @param int $count
     * @return array
     */
    public function lastTweetsFind($count)
    {
        $tweetsForJSON = [];

        $lastTweets = Tweet::find()
            ->byLastOnes($count)
            ->hashtagsViaJunctionTable()
            ->all();

        foreach ($lastTweets as $lastTweet) {
            $tempHashtag = [];

            foreach ($lastTweet->hashtagTexts as $hashtagText) {
                $tempHashtag[] = $hashtagText->attributes['text'];
            }
            $tweetsForJSON[] = array_merge($lastTweet->attributes, ['hashtag' => $tempHashtag]);
        }

        return $tweetsForJSON;
    }
}