<?php

namespace app\modules\dish\controllers;

use Yii;
use app\modules\dish\models\Dish;
use app\modules\dish\models\DishSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\dish\models\Ingredients;
use yii\helpers\BaseArrayHelper;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
 
class DefaultController extends Controller
{
    
    public function behaviors()
    {
        $this->viewPath= dirname(__DIR__).'\views\dishs';
        return [
             'access' => [
            'class' => AccessControl::className(),
            'only' => ['create','update','delete'],
            'rules' => [
                [
                   
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

     
    public function actionIndex()
    {
         $model =Dish::find()->where(['status' => 1])->all();    
         $modelUpdate=Dish::filterActiveDish($model);
         $array=Dish::getIngredientsMap();
         $modelSearch=new Dish();
        
         if ($modelSearch->load(Yii::$app->request->post()) && $modelSearch->validationCountComposition() && count($modelUpdate)!=0) 
             $modelUpdate=   Dish::SearcDish($modelUpdate,$modelSearch->composition);
                  
        $dataProvider = new ArrayDataProvider([
             'allModels' =>   $modelUpdate,
             'key' => 'id',
        ]);
        
        return $this->render('index', [
           
            'dataProvider' => $dataProvider,
            'array'=>$array,
            'model'=>$modelSearch,
        ]);
    }

    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {
       
        $model = new Dish();
        $array=Dish::getIngredientsMap();                              
      
        if ($model->load(Yii::$app->request->post()) && $model->validationCountComposition() && $model->validationCountRecords()  )
        {
           $model->save();
            return $this->redirect(['index']);
             
           
        } 
       
            return $this->render('create', [
                'model' => $model,
                'array'=>$array
            ]);
        
    }

    
    public function actionUpdate($id)
    {
        $array=Dish::getIngredientsMap(); 
        $model = $this->findModel($id);
        $model->composition=unserialize($model->composition);
        if ($model->load(Yii::$app->request->post()) && $model->validationCountComposition() ) {
           $model->composition=serialize($model->composition);
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'array'=>$array
            ]);
        }
    }

     
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

     
    protected function findModel($id)
    {
        if (($model = Dish::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}