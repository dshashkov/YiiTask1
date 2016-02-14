<?php

namespace app\controllers;
use yii;
use TwitterOAuth\TwitterOAuth;
class MainController extends \yii\web\Controller
{
    public function actionIndex()
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
            'q' => 'test',
            'count' => 10,
            'result_type' => 'popular'
        );

        $response = $tw->get('search/tweets', $params)['statuses'];
        $textArray = [];
        $dateArray = [];
        $tagsArray = [];
        $unpreparedTagsArray = [];
        for ($i = 0; $i<count($response);$i++) {
            array_push($dateArray, $response[$i]['created_at']);
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

//        $hello = 'Hello World!';
//          $hello = Yii::$app->basePath;
//        return $this->render('index',
//            ['hello' => $data_for_db]
//            );
    }
    public function actionSearch()
    {
        $search = Yii::$app->request->post('search');
        return $this->render(
            'search',
            ['search' => $search]
        );
    }
}
