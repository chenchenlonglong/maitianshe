<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/22
 * Time: 16:32
 */

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\web\Session;

class BaseController extends Controller
{


    public $enableCsrfValidation = false;

    /**
     * @desc访问地址方法过滤
     * @param yii\base\Action $action
     * @return bool
     * @throws yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        //获取请求的模块
        $modules = Yii::$app->controller->module->id;
        //获取请求的控制器
        $ctl = Yii::$app->controller->id;
        //获取控制器中要执行的action
        $action = Yii::$app->controller->action->id;
        //实际请求路径。
        $requestPath = strtolower($modules . '/' . $ctl . '/' . $action);

        /*session获取用户id*/
        $session = Yii::$app->session;
        $user_id = $session->get('user_id');

        if (isset($user_id)) {
            return parent::beforeAction($action);
        } else {
            //走到这里，没有权限，抛异常，或者输出你想输出的东西
           return $this->redirect(['admin/login/index']);


        }
    }
}