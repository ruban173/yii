<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dish\models\DishSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dish-search">

     <?php $form = ActiveForm::begin(); ?>
 
    <?=$form->field($model, 'composition')->checkboxList($array);?>
    
    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
