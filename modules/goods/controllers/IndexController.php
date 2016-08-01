<?php

/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 9:41
 */
namespace app\modules\goods\controllers;

use app\common\Task;
use app\controllers\CommonController;
use app\models\GoodsModel;
use Yii;
use Functions;

class IndexController extends CommonController
{
    public $enableCsrfValidation = false;


    /**
     * @desc 商品列表
     */
    public  function  actionIndex(){
        $goodsModel= new GoodsModel();
        $page_info= $this->get_page_value();
        $goods_id=Yii::$app->request->post("goods_id","");
        if(!preg_match("/^[0-9]*$/",$goods_id)){
            Functions::dwz_json(300,"商品编号格式不正确");
        }
        if($goods_id){
            $data=$goodsModel->getPage($goodsModel->find(),$page_info[0],$page_info[1],"",["goods_id"=>$goods_id]);
        }else{
            $data=$goodsModel->getPage($goodsModel->find(),$page_info[0],$page_info[1]);
        }
        $data["goods_id"]=$goods_id;

        return $this->renderPartial("index",["data"=>$data]);
    }

    /**
     * @desc 商品编辑
     * @return string
     */
    public  function  actionEdit(){
        $post=Yii::$app->request->post();
        $goods_model=new GoodsModel();
        if($post){
            $goods_id=$post["goods_id"];
            //电话号码验证
            if(!preg_match("/^[0-9]+(.[0-9]{2})?$/",$post["reward"])){
                Functions::dwz_json(300,"奖金格式不正确");
            }
            if(!preg_match("/^[0-9]+(.[0-9]{2})?$/",$post["commision"])){
                Functions::dwz_json(300,"佣金格式不正确");
            }
            $result=  $goods_model->findOne(["goods_id"=>$goods_id]);
            $result->task_level=$post["task_level"];
            $result->reward=$post["reward"];
            $result->commision=$post["commision"];
            if($result->save()){
                return  Functions::return_json(200,"修改成功");
            }else{
              Functions::dwz_json(300,"修改失败");
            }

        }else{
            $goods_id=Yii::$app->request->get("goods_id");

            $goods=$goods_model->find()->where(["goods_id"=>$goods_id])->asArray()->one();
            $task=Task::get_task();
            return $this->renderPartial("edit",["data"=>$goods,"task"=>$task]);
        }

    }

}