<?php

/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:21
 */
namespace app\modules\invite\controllers;

use app\common\Time;
use app\controllers\CommonController;
use app\models\InviteModel;
use Yii;



class IndexController extends  CommonController
{
    public $enableCsrfValidation = false;

    /**
     * @desc邀请码列表展示
     */
    public  function  actionIndex(){

        $where=$this->get_where();

        $page_info=$this->get_page_value();
        $inviteModel= new InviteModel();
        $data=$inviteModel->getPage($inviteModel->find(),$page_info[0],$page_info[1],"start_time DESC",$where[0]);
        $count_today= $inviteModel->select_count(["like","start_time",substr(Time::get_time(),0,5)]);
        $data["count_today"]=$count_today; //今日新增邀请码数量
        $invite_status=Yii::$app->params["invate_type"];
        $invite_status_group=Yii::$app->params["invate_status_group"];
        $data["invite_status"]=$invite_status;  //邀请码的状态码
        $data["invite_status_group"]=$invite_status_group;  //邀请码的状态码
        return $this->renderPartial("index",["data"=>$data,"where"=>$where]);
    }


    public  function  get_where()
    {
        $post = Yii::$app->request->post();
        $where=[
            "user_id"=>isset($post["user_id"])?$post["user_id"]:"",
            "user_by_id"=>isset($post["user_by_id"])?$post["user_by_id"]:"",
            "invition_flag"=>isset($post["invition_flag"])?$post["invition_flag"]:"",
            "invition_status"=>isset($post["invition_status"])?$post["invition_status"]:"",
        ];
        $time=[
          "start_time"=>isset($post["start_time"])?strtotime($post["start_time"]):"",
          "end_time"=>  isset($post["end_time"])?strtotime($post["end_time"]):"",
        ];
        return [self::unset_arr($where),self::unset_arr($time)];

    }

    private function  unset_arr($arr){
        foreach($arr as $key=>$value){
            if($value==""){
                unset($arr[$key]);
            }
        }
        return $arr;
    }

}