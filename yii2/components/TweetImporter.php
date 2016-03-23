<?php
/**
 * This component used for importing TweetStructure[] into Database
 *
 * @author Shashkov Denis
 * @date   20.03.16
 */

namespace app\components;

use app\models\Hashtag;
use app\models\TweetStructure;
use Yii;
use yii\base\Component;
use app\models\Tweet;
use yii\base\Exception;

class TweetImporter extends Component
{
    /**
     * @param TweetStructure[] $tweets
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function importTweet(array $tweets)
    {
        $dbTransaction = Tweet::getDb()->beginTransaction();
        try {
            foreach ($tweets as $tweet) {

                $this->saveTweet($tweet);
            }
            $dbTransaction->commit();

            return true;
        } catch (\Exception $e) {
            $dbTransaction->rollBack();

            throw $e;
        }
    }

    /**
     * @param TweetStructure $tweetStructure
     *
     * @throws Exception
     */
    private function saveTweet(TweetStructure $tweetStructure)
    {
        $tweetText       = $tweetStructure->getTweetText();
        $tweetDateWriten = $tweetStructure->getDateWriten();
        $tweetHashtags   = $tweetStructure->getHashtags();

        $tweet = Tweet::createInstanceFromParam($tweetText, $tweetDateWriten);

        if (!$tweet->save()) {
            throw new Exception('Ошибка записи в базу данных: Таблица tweet');
        }

        if (!empty($tweetHashtags)) {
            $this->importHashtags($tweet, $tweetHashtags);
        }
    }

    /**
     * @param Tweet $tweet
     * @param array $tweetHashtags
     *
     * @throws Exception
     */
    private function importHashtags(Tweet $tweet, array $tweetHashtags)
    {
        foreach ($tweetHashtags as $tweetHashtag) {
            $hashtagFromDb = Hashtag::findOne($tweetHashtag);

            if (empty($hashtagFromDb)) {
                $hashtag = Hashtag::createInstanceFromParam($tweetHashtag);

                if (!$hashtag->save()) {
                    throw new Exception('Ошибка записи в базу данных: Таблица hashtag');
                }

                $tweet->link('hashtagTexts', $hashtag);
            } else {
                /**
                 * @var Hashtag $hashtagFromDb
                 */
                $tweet->link('hashtagTexts', $hashtagFromDb);
            }
        }
    }
}