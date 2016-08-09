<?php
/**
 * author: chenlong
 * Date: 2016/7/26
 * Time: 11:48
 */

namespace app\controllers;

use Yii;

class CommonController extends   BaseController
{
    /**
     * @desc 获得分页数据
     * @return array
     * @return array
     */
    public  function  get_page_value(){

        $request = yii::$app->request;
        $page = $request->post('pageNum') ? $request->post('pageNum') : 1;
        $page_num = $request->post('numPerPage') ? $request->post('numPerPage') : 30;
        return [$page,$page_num];
    }


}