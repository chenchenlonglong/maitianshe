<?php
/**
 * author: chenlong
 * Date: 2016/8/19
 * Time: 9:27
 */

namespace app\modules\user\controllers;


use app\controllers\CommonController;
use app\models\UserModel;
use Yii;
use app\common\User;

class UserController extends  CommonController
{

    public function  actionIndex(){
        $page=$this->get_page_value();
        $userModel= new UserModel();
        $user_name=Yii::$app->request->post("user_name","");
        $where=[];
        if($user_name){
            $where=["e_user_name"=>$user_name];
        }
        $data=$userModel->getPage($userModel->find(),$page[0],$page[1],"reg_time",["e_user_level"=>2],$where);
        $data["total_user"]=User::get_user_count();
        $data["reg_today"]=User::get_today_user_count();
        return $this->renderPartial("index",["data"=>$data]);
    }
}