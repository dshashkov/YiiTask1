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

class TweetImporter extends Component
{
    /**
     * у данного метод должна быть отдна ответственность сохранять в базу все переданные твиты и больше ничего
     * название метода кстати как-то не очень говорит о чем тут речь идет. просто save было бы более понятным, и точнее отражало бы суть
     * зачем в методе tweetImport логика отображения твитов вообще не ясно.
     * это не ответственность данного метода
     * @param TweetStructure[] $tweets
     * @return Tweet[]
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function save($tweets)
    {
        $savedTweets =[];

        $dbTransaction = Tweet::getDb()->beginTransaction();

        try {
            foreach ($tweets as $tweet) {
                $savedTweets[] = $this->saveTweet($tweet);
            }
            $dbTransaction->commit();
        } catch( \Exception $e ) {
            $dbTransaction->rollBack();
            throw $e;
        }

        return $savedTweets;
    }


    /**
     * @param TweetStructure $tweet
     * @return Tweet
     * @throws Exception
     */
    private function saveTweet(TweetStructure $tweet)
    {
        $tweetTable = Tweet::createInstanceFromParam($tweet->getTweetText(), $tweet->getDateWriten());
        if (!$tweetTable->save()) {
            throw new Exception('Ошибка записи в базу данных: Таблица tweet');
        }

        $this->saveHashtags($tweet);

        return $tweetTable;
    }

    /**
     * TODO стоит отрефакторить, метод выглядит грязновато.
     * @param TweetStructure $tweet
     * @throws Exception
     */
    private function saveHashtags(TweetStructure $tweet)
    {
        $tweetHashtags = $tweet->getHashtags();
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