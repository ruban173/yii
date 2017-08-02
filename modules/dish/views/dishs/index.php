<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\dish\models\Ingredients;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\dish\models\DishSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блюда';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="dish-index">

        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
 <?php foreach(Yii::$app->session->getAllFlashes() as $type => $messages): ?>
    <?php foreach($messages as $message): ?>
        <div class="alert alert-<?= $type ?>" role="alert"><?= $message ?></div>
    <?php endforeach ?>
<?php endforeach ?>       
        <div class="dish-search">

            <?php $form = ActiveForm::begin(); ?>

            <?=$form->field($model, 'composition')->checkboxList($array);?>

                <div class="form-group">
                    <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                   <a class="btn btn-default" href="/web/index.php?r=dish" role="button">Сбросить</a>
                </div>

            <?php ActiveForm::end(); ?>

        </div>

        <p>
            <?=(!Yii::$app->user->isGuest)?Html::a('Создать', ['create'], ['class' => 'btn btn-success']):''; ?>
        </p>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
           
            [
            'attribute' => 'composition',
                'label'=>'Состав',
                'format' => 'raw',
            'value' => function($data){
                  $ingredients =Ingredients::findAll(unserialize($data->composition));
                  foreach( $ingredients as $ingredient )  
               {
                   $result.=$ingredient->name.' ';
                 
               };  
                return  $result;
                
                                      },
            ],

             [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($data){
                return ($data->status==0)?'<span style="color:red" class="glyphicon glyphicon-minus-sign"></span>':'<span style="color:green" class="glyphicon glyphicon-plus-sign"></span>';
                
                                      },
            ],
        
         [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'Действия', 
            'headerOptions' => ['width' => '80'],
            'template' => !Yii::$app->user->isGuest?'{update} {delete}{link}':'',
        ],
            
        ],
    'emptyText' => 'Ничего не найдено!',
    ]); ?>
    </div>