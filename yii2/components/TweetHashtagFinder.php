<?php
/**
 * This component used for finding tweets which include assigned #hashtag
 *
 * @author Shashkov Denis
 * @date   20.03.16
 */

namespace app\components;

use app\models\Hashtag;
use Yii;
use yii\base\Component;

class TweetHashtagFinder extends Component
{

    /**
     * @param $hashtagForSearch
     *
     * @return array
     */
    public function findTweetByHashtag($hashtagForSearch)
    {
        $hashtags = Hashtag::find()
            ->byHashtag($hashtagForSearch)
            ->tweetsViaJunctionTable()
            ->all();

        return $this->composeTweets($hashtags);
    }

    /**
     * @param Hashtag[] $hashtags
     *
     * @return array
     */
    private function composeTweets(array $hashtags)
    {
        $tweets = [];

        foreach ($hashtags as $hashtag) {
            foreach ($hashtag->tweets as $tweet) {
                $tempHashtags = [];
                foreach ($tweet->hashtagTexts as $hashtagText) {
                    $tempHashtags[] = $hashtagText->attributes['text'];
                }
                $tweets[] = array_merge($tweet->attributes, ['hashtags' => $tempHashtags]);
            }
        }

        return $tweets;
    }
}