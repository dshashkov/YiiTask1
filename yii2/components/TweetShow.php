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
    /**
     * @param array $tweetsForShow
     */
    public function showSavedTweets($tweetsForShow)
    {
        echo 'Получено и записано в базу данных ' . count($tweetsForShow) . ' твиттов:' . "\n";
        foreach($tweetsForShow as $key => $value){
            echo "\033[01;31m Твитт #" . ($key + 1) . "\n";
            echo "\033[01;32mТекст твитта: \033[01;37m" . $value['tweetText'] . "\n";
            echo "\033[01;32mДата написания твитта: \033[01;37m" . $value['dateWriten'] . "\n";
            if (count($value['hashtags']) > 0) {
                echo "\033[01;32mХештеги твита: \033[01;37m" . "\n";
                foreach ($value['hashtags'] as $hashtag) {
                    echo '              #' . $hashtag . "\n";
                }
            }
            echo "\n";
        }
    }


    /**
     * @param array $tweetsForShow
     * @param string $hashtagForSearch
     */
    public function showTweetsByHashtags($tweetsForShow,$hashtagForSearch)
    {
        if (count($tweetsForShow) > 0) {
            echo 'С хештегом ' . "\033[01;31m$hashtagForSearch" . "\033[01;37m в базе данных найдены: ". "\n";
            foreach($tweetsForShow as $key => $value){
                echo "\033[01;31m Твитт #" . ($key + 1) . "\n";
                echo "\033[01;32mТекст твитта: \033[01;37m" . $value['text'] . "\n";
                echo "\033[01;32mДата написания твитта: \033[01;37m" . $value['date_written'] . "\n";
                echo "\033[01;32mДата записи в базу данных: \033[01;37m" . $value['date_imported'] . "\n";
                if (count($value['hashtags']) > 0) {
                    echo "\033[01;32mХештеги твита: \033[01;37m" . "\n";
                    foreach ($value['hashtags'] as $hashtag) {
                        echo '              #' . $hashtag . "\n";
                    }
                }
                echo "\n";
            }
        } else {
            echo 'С хештегом ' . "\033[01;31m$hashtagForSearch" . "\033[01;37m в базе данных твиттов не найдено " . "\n\n";
        }
    }



    public  function statisticInformMessage(){
        echo "Введите дату согласно одному из форматов:\n";
        echo "\033[01;36mДень-Месяц-Год\n \033[01;37mили \n\033[01;36mГод-Месяц-День\n";
        echo "\033[01;37mГде:\n";
        echo "\033[01;33m";
        echo "--------------------------------------------------------------------------------------------------------------------\n";
        echo "День\n";
        echo "d и j 	День месяца, 2 цифры с нулем в начале или без него (От 01 до 31 либо от 1 до 31)\n";
        echo "D и l 	Текстовое представление дня месяца (От Mon до Sun либо от Sunday до Saturday)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Месяц 	\n";
        echo "F и M 	Текстовое представление месяца, например January или Sept (С January по December либо с Jan по Dec)\n";
        echo "m и n 	Числовое представление месяца с первым нулем или без него (С 01 по 12 либо с 1 по 12)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Год\n";
        echo "Y 	Полное числовое представление года, 4 цифры\n";
        echo "y 	2 цифры в представлении года (в диапазоне 1970-2069 включительно)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo  "\033[01;36m";

    }


    /**
     * @param array $hashtags
     * @param string $dateForSearch
     */
    public function statisticByHashtags($hashtags, $dateForSearch)
    {
        echo "\033[01;37mСтатистика хештегов за \033[01;36m" .$dateForSearch. "\033[01;37m\n\n";

        echo "Всего \033[01;31m". count($hashtags) ."\033[01;37m различных хештегов";
        if(count($hashtags) > 0)
        {
            $onePercent = 100 / count($hashtags);
            echo "\nиз них: \n";

            foreach($hashtags as $key => $value)
            {
                echo "\033[01;36m #".$key. " - \033[01;31m". $value * $onePercent . "%\n";
            }
        } else {
            echo ".\n\n";
        }
    }
}