<?php
/**
 * author: chenlong
 * Date: 2016/8/8
 * Time: 14:38
 */

namespace app\models;


class ReduceModel extends  BaseModel
{
    public static  function  tableName(){

        return "{{hhs_reduce_money}}";
    }

    public function rules()
    {
        return [

            [['amount','user_id','flag','invite_id','status','time',], 'required']
        ];
    }
}