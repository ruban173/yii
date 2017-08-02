<?php

namespace app\modules\dish\models;

use Yii;

/**
 * This is the model class for table "ingredients".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 */
class Ingredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required','message'=>'Введите заголовок!'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    
   public function validationCountRecords() 
    {
         
         
          $name= Ingredients::find()
                    ->where(['name' => $this->name])
                    ->count();
          
            if($name!=0){
                \Yii::$app->session->addFlash('danger','Ингридиент с таким именем уже существует!!');
                return false;
            }
                    
                return true;
              
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'status' => 'Статус',
        ];
    }
}
