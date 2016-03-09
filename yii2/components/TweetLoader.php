<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 26.02.16
 * Time: 20:57
 */
namespace app\components;

use app\models\TweetStructure;
use Yii;
use yii\base\Component;
use TwitterOAuth\TwitterOAuth;
use DateTime;

class TweetLoader extends Component{

    public $tweetConfig;

    /**
     * @param string $search
     * @return array
     */
    public function getPopularTweets($search = 'popular')
    {
        $tweetParams = [
            'q' => $search,
            'count' => 10,
            'result_type' => 'popular'
        ];
        $tweet = new TwitterOAuth($this->tweetConfig);
        $responseFromTwitterApi = $tweet->get('search/tweets', $tweetParams);


        return $this->arrayOftweets($responseFromTwitterApi);
        //return $tweet->get('search/tweets', $tweetParams);
    }

    /**
     * @param array $twitterApiResponse
     * @return array
     */
    private function arrayOftweets($twitterApiResponse){

        $tweetsArray = [];

        $tweetsTextArray = $this->parseText($twitterApiResponse);
        $tweetsDateWritenArray = $this->parseDate($twitterApiResponse);
        $tweetHashtagsArray = $this->parseHashtags($twitterApiResponse);

        foreach ($twitterApiResponse['statuses'] as $key => $value)
        {
            $tweetsArray[] = new TweetStructure($tweetsTextArray[$key],
                $tweetsDateWritenArray[$key],
                $tweetHashtagsArray[$key],
                $config = []);
        }
        return $tweetsArray;
    }

    /**
     * @param array $twitterApiResponse
     * @return array
     */
    private function parseText($twitterApiResponse){
        $textArray = [];
        $tweets = $twitterApiResponse['statuses'];
        foreach ($tweets as $key) {
            $textArray[]=$key['text'];
        }
        return $textArray;
    }
    private function parseDate($twitterApiResponse){
        $dateArray = [];
        $tweets = $twitterApiResponse['statuses'];

        foreach ($tweets as $key) {
            $dateWritenFormat = new dateTime ($key['created_at']);
            $dateArray[] = $dateWritenFormat->format('F j, Y-m-d H:i:s');
        }
        return $dateArray;
    }

    /**
     * @param array $twitterApiResponse
     * @return array
     */
    private function parseHashtags($twitterApiResponse){
        $tagsArray = [];
        $unpreparedTagsArray = [];

        $tweets = $twitterApiResponse['statuses'];

        foreach ($tweets as $key)  {
            $unpreparedTagsArray[] = $key['entities']['hashtags'];
        }

        foreach ($unpreparedTagsArray as $array) {
            $tempArray = [];
            foreach ($array as $k) {
                $tempArray[] = $k['text'];
            }
            $tagsArray[] = $tempArray;
        }
        return $tagsArray;
    }
}