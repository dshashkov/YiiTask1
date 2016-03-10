<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.03.16
 * Time: 16:35
 */
namespace app\commands;

use app\components\TweetShow;
use app\components\TweetStatistic;
use DateTime;
use Yii;
use yii\console\Controller;

class TweetsStatisticController extends Controller{


    public function actionIndex(){

        $stdin = fopen("php://stdin", "r");

        /** @var TweetShow $tweetShow */
        $tweetShow = Yii::$app->get('tweetshow');
        $tweetShow->statisticInformMessage();

        $dateForSearch = fgets($stdin);
        try{
        $dateTime = new DateTime($dateForSearch);
        } catch (\Exception $e)
        {
            echo "\033[01;31mНеверный формат даты!!!\n";
            die();
        }
        $date = $dateTime->format('Y-m-d');

        /** @var TweetStatistic $tweetStatistic */
        $tweetStatistic = Yii::$app->get('tweetstatistic');

        $statistic = $tweetStatistic->statisticByDate($date);
        $tweetShow->statisticByHashtags($statistic,$dateForSearch);
    }
}
