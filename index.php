<?php
header('Content-Type: text/html; charset=utf-8');
//ini_set('display_errors', 1);
require_once('global/tweetget/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "4868612410-MxIVsQJhy4usrIbJk7ZhPKJGVopAqrHoTKh5tGl",
    'oauth_access_token_secret' => "J5LCadZEGcuSDIxsP4shQn7iGv4CD9UFRkkpVJullnVcR",
    'consumer_key' => "d4KdO116BkRghlk1l6lZD4gqo",
    'consumer_secret' => "LeCmsBRUXX9YMar6hJ6h3GHCfFUV3jFT1tygaVny7N7m07UL5L"
);


/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = 'q=?&result_type=popular&count=10';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
//$data = json_decode($response)->statuses;
$data = json_decode($response, true)['statuses'];
$data_for_db = get_db_value($data);
//$i=0;
function get_db_value($data)
{
    $prepared_value =[];


        foreach ($data as $k => $v) {
            $tempText = '';
            $tempDate = '';
            $tempHashtags = [];
            foreach ($data[$k] as $key => $value) {
                if ($key != 'text' && $key != 'created_at' && $key != 'entities') {
                    unset($data[$k][$key]);
                }
                if($key == 'text')
                {
                    $tempText = $value;
                }
                if($key == 'created_at')
                {
                    $tempDate = $value;
                }
                if ($key == 'entities') {
                    foreach ($data[$k][$key] as $is_hashtag => $hasht_value) {
                        if ($is_hashtag != 'hashtags') {
                            unset($data[$k][$key][$is_hashtag]);
                        } else {
                            foreach ($data[$k][$key][$is_hashtag] as $is_index => $isi_value) {
                                foreach ($data[$k][$key][$is_hashtag][$is_index] as $last_one => $last_val) {
                                    if ($last_one != 'text') {
                                        unset($data[$k][$key][$is_hashtag][$is_index][$last_one]);
                                    } else {
                                        array_push($tempHashtags,$last_val);
                                    }
                                }
                            }
                        }
                    }

                }
            }
            $prepared_value[] = array(
                'tweet_text' => $tempText,
                'tweet_date' => $tempDate,
                'tweet_hashtags' => $tempHashtags,
                );
        }
    return $prepared_value;
}
echo 'обработанный вывод для дальнейшей работы';
echo '<hr>';
echo '<pre>';
print_r($data_for_db);
echo '</pre>';
echo '<hr>';
echo 'дамп целого json без обработки';
echo '<pre>';
var_dump(json_decode($response));
echo '</pre>';
