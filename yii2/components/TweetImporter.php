<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 27.02.16
 * Time: 23:42
 */
namespace app\components;

use app\models\TweetStructure;
use Yii;
use yii\base\Component;
use app\models\Tweet;
use yii\base\Model;

class TweetImporter extends Component{

    /**
     * @param $unpreparedTweets
     * @return array
     */
    public function tweetImport($unpreparedTweets){

        $tweets= new TweetStructure($unpreparedTweets);

        $preparedTweets =[];
        $textArray = $tweets->getTweetText();
        $dateArray = $tweets->getDateWriten();
        $tagsArray = $tweets->getHashTags();

        for ($i = 0; $i<$tweets->getTweetCounts();$i++)
        {
            $preparedTweets[$i] = [
                'tweetText' => $textArray[$i],
                'dateWriten' => $dateArray[$i],
                'hashtags' => $tagsArray[$i],
            ];
        }
        $this->saveTweet($preparedTweets);
        return $preparedTweets;
    }

    private function saveTweet($preparedTweets){

        for ($i = 0; $i< count($preparedTweets); $i++) {
            $tweetForSave = Tweet::createPreparedTweet($preparedTweets[$i]);
            $tweetForSave->save();
        }
    }
}