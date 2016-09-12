<?php

/**
 * author: chenlong
 * Date: 2016/8/8
 * Time: 14:32
 */
namespace app\modules\audit\controllers;

use app\common\Statistics;
use app\common\Tools;
use app\controllers\CommonController;
use app\models\OrderModel;
use app\models\RebateModel;
use app\models\ReduceModel;
use app\models\UserModel;
use Yii;
use Functions;
use yii\curl\Curl;

class ReduceController extends CommonController
{
    public $enableCsrfValidation = false;



    /**
     * @desc 提现列表展示
     * @return string
     */
    public  function actionIndex(){
        $page=$this->get_page_value();
        $reduceModel= new ReduceModel();
        $sql=self::sql()." where a.`audit_time` is null and a.`audit_name` is null ";
        $result=$reduceModel->findBySql($sql)->asArray()->all();
        $data=$reduceModel->getPage_by_sql($result,$page[0],$page[1]);
        $start=($page[0]-1)*$page[1];
        $sql=$sql."order by  a.`time` asc   limit {$start},{$page[1]};";
        $result=$reduceModel->findBySql($sql)->asArray()->all();
        $data["data"]=$result;
        return    $this->renderPartial("index",["data"=>$data]);
    }


    /**
     * @desc 提现审批历史
     * @return string
     */
    public  function  actionReduce_history(){
        $page=$this->get_page_value();
        $reduceModel= new ReduceModel();
        $post=Yii::$app->request->post();
        $sql=self::sql();
        $sql=$sql." where a.`audit_time` is  not null and a.`audit_name` is  not null";
        if($post){
            if(isset($post["user_name"])){
                $sql=$sql." and  b.`e_user_name`='{$post["user_name"]}'";
            }
            if(isset($post["flag"])){
                $sql=$sql." and  a.`flag`='{$post["flag"]}'";
            }
            if(isset($post["start_time"])){
                $start_time=strtotime($post["start_time"]);
                $end_time=$start_time+60*60*24;
                $sql=$sql." and  a.`time`>='{$start_time}' and a.`time`<'{$end_time}'";
            }
            if(isset($post["audit_time"])){
                $start_time=strtotime($post["audit_time"]);
                $end_time=$start_time+60*60*24;
                $sql=$sql." and  a.`audit_time`>='{$start_time}' and a.`audit_time`<'{$end_time}'";
            }
        }
        $result=$reduceModel->findBySql($sql)->asArray()->all();
        $data=$reduceModel->getPage_by_sql($result,$page[0],$page[1]);
        $start=($page[0]-1)*$page[1];
        $sql=$sql." order by  a.`time` asc   limit {$start},{$page[1]};";
        $result=$reduceModel->findBySql($sql)->asArray()->all();
        $data["data"]=$result;
        $reduce_status=Yii::$app->params["audit_status"];
        unset($reduce_status["3003"]);
        $data["audit_status"]=$reduce_status;
        return    $this->renderPartial("history",["data"=>$data,"post"=>$post]);
    }





    /**
     * @desc 提现操作显示
     * @return string
     */
    public  function  actionReduce_show(){
        $user_id=Yii::$app->request->get("user_id");
        $id=Yii::$app->request->get("id");
        $reduceModel= new ReduceModel();
        $sql=self::sql(). " where a.`id`={$id} and a.`user_id`={$user_id}";
        $data= $reduceModel->findBySql($sql)->asArray()->one();
        $reduce_all_money=Statistics::count_tatal_true_money($user_id);//可提现的所有金额
        $data["reduce_all_money"]=$reduce_all_money;
        $message=self::check_reduce($user_id);
        if($message){
            Functions::dwz_json(300,$message);
        }
            return $this->renderPartial("reduce",["data"=>$data]);

    }


    /**
     * @param $user_id
     * @return string
     */
    private  function  check_reduce($user_id){
        $rebateModel= new RebateModel();
        $reduce_detail=$rebateModel->find()->select("invite_id")->where(["user_id"=>$user_id,"status"=>3004,"flag"=>4,"check"=>0])->asArray()->all();
        $orderModel= new OrderModel();
        $mess="";
        foreach($reduce_detail as  $key=>$value){
            $result=$orderModel->find()->where(["user_id"=>$user_id,"team_sign"=>$value["invite_id"],"team_status"=>2])->asArray()->all();
            if(empty($result)){
                $mess=$value["invite_id"]."数据异常。";
                break;
            }
            $rebateModel->updateAll(["check"=>1],["user_id"=>$user_id,"invite_id"=>$value["invite_id"]]);
        }
        return $mess;

    }



    /**
     * @desc 提现操作
     * @return string
     */
    public  function  actionReduce(){
        $user_id=Yii::$app->request->post("user_id");
        $id=Yii::$app->request->post("id");
        $reduceModel= new ReduceModel();
        $sql=self::reduce_sql()."where a.`id`={$id} and a.`user_id`={$user_id}";
        $data= $reduceModel->findBySql($sql)->asArray()->one();
        if(empty($data)){
            return Functions::return_json(301,"数据异常,请重新执行提现流程或咨询技术人员");
        }
        $message=[
            "openid"=>$data["openid"],
            "user_id"=>$data["user_id"],
            "price"=>$data["amount"],
            "trade_no"=>$data["trade_no"]
        ];
        $curl= new Curl();
        $reduce_result_json=$curl->setOption(CURLOPT_POSTFIELDS, http_build_query($message))->post(yii::$app->params['reduce_url']);
        $reduce_result=json_decode($reduce_result_json,true);
        file_put_contents("reduce.txt", date("Y-m-d H:i:s", time()) ."trade_no".$data["trade_no"]. $reduce_result_json . "\r", FILE_APPEND);
        file_put_contents("params.txt", date("Y-m-d H:i:s", time()) . json_encode($message) . "\r", FILE_APPEND);
        if($reduce_result["code"]==200){
          $reduceModel->updateAll(["flag"=>3004,"audit_time"=>time(),"audit_name"=>Tools::get_user_name()],["id"=>$id]);
          return Functions::return_json(200,"提现成功","","reduce_id_index","closeCurrent");
      }

        $reduceModel->updateAll(["flag"=>3004],["id"=>$id]);
        return Functions::return_json(300,$reduce_result["data"]["return_msg"],"","reduce_id_index","closeCurrent");
    }







    /**
     * @desc 列表sql
     * @return string
     */
    private function    sql(){
        return "SELECT DISTINCT a.`id`, a.`user_id`,a.`flag`,a.`reason`,a.`amount`,a.`time`,a.`audit_time`,b.`uname`,
                a.`audit_name`,b.`e_register_phone` as telephone,b.`e_admin_team_name` as team_name,b.`e_user_name` as user_name,b.`e_register_email`AS email,
                b.`e_user_wx_number` AS wx_name
                FROM hhs_reduce_money AS a LEFT JOIN hhs_users AS b ON a.`user_id`=b.`user_id` ";
    }




    /**
     * @desc 提现sql
     * @return string
     */
    private function reduce_sql(){
        return "SELECT DISTINCT  a.`user_id`,a.`trade_no`,a.`amount`,b.`openid`
                FROM hhs_reduce_money AS a LEFT JOIN hhs_users AS b ON a.`user_id`=b.`user_id`";
    }

}