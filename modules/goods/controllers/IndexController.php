<?php

/**
 * author: chenlong
 * Date: 2016/8/1
 * Time: 9:41
 */
namespace app\modules\goods\controllers;

use app\common\Task;
use app\controllers\CommonController;
use app\models\Goods_bakModel;
use app\models\GoodsModel;
use app\models\InviteModel;

use app\models\TaskModel;
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
        $goods_sn=Yii::$app->request->post("goods_sn","");
        $task_level=Yii::$app->request->post("task_level","");
        $team_num=Yii::$app->request->post("team_num","");
        $where=[
            "goods_sn"=>$goods_sn,
            "task_level"=>$task_level,
            "team_num"=>$team_num,
        ];
        if($where){
            $data=$goodsModel->getPage($goodsModel->find(),$page_info[0],$page_info[1],"last_update desc ",$where);
        }else{
            $data=$goodsModel->getPage($goodsModel->find(),$page_info[0],$page_info[1],"last_update desc");
        }
        $data["goods_sn"]=$goods_sn;
        $data["task_level"]=$task_level;
        $data["team_num"]=$team_num;
        $taskModel= new TaskModel();
        $task=$taskModel->find()->distinct(["task_name"])->select(["task_level","task_name"])->asArray()->all();
        return $this->renderPartial("index",["data"=>$data,"task"=>$task]);
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
                return Functions::return_json(200,"修改成功，请手动关闭页面");
            }else{
              Functions::dwz_json(300,"修改失败");
            }

        }else{
            $goods_id=Yii::$app->request->get("goods_id");

            $goods=$goods_model->find()->where(["goods_id"=>$goods_id])->asArray()->one();
            $taskModel= new TaskModel();
            $task=$taskModel->find()->distinct(["task_name"])->select(["task_level","task_name"])->asArray()->all();
            return $this->renderPartial("edit",["data"=>$goods,"task"=>$task]);
        }

    }

    /**
     * @desc 置顶
     * @return string
     */
    public  function  actionPull(){
        $goods_id=Yii::$app->request->get("goods_id");
        $goodsModelYang=new GoodsModel();
        $goodsModel= new Goods_bakModel();
        $result_one=$goodsModelYang->findOne(["goods_id"=>$goods_id]);
        $result=$goodsModel->findOne(["goods_id"=>$goods_id]);
        $result_one->last_update=time();
        $result->last_update=time();
        if($result->save() && $result_one->save()){
            return Functions::return_json(200,"置顶成功");
        }
        Functions::dwz_json(300,"修改失败");
    }

}