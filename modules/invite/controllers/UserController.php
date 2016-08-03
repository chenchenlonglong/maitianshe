<?php
/**
 * author: chenlong
 * Date: 2016/8/3
 * Time: 9:53
 */

namespace app\modules\invite\controllers;


use app\controllers\InviteController;
use app\models\InviteModel;
use app\models\UserModel;
use Functions;
use Yii;

class UserController extends  InviteController
{
    /**
     * @desc 团长临时邀请码列表
     * @return string
     */
    public  function  actionIndex_temporary(){
            $page= $this->get_page_value();
            $invateModel= new InviteModel();
            $data=$invateModel->getPage($invateModel->find(),$page[0],$page[1],"start_time DESC",["invition_flag"=>InviteModel::USER_TEMP]);
            return $this->renderPartial("index",["data"=>$data]);
    }

    public  function  actionGet_invite(){
        $num=Yii::$app->request->post("num","");
        $admin_id=Yii::$app->request->post("admin_id","");
        if(empty($admin_id)){
            Functions::dwz_json(300,"管理员用户为空");
        }
        if(empty($num)){
            Functions::dwz_json(300,"邀请码个数为空");
        }
        if(!preg_match("/^[0-9]*$/",$num)){
            Functions::dwz_json(300,"生成数量格式不正确");
        }
        if($num>5){
            Functions::dwz_json(300,"超过邀请码生成最大限制");
        }

        $userModel= new UserModel();
        $data_first=$userModel->find()->where(["user_id"=>$admin_id,"e_user_level"=>3])->asArray()->one();
        if(empty($data_first)){
            $data_second=$userModel->find()->where(["e_user_wx_number"=>$admin_id,"e_user_level"=>3])->asArray()->one();
            if(empty($data_second)){
                return Functions::return_json(300,"您输入的管理员不存在或未激活");
            }else{
                $admin_id=$data_second["e_user_wx_number"];
            }
        }
        $data=$this->get_invite_time();
        $data["user_id"]=$admin_id;//管理员id
        $data["user_by_id"]=0; //团长id
        $data["invition_flag"]=InviteModel::USER_TEMP; //临时邀请嘛标识
        $data["invition_status"]=InviteModel::STATUS_ACTIVE; //已激活状态
        $result=$this->get_invite($num,$data);
        if($result){
            return Functions::return_json(200,"邀请码生成成功");
        }else{
            Functions::exit_json(300,"邀请码生成失败");
        }
    }
}