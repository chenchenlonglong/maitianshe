<?php
/**
 * author: chenlong
 * Date: 2016/8/4
 * Time: 16:34
 */

namespace app\models;


class TaskModel extends  BaseModel
{
    public  static  function  tableName(){
        return "{{hhs_task}}";
    }
}