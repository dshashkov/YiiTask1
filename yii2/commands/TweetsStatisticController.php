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
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $stdin = fopen("php://stdin", "r");

        /**
         * @var TweetShow $tweetShow
         */
        $tweetShow = Yii::$app->get('tweetshow');

        $tweetShow->showStatisticInformMessage();

        $enteredData = fgets($stdin);

        try {
            $dateTime = $this->convertDateTime($enteredData);

            /**
             * @var TweetStatistic $tweetStatistic
             */
            $tweetStatistic = Yii::$app->get('tweetstatistic');

            $statistic = $tweetStatistic->getHashtagsStatisticByDate($dateTime);

            $tweetShow->statisticByHashtags($statistic, $dateTime);
        } catch (\Exception $e) {
            $tweetShow->wrongFormatMessage();
        }
    }

    private function convertDateTime($enteredData)
    {
        $dateTime = new DateTime($enteredData);

        return $dateTime->format('Y-m-d H:i:s');
    }
}
