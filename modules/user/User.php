<?php

/**
 * Created by PhpStorm.
 * User: chenlong
 * Date: 2016/8/1
 * Time: 23:14
 */
namespace app\modules\user;
use yii\base\Module;

class User extends Module
{
    public $controllerNamespace = 'app\modules\user\controllers';

    public  function  init(){

        parent::init();
    }
}