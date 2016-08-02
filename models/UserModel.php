<?php
/**
 * author: chenlong
 * Date: 2016/8/2
 * Time: 17:35
 */

namespace app\models;


class UserModel extends BaseModel
{

    public  static  function  tableName(){
        return "{{hhs_users}}";
    }

}