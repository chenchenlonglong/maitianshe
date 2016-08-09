<?php

/**
 * author: chenlong
 * Date: 2016/8/8
 * Time: 14:32
 */
namespace app\modules\audit\controllers;

use app\controllers\CommonController;
use app\models\ReduceModel;
use app\models\UserModel;

class ReduceController extends CommonController
{
    public  function actionIndex(){
        $page=$this->get_page_value();
        $reduceModel= new ReduceModel();
        $result=$reduceModel->findBySql(self::sql())->asArray()->all();
        $data=$reduceModel->getPage_by_sql($result,$page[0],$page[1]);
        $start=($page[0]-1)*$page[1];
        $sql=self::sql()."  limit {$start},{$page[1]} ;";
        $result=$reduceModel->findBySql($sql)->asArray()->all();
        $data["data"]=$result;
      return   $this->renderPartial("index",["data"=>$data]);
    }





    private function  sql(){
        return "SELECT DISTINCT a.`id`, b.`e_user_name` as user_name,b.`e_user_wx_number` as wx_name,a.`flag`,a.`reason`,a.`amount`
                FROM hhs_reduce_money AS a LEFT JOIN hhs_users AS b ON a.`user_id`=b.`user_id`;";
    }

}