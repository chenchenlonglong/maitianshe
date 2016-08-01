<?php
/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 11:58
 */

namespace app\common;


class Task
{
    public  static  function  get_task(){
        return[
            "0"=>"无任务等级",
            "1"=>"初级任务",
            "2"=>"中级任务",
            "3"=>"高级任务",
            "4"=>"超级组任务",
        ];
    }

}