<?php
/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 22:42
 */

namespace app\modules\invate\controllers;


use app\controllers\CommonController;
use app\models\InvateModel;
use Yii;
use Functions;

class AdminController extends CommonController
{

    /**
     * @desc 管理员临时邀请码列表
     * @return string
     */
    public  function actionIndex_temporary(){
        $page= $this->get_page_value();
        $invateModel= new InvateModel();
        $data=$invateModel->getPage($invateModel->find(),$page[0],$page[1],"start_time",["invition_flag"=>1]);
        return $this->renderPartial("index",["data"=>$data]);
    }

    /**
     * @desc 邀请码循环入库
     */
    public  function actionGet_invate(){
        $num=Yii::$app->request->post("num","");
        if(!preg_match("/^[0-9]*$/",$num)){
            Functions::dwz_json(300,"生成数量格式不正确");
        }
        if($num>5){
            Functions::dwz_json(300,"超过邀请码生成最大限制");
        }
        $start_time=time(); //申请时间
        $end_time=time()+(3600*24*30); //有效期
        $data=array(
            'user_id'=>0, //管理员id
            'user_by_id'=>0, // 团长id
            'invition_flag'=>1, //管理员临时邀请码标识
            'invition_status'=>3004, //已激活状态,临时邀请码都是已激活状态
            'start_time'=>$start_time,
            'end_time'=>$end_time
        );
        $invateModel= new InvateModel();

        for($i=0;$i<$num;$i++){
            $data['invition_code']=$this->verify();
            $_model = clone $invateModel;
            $_model->setAttributes($data);
            $result=$_model->save();
        }

        if( $result){
            return Functions::return_json(200,"邀请码生成成功");
        }else{
            Functions::exit_json(300,"邀请码生成失败");
        }
    }

    /**
     * @desc 邀请码生成函数
     * @return string
     */
    private function verify(){
        $letters=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $msg="";
        $letter="";
        for($i=0;$i<4;$i++){
            $msg.=mt_rand(0, 9);

        }
        for($i=0;$i<4;$i++){
            $const=mt_rand(0, 9);
            $letter.=$letters[$const];
        }
        $invition_code=$msg.$letter;
        return $invition_code;
    }
}