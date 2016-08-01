<?php
/**
 * author: chenlong
 * Date: 2016/7/28
 * Time: 16:09
 */

namespace app\common;


class Time{

    /**
     * @desc 获得当前的时间戳
     * @return int
     */
    public  static  function get_time($time=""){
        if($time){
            return  strtotime(date("Y-m-d H:i:s"));
        }
    }

}