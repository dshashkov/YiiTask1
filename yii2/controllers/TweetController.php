<?php
/**
 * Rest controller used for:
 * Finding last imported tweets by TweetLastFinder component, LastTweets action.
 * Count should be transmitted as parameter.
 * Request view: tweet/last-tweets/<count>
 *
 * Finding all tweets which include assigned #hashtag by TweetHashtagFinder component, FindByHashtag action.
 * Hashtag should be transmitted as parameter                                        
 * Request view: tweet/find-by-hashtag/<hashtag>
 *
 * Build #hashtags statistic according to entry date by TweetStatistic component.
 * Dates "from","from" should be transmitted as a parameter in format which can be parsed into DateTime
 * Request view: tweet/hashtag-statistic/<from>/<to>
 *
 * Response can be returned according request format.
 *
 * @author Shashkov Denis
 * @date   31.03.16
 */

namespace app\controllers;

use app\components\TweetHashtagFinder;
use app\components\TweetLastFinder;
use app\components\TweetStatistic;
use DateTime;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

class TweetController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application\json' => Response::FORMAT_JSON,
            ]
        ];
        $behaviors['authenticator'] = [
          'class' => QueryParamAuth::className()
        ];

        return $behaviors;
    }


    /**
     * @param int $count
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLastTweets($count)
    {
        /**
         * @var TweetLastfinder $tweetLastFinder
         */
        $tweetLastFinder = Yii::$app->get('tweetlastfinder');

        return $tweetLastFinder->findLastTweets($count);
    }


    /**
     * @param string $from
     * @param string $to
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionHashtagStatistic($from, $to)
    {

        /**
         * @var TweetStatistic $tweetStatistic
         */
        $tweetStatistic = Yii::$app->get('tweetstatistic');

        $dateTimeFrom = new DateTime($from);
        $fromDateTime = $dateTimeFrom->format('Y-m-d H:i:s');

        $dateTimeTo = new DateTime($to);
        $toDateTime = $dateTimeTo->format('Y-m-d H:i:s');

        return $tweetStatistic->getHashtagsStatistic($fromDateTime, $toDateTime);
    }


    /**
     * @param string $hashtag
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionFindByHashtag($hashtag)
    {
        /**
         * @var TweetHashtagFinder $tweetHashtagFinder
         */
        $tweetHashtagFinder = Yii::$app->get('tweethashtagfinder');

        return $tweetHashtagFinder->findTweetByHashtag($hashtag);
    }
}