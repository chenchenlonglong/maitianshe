<?php

/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 23:11
 */
namespace app\modules\user\controllers;

use app\controllers\CommonController;

class AdminController extends  CommonController
{
    public  function actionIndex(){
        return $this->renderPartial("index");
    }
}