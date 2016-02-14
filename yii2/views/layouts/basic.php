<?php
use app\assets\AppAsset;
use yii\bootstrap\NavBar;
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
    <html lang="<?= Yii::$app->language ?>" xmlns="http://www.w3.org/1999/html">
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
$this->beginBody() ?>
<div class="warp" style="min-height: 100%" >
    <?php
    NavBar::begin(
        [
            'brandLabel' => 'Test app'
        ]
    );
    NavBar::end();
    ?>
    <div class="container">
        <?= $content?>
        </div>
    </div>

<div class ="footer">
    <div class="container">
        <span class="badge">
              <span class="glyphicon glyphicon-copyright-mark"></span> denShashkov <?= date('Y')?>
        </span>
    </div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php
$this->endPage();