<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 28.02.16
 * Time: 20:29
 */

namespace app\models;

use yii;
use yii\base\Model;
use DateTime;

class TweetStructure extends Model{

    private $tweetContent;
    private $tweetCounts;
    private $tweetText;
    private $dateWriten;
    private $hashtags;

    /**
     * Tweet constructor.
     * @param array $tweetContent
     * @param array $config
     */
    public function __construct($tweetContent,$config = [])
    {
        $this->tweetContent = $tweetContent;
        $this->tweetCounts = $this->parseCount($tweetContent);
        $this->tweetText = $this->parseText($tweetContent);
        $this->dateWriten = $this->parseDate($tweetContent);
        $this->hashtags = $this->parseHashtags($tweetContent);
        parent::__construct($config);
    }

    /**
     * @return int
     */
    public function getTweetCounts()
    {
        return $this->tweetCounts;
    }

    /**
     * @return mixed
     */
    public function getTweetText()
    {
        return $this->tweetText;
    }

    /**
     * @return mixed
     */
    public function getDateWriten()
    {
        return $this->dateWriten;
    }

    /**
     * @return mixed
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }
    private function parseCount($tweetsContent){
        return count($tweetsContent['statuses']);
    }

    private function parseText($tweetsContent){
        $textArray = [];
        $tweets = $tweetsContent['statuses'];
        for ($i = 0; $i < count($tweets); $i++) {
            array_push($textArray, $tweets[$i]['text']);
        }
        return $textArray;
    }
    private function parseDate($tweetsContent){
        $dateArray = [];
        $tweets = $tweetsContent['statuses'];

        for ($i = 0; $i<count($tweets);$i++) {
            $dateWritenFormat = new dateTime ($tweets[$i]['created_at']);
            array_push($dateArray, $dateWritenFormat->format('F j, Y-m-d H:i:s'));
        }
        return $dateArray;
    }
    private function parseHashtags($tweetsContent){
        $tagsArray = [];
        $unpreparedTagsArray = [];

        $tweets = $tweetsContent['statuses'];

        for ($i = 0; $i < count($tweets); $i++) {
            array_push($unpreparedTagsArray, $tweets[$i]['entities']['hashtags']);
        }

        foreach ($unpreparedTagsArray as $key) {
            $tempArray = [];
            foreach ($key as $k) {
                array_push($tempArray, $k['text']);
            }
            array_push($tagsArray, $tempArray);
        }
        return $tagsArray;
    }

}