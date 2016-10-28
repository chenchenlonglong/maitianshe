<?php
/**
 * author: chenlong
 * Date: 2016/10/28
 * Time: 11:23
 */

namespace app\models;


class Order_goodsModel extends  BaseModel
{
    public static  function  tableName(){
        return "{{hhs_order_goods}}";
    }
}