<?php

/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 23:11
 */
namespace app\modules\user\controllers;

use app\common\User;
use app\controllers\CommonController;
use app\models\UserModel;
use Yii;
use Functions;
use yii\db\Query;
use yii\web\UploadedFile;
use app\common\Qiniu;

class AdminController extends  CommonController
{
    /**
     * @desc 管理员列表显示
     * @return string
     */
    public  function actionIndex(){
        $page=$this->get_page_value();
        $userModel=new UserModel();
        //管理员标识
        $admin_name=Yii::$app->request->post("admin_name","");
        if($admin_name){
            $data=   $userModel->getPage($userModel->find(),$page[0],$page[1],"",["e_user_level"=>3],["e_user_name"=>$admin_name]);
        }else{
            $data=   $userModel->getPage($userModel->find(),$page[0],$page[1],"",["e_user_level"=>3]);
        }
        //注册总人数
        $data["count"]=User::get_count();
        //今日注册人数
        $data["today"]=User::get_today_count();
        return $this->renderPartial("index",["data"=>$data]);
    }


    /**
     * @desc 管理员编辑显示
     * @return string
     */
    public function  actionEdit(){
        $user_id=Yii::$app->request->get("user_id","");
        $userModel= new UserModel();
        if($user_id){
            $select=["user_id","e_user_name","e_user_wx_number","e_age_group","e_admin_wx_code_img","e_admin_wx_code_img_url","e_admin_team_name","e_register_phone",
                      "e_register_email","e_alipay_number","e_beneficiary_name","e_admin_team_name"];
            $data=$userModel->find()->select($select)->where(["user_id"=>$user_id])->asArray()->one();
            $data["age_group"]=Yii::$app->params["age_group"];
            return $this->renderPartial("edit",["data"=>$data,"model"=>$userModel]);
        }
        $post=Yii::$app->request->post();
        //二维码上传
        $user_id=$post["user_id"];
        $save_arr=[
            "user_id"=>$user_id,
            "e_user_name"=>$post["e_user_name"],
            "e_user_wx_number"=>$post["e_user_wx_number"], //微信号
            "e_age_group"=>$post["e_age_group"], //年龄段
            "e_admin_team_name"=>$post["e_admin_team_name"], //团队名称
            "e_register_phone"=>$post["e_register_phone"],//电话号码
            "e_register_email"=>$post["e_register_email"],//邮件
            "e_alipay_number"=>$post["e_alipay_number"],//支付宝账户
            "e_beneficiary_name"=>$post["e_beneficiary_name"]//支付宝收款账户
        ];
        $qr_code =UploadedFile::getInstance($userModel, "e_admin_wx_code_img");
        if($qr_code){
            if(in_array($qr_code->type,Yii::$app->params["image_allow"])){
                $img_url=Qiniu::qiniu_upload($qr_code->tempName,Yii::$app->params["qiniu_params"]["qr_code_path"]);
                $img_name=$qr_code->name;
                $save_arr["e_admin_wx_code_img"]=$img_name;
                $save_arr["e_admin_wx_code_img_url"]=$img_url;
            }else{
                return    Functions::return_json(300,"文件格式不正确");
            }
        }
        $save_result=$userModel->updateAll($save_arr,["user_id"=>$user_id]);
        if($save_result>0){
            return Functions::return_json(200,"管理员信息修改成功");
        }
        return Functions::return_json(300,"修改失败，请重试");

    }

    /**
     * @desc 创建邀请码显示
     * @return string
     */
    public  function  actionCreate_invite_show(){
        $user_id=Yii::$app->request->get("user_id","");
        $user_name=Yii::$app->request->get("user_name","");
        return $this->renderPartial("invite_show",["user_id"=>$user_id,"user_name"=>$user_name]);
    }





    /**
     * @desc 团队下团长列表展示
     * @return string
     */
    public function actionTeam_show(){
        $team_name=Yii::$app->request->get("team_name");
        $page=$this->get_page_value();
        $userModel = new UserModel();
        $user_name=Yii::$app->request->post("user_name","");
        $where=[];
        if($user_name){
            $where=["e_user_name"=>$user_name];
        }
        $data=$userModel->getPage($userModel->find(),$page[0],$page[1],"",["e_admin_team_name"=>$team_name],["!=","e_user_level",3],$where);
        $data["reg_today"]=User::get_today_team_count($team_name);
        $data["user_name"]=$user_name;
        return $this->renderPartial("team_index",["data"=>$data]);
    }



}