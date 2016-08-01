<?php
/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:37
 */

namespace app\models;


class InvateModel extends  BaseModel
{


    public static  function  tableName(){
        return "{{hhs_invite}}";
    }


    public  function  select_count($condition=[]){

     return  $this->find()->where($condition)->asArray()->count();
    }
}