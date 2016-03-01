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

    /**
     * @param TweetStructure $tweets
     * @return Tweet[]
     */
    public function save(TweetStructure $tweets)
    {
        // TODO тут нарушение паттерна информационного посредника.
        // TODO TweetImporter знает слишком много о внутренем устройстве TweetStructure


        // гораздо лучше если у TweetStructure будет метод iterate
        // который будет возвращать через yield модель Tweet созданную внутри TweetStructure
        // поскольку у него есть вся необходимая для этого инфа
        $preparedTweets = [];

        foreach($tweets->iterateTweets() as $tweet) {
            $tweet->save();
            $preparedTweets[] = $tweet;
        }

        return $preparedTweets;
    }
}