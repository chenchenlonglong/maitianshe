<?php
/**
 * 登录后默认首页管理
 *
 * IndexController
 * @author liuranggang
 * @copyright leyou
 * @time 2016-03-22
 * @version v1.0
 */

namespace app\controllers;

use app\common\Tools;
use app\models\Auth_adminModel;
use app\models\Auth_item_childModel;
use yii;
use yii\web\Controller;

class IndexController extends BaseController
{
    public $layout = 'dwz';

    public function actionIndex()
    {

        return $this->render('index');
    }
}

?>