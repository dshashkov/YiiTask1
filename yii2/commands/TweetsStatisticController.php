<?php
/**
 * Controller used for:
 * Interactive features for entry of the date
 * Build #hashtags statistic according to entry date by TweetStatistic component
 * Display built statistic into console by TweetShow component
 *
 * @author Shashkov Denis
 * @date   20.03.16
 */
namespace app\commands;

use app\components\TweetShow;
use app\components\TweetStatistic;
use DateTime;
use Yii;
use yii\console\Controller;

class TweetsStatisticController extends Controller
{

    /**
     * @param string $between
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($between = 'fromBegin')
    {
        /**
         * @var TweetShow      $tweetShow
         * @var TweetStatistic $tweetStatistic
         */
        $tweetShow      = Yii::$app->get('tweetshow');
        $tweetStatistic = Yii::$app->get('tweetstatistic');
        $fromDateTime   = 'от даты создания таблицы';

        $tweetShow->showStatisticInformMessage();

        if ($between === 'between') {
            $tweetShow->showEnterFromDateTime();

            $fromDateTime = $this->entryDateTime();

            $tweetShow->showEnterToDateTime();

            $toDateTime = $this->entryDateTime();

            if ($toDateTime && $fromDateTime) {
                $statistic = $tweetStatistic->getHashtagsStatistic($fromDateTime, $toDateTime);

                $tweetShow->statisticByHashtags($statistic, $fromDateTime, $toDateTime);
            } else {
                $tweetShow->wrongFormatMessage();
            }
        } else {
            $tweetShow->showEnterToDateTime();

            if ($toDateTime = $this->entryDateTime()) {
                $statistic = $tweetStatistic->getHashtagsStatistic($fromDateTime, $toDateTime);

                $tweetShow->statisticByHashtags($statistic, $fromDateTime, $toDateTime);
            } else {
                $tweetShow->wrongFormatMessage();
            }
        }
    }

    /**
     * @return string
     */
    private function entryDateTime()
    {
        $stdin = fopen("php://stdin", "r");

        return $this->convertDateTime(fgets($stdin));
    }

    /**
     * @param string $enteredDate
     *
     * @return null|string
     */
    private function convertDateTime($enteredDate)
    {
        try {
            $dateTime = new DateTime($enteredDate);
        } catch (\Exception $e) {

            return NULL;
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
