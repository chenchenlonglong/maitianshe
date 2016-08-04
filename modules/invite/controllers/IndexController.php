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

        $data=$inviteModel->getPage($inviteModel->find(),$page_info[0],$page_info[1],"start_time DESC",$where[0],$where[1][0],$where[1][1]);

        
        $count_today= $inviteModel->select_count(["like","start_time",substr(Time::get_time(),0,5)]);
        $data["count_today"]=$count_today; //今日新增邀请码数量



        $data["invite_status"]=Yii::$app->params["invate_type"];  //邀请码的状态码
        $data["invite_status_group"]=Yii::$app->params["invate_status_group"]; //邀请码的状态码
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
            $new_time=[[],[]];
        if(!empty($time["start_time"])){
           $new_time[0]=["and",[">=","start_time",$time["start_time"]],["<=","start_time",$time["start_time"]+60*60*24]];
        }
        if(!empty($time["end_time"])){
            $new_time[1]=["and",[">=","end_time",$time["end_time"]],["<=","end_time",$time["end_time"]+60*60*24]];
        }

        return [self::unset_arr($where),$new_time,$time];

    }




    private function  unset_arr($arr){
        foreach($arr as $key=>$value){
            if($value==""){
                unset($arr[$key]);
            }
        }
        return $arr;
    }



    private function  get_sql(){

        $sql= "SELECT  DISTINCT a.`invition_id`,b.`e_user_name`,b.`e_user_wx_number`,c.`e_user_name` AS e_user_by_name,c.`e_user_wx_number` AS e_user_by_wx_number ,
              a.`invition_code`,a.`invition_flag`,a.`invition_status`,a.`start_time`,a.`end_time` FROM hhs_inviteAS a LEFT JOIN hhs_users AS b ON a.`user_id`=b.`user_id`
              LEFT JOIN hhs_users AS c ON a.`user_by_id`=c.`user_id` ";

        return $sql;

}
}