<?php
/**
 * author: chenlong
 * Date: 2016/8/4
 * Time: 11:07
 */

namespace app\common;


use app\models\UserModel;

class User
{
    /**
     * @desc 查询注册总人数
     */
    public  static  function get_count(){
        $userModel= new UserModel();
        return $userModel->find()->count();
    }

    /**
     * $desc 查询今日注册总人数
     */
    public  static  function get_today_count(){
        $userModel= new UserModel();
        $time_first= strtotime(date("Y-m-d",time()));
        $time_sec=$time_first+60*60*24;
        $reg_today=$userModel->find()->where(["and",[">=","reg_time",$time_first],["<=","reg_time",$time_sec]])->count();
        return $reg_today;
    }

    /**
     * @desc 管理员总人数
     */
    public  static  function  get_admin_count(){
        $userModel= new UserModel();
        $count= $userModel->find()->where(["e_user_level"=>3])->count();
        return $count;
    }

    /**
     * @desc 今日加入团队的人数，
     * @param $team_name 团队名称
     * @return int|string
     */
    public static  function get_today_team_count($team_name){
        $userModel= new UserModel();
        $time_first= strtotime(date("Y-m-d",time()));
        $time_sec=$time_first+60*60*24;
        $count=$userModel->find()->where(["and",[">=","reg_time",$time_first],["<=","reg_time",$time_sec],["e_admin_team_name"=>$team_name]])->count();
        return $count;
    }
}