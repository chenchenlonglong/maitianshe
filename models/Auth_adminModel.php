<?php
/**
 * @author oj
 * @data : 2016/3/28
 * @time: 16:12
 */

namespace app\models;


use app\models\BaseModel;

class Auth_adminModel extends BaseModel
{
    public static function tableName()
    {
        return "{{auth_admin}}";
    }
}