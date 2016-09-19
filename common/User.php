<?php
/**
 * author: chenlong
 * Date: 2016/8/4
 * Time: 11:07
 */

namespace app\common;


use app\models\AdminrelationModel;
use app\models\UserModel;

class User
{
    /**
     * @desc 管理员总人数
     */
    public static function  get_admin_count()
    {
        $userModel = new UserModel();
        $count = $userModel->find()->where(["e_user_level" => 3])->count();
        return $count;
    }


    /**
     * @desc 查询团长总人数
     * @return int|string
     */
    public static function  get_user_count()
    {
        $userModel = new UserModel();
        $count = $userModel->find()->where(["e_user_level" => 2])->count();
        return $count;
    }

    /**
     * @desc 查询普通用户人数
     */
    public static function get_common_user_count()
    {
        $userModel = new UserModel();
        return $userModel->find()->where(["e_user_level" => 1])->count();
    }

    /**
     * $desc 今日成为管理员的人数
     */
    public static function get_today_admin_count()
    {
        $userModel = new UserModel();
        $time_first = strtotime(date("Y-m-d"));
        $time_sec = $time_first + 60 * 60 * 24;
        $reg_today = $userModel->find()->where(["and", [">=", "reg_time", $time_first], ["<=", "reg_time", $time_sec]])->andWhere(["e_user_level" => 3])->count();
        return $reg_today;
    }


    /**
     * @desc 今日成为团长的人数，
     * @param $team_name 团队名称
     * @return int|string
     */
    public static function get_today_user_count()
    {
        $userModel = new UserModel();
        $time_first = strtotime(date("Y-m-d"));
        $time_sec = $time_first + 60 * 60 * 24;
        var_dump($time_first);
        var_dump($time_sec);
        var_dump(date("Y-m-d"));
        $count = $userModel->find()->where(["and", [">=", "reg_time", $time_first], ["<=", "reg_time", $time_sec], ["e_user_level" => 2]])->count();
        return $count;
    }

    /**
     * @desc 今日普通用户的人数，
     * @param $team_name 团队名称
     * @return int|string
     */
    public static function get_today_common_user_count()
    {
        $userModel = new UserModel();
        $time_first = strtotime(date("Y-m-d"));
        $time_sec = $time_first + 60 * 60 * 24;
        $count = $userModel->find()->where(["and", [">=", "reg_time", $time_first], ["<=", "reg_time", $time_sec], ["e_user_level" => 1]])->count();
        return $count;
    }

    /**
     * @desc 查询某个团队下的人数
     * @param $team_name
     * @return int|string
     */
    public  static function  get_team_num($team_name){
        $userModel = new UserModel();
        return   $userModel->find()->where(["e_admin_team_name"=>$team_name])->andWhere(["!=","e_user_level",3])->count();
    }

    /**
     * @desc:管理员的团队人数
     * @param $admin_id
     * @return int
     */
    public static function admin_team_num($admin_id){
        $admin_model = new AdminrelationModel();
        $team_num = $admin_model->find()
            ->where(['admin_id'=>$admin_id])
            ->asArray()
            ->count();
        return $team_num;
    }



    /**
     * @desc 今日加入团队的人数，
     * @param $team_name 团队名称
     * @return int|string
     */
    public static function get_today_team_count($team_name = "")
    {
        $userModel = new UserModel();
        $time_first = strtotime(date("Y-m-d", time()));
        $time_sec = $time_first + 60 * 60 * 24;
        if ($team_name) {
            $count = $userModel->find()->where(["and", [">=", "reg_time", $time_first], ["<=", "reg_time", $time_sec], ["e_admin_team_name" => $team_name]])->count();
        } else {
            $count = $userModel->find()->where(["and", [">=", "reg_time", $time_first], ["<=", "reg_time", $time_sec]])->count();
        }
        return $count;
    }


    /**
     * @desc 查询注册总人数
     */
    public static function get_count()
    {
        $userModel = new UserModel();
        return $userModel->find()->where(["!=", "e_user_level", 1])->count();
    }

    /**
     * $desc 查询今日注册总人数
     */
    public static function get_today_count()
    {
        $userModel = new UserModel();
        $time_first = strtotime(date("Y-m-d", time()));
        $time_sec = $time_first + 60 * 60 * 24;
        $reg_today = $userModel->find()->where(["and", [">=", "reg_time", $time_first], ["<=", "reg_time", $time_sec]])->count();
        return $reg_today;
    }
}




