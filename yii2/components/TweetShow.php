<?php
/**
 * This component for showing results into console according to used service
 *
 * @author Shashkov Denis
 * @date 20.03.16
 */

namespace app\components;


use app\models\TweetStructure;
use yii;
use yii\base\Component;

class TweetShow extends Component
{
    /**
     * @param TweetStructure[] $tweetsForShow
     */
    public function showSavedTweets(array $tweetsForShow)
    {
        echo 'Получено и записано в базу данных ' . count($tweetsForShow) . ' твиттов:' . "\n";

        foreach($tweetsForShow as $key => $value){
            echo "\033[01;31m Твитт #" . ($key + 1) . "\n";
            echo "\033[01;32mТекст твитта: \033[01;37m" . $value->getTweetText() . "\n";
            echo "\033[01;32mДата написания твитта: \033[01;37m" . $value->getDateWriten() . "\n";

            if (count($value->getHashtags()) > 0) {
                echo "\033[01;32mХештеги твита: \033[01;37m" . "\n";

                foreach ($value->getHashtags() as $hashtag) {
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
        echo "Введите дату и время согласно предлженному из формату:\n";
        echo "\033[01;36mГод-Месяц-День Час:Минута:Cекунда\n";
        echo "\033[01;37mГде:\n";
        echo "\033[01;33m";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Год\n";
        echo "YYYY 	    Полное числовое представление года, 4 цифры\n";
        echo "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Месяц 	\n";
        echo "MM 	    Полное числовое представление месяца с первым нулем, 2 цифры(С 01 по 12)\n";
        echo "--------------------------------------------------------------------------------------------------------------------\n";
        echo "День\n";
        echo "DD 	    Полное числовое представление дня с первым нулем, 2 цифры(С 01 по 31)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Час\n";
        echo "HH 	    Полное числовое представление часа с первым нулем, 2 цифры(С 00 по 23)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Минута\n";
        echo "II 	    Полное числовое представление минуты с первым нулем, 2 цифры(С 00 по 59)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "Секунда\n";
        echo "SS	    Полное числовое представление секунды с первым нулем, 2 цифры(С 00 по 59)\n";
        echo  "-------------------------------------------------------------------------------------------------------------------\n";
        echo "\n\033[01;36mДопускается не полной представление даты и времени при соблюдение нисходящей последовательности\n";
        echo "\n\033[01;36mНеуказанные значение по умолчание принемают минимальное значение\n";
        echo "\n\033[01;36mДопускается использование любой знак пунктуации в качестве разделительно символа\n";
        echo "\n\033[01;37mПримеры: 2015.12.31 11+30+45', '2015/12/31 11*30', 2015-12 и т.д.\n\n";
        echo  "\033[01;36mВведите дату и время - :";
    }


    /**
     * @param array $tweets
     */
    public function showLastTweetsJSON(array $tweets)
    {
        $json = (json_encode($tweets));
        echo $json . "\n";
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
            $onePercent = 100 / array_sum($hashtags);
            echo "\nиз них: \n";

            foreach($hashtags as $key => $value)
            {
                echo "\033[01;36m #".$key. " - \033[01;31m". round($value * $onePercent, 2) . "%\n";
            }
        } else {
            echo ".\n\n";
        }
    }
}