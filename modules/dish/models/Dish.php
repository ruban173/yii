<?php

namespace app\modules\dish\models;

use Yii;
use app\modules\dish\models\Ingredients;
use yii\helpers\BaseArrayHelper;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class Dish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           ['title', 'required','message'=>'Введите название блюда!'],
           ['composition', 'required','message'=>'Выберите больше ингридиентов!'],
           [['status'], 'integer'],
           [['title'], 'string', 'max' => 255],
        ];
    }
public function validationCountComposition(){
    if( count($this->composition)>5){
        \Yii::$app->session->addFlash('danger','Выбрано более 5 продуктов!!');
        return false ;
    }
       else return true; 
    
}
   public function validationCountRecords() 
    {
         $this->composition=serialize($this->composition);
         
          $title= Dish::find()
                    ->where(['title' => $this->title])
                    ->count();
          $composition= Dish::find()
                    ->where(['composition' => $this->composition])
                    ->count(); 
            
            if($title!=0){
                \Yii::$app->session->addFlash('danger','Блюдо с таким заголовком уже существует!!');
                return false;
            }
            elseif($composition!=0){
                 \Yii::$app->session->addFlash('danger','Блюдо с таким набором продуктов уже существует!!');
                return false;
            }
            
                return true;
              
    }
  static  public function getIngredientsMap()
    {
        $ingredients =Ingredients::find(['id','name'])
                                        ->select(['id','name'])
                                        ->where(['status' => 1])
                                        ->orderBy('id')
                                        ->all();
       return ArrayHelper::map($ingredients, 'id', 'name'); 
    }
    
static public  function filterActiveDish ($model){
    
    foreach($model as $item)
        {
              $composition= unserialize($item->composition); 
              $countComposition=count($composition);
              $ingredients =Ingredients::findAll($composition);
              $countStatusTrue=0;
            foreach( $ingredients as $ingredient )  
               {
                  
                $countStatusTrue+=($ingredient->status==1)?1:0;
               }; 
           
            if ($countComposition==$countStatusTrue)
                       $modelUpdate[] =$item;
            
                
        };
    return $modelUpdate;
}
  static public  function SearcDish ($data,$search){ 
      
      foreach($data as $item)
                {
              $composition= unserialize($item->composition); 
              $count=count(array_intersect($search,$composition )) ;
              if($count==5) $modelSearch_5[]=$item;
                  elseif($count==4) $modelSearch_4[]=$item;
                      elseif($count==3) $modelSearch_3[]=$item;
                };
              if(count($modelSearch_5)==0)
                  if(count($modelSearch_4)==0)
                      if(count($modelSearch_3)==0)
                      {
                          $data=[];
                      }
              else $data=$modelSearch_3;
                  else $data=$modelSearch_4;
                        else $data=$modelSearch_5;
      return $data;
  }
    
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'composition' => 'Состав',
            'status' => 'Статус',
        ];
    }
}
