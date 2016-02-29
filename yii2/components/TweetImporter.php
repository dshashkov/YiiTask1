<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 27.02.16
 * Time: 23:42
 */
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Tweet;
class TweetImporter extends Component{

    public function tweetImport($unpreparedTweets){

        $tweets= \Yii::createObject([
            'class' => TweetStructure::className(),
        ],[$unpreparedTweets]);

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

    public function saveTweet($preparedTweets){

        for ($i = 0; $i< count($preparedTweets); $i++) {
            $tweetForSave = Tweet::createPreparedTweet($preparedTweets[$i]);
            $tweetForSave->save();
        }
    }
}