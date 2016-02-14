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
        $config = array(
            'consumer_key' => 'd4KdO116BkRghlk1l6lZD4gqo',
            'consumer_secret' => 'LeCmsBRUXX9YMar6hJ6h3GHCfFUV3jFT1tygaVny7N7m07UL5L',
            'oauth_token' => '4868612410-MxIVsQJhy4usrIbJk7ZhPKJGVopAqrHoTKh5tGl',
            'oauth_token_secret' => 'J5LCadZEGcuSDIxsP4shQn7iGv4CD9UFRkkpVJullnVcR',
            'output_format' => 'array'
        );

        $tw = new TwitterOAuth($config);

        $params = array(
            'q' => $search,
            'count' => 10,
            'result_type' => 'popular'
        );

        $response = $tw->get('search/tweets', $params)['statuses'];
        $textArray = [];
        $dateArray = [];
        $tagsArray = [];
        $unpreparedTagsArray = [];
        for ($i = 0; $i<count($response);$i++) {
            $dateWritenFormat = new dateTime ($response[$i]['created_at']);
            array_push($dateArray, $dateWritenFormat->format('F j, Y-m-d H:i:s'));
            array_push($textArray, $response[$i]['text']);
            array_push($unpreparedTagsArray, $response[$i]['entities']['hashtags']);
        }

        foreach($unpreparedTagsArray as $key)
        {
            $tempArray = [];
            foreach ($key as $k) {
                array_push($tempArray,$k['text']);
            }
            array_push($tagsArray,$tempArray);
        }

        $tweetCount = 0;
        for ($j = 0; $j < count($textArray); $j++)
        {
            $textForSave = $textArray[$j];
            $dateWritentForSave = $dateArray[$j];
            $dateImportedFormat = new DateTime('now');
            $dateImportedForSave  = $dateImportedFormat->format('F j, Y-m-d H:i:s');
            $this->save_tweet($textForSave,$dateWritentForSave,$dateImportedForSave);
            $tweetCount++;
        }
        echo 'Получено и записано в базу данных в таблицу `tweet` '. $tweetCount . ' твиттов:' . "\n";
        for ($n = 0; $n < count($textArray); $n++)
        {
            echo "\033[01;31m Твитт #".($n+1)."\n";
            echo "\033[01;32mТекст твитта: " .  $textArray[$n]."\n";
            echo 'Дата написания твитта: ' .  $dateArray[$n]."\n\n";
        }
    }
    public function save_tweet($tweetText, $dateWriten, $dateImported)
    {
        $tweet = new Tweet();
        $tweet->text = $tweetText;
        $tweet->date_imported = $dateImported;
        $tweet->date_written = $dateWriten;
        return $tweet->save();
    }
}