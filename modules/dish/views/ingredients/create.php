<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dish\models\Ingredients */

$this->title = 'Создать ингридиент';
$this->params['breadcrumbs'][] = ['label' => 'Ингридиент', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
