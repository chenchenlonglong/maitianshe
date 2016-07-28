<?php
/**
 * @author oj
 * @data : 2016/3/28
 * @time: 15:25
 */

namespace app\models;


use app\models\BaseModel;

class Auth_assignmentModel extends BaseModel
{

    public static function tableName()
    {
        return "{{auth_assignment}}";
    }
}