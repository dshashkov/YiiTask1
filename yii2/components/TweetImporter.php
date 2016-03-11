<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 27.02.16
 * Time: 23:42
 */
namespace app\components;

use app\models\Hashtag;
use app\models\TweetHashtag;
use app\models\TweetStructure;
use Yii;
use yii\base\Component;
use app\models\Tweet;
use yii\base\Exception;

class TweetImporter extends Component{

    /**
     * @param $unpreparedTweets
     * @return array
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function tweetImport($unpreparedTweets){

        $savedTweets =[];

        $dbTransaction = Tweet::getDb()->beginTransaction();
        try {
            foreach ($unpreparedTweets as $tweet) {

                /**
                 * @var TweetStructure $tweet
                 */

                $this->saveTweet($tweet);
                $savedTweets[] = [
                    'tweetText' => $tweet->getTweetText(),
                    'dateWriten' => $tweet->getDateWriten(),
                    'hashtags' => $tweet->getHashtags(),
                ];

            }
            $dbTransaction->commit();
        }catch(\Exception $e )
        {
            $dbTransaction->rollBack();
            throw $e;
        }

        /**
         * @var TweetShow $tweetShow
         */
        $tweetShow = Yii::$app->get('tweetshow');
        $tweetShow->showSavedTweets($savedTweets);
    }


    /**
     * @param $tweet
     * @throws Exception
     */
    private function saveTweet($tweet)
    {
        /**
         * @var TweetStructure $tweet
         */
        $tweetText = $tweet->getTweetText();
        $dateWriten = $tweet->getDateWriten();
        $tweetHashtags = $tweet->getHashtags();



        $tweetTable = Tweet::createInstanceFromParam($tweetText, $dateWriten);
        if (!$tweetTable->save()) {
            throw new Exception('Ошибка записи в базу данных: Таблица tweet');
        }


        if (!empty($tweetHashtags))
        {
            foreach ($tweetHashtags as $key) {
                $hashtagFromDb = Hashtag::findOne($key);
                if (empty($hashtagFromDb))
                {
                    $hashtagTable = Hashtag::createInstanceFromParam($key);
                    if (!$hashtagTable->save())
                    {
                        throw new Exception('Ошибка записи в базу данных: Таблица hashtag');
                    }
                }
                $tweetLastId = Tweet::find()
                    ->max('id');

                $TweetHashtagTable = TweetHashtag::createInstanceFromParam($tweetLastId,$key);
                if (!$TweetHashtagTable->save())
                {
                    throw new Exception('Ошибка записи в базу данных: Таблица tweet_hashtag');
                }
            }

        }
    }

}