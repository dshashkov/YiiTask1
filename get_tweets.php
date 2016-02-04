<?php
/**
 * Created by PhpStorm.
 * User: denshash
 * Date: 03.02.16
 * Time: 11:00
 */
// подключаем библиотеку Мэта Харриса
// ваш путь может быть другим,
// я предпочитаю использовать папки
// типа lib или inc/lib в корне сайтов
require_once("tmhOAuth.php");

// OAuth-данные для нашего Twitter-приложения
// как добыть эти секретные данные -
// смотрите выше в этом посте
$consumer_key = '8i6BcbrZ7EqahHARJgRXrltMS';
$consumer_secret = 'ScCXe5pNeCFsC8U9Ed7euUfDBvOvLotuc3az0D6TDtjTdBsFv8';
$user_token = '4868612410-Yy6LMiWPsr3lt1aTJrvyQbQKu00OvsqhfmcHAgA';
$user_secret = 'SgNp9fGlJ1ly8IB2BgvPZb4crYVPvN305y3qOwBi11zYy';


// Создаём OAuth соединение к Twitter API
$connection = new tmhOAuth(array(
        'consumer_key'=> $consumer_key,
        'consumer_secret' => $consumer_secret,
        'user_token'=> $user_token,
        'user_secret'=> $user_secret)
);
//die(var_dump($connection));

$code = $connection->request('GET',$connection->url('1.1/statuses/user_timeline'),
    array('screen_name' => '5umm', 'count' => 1));
//echo 'ok';
// декодируем полученные данные из JSON-объекта в PHP-массив
$tweet_data = json_decode($connection->response['response'],true);

// Ответный код 200 ? Да - всё в порядке
if ($code == 200) {
    // соберём твиты и сформируем из них
    // HTML-код для вывода на нашей странице
    $tweet_stream = '';
    foreach($tweet_data as $tweet) {
        // SYS: JS:  etc. get in bold
        $t = preg_replace('/^(.*?):/',"<b>$1</b>: ",$tweet['text']);
        $tweet_stream .= $t . '<br/><br/>';
    }

    // Выведем их в браузер
    echo $tweet_stream;
}
else {
    // Тут можно обработать ошибки
    // я просто вывожу её как есть
    echo "<strong>Code:</strong> $code<br>";
    // Выводим запрос как массив для разбора
    echo "<strong>Response:</strong><br><br>";
    print_r($tweet_data);
    echo "<br><br>";
}
