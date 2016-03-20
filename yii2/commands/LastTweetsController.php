<?php
/**
 * Controller used for:
 * Finding last imported tweets by TweetLastFinder component
 * Display founded tweets into console in JSON format by TweetShow component
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

namespace app\commands;


use app\components\TweetLastFinder;
use app\components\TweetShow;
use yii\console\Controller;
use yii;

class LastTweetsController extends Controller
{
    /**
     * @param int $count
     * @throws yii\base\InvalidConfigException
     */
    public function actionIndex($count = 10)
    {
        /** @var TweetLastfinder $tweetLastFinder */
        $tweetLastFinder = Yii::$app->get('tweetlastfinder');

        /**
         * @var TweetShow $tweetShow
         */
        $tweetShow = Yii::$app->get('tweetshow');

        $tweetShow->showLastTweetsJSON($tweetLastFinder->lastTweetsFind($count));
    }
}