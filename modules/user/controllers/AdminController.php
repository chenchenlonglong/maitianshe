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

class AdminController extends  CommonController
{
    public  function actionIndex(){
        $userModel=new UserModel();
        //管理员标识
        
        return $this->renderPartial("index");
    }
}