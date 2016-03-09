<?php
namespace app\commands;

use app\components\TweetLastFinder;
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
        $tweetLastFinder->lastTweetsFind($count);
    }
}