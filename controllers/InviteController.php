<?php
/**
 * author: chenlong
 * Date: 2016/8/3
 * Time: 9:55
 */

namespace app\controllers;
use app\models\InviteModel;
use Yii;

class InviteController extends  CommonController
{
   
    /**
     * @param $num 生成邀请码的数量
     * @param $data 操作的数据
     * @return bool
     */


    public  function  get_invite($num,$data){
        for($i=0;$i<$num;$i++){
            $invateModel= new InviteModel();
            $data['invition_code']=$this->verify();
            foreach($data as $key=>$value){
                $invateModel->$key=$value;
            }
            $result=$invateModel->save();
        }

        return $result;
    }

    /**
     * @desc 邀请码有效期
     * @return array
     */
    public function  get_invite_time(){
        $start_time=time(); //申请时间
        $end_time=time()+(3600*24*30); //有效期
        $data=array(
            'start_time'=>$start_time,
            'end_time'=>$end_time
        );

        return $data;
    }


    /**
     * @desc 邀请码生成函数
     * @return string
     */
     private  function verify(){
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