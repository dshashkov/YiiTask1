<?php
namespace app\commands;

use yii\console\Controller;
use yii;
use TwitterOAuth\TwitterOAuth;
use app\models\Tweet;
use DateTime;

class TweetController extends Controller
{
    public function actionIndex($search = 'popular')
    {
        $tweetLoader = Yii::$app->tweetloader->getPopularTweets($search);
        Yii::$app->tweetshow->showSavedTweets(
            Yii::$app->tweetimporter->tweetImport($tweetLoader));
    }
}