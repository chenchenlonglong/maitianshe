<?php

/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:21
 */
namespace app\modules\invite\controllers;


use app\controllers\InviteController;
use app\models\InviteModel;
use Yii;



class IndexController extends  InviteController
{
    public $enableCsrfValidation = false;


    /**
     * @DESC 生成数据
     * @return string
     */
    public  function  actionIndex(){
        $post=Yii::$app->request->post();
        $page_info=$this->get_page_value();
        $sql=$this->get_value($post);
        $inviteModel= new InviteModel();


        //查询总条数
        $result=$inviteModel->findBySql($sql)->asArray()->all();
        $data=$inviteModel->getPage_by_sql($result,$page_info[0],$page_info[1]);


        $start=($page_info[0]-1)*$page_info[1];
        $sql=$sql."  limit {$start},{$page_info[1]} ;";
        $result=$inviteModel->findBySql($sql)->asArray()->all();



        $data["data"]=$result;
        $data["invite_status"]=Yii::$app->params["invate_type"];  //邀请码的状态码
        $data["invite_status_group"]=Yii::$app->params["invate_status_group"]; //邀请码的状态码
        $data["today"]=self::get_invite_num();
        $data["yesterday"]=self::get_invite_num(false);
        return $this->renderPartial("index",["data"=>$data,"post"=>$post]);

    }

    /**
     * @desc 获得查询条件
     * @param $post
     * @return string
     */
    public  function  get_value($post){
        $sql_where="";
        foreach($post as $key=>$value){
            if($value!=""){
                if($key=="user_name"){
                    $sql_where.= " and  b.`e_user_name`= '{$value}'";
                }
                if($key=="user_by_name"){
                    $sql_where.="  and  c.`e_user_name` ='{$value}'";
                }
                if($key=="invition_flag"){
                    $sql_where.=" and  a.`invition_flag` = '{$value}'";
                }
                if($key=="invition_status"){
                    $sql_where.="  and a.`invition_status` = '{$value}'";
                }
                if($key=="start_time"){
                    $time_one=strtotime($value);
                    $time_two=strtotime($value)+60*60*24;
                    $sql_where.=" and  a.`start_time` >= '{$time_one}' and a.`start_time`<='{$time_two}' ";
                }
                if($key=="end_time"){
                    $time_one=strtotime($value);
                    $time_two=strtotime($value)+60*60*24;
                    $sql_where.=" and  a.`end_time` >= '{$time_one}' and a.`end_time`<='{$time_two}' ";
                }
            }
        }
        $sql=$this->get_sql().$sql_where ."order by a.`start_time` desc";
        return $sql;

    }


    private function  get_invite_num($now=true){
        $inviteModel=new InviteModel();
        $time=strtotime(date("Y-m-d",time()));
        if(!$now){
            $time= strtotime(date("Y-m-d",strtotime("-1 days")));

        }

        $time_now=$time+60*60*24;
        $count=$inviteModel->select_count(["and",[">=","start_time",$time],["<=","start_time",$time_now]]);
        return $count;
    }




}