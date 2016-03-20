<?php
/**
 * Model which describes structure of the each tweet
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

namespace app\models;


use yii;

class TweetStructure
{
    private $tweetText;
    private $dateWriten;
    private $hashtags;


    /**
     * TweetStructure constructor.
     * @param $tweetText
     * @param $dateWriten
     * @param array $hashtags
     */
    public function __construct($tweetText, $dateWriten, $hashtags)
    {
        $this->tweetText  = $tweetText;
        $this->dateWriten = date('Y-m-d G:i:s', strtotime($dateWriten));
        $this->hashtags   = $hashtags;
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
}