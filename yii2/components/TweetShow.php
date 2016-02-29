<?php
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 29.02.16
 * Time: 12:23
 */
namespace app\components;

use yii;
use yii\base\Component;

class TweetShow extends Component
{
    public function showSavedTweets($tweetsForShow)
    {
        echo 'Получено и записано в базу данных в таблицу `tweet` ' . count($tweetsForShow) . ' твиттов:' . "\n";
        for ($i = 0; $i < count($tweetsForShow); $i++) {
            echo "\033[01;31m Твитт #" . ($i + 1) . "\n";
            echo "\033[01;32mТекст твитта: \033[01;37m" . $tweetsForShow[$i]['tweetText'] . "\n";
            echo "\033[01;32mДата написания твитта: \033[01;37m" . $tweetsForShow[$i]['dateWriten'] . "\n";
            if (count($tweetsForShow[$i]['hashtags']) > 0) {
                echo "\033[01;32mХештеги твита: \033[01;37m" . "\n";
                foreach ($tweetsForShow[$i]['hashtags'] as $key) {
                    echo '              #' . $key . "\n";
                }
            }
            echo "\n";
        }
    }
}