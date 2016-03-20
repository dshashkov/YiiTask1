<?php
/**
 * Controller used for:
 * finding all tweets which include assigned #hashtag by TweetHashtagFinder component
 * Display founded tweets into console by TweetShow component
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

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