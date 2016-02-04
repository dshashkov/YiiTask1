<?php
/**
 * Created by PhpStorm.
 * User: denshash
 * Date: 02.02.16
 * Time: 17:24
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin();?>

<?=$form->field($model, 'name');?>
<?=$form->field($model, 'email');?>


<div class="form-group">
    <?=Html::submitButton('send',['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end();?>