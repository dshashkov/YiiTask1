<?php
namespace app\commands;

use app\components\TweetImporter;
use app\components\TweetLoader;
use app\components\TweetShow;
use yii\console\Controller;
use yii;

class TweetController extends Controller
{
    public function actionIndex($search = 'popular')
    {
        /**
         * @var TweetLoader $tweetLoader
         */
        $tweetLoader = Yii::$app->tweetloader;

        /**
         * @var TweetShow $tweetShow
         */
        $tweetShow = Yii::$app->tweetshow;

        /**
         * @var TweetImporter $tweetImporter
         */
        $tweetImporter = Yii::$app->tweetimporter;

        $popularTweets = $tweetLoader->getPopularTweets($search);

        // В использовании TweetImporter в отдельности мало смысла.
        // лучше перенести его использование в getPopularTweets
        // И из метода getPopularTweets возвращать массив моделей Tweet который уже сохранены.
        $importedTweets = $tweetImporter->save($popularTweets);

        $tweetShow->showSavedTweets($importedTweets);
    }
}