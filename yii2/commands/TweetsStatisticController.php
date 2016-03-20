<?php
/**
 * Controller used for:
 * Interactive features for entry of the date
 * Build #hashtags statistic according to entry date by TweetStatistic component
 * Display built statistic into console by TweetShow component
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */
namespace app\commands;


use app\components\TweetShow;
use app\components\TweetStatistic;
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

        $tweetShow->statisticInformMessage();

        $dateAndTimeForSearch = fgets($stdin);
        try {
            strtotime($dateAndTimeForSearch);
        } catch (\Exception $e) {
            echo "\033[01;31mНеверный формат даты!!!\n";
            die();
        }
        /**
         * @var TweetStatistic $tweetStatistic
         */
        $tweetStatistic = Yii::$app->get('tweetstatistic');

        $statistic = $tweetStatistic->statisticByDate($dateAndTimeForSearch);

        $tweetShow->statisticByHashtags($statistic, $dateAndTimeForSearch);
    }
}
