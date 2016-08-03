<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 22:42
 */

namespace app\modules\invite\controllers;


use app\controllers\InviteController;
use app\models\InviteModel;
use Yii;
use Functions;

class AdminController extends InviteController
{

    /**
     * @desc 管理员临时邀请码列表
     * @return string
     */
    public  function actionIndex_temporary(){
        $page= $this->get_page_value();
        $invateModel= new InviteModel();
        $data=$invateModel->getPage($invateModel->find(),$page[0],$page[1],"start_time DESC",["invition_flag"=>InviteModel::ADMIN_TEMP]);
        return $this->renderPartial("index",["data"=>$data]);
    }


    /**
     * @desc 邀请码循环入库
     */
    public  function actionGet_invite(){
        $num=Yii::$app->request->post("num","");
        if(!preg_match("/^[0-9]*$/",$num)){
            Functions::dwz_json(300,"生成数量格式不正确");
        }
        if($num>5){
            Functions::dwz_json(300,"超过邀请码生成最大限制");
        }
        $data=$this->get_invite_time();
        $data["user_id"]=0;//管理员id
        $data["user_by_id"]=0; //团长id
        $data["invition_flag"]=InviteModel::ADMIN_TEMP; //临时邀请嘛标识
        $data["invition_status"]=InviteModel::STATUS_ACTIVE; //已激活状态
        $result=$this->get_invite($num,$data);
        if($result){
            return Functions::return_json(200,"邀请码生成成功");
        }else{
            Functions::exit_json(300,"邀请码生成失败");
        }
    }


}