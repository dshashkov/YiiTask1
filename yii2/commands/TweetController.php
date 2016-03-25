<?php
/**
 * Controller used for:
 * Receive tweets from Twitter API by TweetLoader component
 * Import received tweets into Database by TweetImporter component
 * Display imported tweets into console by TweetShow component
 *
 * @author Shashkov Denis
 * @date   20.03.16
 */

namespace app\commands;

use app\components\TweetImporter;
use app\components\TweetLoader;
use app\components\TweetShow;
use yii\console\Controller;
use yii;

class TweetController extends Controller
{
    /**
     * @param string $search
     *
     * @throws yii\base\InvalidConfigException
     */
    public function actionIndex($search = 'popular')
    {
        /**
         * @var TweetLoader   $tweetLoader
         * @var TweetImporter $tweetImporter
         */
        $tweetLoader   = Yii::$app->get('tweetloader');
        $tweets        = $tweetLoader->getPopularTweets($search);
        $tweetImporter = Yii::$app->get('tweetimporter');

        if ($tweetImporter->importTweet($tweets)) {
            /**
             * @var TweetShow $tweetShow
             */
            $tweetShow = Yii::$app->get('tweetshow');

            $tweetShow->showSavedTweets($tweets);
        }
    }
}