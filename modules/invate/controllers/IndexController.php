<?php

/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 9:21
 */
namespace app\modules\invate\controllers;

use app\common\Time;
use app\controllers\CommonController;
use app\models\InvateModel;


class IndexController extends  CommonController
{
    public $enableCsrfValidation = false;

    /**
     * @desc邀请码列表展示
     */
    public  function  actionIndex(){
        $page_info=$this->get_page_value();
        $invateModel= new InvateModel();
        $data=$invateModel->getPage($invateModel->find(),$page_info[0],$page_info[1]);
        $count_today= $invateModel->select_count(["like","start_time",substr(Time::get_time(),0,5)]);
        $data["count_today"]=$count_today; //今日新增邀请码数量
        return $this->renderPartial("index",["data"=>$data]);
    }
}