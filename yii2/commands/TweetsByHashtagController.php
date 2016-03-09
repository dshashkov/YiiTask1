<?php

namespace app\commands;

use app\components\TweetHashtagFinder;
use Yii;
use yii\console\Controller;
class TweetsByHashtagController extends Controller
{


    /**
     * @param $hashtagForSearch
     * @throws \yii\base\InvalidConfigException
     * @internal param string $hashtag
     */
    public function actionIndex($hashtagForSearch)
    {
        /** @var TweetHashtagFinder $tweetHashtagFinder */
        $tweetHashtagFinder = Yii::$app->get('tweethashtagfinder');
        $tweetHashtagFinder->findTweetByHashtag($hashtagForSearch);
    }

}