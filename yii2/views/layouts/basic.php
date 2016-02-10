<?php
use app\assets\AppAsset;
/**
 * Created by PhpStorm.
 * User: dshash
 * Date: 09.02.16
 * Time: 13:15
 */
/* @var $content string */
/* @var $this \yii\web\View */
AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <?php $this->registerMetaTag(['name'=> 'viewport',
    'content' => 'width=device-width, initial-scale=1'])
    ?>
    <title><?= Yii::$app->name?></title>
    <?php
    $this->head();
    ?>
</head>
<body>
<?php
$this->beginBody()
?>
<p> Верхняя часть </p>

<?= $content?>
<p> Нижняя часть </p>
<?php
$this->endBody();
?>
</body>
</html>
<?php
$this->endPage();