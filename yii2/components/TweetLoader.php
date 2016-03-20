<?php
/**
 * This component for receiving tweet in JSON from Twitter API 1.1
 * For work with Twitter API used "TwitterOAuth by @Ricard0Per" library
 * According Twitter API docs, necessary parameter of search by assigned words has default value - popular
 * This parameter can be changed according assigned argument $search
 * Fixed count of tweets - 10
 * Default
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

namespace app\components;


use app\models\TweetStructure;
use Yii;
use yii\base\Component;
use TwitterOAuth\TwitterOAuth;

class TweetLoader extends Component
{
    public $tweetConfig;


    /**
     * @param string $search
     * @return TweetStructure[]
     */
    public function getPopularTweets($search = 'popular')
    {
        $tweetParams = [
            'q'           => $search,
            'count'       => 10,
            'result_type' => 'popular'
        ];

        $tweet = new TwitterOAuth($this->tweetConfig);

        $twitterApiResponse = $tweet->get('search/tweets', $tweetParams);

        $parsedTweets = $this->parseTweetsData($twitterApiResponse);

        return $this->arrayOftweets($parsedTweets);
    }

    /**
     * @param array $parsedTweets
     * @return TweetStructure[]
     */
    private function arrayOftweets(array $parsedTweets)
    {
        $tweetsArray = [];

        foreach ($parsedTweets as $parsedTweet) {
            $tweetsArray[] = new TweetStructure(
                $parsedTweet['text'],
                $parsedTweet['dateWriten'],
                $parsedTweet['hashtags']
            );
        }
        return $tweetsArray;
    }

    /**
     *  Example response:
     * {
     *   "statuses": [
     *   {
     *     "coordinates": null,
     *     "favorited": false,
     *     "truncated": false,
     *     "created_at": "Mon Sep 24 03:35:21 +0000 2012",
     *     "id_str": "250075927172759552",
     *     "entities": {
     *       "urls": [
     *
     *       ],
     *       "hashtags": [
     *         {
     *           "text": "freebandnames",
     *           "indices": [
     *             20,
     *             34
     *           ]
     *         }
     *       ],
     *       "user_mentions": [
     *
     *       ]
     *     },
     *     "in_reply_to_user_id_str": null,
     *     "contributors": null,
     *     "text": "Aggressive Ponytail #freebandnames",
     *
     * @param array $twitterApiResponse
     * @return array
     */
    private function parseTweetsData(array $twitterApiResponse)
    {
        $parsedTweets = [];

        $tweets = $twitterApiResponse['statuses'];

        foreach ($tweets as $tweet) {
            $text               = $tweet['text'];
            $dateWriten         = $tweet['created_at'];
            $hashtagsAndIndices = $tweet['entities']['hashtags'];
            $hashtags = [];

            foreach ($hashtagsAndIndices as $hastagAndIndices) {
                foreach ($hastagAndIndices as $key => $value) {
                    $key == 'text' ? $hashtags[] = $value : null;
                }
            }
            $parsedTweets[] = [
                'text'       => $text,
                'dateWriten' => $dateWriten,
                'hashtags'   => $hashtags
            ];
        }

        return $parsedTweets;
    }
}