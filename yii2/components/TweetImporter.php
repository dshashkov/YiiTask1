<?php
/**
 * This component used for importing TweetStructure[] into Database
 *
 * @author Shashkov Denis
 * @date 20.03.16
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
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function tweetImport(array $tweets)
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
            foreach ($tweetHashtags as $tweetHashtag) {
                $hashtagFromDb = Hashtag::findOne($tweetHashtag);

                if (empty($hashtagFromDb)) {
                    $hashtag = Hashtag::createInstanceFromParam($tweetHashtag);

                    if (!$hashtag->save()) {
                        throw new Exception('Ошибка записи в базу данных: Таблица hashtag');
                    }
                    if ($tweet->validate() && $hashtag->validate()) {
                        $tweet->link('hashtagTexts', $hashtag);
                    } else {
                        throw new Exception('Ошибка валидации');
                    }
                } else {
                    /** @var Hashtag $hashtagFromDb */
                    if ($tweet->validate() && $hashtagFromDb->validate()) {
                        $tweet->link('hashtagTexts', $hashtagFromDb);
                    } else {
                        throw new Exception('Ошибка валидации');
                    }
                }
            }
        }
    }
}