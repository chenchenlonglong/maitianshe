<?php

/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 23:11
 */
namespace app\modules\user\controllers;

use app\controllers\CommonController;
use app\models\UserModel;
use Yii;

class AdminController extends  CommonController
{
    public  function actionIndex(){
        $page=$this->get_page_value();
        $userModel=new UserModel();
        //管理员标识
        $admin_name=Yii::$app->request->post("admin_name","");
        if($admin_name){
            $data=   $userModel->getPage($userModel->find(),$page[0],$page[1],"e_active_time",["e_user_level"=>3],["e_user_name"=>$admin_name]);
        }else{
            $data=   $userModel->getPage($userModel->find(),$page[0],$page[1],"e_active_time",["e_user_level"=>3]);
        }

        return $this->renderPartial("index",["data"=>$data]);
    }


    public  function  actionCreate_invite_show(){
        $user_id=Yii::$app->request->get("user_id","");
        $user_name=Yii::$app->request->get("user_name","");
        return $this->renderPartial("invite_show",["user_id"=>$user_id,"user_name"=>$user_name]);
    }
}