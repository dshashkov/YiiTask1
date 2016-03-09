<?php
namespace app\commands;

use app\components\TweetImporter;
use app\components\TweetLoader;
use yii\console\Controller;
use yii;

class TweetController extends Controller
{

    /**
     * @param string $search
     * @throws yii\base\InvalidConfigException
     */
    public function actionIndex($search = 'popular')
    {
        /**
         * @var TweetLoader $tweetLoader
         */
        $tweetLoader = Yii::$app->get('tweetloader');

        /**
         *@var TweetImporter $tweetImporter
         */
        $tweetImporter = Yii::$app->get('tweetimporter');

        $tweetsArray = $tweetLoader->getPopularTweets($search);
        $tweetImporter->tweetImport($tweetsArray);

    }
}