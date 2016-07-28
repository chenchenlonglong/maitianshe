<?php
/**
 * @author oj
 * @data : 2016/3/31
 * @time: 10:57
 */

namespace app\modules\admin\controllers;

use app\common\Tools;
use app\models\Auth_adminModel;
use yii;
use yii\web\Controller;

class LoginController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @desc没有参数时登录页面显示 post不为空时 验证登录 并将用户id存到session中
     * @return string
     */
    public function actionIndex()
    {
        $post = Yii::$app->request->post();
        if(empty($post)){
           return $this->renderPartial('login');
        }
        $auth_admin_model = new Auth_adminModel();
        $user = $auth_admin_model->findOne(['user_name' => $post['user_name']]);
        if ($user && $user->password == Tools::md5_pwd($post['password'])) {
            //对比密码
            $session = Yii::$app->session;
            if (!$session->isActive) {
                $session->open();
            }
            $session = Yii::$app->session;
            $session->set('user_id', $user->user_id);
            setcookie("user_id", $user->user_id, time() + 3600 * 24);

            $user->is_login = 1;
            $user->last_login_time =time();
            $user->login_ip = $_SERVER['REMOTE_ADDR'];

            $user->save();

            $this->redirect('/');
        } else {
            echo '<script type="text/javascript">alert("账号或密码错误,请重新输入!");location.href="?r=admin/login/index"</script>';
        }

    }


    /**
     * @desc 记录退出登录的用户
     */
    public function actionLogin_out()
    {
        $session = Yii::$app->session;
        if ($session->isActive) {
            $session->open();
        }
        $auth_admin_model = new Auth_adminModel();
        $user_id = Tools::get_user_id();
        if($user_id){
            $user = $auth_admin_model->findOne(['user_id'=>$user_id]);
            $user->is_login = 0;
            $user->save();
            unset($session['user_id']);
            $session->close();
            $session->destroy();
            setcookie("user_id");
        }elseif (!empty($_COOKIE['user_id'])) {
            $user = $auth_admin_model->findOne(['user_id' => $_COOKIE['user_id']]);
            $user->is_login = 0;
            $user->save();
            setcookie("user_id");
        }
        $this->redirect(['login/index']);
    }


    public  function  actionLogin_out_time(){

        return $this->render("login_out_time");
    }

}