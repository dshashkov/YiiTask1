<?php
/**
 * Created by PhpStorm.
 * User: denshash
 * Date: 02.02.16
 * Time: 17:21
 */
use  yii\helpers\Html;
?>
<p> message bellow: </p>

<ul>
    <li><label>Name</label>: <?=Html::encode($model->name) ?></li>
    <li><label>Email</label>: <?=Html::encode($model->email) ?></li>
</ul>