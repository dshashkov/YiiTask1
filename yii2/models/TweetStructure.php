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

class TweetStructure extends Model{

    private $tweetText;
    private $dateWriten;
    private $hashtags;

    /**
     * TweetStructure constructor.
     * @param array $hashtags
     * @param $dateWriten
     * @param $tweetText
     * @param array $config
     */
    public function __construct($tweetText, $dateWriten, $hashtags, $config = [])
    {
        $this->tweetText = $tweetText;
        $this->dateWriten = $dateWriten;
        $this->hashtags = $hashtags;
        parent::__construct($config);
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